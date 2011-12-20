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
                $referer = (isset($_SERVER["HTTP_REFERER"])) ? ((preg_match('/product/',$_SERVER["HTTP_REFERER"])==0)?preg_replace("/(\/[a-zA-Z0-9\-]+\-[0-9]+)/","",$_SERVER["HTTP_REFERER"]):"") : '/';
            }
            if ($_POST['action'] == 'removeItem') {
                $this->cart->removeItem($_POST['productId'], $_POST['productNodeId']);
            }
            if ($_POST['action'] == 'changeQuantity') {
                if ($_POST['quantity'] == 0)
                    $this->cart->removeItem($_POST['productId'], $_POST['productNodeId']);
                else
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
        
        $saleSum = 0;
        
        $cart = $this->cart->getList();
        $cartItems = array();
        foreach ($this->cart->getItems() AS $cartItem) {
            $product = Product::model()->findByPk($cartItem['product_id']);
            if ( ! $product) {
                continue;
            }
            $productNode = $product->getProduct($cartItem['product_node_id']);
            if ($productNode->mainNode->sale) {
                $saleSum += $productNode->mainNode->price;
            }
            $cartItems[] = array(
                'item' => $cartItem,
                'product' => $productNode
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
                if ($coupon->not_for_sale != 1) {
                    $saleSum = 0;
                }
            }
        }
        
        $countries = array();
        $activeCountries = Country::model()->getActive();
        foreach ($activeCountries AS $activeCountry) {
            $countries[] = $activeCountry->title;
        }
        
        $categoryLink = "";
        $session = new CHttpSession();
        $session->open();
        $categoryOrder = $session->get('categoryOrder');
        if ($categoryOrder) {
            $categoryLink = $categoryLink.'?orderby='.$categoryOrder;
        }
        $categoryPage = $session->get('categoryPage');
        if ($categoryPage) {
            $categoryLink = $categoryLink.(($categoryOrder)?'&':'?').'page='.$categoryPage;
        }
        $categoryViewAll = $session->get('categoryViewAll');
        if ($categoryViewAll) {
            $categoryLink = $categoryLink.(($categoryOrder)?'&':'?').'viewall='.$categoryViewAll;
        }
        if ($referer != '/' AND !empty($categoryLink)) {
            $referer .= $categoryLink;
        }
        
        $this->breadcrumbs[] = Yii::t('app', 'Cart');
        $this->render('index', array(
            'list' => $cart,
            'items' => $cartItems,
            'cartItems' => $this->cart->getItems(),
            'countries' => $countries,
            'discount' => $discount,
            'saleSum' => $saleSum,
            'discountType' => $discountType,
            'referer' => $referer,
        ));
    }
    
    public function actionCoupon() {
        if ($_POST) {
            $coupon = Coupon::model()->checkCode($_POST['code']);
            if ($coupon AND !$this->cart->getCoupon()) {
                $this->cart->setCoupon($coupon->id);
            }
        }
        Yii::app()->controller->redirect(array('/cart'));
    }

}