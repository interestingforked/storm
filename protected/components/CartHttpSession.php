<?php

class CartHttpSession {

    protected $cart;
    protected $items;
    protected $driver;

    public function __construct() {
        $this->driver = new CHttpSession();
        $this->driver->open();
        $this->cart = $this->getList();
        $this->items = $this->getItems();
    }

    public function create() {
        $this->cart = array(
            'key' => $this->driver->getSessionID(),
            'total_count' => 0,
            'total_price' => 0.00,
            'coupon_id' => 0,
        );
        $this->driver->add('cart', $this->cart);
        return $this->cart;
    }

    public function addItem($productId, $productNodeId, $price) {
        $id = $productId.'-'.$productNodeId;
        $this->items[$id] = array(
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
            'quantity' => 1,
            'price' => $price,
            'subtotal' => $price
        );
        $this->driver->add('cart_items', $this->items);
        $this->count_total();
    }
    
    public function removeItem($productId, $productNodeId) {
        $id = $productId.'-'.$productNodeId;
        unset($this->items[$id]);
        $this->driver->add('cart_items', $this->items);
        $this->count_total();
    }

    public function setQuantity($productId, $productNodeId, $quantity) {
        $id = $productId.'-'.$productNodeId;
        $this->items[$id]['quantity'] = $quantity;
        $this->items[$id]['subtotal'] = ($quantity * $this->items[$id]['price']);
        $this->driver->add('cart_items', $this->items);
        $this->count_total();
    }

    public function changeNode($productId, $productNodeId, $newProductNodeId, $price) {
        $id = $productId.'-'.$productNodeId;
        $newId = $productId.'-'.$newProductNodeId;
        if ( ! isset($this->items[$id]))
            return;
        $this->items[$id]['product_node_id'] = $newProductNodeId;
        $this->items[$id]['price'] = $price;
        $this->items[$id]['subtotal'] = ($this->items[$id]['quantity'] * $price);
        $this->items[$newId] = $this->items[$id];
        $this->removeItem($productId, $productNodeId);
    }
    
    public function setCoupon($couponId) {
        $this->cart['coupon_id'] = $couponId;
        $this->driver->add('cart', $this->cart);
    }
    
    public function getCoupon() {
        return $this->cart['coupon_id'];
    }

    public function getList() {
        return $this->driver->get('cart');
    }

    public function getItems() {
        return $this->driver->get('cart_items', array());
    }

    public function delete() {
        $this->driver->remove('cart');
        $this->driver->remove('cart_items');
    }
    
    public function count() {
        return ($this->items) ? count($this->items) : 0;
    }
    
    public function getTotalCount() {
        return $this->cart['total_count'];
    }
    
    public function getTotalPrice() {
        return $this->cart['total_price'];
    }
    
    private function count_total() {
        $total_price = 0;
        $total_count = 0;
        foreach ($this->items AS $item) {
            $total_price += $item['subtotal'];
            $total_count += $item['quantity'];
        }
        $this->cart['total_price'] = $total_price;
        $this->cart['total_count'] = $total_count;
        $this->driver->add('cart', $this->cart);
    }
    
    public function close() {}

}
