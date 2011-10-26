<?php

class WishlistController extends Controller {

    public function actionIndex() {
		$referer = "/";
        if ($_POST) {
            $wishlist = $this->wishlistManager->getList();
            if ( ! $wishlist)
                $wishlist = $this->wishlistManager->create();
            if ($_POST['action'] == 'changeNode') {
                $this->wishlistManager->changeNode($_POST['productId'], $_POST['productNodeId'], $_POST['newProductNodeId']);
            }
            if ($_POST['action'] == 'addItem') {
                $this->wishlistManager->addItem($_POST['productId'], $_POST['productNodeId']);
				$referer = (isset($_SERVER["HTTP_REFERER"])) ? preg_replace("/(\/[a-zA-Z0-9\-]+\-[0-9]+)/","",$_SERVER["HTTP_REFERER"]) : '/';
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
            if ( ! $product) {
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

}