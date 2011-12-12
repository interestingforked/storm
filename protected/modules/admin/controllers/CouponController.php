<?php

class CouponController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Coupons';

        $criteria = new CDbCriteria();
        $coupons = Coupon::model()->findAll($criteria);

        $this->render('index', array(
            'coupons' => $coupons,
        ));
    }
    
    public function actionAdd() {
        $this->pageTitle = 'Coupons / Add coupon';

        $errors = array();

        $model = new Coupon;

        if (isset($_POST['Coupon'])) {
            $model->attributes = $_POST['Coupon'];

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $transaction->commit();
                $this->redirect(array('/admin/coupon'));
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('add', array(
            'errors' => $errors,
            'model' => $model,
        ));
    }
    
    public function actionEdit($id) {
        $this->pageTitle = 'Coupons / Add coupon';

        $errors = array();

        $model = Coupon::model()->findByPk($id);

        if (isset($_POST['Coupon'])) {
            $model->attributes = $_POST['Coupon'];

            $transaction = Yii::app()->db->beginTransaction();
            if ($model->save()) {
                $transaction->commit();
                $this->redirect(array('/admin/coupon'));
            } else {
                $transaction->rollback();
                $errors = $model->getErrors();
            }
        }

        $this->render('edit', array(
            'errors' => $errors,
            'model' => $model,
            'title' => $model->code,
        ));
    }
    
    public function actionDelete($id) {
        $model = Coupon::model()->findByPk($id);
        $model->delete();

        $this->redirect(array('/admin/coupon'));
    }

}
