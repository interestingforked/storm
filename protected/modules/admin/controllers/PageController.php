<?php

class PageController extends AdminController {
    
    public $plugins;

    public function init() {
        parent::init();
        
        $this->plugins = array(
            'page' => 'Page',
            'article' => 'Article',
            'gallery' => 'Gallery',
        );
    }

    public function actionIndex() {
        $this->pageTitle = 'Pages';
        
        $rootPage = Page::model()->findByPk(1);
        $tableRows = $rootPage->getTableRows();

        $this->render('index', array(
            'pages' => $tableRows['items'],
        ));
    }

    public function actionAdd() {
        $this->pageTitle = 'Pages / Add page';
        
        $errors = array();
        
        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getTableRows();
        
        $pageModel = new Page;
        $contentModel = new Content;

        if (isset($_POST['Page'])) {
            $pageModel->attributes = $_POST['Page'];
            $contentModel->attributes = $_POST['Content'];
            
            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }
            
            $transaction = Yii::app()->db->beginTransaction();
            if ($pageModel->save()) {
                $contentModel->module = 'page';
                $contentModel->module_id = $pageModel->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];
                
                $contentModel->background = Attachment::model()->saveImage($contentModel->background, 'background');
                
                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'page', $pageModel->id, $pageModel->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/page'));
                    }
                    $errors = $result;
                    $transaction->rollback();
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $pageModel->getErrors();
            }
        }

        $this->render('add', array(
            'errors' => $errors,
            'pages' => $pages,
            'pageModel' => $pageModel,
            'contentModel' => $contentModel,
            'plugins' => $this->plugins,
        ));
    }
    
    public function actionEdit($id) {
        $this->pageTitle = 'Pages / Add page';
        
        $errors = array();
        
        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getTableRows();
        
        $pageModel = Page::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('page', $id);
        
        $attachmentModels = Attachment::model()->getAttachments('page', $id);

        if (isset($_POST['Page'])) {
            $pageModel->attributes = $_POST['Page'];
            
            if (empty($_POST['Content']['background'])) {
                unset($_POST['Content']['background']);
            }
            $contentModel->attributes = $_POST['Content'];
            
            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }
            
            $transaction = Yii::app()->db->beginTransaction();
            if ($pageModel->save()) {
                $contentModel->module = 'page';
                $contentModel->module_id = $pageModel->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                if (!empty($_POST['Content']['background'])) {
                    $contentModel->background = Attachment::model()->saveImage($_POST['Content']['background'], 'background');
                }
                
                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'page', $pageModel->id, $pageModel->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/page'));
                    }
                    $errors = $result;
                    $transaction->rollback();
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $pageModel->getErrors();
            }
        }

        $this->render('edit', array(
            'errors' => $errors,
            'pages' => $pages,
            'pageModel' => $pageModel,
            'contentModel' => $contentModel,
            'plugins' => $this->plugins,
            'title' => $contentModel->title,
            'attachmentModels' => $attachmentModels,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = Page::model()->findByPk($id);
            $model->deleted = 1;
            $model->save();

            $this->redirect(array('/admin/page'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}
