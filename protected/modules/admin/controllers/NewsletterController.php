<?php

class NewsletterController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Newsletter';

        $criteria = new CDbCriteria();
        $newsletters = Newsletter::model()->findAll($criteria);

        $this->render('index', array(
            'newsletters' => $newsletters,
        ));
    }
    
    public function actionAdd() {
        $this->pageTitle = 'Newsletters / Add newsletter';

        $errors = array();

        $model = new Newsletter;
        $model->message = $this->renderPartial('template_2', null, true);

        if (isset($_POST['Newsletter'])) {
            $model->attributes = $_POST['Newsletter'];
            $model->message = $this->renderPartial('template_1', array(
                'content' => $model->message
            ), true);

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $transaction->commit();
                $this->redirect(array('/admin/newsletter'));
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('add', array(
            'errors' => $errors,
            'model' => $model,
            'title' => $model->subject,
        ));
    }
    
    public function actionEdit($id) {
        $this->pageTitle = 'Newsletters / Add newsletter';

        $errors = array();

        $model = Newsletter::model()->findByPk($id);

        if (isset($_POST['Newsletter'])) {
            $model->attributes = $_POST['Newsletter'];
            $model->message = $this->renderPartial('template_1', array(
                'content' => $model->message
            ), true);

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $transaction->commit();
                $this->redirect(array('/admin/newsletter'));
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('edit', array(
            'errors' => $errors,
            'model' => $model,
            'title' => $model->subject,
        ));
    }
    
    public function actionActivate($id) {
        $model = Newsletter::model()->findByPk($id);
        $model->start = new CDbExpression('CURRENT_TIMESTAMP');
        $model->save();
        
        $users = User::model()->findAll();
        foreach ($users AS $user) {
            $newsletterUser = new NewsletterUser;
            $newsletterUser->isNewRecord = true;
            $newsletterUser->id = null;
            $newsletterUser->newsletter_id = $model->id;
            $newsletterUser->user_id = $user->id;
            $newsletterUser->email = $user->email;
            $newsletterUser->save();
			
        }
        
        $this->redirect(array('/admin/newsletter'));
    }
    
    public function actionDelete($id) {
        $model = Newsletter::model()->findByPk($id);
        $model->delete();

        $this->redirect(array('/admin/newsletter'));
    }

}
