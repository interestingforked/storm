<?php

class OrderController extends Controller {

    public function actionIndex() {
        $this->breadcrumbs[] = Yii::t('app', 'My orders');
        $this->metaTitle = Yii::t('app', 'My orders');
        
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('/user/login'));
        }
        
        $user = User::model()->findByPk(Yii::app()->user->id);
        $orders = $user->orders;
        
        $this->render('index', array(
            'orders' => $orders
        ));
        
    }

}