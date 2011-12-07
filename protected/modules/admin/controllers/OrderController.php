<?php

class OrderController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Orders';

        $criteria = new CDbCriteria();
        $count = Order::model()->count($criteria);
        $pagination = new CPagination($count);

        $pagination->pageSize = 15;
        $pagination->applyLimit($criteria);
        
        $orders = Order::model()->findAll($criteria);

        $this->render('index', array(
            'orders' => $orders,
            'pagination' => $pagination
        ));
    }

}
