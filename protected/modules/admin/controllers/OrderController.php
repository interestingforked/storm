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
