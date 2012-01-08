<?php

class GalleryController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Gallery';

        $criteria = new CDbCriteria();
        $galleries = Gallery::model()->notDeleted()->sorted2()->findAll($criteria);

        $this->render('index', array(
            'galleries' => $galleries,
        ));
    }
    
    public function actionAdd() {
        $this->pageTitle = 'Galleries / Add gallery';

        $errors = array();

        $model = new Gallery;
        $contentModel = new Content;
        
        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getTableRows();

        if (isset($_POST['Gallery'])) {
            $model->attributes = $_POST['Gallery'];
            $contentModel->attributes = $_POST['Content'];

            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $contentModel->module = 'gallery';
                $contentModel->module_id = $model->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'gallery', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/gallery'));
                    }
                    $errors = $result;
                    $transaction->rollback();
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('add', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
            'pages' => $pages,
        ));
    }
    
    public function actionAddHeading() {
        $this->pageTitle = 'Galleries / Add gallery heading';

        $errors = array();

        $model = new Gallery;
        $contentModel = new Content;
        
        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getTableRows();

        if (isset($_POST['Gallery'])) {
            $model->attributes = $_POST['Gallery'];
            $contentModel->attributes = $_POST['Content'];
            
            $model->slug = $contentModel->title;
            $model->pagination = 0;
            $model->heading = 1;

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $contentModel->module = 'gallery';
                $contentModel->module_id = $model->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                if ($contentModel->save()) {
                    $transaction->commit();
                    $this->redirect(array('/admin/gallery'));
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('add_heading', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
            'pages' => $pages,
        ));
    }

    public function actionEdit($id) {
        $this->pageTitle = 'Galleries / Edit gallery';

        $errors = array();

        $model = Gallery::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('gallery', $id);

        $attachmentModels = Attachment::model()->getAttachments('gallery', $id);
        
        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getTableRows();

        if (isset($_POST['Gallery'])) {
            $model->attributes = $_POST['Gallery'];
            $contentModel->attributes = $_POST['Content'];

            $attachments = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/tmpfile([0-9]+)/i', $k)) {
                    $attachments[] = $v;
                }
            }

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'gallery', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/gallery'));
                    }
                    $errors = $result;
                    $transaction->rollback();
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('edit', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
            'title' => $contentModel->title,
            'attachmentModels' => $attachmentModels,
            'pages' => $pages,
        ));
    }
    
    public function actionEditHeading($id) {
        $this->pageTitle = 'Galleries / Edit gallery heading';

        $errors = array();

        $model = Gallery::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('gallery', $id);

        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getTableRows();

        if (isset($_POST['Gallery'])) {
            $model->attributes = $_POST['Gallery'];
            $contentModel->attributes = $_POST['Content'];

            $model->slug = $contentModel->title;
            
            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                if ($contentModel->save()) {
                    $transaction->commit();
                    $this->redirect(array('/admin/gallery'));
                } else {
                    $transaction->rollback();
                    $errors = $contentModel->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('edit_heading', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
            'title' => $contentModel->title,
            'pages' => $pages,
        ));
    }

    public function actionDelete($id) {
        $model = Gallery::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/gallery'));
    }

}
