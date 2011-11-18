<?php

class WishlistController extends Controller {

    public function actionIndex() {
        $referer = "/";
        if ($_POST) {
            $wishlist = $this->wishlistManager->getList();
            if (!$wishlist)
                $wishlist = $this->wishlistManager->create();
            if ($_POST['action'] == 'changeNode') {
                $this->wishlistManager->changeNode($_POST['productId'], $_POST['productNodeId'], $_POST['newProductNodeId']);
            }
            if ($_POST['action'] == 'addItem') {
                $this->wishlistManager->addItem($_POST['productId'], $_POST['productNodeId']);
                $referer = (isset($_SERVER["HTTP_REFERER"])) ? preg_replace("/(\/[a-zA-Z0-9\-]+\-[0-9]+)/", "", $_SERVER["HTTP_REFERER"]) : '/';
            }
            if ($_POST['action'] == 'removeItem') {
                $this->wishlistManager->removeItem($_POST['productId'], $_POST['productNodeId']);
            }
            if ($_POST['action'] == 'changeQuantity') {
                $this->wishlistManager->changeQuantity($_POST['productId'], $_POST['productNodeId'], $_POST['quantity']);
            }
        }
        $wishlist = $this->wishlistManager->getList();
        $wishlistItems = array();
        foreach ($this->wishlistManager->getItems() AS $wishlistItem) {
            $product = Product::model()->findByPk($wishlistItem['product_id']);
            if (!$product) {
                continue;
            }
            $wishlistItems[] = array(
                'item' => $wishlistItem,
                'product' => $product->getProduct($wishlistItem['product_node_id'])
            );
        }

        $this->breadcrumbs[] = Yii::t('app', 'Wishlist');
        $this->render('index', array(
            'list' => $wishlist,
            'items' => $wishlistItems,
            'wishlistItems' => $this->wishlistManager->getItems(),
            'referer' => $referer,
        ));
    }
    
    public function actionSend() {
        $message = null;
        $wishlist = $this->wishlistManager->getList();
        $wishlistItems = $this->wishlistManager->getItems();
        if ($_POST) {
            $user = User::model()->findByPk(Yii::app()->user->getId());
            $profile = $user->profile;
            $mail = $this->renderPartial('//mails/wishlist', array(
                'message' => $_POST['message'],
                'list' => $wishlist,
                'items' => $wishlistItems,
                'fromWho' => $profile->firstname.' '.$profile->lastname,
            ), true);
            
            $subject = 'STORM - список предпочтений';
            $adminEmail = Yii::app()->params['adminEmail'];
            $headers = "MIME-Version: 1.0\r\nFrom: {$adminEmail}\r\nReply-To: {$adminEmail}\r\nContent-Type: text/html; charset=utf-8";
            
            $emails = explode("\r\n", $_POST['emails']);
            foreach ($emails AS $email) {
                mail($email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $mail, $headers);
            }
            Yii::app()->controller->redirect(array('/wishlist'));
        }
        $this->render('send', array(
            'message' => $message,
            'items' => $wishlistItems,
        ));
    }
    
    public function actionView() {
        $key = Yii::app()->getRequest()->getParam('key');
        $wishlist = Wishlist::model()->findByWishlistKey($key);
        $wishlistItems = array();
        if ($wishlist) {
            foreach ($wishlist->items AS $wishlistItem) {
                $product = Product::model()->findByPk($wishlistItem->product_id);
                if (!$product) {
                    continue;
                }
                $wishlistItems[] = array(
                    'item' => $wishlistItem,
                    'product' => $product->getProduct($wishlistItem->product_node_id)
                );
            }
        }
        $this->breadcrumbs[] = Yii::t('app', 'Wishlist');
        $this->render('view', array(
            'list' => $wishlist,
            'items' => $wishlistItems,
        ));
    }

}