<?php

class CartDatabase {
    
    protected $cart;
    protected $items;

    public function __construct() {
        $this->cart = Cart::model()->getByUserId(Yii::app()->user->id);
        if ($this->cart) {
            $this->items = $this->cart->items;
        }
    }
    
    private function refresh() {
        $this->cart = Cart::model()->getByUserId(Yii::app()->user->id);
        if ($this->cart) {
            $this->items = $this->cart->items;
        }
    }

    public function create() {
        if ( ! $this->cart)
            $this->cart = new Cart();
            $this->cart->user_id = Yii::app()->user->id;
            $this->cart->key = md5(uniqid());
            $this->cart->save();
        return $this->cart;
    }

    public function addItem($productId, $productNodeId, $price) {
        $item = CartItem::model()->findByAttributes(array(
            'cart_id' => $this->cart->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
        ));
        if ($item)
            $this->setQuantity($productId, $productNodeId, $item->quantity + 1);
        else {
            $item = new CartItem();
            $item->cart_id = $this->cart->id;
            $item->product_id = $productId;
            $item->product_node_id = $productNodeId;
            $item->quantity = 1;
            $item->price = $price;
            $item->subtotal = $price;
            $item->save();
        }
        $this->count_total();
    }
    
    public function removeItem($productId, $productNodeId) {
        $item = CartItem::model()->findByAttributes(array(
            'cart_id' => $this->cart->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
        ));
        $item->delete();
        $this->count_total();
    }

    public function setQuantity($productId, $productNodeId, $quantity) {
        $item = CartItem::model()->findByAttributes(array(
            'cart_id' => $this->cart->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
        ));
        $item->quantity = $quantity;
        $item->subtotal = ($item->price * $quantity);
        $item->save();
        $this->count_total();
    }

    public function changeNode($productId, $productNodeId, $newProductNodeId, $price) {
        $item = CartItem::model()->findByAttributes(array(
            'cart_id' => $this->cart->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
        ));
        if ( ! $item)
            return false;
        $newItem = CartItem::model()->findByAttributes(array(
            'cart_id' => $this->cart->id,
            'product_id' => $productId,
            'product_node_id' => $newProductNodeId,
        ));
        if ( ! $newItem) {
            $item->product_node_id = $newProductNodeId;
            $item->price = $price;
            $item->subtotal = ($price * $item->quantity);
            $item->save();
        } else {
            $newItem->quantity = $newItem->quantity + $item->quantity;
            $newItem->subtotal = ($newItem->price * $newItem->quantity);
            $newItem->save();
            $item->delete();
        }
    }

    public function getList() {
        $this->refresh();
        if ( ! $this->cart)
            return false;
        $cart = array(
            'user_id' => $this->cart->user_id,
            'key' => $this->cart->key,
            'total_price' => $this->cart->total_price,
            'total_count' => $this->cart->total_count,
            'coupon_id' => $this->cart->coupon_id,
        );
        return $cart;
    }

    public function getItems() {
        $this->refresh();
        $items = array();
        if (is_array($this->items)) {
            foreach ($this->items AS $item) {
                $items[] = array(
                    'product_id' => $item->product_id,
                    'product_node_id' => $item->product_node_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                );
            }
        }
        return $items;
    }
    
    public function setCoupon($couponId) {
        $this->refresh();
        $this->cart->coupon_id = $couponId;
        $this->cart->save();
    }
    
    public function getCoupon() {
        return ($this->cart) ? $this->cart->coupon_id : null;
    }

    public function delete() {
        $this->refresh();
        $this->cart->delete();
        foreach ($this->cart->items AS $item) {
            $item->delete();
        }
    }
    
    public function close() {
        $this->refresh();
        $this->cart->closed = 1;
        $this->cart->save();
    }
    
    public function count() {
        return ($this->items) ? count($this->items) : 0;
    }
    
    public function getTotalCount() {
        return $this->cart->total_count;
    }
    
    public function getTotalPrice() {
        return $this->cart->total_price;
    }
    
    private function count_total() {
        $this->refresh();
        $total_price = 0;
        $total_count = 0;
        foreach ($this->items AS $item) {
            $total_price += $item['subtotal'];
            $total_count += $item['quantity'];
        }
        $this->cart->total_price = $total_price;
        $this->cart->total_count = $total_count;
        $this->cart->save();
    }
    
}