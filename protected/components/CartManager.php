<?php

class CartManager {

    protected $manager;
    
    public function __construct() {
        if (Yii::app()->user->isGuest)
            $this->manager = new CartHttpSession();
        else
            $this->manager = new CartDatabase();
    }
    
    public function create() {
        return $this->manager->create();
    }
    
    public function addItem($productId, $productNodeId, $price) {
        $price = $this->format_price($price);
        if ( ! $price)
            return false;
        $this->manager->addItem($productId, $productNodeId, $price);
    }
    
    public function removeItem($productId, $productNodeId) {
        $this->manager->removeItem($productId, $productNodeId);
    }
    
    public function changeQuantity($productId, $productNodeId, $quantity) {
        $this->manager->setQuantity($productId, $productNodeId, $quantity);
    }
    
    public function changeNode($productId, $productNodeId, $newProductNodeId, $price) {
        $price = $this->format_price($price);
        if ( ! $price)
            return false;
        $this->manager->changeNode($productId, $productNodeId, $newProductNodeId, $price);
    }
    
    public function getList() {
        return $this->manager->getList();
    }
    
    public function getItems() {
        return $this->manager->getItems();
    }
    
    public function delete() {
        $this->manager->delete();
    }
    
    public function close() {
        $this->manager->close();
    }
    
    public function count() {
        return $this->manager->count();
    }
    
    public function total() {
        return $this->manager->total();
    }
    
    public function getTotalCount() {
        return $this->manager->getTotalCount();
    }
    
    public function getTotalPrice() {
        return $this->manager->getTotalPrice();
    }
    
    public function setCoupon($couponId) {
        $this->manager->setCoupon($couponId);
    }
    
    public function getCoupon() {
        return ($this->manager->getCoupon()) ? $this->manager->getCoupon() : false;
    }
    
    public function format_price($price) {
        $price = trim(preg_replace('/([^0-9\.])/i', '', $price));
        $price = trim(preg_replace('/(^[0]+)/i', '', $price));
        if ( ! is_numeric($price)) {
            return false;
        }
        return $price;
    }
    
    public function moveToDatabase() {
        if ( ! $this->manager instanceof CartHttpSession)
            return false;
        if ($this->count() == 0)
            return false;
        $cartDatabaseManager = new CartDatabase();
        $cart = $cartDatabaseManager->create();
        foreach ($this->getItems() AS $item) {
            $cartDatabaseManager->addItem($item['product_id'], $item['product_node_id'], $item['price']);
            if ($item['quantity'] > 1)
                $cartDatabaseManager->setQuantity($item['product_id'], $item['product_node_id'], $item['quantity']);
        }
        $this->manager->delete();
        $this->manager = new CartDatabase();
    }
    
}
