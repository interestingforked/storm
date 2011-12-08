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
                    'payment',
                    'paymentsuccess',
                    'paymentfailed',
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

        $session = new CHttpSession();
        $session->open();
        if (!isset($session['country_id'])) {
            $session['country_id'] = 811;
        }

        $messages = null;
        $countryList = CHtml::listData(Country::model()->getActive(), 'id', 'title');

        $order = Order::model()->getByUserId(Yii::app()->user->id);
        $orderId = ($order) ? $order->id : 0;
        $paymentData = OrderDetail::model()->getOrderPaymentData($orderId);
        if (!$paymentData) {
            $oldOrder = Order::model()->getByUserId(Yii::app()->user->id, 3);
            if ($oldOrder)
                $paymentData = OrderDetail::model()->getOrderPaymentData($oldOrder->id);
            else {
                $paymentData = new OrderDetail();
                $profile = Profile::model()->findByPk(Yii::app()->user->id);
                $paymentData->name = $profile->firstname;
                $paymentData->surname = $profile->lastname;
                $paymentData->email = Yii::app()->user->email;
            }
        }

        if ($_POST) {
            $preorder = 0;
            $cart = Cart::model()->getByUserId(Yii::app()->user->id);
            if ($cart) {
                $cartItems = array();
                foreach ($this->cart->getItems() AS $item) {
                    $product = Product::model()->findByPk($item['product_id']);
                    if (!$product)
                        continue;
                    $productNode = $product->getProduct($item['product_node_id']);
                    if ($productNode->mainNode->quantity == 0) {
                        if ($productNode->mainNode->preorder == 1) {
                            $preorder = 1;
                        } else {
                            $this->cart->removeItem($item['product_id'], $item['product_node_id']);
                            continue;
                        }
                    }
                    if ($productNode->mainNode->quantity < $item['quantity'] AND $productNode->mainNode->preorder != 1) {
                        $this->cart->changeQuantity($item['product_id'], $item['product_node_id'], $productNode->mainNode->quantity);
                        $item['quantity'] = $productNode->mainNode->quantity;
                    }
                }
            }
            if (!$order) {
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
            if ($preorder != 0) {
                $order->preorder = 1;
                $order->save();
            }
            if ($order->total != $cart->total_price) {
                $order->quantity = $cart->total_count;
                $order->total = $cart->total_price;
                $order->save();
            }
            $orderDetail = OrderDetail::model()->getOrderPaymentData($order->id);
            if (!$orderDetail) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->type = 'payment';
            }
            $orderDetail->country_id = $_POST['country_id'];
            $orderDetail->district_id = $_POST['district_id'];
            $orderDetail->point_id = $_POST['point_id'];
            $orderDetail->name = $_POST['name'];
            $orderDetail->surname = $_POST['surname'];
            $orderDetail->phone = $_POST['phone'];
            $orderDetail->email = $_POST['email'];
            $orderDetail->house = $_POST['house'];
            $orderDetail->flat = $_POST['flat'];
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
        if (!$order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }
        $paymentData = OrderDetail::model()->getOrderPaymentData($order->id);
        $shippingData = OrderDetail::model()->getOrderShipingData($order->id);
        if (!$shippingData) {
            $oldOrder = Order::model()->getByUserId(Yii::app()->user->id, 3);
            if ($oldOrder)
                $shippingData = OrderDetail::model()->getOrderShipingData($oldOrder->id);
            else
                $shippingData = new OrderDetail();
        }

        if ($_POST) {
            $orderDetail = OrderDetail::model()->getOrderShipingData($order->id);
            if (!$orderDetail) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->type = 'shipping';
                $orderDetail->save();
            }
            $orderDetail->country_id = $_POST['country_id'];
            $orderDetail->district_id = $_POST['district_id'];
            $orderDetail->point_id = $_POST['point_id'];
            $orderDetail->name = $_POST['name'];
            $orderDetail->surname = $_POST['surname'];
            $orderDetail->phone = $_POST['phone'];
            $orderDetail->email = $_POST['email'];
            $orderDetail->house = $_POST['house'];
            $orderDetail->flat = $_POST['flat'];
            $orderDetail->street = $_POST['street'];
            $orderDetail->city = $_POST['city'];
            $orderDetail->district = $_POST['district'];
            $orderDetail->postcode = $_POST['postcode'];
            $orderDetail->notes = $_POST['notes'];
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
        if (!$order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }

        $weight = 0;
        $items = $this->cart->getItems();
        foreach ($items AS $item) {
            $productNode = ProductNode::model()->findByPk($item['product_node_id']);
            $weight += ($productNode->weight * $item['quantity']);
        }

        $shippingData = OrderDetail::model()->getOrderShipingData($order->id);
        
        $ponyExpress = new PonyExpressService(Yii::app()->params['ponyExpress']);
        $response = $ponyExpress->getRate(array(
            'citycode' => $shippingData->point_id,
            'district' => $shippingData->district_id,
            'count' => $order->quantity,
            'weight' => $weight,
                ));
        
        if ($_POST) {
            $order->shipping_method = $_POST['delivery_method'];
            $order->payment_method = $_POST['payment_method'];
            $order->shipping = $_POST['delivery_cost'];
            if ($order->save()) {
                Yii::app()->controller->redirect(array('/checkout/orderoverview'));
            } else {
                $messages = $order->getErrors();
            }
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('delivery_method', array(
            'ponyExpress' => $response,
            'order' => $order,
            'pointId' => $shippingData->point_id,
            'countryId' => $shippingData->country_id,
        ));
    }

    public function actionOrderoverview() {
        $messages = null;

        $order = Order::model()->getByUserId(Yii::app()->user->id);
        if (!$order) {
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
                if (!$product)
                    continue;
                $productNode = $product->getProduct($item['product_node_id']);
                if ($productNode->mainNode->quantity == 0) {
                    if ($productNode->mainNode->preorder == 1) {
                        $preorder = 1;
                    } else {
                        $this->cart->removeItem($item['product_id'], $item['product_node_id']);
                        continue;
                    }
                }
                if ($productNode->mainNode->quantity < $item['quantity'] AND $productNode->mainNode->preorder != 1) {
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

        $rbkServiceForm = '';

        if ($_POST) {
            if ($order->coupon_id) {
                if ($discountType == 'percentage')
                    $order->discount = '- ' . $coupon->value . ' %';
                else
                    $order->discount = '- ' . $coupon->value . Yii::app()->params['currency'];
            }
            $order->key = Order::model()->getMaxNumber(date('ym'));
            if ($order->save()) {
                if ($order->payment_method == 2)
                    Yii::app()->controller->redirect(array('/checkout/payment'));
                else {
                    $this->copyFromCart($order);
                    Yii::app()->controller->redirect(array('/checkout/confirmation'));
                }
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
            'order' => $order,
            'totalPrice' => ($totalPrice + $order->shipping),
            'cartItems' => $cartItems,
        ));
    }

    public function actionPayment() {
        $messages = null;
        $order = Order::model()->getByUserId(Yii::app()->user->id);
        if (!$order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }
        $rbkServiceForm = null;
        if ($_POST) {
            $order->status = 2;
            $order->save();
            
            $this->copyFromCart($order);
            $order->processQuantity();
            
            $this->sendConfirmMail($order);

            $rbkService = new RBKMoneyService(Yii::app()->params['RBKMoney']);
            $rbkServiceForm = $rbkService->generateRequestForm(array(
                'order' => $order->key,
                'service' => 'STORM Watches',
                'amount' => ($order->total + $order->shipping)
                    ));
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('payment', array(
            'key' => $order->key,
            'rbkServiceForm' => $rbkServiceForm,
        ));
    }

    public function actionConfirmation() {
        $messages = null;
        $order = Order::model()->getByUserId(Yii::app()->user->id);
        if (!$order) {
            Yii::app()->controller->redirect(array('/checkout'));
        }

        if ($order->sent != 1) {
            if ($this->sendConfirmMail($order)) {
                $order->sent = 1;
                $order->status = 3;
                $order->save();
                $order->processQuantity();
            }
        }
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('confirmation', array(
            'key' => $order->key,
        ));
    }

    public function actionPaymentsuccess() {
        $message = null;
        $key = $_GET['key'];

        $order = Order::model()->getByOrderKey($key);

        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('success', array(
            'key' => $key,
            'message' => $message,
        ));
    }

    public function actionPaymentfailed() {
        $this->breadcrumbs[] = Yii::t('app', 'Checkout');
        $this->render('error');
    }
    
    private function copyFromCart($order) {
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
    }

    private function sendConfirmMail($order, $adminOnly = false) {
        $paymentData = OrderDetail::model()->getOrderPaymentData($order->id);
        $shippingData = OrderDetail::model()->getOrderShipingData($order->id);
        $items = $order->items;

        $user = User::model()->findByPk($order->user_id);

        $adminMail = $this->renderPartial('//mails/admin_confirm', array(
            'order' => $order,
            'payment' => $paymentData,
            'shipping' => $shippingData,
            'items' => $items,
            'user' => $user
                ), true);
        $adminSubject = 'STORM - Подтверждение заказа';
        $adminEmail = Yii::app()->params['adminEmail'];
        
        $headers = "MIME-Version: 1.0\r\nFrom: {$adminEmail}\r\nReply-To: {$adminEmail}\r\nContent-Type: text/html; charset=utf-8";
        
        if ($adminOnly) {
            return mail($adminEmail, '=?UTF-8?B?' . base64_encode($adminSubject) . '?=', $adminMail, $headers);
        }
        
        $mail = $this->renderPartial('//mails/confirm', array(
            'order' => $order,
            'payment' => $paymentData,
            'shipping' => $shippingData,
            'items' => $items,
            'user' => $user
                ), true);
        $subject = 'STORM - Подтверждение заказа';
        $email = Yii::app()->user->email;

        return (mail($email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $mail, $headers)
                AND mail($adminEmail, '=?UTF-8?B?' . base64_encode($adminSubject) . '?=', $adminMail, $headers));
    }

}