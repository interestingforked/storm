<?php

class CheckoutController extends Controller {

    public function filters() {
        return array('accessControl');
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array(
                    'index', 
                    'deliveryaddress', 
                    'deliverymethod',
                    'orderoverview',
                    'confirmation'
                ),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex() {
        $messages = null;
        $countryList = CHtml::listData(Country::model()->getActive(), 'id', 'title');
        
        $order = Order::model()->getByUserId(Yii::app()->user->id);
        $orderId = ($order) ? $order->id : 0;
        $paymentData = OrderDetail::model()->getOrderPaymentData($orderId);
        if ( ! $paymentData) {
            $paymentData = new OrderDetail();
        }
        
        if ($_POST) {
            if ( ! $order) {
                $cart = Cart::model()->getByUserId(Yii::app()->user->id);
                if ($cart) {
                    $cartItems = array();
                    foreach ($this->cart->getItems() AS $item) {
                        $product = Product::model()->findByPk($item['product_id']);
                        if ( ! $product)
                            continue;
                        $productNode = $product->getProduct($item['product_node_id']);
                        if ($productNode->mainNode->quantity == 0) {
                            $this->cart->removeItem($item['product_id'], $item['product_node_id']);
                            continue;
                        }
                        if ($productNode->mainNode->quantity < $item['quantity']) {
                            $this->cart->changeQuantity($item['product_id'], $item['product_node_id'], $productNode->mainNode->quantity);
                            $item['quantity'] = $productNode->mainNode->quantity;
                        }
                    }
                }
            
                $order = new Order();
                $order->cart_id = $cart->id;
                $order->user_id = Yii::app()->user->id;
                $order->coupon_id = $cart->coupon_id;
                $order->status = 1;
                $order->quantity = $cart->total_count;
                $order->total = $cart->total_price;
                $order->ip = Yii::app()->request->getUserHostAddress();
                $order->save();
            }
            $orderDetail = OrderDetail::model()->getOrderPaymentData($order->id);
            if ( ! $orderDetail) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->type = 'payment';
                $orderDetail->save();
            }
            $orderDetail->country_id = $_POST['country_id'];
            $orderDetail->name = $_POST['name'];
            $orderDetail->surname = $_POST['surname'];
            $orderDetail->phone = $_POST['phone'];
            $orderDetail->email = $_POST['email'];
            $orderDetail->house = $_POST['house'];
            $orderDetail->street = $_POST['street'];
            $orderDetail->city = $_POST['city'];
            $orderDetail->district = $_POST['district'];
            $orderDetail->postcode = $_POST['postcode'];
            if ($orderDetail->save()) {
                Yii::app()->controller->redirect(array('/checkout/deliveryaddress'));
            } else {
                $messages = $orderDetail->getErrors();
            }
            
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('index', array(
            'countries' => $countryList,
            'messages' => $messages,
            'data' => $paymentData,
        ));
    }
    
    public function actionDeliveryaddress() {
        $messages = null;
        $countryList = CHtml::listData(Country::model()->getActive(), 'id', 'title');
        
        $order = Order::model()->getByUserId(Yii::app()->user->id);
        if ( ! $order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }
        $paymentData = OrderDetail::model()->getOrderPaymentData($order->id);
        $shippingData = OrderDetail::model()->getOrderShipingData($order->id);
        if ( ! $shippingData) {
            $shippingData = new OrderDetail();
        }
        
        if ($_POST) {
            $orderDetail = OrderDetail::model()->getOrderShipingData($order->id);
            if ( ! $orderDetail) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->type = 'shipping';
                $orderDetail->save();
            }
            $orderDetail->country_id = $_POST['country_id'];
            $orderDetail->name = $_POST['name'];
            $orderDetail->surname = $_POST['surname'];
            $orderDetail->phone = $_POST['phone'];
            $orderDetail->email = $_POST['email'];
            $orderDetail->house = $_POST['house'];
            $orderDetail->street = $_POST['street'];
            $orderDetail->city = $_POST['city'];
            $orderDetail->district = $_POST['district'];
            $orderDetail->postcode = $_POST['postcode'];
            if ($orderDetail->save()) {
                Yii::app()->controller->redirect(array('/checkout/deliverymethod'));
            } else {
                $messages = $orderDetail->getErrors();
            }
            
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('delivery_address', array(
            'countries' => $countryList,
            'messages' => $messages,
            'paymentData' => $paymentData,
            'data' => $shippingData,
        ));
    }

    public function actionDeliverymethod() {
        $messages = null;
        
        $order = Order::model()->getByUserId(Yii::app()->user->id);
        if ( ! $order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }
        if ($_POST) {
            $order->shipping_method = $_POST['delivery_method'];
            $order->shipping = 0.00;
            if ($order->save()) {
                Yii::app()->controller->redirect(array('/checkout/orderoverview'));
            } else {
                $messages = $order->getErrors();
            }
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('delivery_method', array(
        ));
    }
    
    public function actionOrderoverview() {
        $messages = null;
        
        $order = Order::model()->getByUserId(Yii::app()->user->id);
        if ( ! $order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }
        $paymentData = OrderDetail::model()->getOrderPaymentData($order->id);
        $shippingData = OrderDetail::model()->getOrderShipingData($order->id);
        
        $cartModel = Cart::model()->getByUserId(Yii::app()->user->id);
        if ($cartModel->coupon_id) {
            $order->coupon_id = $cartModel->coupon_id;
            $order->save();
        }
        
        $cart = $this->cart->getList();
        if ($cart) {
            $cartItems = array();
            foreach ($this->cart->getItems() AS $item) {
                $product = Product::model()->findByPk($item['product_id']);
                if ( ! $product)
                    continue;
                $productNode = $product->getProduct($item['product_node_id']);
                if ($productNode->mainNode->quantity == 0) {
                    $this->cart->removeItem($item['product_id'], $item['product_node_id']);
                    continue;
                }
                if ($productNode->mainNode->quantity < $item['quantity']) {
                    $this->cart->changeQuantity($item['product_id'], $item['product_node_id'], $productNode->mainNode->quantity);
                    $item['quantity'] = $productNode->mainNode->quantity;
                }
                $cartItems[] = array(
                    'item' => $item,
                    'product' => $productNode,
                );
            }
            $order->quantity = $this->cart->getTotalCount();
            $order->total = $this->cart->getTotalPrice();
            $order->save();
        }
        
        $totalPrice = $order->total;
        
        $discountType = '';
        $discount = 0;
        if ($order->coupon_id) {
            $coupon = Coupon::model()->getActiveCoupon($order->coupon_id);
            if ($coupon) {
                $discountType = ($coupon->percentage == 1) ? 'percentage' : 'value';
                $discount = $coupon->value;
                if ($discountType == 'percentage')
                    $totalPrice = $order->total - ($order->total / 100 * $coupon->value);
                else
                    $totalPrice = $order->total - $coupon->value;
            }
        }
        
        if ($_POST) {
            if ($order->coupon_id) {
                if ($discountType == 'percentage')
                    $order->discount = '- '.$coupon->value.' %';
                else
                    $order->discount = '- '.$coupon->value.Yii::app()->params['currency'];
            }
            $order->key = $order->id.'-'.$order->user_id.$order->cart_id;
            $order->status = 2;
            if ($order->save()) {
                
                $orderItem = new OrderItem();
                foreach ($this->cart->getItems() AS $item) {
                    $orderItem->isNewRecord = true;
                    $orderItem->id = null;
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item['product_id'];
                    $orderItem->product_node_id = $item['product_node_id'];
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['price'];
                    $orderItem->subtotal = $item['subtotal'];
                    $orderItem->save();
                }
                $this->cart->close();

                Yii::app()->controller->redirect(array('/checkout/confirmation'));
            } else {
                $messages = $order->getErrors();
            }
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('order_overview', array(
            'messages' => $messages,
            'paymentData' => $paymentData,
            'shippingData' => $shippingData,
            'discount' => $discount,
            'discountType' => $discountType,
            'shipping' => $order->shipping,
            'price' => $order->total,
            'totalPrice' => ($totalPrice + $order->shipping),
            'cartItems' => $cartItems,
        ));
    }
    
    public function actionConfirmation() {
        $messages = null;
        $order = Order::model()->getByUserId(Yii::app()->user->id, 2);
        if ( ! $order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('confirmation', array(
            'key' => $order->key,
        ));
    }

}