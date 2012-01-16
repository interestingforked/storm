<?php

class BlockController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Blocks';

        $blocks = Block::model()->findAll();

        $this->render('index', array(
            'blocks' => $blocks,
        ));
    }

    public function actionAdd() {
        $this->pageTitle = 'Blocks / Add block';

        $errors = array();

        $model = new Block;
        $contentModel = new Content;
        $contentModel->language = Yii::app()->params['defaultLanguage'];

        if (isset($_POST['Block'])) {
            $model->attributes = $_POST['Block'];
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
                $contentModel->module = 'block';
                $contentModel->module_id = $model->id;
                $contentModel->language = Yii::app()->params['defaultLanguage'];

                if ($contentModel->save()) {
                    $result = Attachment::model()->saveAttachments($attachments, 'block', $model->id, 'block'.$model->id.time());
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/block'));
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
        $this->pageTitle = 'Blocks / Edit Block';

        $errors = array();

        $model = Block::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('block', $id);

        $attachmentModels = Attachment::model()->getAttachments('block', $id);

        if (isset($_POST['Block'])) {
            $model->attributes = $_POST['Block'];
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
                    $result = Attachment::model()->saveAttachments($attachments, 'block', $model->id, 'block'.$model->id.time());
                    if (!is_array($result)) {
                        $transaction->commit();
                        $this->redirect(array('/admin/block'));
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

    public function actionTranslate($id) {
        $this->pageTitle = 'Blocks / Translate block';

        $errors = array();

        $model = Block::model()->findByPk($id);
        $contentModel = Content::model()->getModuleContent('block', $id, 'ru');

        if (isset($_POST['Content'])) {
            if ($contentModel->language != 'ru') {
                $contentModel->isNewRecord = true;
                $contentModel->id = null;
            }
            $contentModel->attributes = $_POST['Content'];
            $contentModel->language = 'ru';

            $transaction = Yii::app()->db->beginTransaction();
            if ($contentModel->save()) {
                $transaction->commit();
                $this->redirect(array('/admin/block'));
            } else {
                $transaction->rollback();
                $errors = $contentModel->getErrors();
            }
        } else {
            $contentModel->language = 'ru';
        }

        $this->render('translate', array(
            'errors' => $errors,
            'model' => $model,
            'contentModel' => $contentModel,
            'title' => $contentModel->title,
        ));
    }

    public function actionMoveU($id) {
        $model = Block::model()->findByPk($id);
        $sort = $model->sort;
        if ($sort > 1) {
            $upperModel = Block::model()->findBySql(
                    "SELECT * FROM blocks WHERE sort < :sort", array(':sort' => $sort)
            );
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/block'));
    }

    public function actionMoveD($id) {
        $model = Block::model()->findByPk($id);
        $sort = $model->sort;
        $maxModel = Block::model()->findBySql("SELECT MAX(sort) as sort FROM blocks");
        if ($sort < $maxModel->sort) {
            $upperModel = Block::model()->findBySql(
                    "SELECT * FROM blocks WHERE sort > :sort", array(':sort' => $sort)
            );
            if ($upperModel) {
                $model->sort = $upperModel->sort;
                $model->save();
                $upperModel->sort = $sort;
                $upperModel->save();
            }
        }
        $this->redirect(array('/admin/block'));
    }

    public function actionDelete($id) {
        $model = Block::model()->findByPk($id);
        $model->deleted = 1;
        $model->save();

        $this->redirect(array('/admin/block'));
    }

}
