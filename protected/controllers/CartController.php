<?php

class CartController extends Controller {

    public function actionIndex() {
        $referer = "/";
        if ($_POST) {
            $cart = $this->cart->getList();
            if ( ! $cart)
                $cart = $this->cart->create();
            if ($_POST['action'] == 'changeNode') {
                $product = Product::model()->findByPk($_POST['productId']);
                $node = $product->getProduct($_POST['newProductNodeId']);
                $this->cart->changeNode($_POST['productId'], $_POST['productNodeId'], $_POST['newProductNodeId'], $node->mainNode->price);
            }
            if ($_POST['action'] == 'addItem') {
                $this->cart->addItem($_POST['productId'], $_POST['productNodeId'], $_POST['price']);
                $referer = (isset($_SERVER["HTTP_REFERER"])) ? preg_replace("/(\/[a-zA-Z0-9\-]+\-[0-9]+)/","",$_SERVER["HTTP_REFERER"]) : '/';
            }
            if ($_POST['action'] == 'removeItem') {
                $this->cart->removeItem($_POST['productId'], $_POST['productNodeId']);
            }
            if ($_POST['action'] == 'changeQuantity') {
                $this->cart->changeQuantity($_POST['productId'], $_POST['productNodeId'], $_POST['quantity']);
            }
            
            if ($_POST['action'] == 'copy_from_wishlist') {
                foreach ($this->wishlistManager->getItems() AS $wishlistItem) {
                    $productNode = ProductNode::model()->findByPk($wishlistItem['product_node_id']);
                    if ($productNode) {
                        $this->cart->addItem($wishlistItem['product_id'], $wishlistItem['product_node_id'], $productNode->price);
                        $this->cart->changeQuantity($wishlistItem['product_id'], $wishlistItem['product_node_id'], $wishlistItem['quantity']);
                    }
                }
            }
        }
        $cart = $this->cart->getList();
        $cartItems = array();
        foreach ($this->cart->getItems() AS $cartItem) {
            $product = Product::model()->findByPk($cartItem['product_id']);
            if ( ! $product) {
                continue;
            }
            $cartItems[] = array(
                'item' => $cartItem,
                'product' => $product->getProduct($cartItem['product_node_id'])
            );
        }
        
        $discount = 0;
        $discountType = '';
        $couponId = $this->cart->getCoupon();
        if ($couponId) {
            $coupon = Coupon::model()->getActiveCoupon($couponId);
            if ($coupon) {
                $discountType = ($coupon->percentage == 1) ? 'percentage' : 'value';
                $discount = $coupon->value;
            }
        }
        
        $countries = array();
        $activeCountries = Country::model()->getActive();
        foreach ($activeCountries AS $activeCountry) {
            $countries[] = $activeCountry->title;
        }
        
        $this->breadcrumbs[] = Yii::t('app', 'Cart');
        $this->render('index', array(
            'list' => $cart,
            'items' => $cartItems,
            'cartItems' => $this->cart->getItems(),
            'countries' => $countries,
            'discount' => $discount,
            'discountType' => $discountType,
            'referer' => $referer,
        ));
    }
    
    public function actionCoupon() {
        if ($_POST) {
            $coupon = Coupon::model()->checkCode($_POST['code']);
            if ($coupon) {
                $this->cart->setCoupon($coupon->id);
            }
        }
        Yii::app()->controller->redirect(array('/cart'));
    }

}