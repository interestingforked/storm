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
        
        $userStatuses = array(
            0 => 'Просто зарегестрированные',
            1 => 'Сделавшие покупку',
            2 => 'Подписчики на новости',
            //3 => 'Пользователи выбравшие LV язык',
            //4 => 'Пользователи выбравшие RU язык',
            //5 => 'Подписчики на новости и выбравшие LV язык',
            //6 => 'Подписчики на новости и выбравшие RU язык',
        );

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
            'userStatuses' => $userStatuses
        ));
    }
    
    public function actionEdit($id) {
        $this->pageTitle = 'Newsletters / Add newsletter';

        $errors = array();
        
        $userStatuses = array(
            0 => 'Просто зарегестрированные',
            1 => 'Сделавшие покупку',
            2 => 'Подписчики на новости',
            //3 => 'Пользователи выбравшие LV язык',
            //4 => 'Пользователи выбравшие RU язык',
            //5 => 'Подписчики на новости и выбравшие LV язык',
            //6 => 'Подписчики на новости и выбравшие RU язык',
        );

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
            'userStatuses' => $userStatuses
        ));
    }
    
    public function actionActivate($id) {
        $model = Newsletter::model()->findByPk($id);
        $model->start = new CDbExpression('CURRENT_TIMESTAMP');
        $model->save();
        
        $sql = "SELECT * FROM `users` `t` WHERE true ";
        if ($model->filter == 1) {
            $sql .= "AND id IN (SELECT user_id FROM orders WHERE status > 1) ";
        }
        if ($model->filter == 2) {
            $sql .= "AND id IN (SELECT user_id FROM profiles WHERE newsletters = 1) ";
        }
        if ($model->filter == 3) {
            $sql .= "AND id IN (SELECT user_id FROM profiles WHERE language = 'lv') ";
        }
        if ($model->filter == 4) {
            $sql .= "AND id IN (SELECT user_id FROM profiles WHERE language = 'ru') ";
        }
        if ($model->filter == 5) {
            $sql .= "AND id IN (SELECT user_id FROM profiles WHERE newsletters = 1 AND language = 'lv') ";
        }
        if ($model->filter == 6) {
            $sql .= "AND id IN (SELECT user_id FROM profiles WHERE newsletters = 1 AND language = 'ru') ";
        }
        $users = User::model()->findAllBySql($sql);
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
