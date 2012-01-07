<?php

class OrderController extends AdminController {

    public function actionIndex() {
        $this->pageTitle = 'Orders';

        $criteria = new CDbCriteria();
        $criteria->order = 'created DESC';
        $orders = Order::model()->findAll($criteria);

        $this->render('index', array(
            'orders' => $orders,
        ));
    }
    
    public function actionUser($id) {
        $this->pageTitle = 'User orders';

        $user = User::model()->findByPk($id);
        if (!$user) {
            $this->redirect(array('/admin/order'));
        }
        $orders = $user->orders;

        $this->render('index', array(
            'orders' => $orders,
        ));
    }
    
    public function actionReport() {
        $this->pageTitle = 'Order reports';

        $orderStartDate = date('Y-m-d');
        $orderEndDate = date('Y-m-d');
        $orderStatus = 0;
        $orderStatuses = array(
            0 => '-',
            1 => 'New order',
            2 => 'Waiting for payment',
            3 => 'Completed',
            4 => 'Completed (RBK)',
        );
        
        $criteria = new CDbCriteria();
        if ($_POST) {
            $orderStartDate = $_POST['start_date'];
            $orderEndDate = $_POST['end_date'];
            $orderStatus = $_POST['status'];
            
            $criteria->addCondition("created >= '{$orderStartDate}'");
            $criteria->addCondition("created <= '{$orderEndDate}'");
            if ($orderStatus > 0) {
                $criteria->addCondition('status = '.$orderStatus);
            }
        }
        
        $criteria->order = 'created DESC';
        $orders = Order::model()->findAll($criteria);

        $this->render('report', array(
            'orders' => $orders,
            'orderStartDate' => $orderStartDate,
            'orderEndDate' => $orderEndDate,
            'orderStatus' => $orderStatus,
            'orderStatuses' => $orderStatuses,
        ));
    }
    
    public function actionView($id) {
        $this->pageTitle = 'Order info';
        
        $order = Order::model()->findByPk($id);
        if ( ! $order) {
            $this->redirect(array('/admin/order'));
        }
        $paymentDetails = OrderDetail::model()->getOrderPaymentData($id);
        $shippingDetails = OrderDetail::model()->getOrderShipingData($id);
        $orderItems = $order->items;
        
        $user = User::model()->findByPk($order->user_id);
        $profile = $user->profile;
        
        $products = array();
        foreach ($orderItems AS $item) {
            $product = Product::model()->findByPk($item->product_id);
            if ( ! $product) {
                continue;
            }
            $product->content = Content::model()->getModuleContent('product', $product->id);
            $product->mainNode = ProductNode::model()->findByPk($item->product_node_id);
            $products['item_'.$item->id] = $product;
        }
        
        $this->render('view', array(
            'order' => $order,
            'paymentDetails' => $paymentDetails,
            'shippingDetails' => $shippingDetails,
            'orderItems' => $orderItems,
            'products' => $products,
            'user' => $user,
            'userProfile' => $profile,
        ));
    }
    
    public function actionDelete($id) {
        $order = Order::model()->findByPk($id);
        foreach ($order->orderDetails AS $detail) {
            $detail->delete();
        }
        foreach ($order->items AS $item) {
            $item->delete();
        }
        $order->delete();
        
        $this->redirect(array('/admin/order'));
    }

}
