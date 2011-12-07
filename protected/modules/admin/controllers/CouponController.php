<?php

class CouponController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Coupons';

        $criteria = new CDbCriteria();
        $count = Coupon::model()->count($criteria);
        $pagination = new CPagination($count);

        $pagination->pageSize = 15;
        $pagination->applyLimit($criteria);
        
        $coupons = Coupon::model()->findAll($criteria);

        $this->render('index', array(
            'coupons' => $coupons,
            'pagination' => $pagination
        ));
    }

}
