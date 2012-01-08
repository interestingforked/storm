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
    
    public function actionReport() {
        $this->pageTitle = 'User reports';

        $userStartDate = time();
        $userEndDate = time();
        $userStatus = 0;
        $userStatuses = array(
            0 => 'Просто зарегестрированные',
            1 => 'Сделавшие покупку',
            2 => 'Подписчики на новости',
            3 => 'Зарегестрировавшиеся в определенный промежуток времени',
        );

        $sql = "SELECT id, username, email, createtime, lastvisit, superuser, status FROM `users` `t` WHERE true ";
        if ($_POST) {
            $userStartDate = strtotime($_POST['start_date']);
            $userEndDate = strtotime($_POST['end_date']);
            $userStatus = $_POST['status'];

            if ($userStatus == 1) {
                $sql .= "AND id IN (SELECT user_id FROM orders WHERE status > 1) ";
            }
            if ($userStatus == 2) {
                $sql .= "AND id IN (SELECT user_id FROM profiles WHERE newsletters = 1) ";
            }
            if ($userStatus == 3) {
                $sql .= "AND createtime >= {$userStartDate} AND createtime <= {$userEndDate} ";
            }
        }
        
        $sql .= "ORDER BY createtime DESC";

        $users = User::model()->findAllBySql($sql);
        
        $userStartDate = strftime('%Y-%m-%d', $userStartDate);
        $userEndDate = strftime('%Y-%m-%d', $userEndDate);
        
        if (isset($_POST['tocsv']) AND $_POST['tocsv'] == 1) {
            $dataArray = array();
            $dataArray[] = array(
                'Firstname', 'Lastname', 'Username', 'E-mail', 'Sex', 'Age', 'Newsletters', 'Status', 'Created'
            );
            foreach ($users AS $user) {
                $profile = $user->profile;
                $sex = ($profile->sex ? 'Мужской' : 'Женский');
                $age = Profile::range('1==Младше 18;2==18-25;3==26-35;4==36+', $profile->getAttribute('age'));
                $newsletter = ($profile->newsletters ? 'Да' : 'Нет');
                switch ($user->status) {
                    case User::STATUS_BANED:
                        $status = 'Banned'; break;
                    case User::STATUS_NOACTIVE:
                        $status = 'Not active'; break;
                    case User::STATUS_ACTIVE:
                        $status = 'Active'; break;
                    default:
                        $status = '-'; break;
                }
                $created = date('Y-m-d G:j:s', $user->createtime);
                $userData = array(
                    $profile->firstname,
                    $profile->lastname,
                    $user->username,
                    $user->email,
                    $sex,
                    $age,
                    $newsletter,
                    $user->status,
                    $status,
                    $created
                );
                $dataArray[] = $userData;
            }
            
            $fp = fopen(Yii::app()->basePath.'/../assets/file.csv', 'w');
            foreach ($dataArray as $fields) {
                fputcsv($fp, $fields);
            }
            fclose($fp);
            $file = file_get_contents(Yii::app()->basePath.'/../assets/file.csv');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=file.csv');
            $file = iconv('utf-8', 'windows-1251', $file);
            echo $file;
            exit;
        }
        
        $this->render('report', array(
            'users' => $users,
            'userStartDate' => $userStartDate,
            'userEndDate' => $userEndDate,
            'userStatus' => $userStatus,
            'userStatuses' => $userStatuses,
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
