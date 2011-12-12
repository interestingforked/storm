<?php

class UserController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Users';

        $criteria = new CDbCriteria();
        $users = User::model()->findAll($criteria);

        $this->render('index', array(
            'users' => $users,
        ));
    }

    public function actionEdit($id) {
        $this->pageTitle = 'Users / Edit user';

        $errors = array();

        $model = User::model()->findByPk($id);
        $profile = $model->profile;
        
        $fields = $profile->getFields();
        foreach ($fields AS $field) {
            if ($field->varname == 'sex')
                $rangeSex = $field->range;
            if ($field->varname == 'age')
                $rangeAge = $field->range;
        }

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $profile->attributes = $_POST['Profile'];

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                if ($profile->save()) {
                    $transaction->commit();
                    $this->redirect(array('/admin/user'));
                } else {
                    $transaction->rollback();
                    $errors = $profile->getErrors();
                }
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('edit', array(
            'errors' => $errors,
            'model' => $model,
            'profile' => $profile,
            'rangeSex' => $rangeSex,
            'rangeAge' => $rangeAge,
            'title' => $model->email,
        ));
    }
    
    public function actionDisable($id) {
        $model = User::model()->findByPk($id);
        $model->status = 0;
        $model->save();

        $this->redirect(array('/admin/user'));
    }

    public function actionBan($id) {
        $model = User::model()->findByPk($id);
        $model->status = -1;
        $model->save();

        $this->redirect(array('/admin/user'));
    }
    
    public function actionEnable($id) {
        $model = User::model()->findByPk($id);
        $model->status = 1;
        $model->save();

        $this->redirect(array('/admin/user'));
    }

}
