<?php

class WishlistHttpSession {

    protected $wishlist;
    protected $items;
    protected $driver;

    public function __construct() {
        $this->driver = new CHttpSession();
        $this->driver->open();
        $this->wishlist = $this->getList();
        $this->items = $this->getItems();
    }

    public function create() {
        $this->wishlist = array(
            'key' => $this->driver->getSessionID(),
        );
        $this->driver->add('wishlist', $this->wishlist);
        return $this->wishlist;
    }

    public function addItem($productId, $productNodeId) {
        $this->items[$productId.'-'.$productNodeId] = array(
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
            'quantity' => 1
        );
        $this->driver->add('wishlist_items', $this->items);
    }
    
    public function removeItem($productId, $productNodeId) {
        unset($this->items[$productId.'-'.$productNodeId]);
        $this->driver->add('wishlist_items', $this->items);
    }

    public function setQuantity($productId, $productNodeId, $quantity) {
        $this->items[$productId.'-'.$productNodeId]['quantity'] = $quantity;
        $this->driver->add('wishlist_items', $this->items);
    }

    public function changeNode($productId, $productNodeId, $newProductNodeId) {
        if ( ! isset($this->items[$productId.'-'.$productNodeId]))
            return;
        $this->items[$productId.'-'.$productNodeId]['product_node_id'] = $newProductNodeId;
        $this->items[$productId.'-'.$newProductNodeId] = $this->items[$productId.'-'.$productNodeId];
        $this->removeItem($productId, $productNodeId);
    }

    public function getList() {
        return $this->driver->get('wishlist');
    }

    public function getItems() {
        return $this->driver->get('wishlist_items', array());
    }

    public function delete() {
        $this->driver->remove('wishlist');
        $this->driver->remove('wishlist_items');
    }
    
    public function count() {
        return ($this->items) ? count($this->items) : 0;
    }

}
