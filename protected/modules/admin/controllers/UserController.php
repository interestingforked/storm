<?php

class UserController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Users';

        $criteria = new CDbCriteria();
        $count = User::model()->count($criteria);
        $pagination = new CPagination($count);

        $pagination->pageSize = 15;
        $pagination->applyLimit($criteria);
        
        $users = User::model()->findAll($criteria);

        $this->render('index', array(
            'users' => $users,
            'pagination' => $pagination
        ));
    }

    public function actionAdd() {
        $this->pageTitle = 'News / Add article';

        $errors = array();

        $model = new Article;
        $contentModel = new Content;

        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
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
                $contentModel->module = 'article';
                $contentModel->module_id = $model->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'article', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/article'));
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
        ));
    }

    public function actionEdit($id) {
        $this->pageTitle = 'News / Edit article';

        $errors = array();

        $model = Article::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('article', $id);

        $attachmentModels = Attachment::model()->getAttachments('article', $id);

        if (isset($_POST['Article'])) {
            $model->attributes = $_POST['Article'];
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
                    $result = Attachment::model()->saveAttachments($attachments, 'article', $model->id, $model->slug);
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/article'));
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
        ));
    }

    public function actionDelete($id) {
        $model = Article::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/article'));
    }

}
