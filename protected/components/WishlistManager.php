<?php

class WishlistManager {

    protected $manager;
    
    public function __construct() {
        if (Yii::app()->user->isGuest)
            $this->manager = new WishlistHttpSession();
        else
            $this->manager = new WishlistDatabase();
    }
    
    public function create() {
        return $this->manager->create();
    }
    
    public function addItem($productId, $productNodeId) {
        $this->manager->addItem($productId, $productNodeId);
    }
    
    public function removeItem($productId, $productNodeId) {
        $this->manager->removeItem($productId, $productNodeId);
    }
    
    public function changeQuantity($productId, $productNodeId, $quantity) {
        $this->manager->setQuantity($productId, $productNodeId, $quantity);
    }
    
    public function changeNode($productId, $productNodeId, $newProductNodeId) {
        $this->manager->changeNode($productId, $productNodeId, $newProductNodeId);
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
    
    public function count() {
        return $this->manager->count();
    }
    
    public function moveToDatabase() {
        if ( ! $this->manager instanceof WishlistHttpSession)
            return false;
        if ($this->count() == 0)
            return false;
        $wishlistDatabaseManager = new WishlistDatabase();
        $wishlist = $wishlistDatabaseManager->create();
        foreach ($this->getItems() AS $item) {
            $wishlistDatabaseManager->addItem($item['product_id'], $item['product_node_id']);
            if ($item['quantity'] > 1)
                $wishlistDatabaseManager->setQuantity($item['product_id'], $item['product_node_id'], $item['quantity']);
        }
        $this->manager->delete();
        $this->manager = new WishlistDatabase();
    }
    
}
