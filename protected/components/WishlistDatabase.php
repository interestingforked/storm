<?php

class WishlistDatabase {

    protected $wishlist;
    protected $items;

    public function __construct() {
        $this->wishlist = Wishlist::model()->getByUserId(Yii::app()->user->id);
        if ($this->wishlist) {
            $this->items = $this->wishlist->items;
        }
    }

    private function refresh() {
        $this->wishlist = Wishlist::model()->getByUserId(Yii::app()->user->id);
        if ($this->wishlist) {
            $this->items = $this->wishlist->items;
        }
    }

    public function create() {
        if (!$this->wishlist)
            $this->wishlist = new Wishlist();
        $this->wishlist->user_id = Yii::app()->user->id;
        $this->wishlist->key = md5(uniqid());
        $this->wishlist->email = Yii::app()->user->email;
        $this->wishlist->save();
        return $this->wishlist;
    }

    public function addItem($productId, $productNodeId) {
        $item = WishlistItem::model()->findByAttributes(array(
            'wishlist_id' => $this->wishlist->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
                ));
        if ($item)
            $this->setQuantity($productId, $productNodeId, $item->quantity + 1);
        else {
            $item = new WishlistItem();
            $item->wishlist_id = $this->wishlist->id;
            $item->product_id = $productId;
            $item->product_node_id = $productNodeId;
            $item->quantity = 1;
            $item->save();
        }
    }

    public function removeItem($productId, $productNodeId) {
        $item = WishlistItem::model()->findByAttributes(array(
            'wishlist_id' => $this->wishlist->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
                ));
        $item->delete();
    }

    public function setQuantity($productId, $productNodeId, $quantity) {
        $item = WishlistItem::model()->findByAttributes(array(
            'wishlist_id' => $this->wishlist->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
                ));
        $item->quantity = $quantity;
        $item->save();
    }

    public function changeNode($productId, $productNodeId, $newProductNodeId) {
        $item = WishlistItem::model()->findByAttributes(array(
            'wishlist_id' => $this->wishlist->id,
            'product_id' => $productId,
            'product_node_id' => $productNodeId,
                ));
        if (!$item)
            return false;
        $newItem = WishlistItem::model()->findByAttributes(array(
            'wishlist_id' => $this->wishlist->id,
            'product_id' => $productId,
            'product_node_id' => $newProductNodeId,
                ));
        if (!$newItem) {
            $item->product_node_id = $newProductNodeId;
            $item->save();
        } else {
            $newItem->quantity = $newItem->quantity + $item->quantity;
            $newItem->save();
            $item->delete();
        }
    }

    public function getList() {
        $this->refresh();
        if ( ! $this->wishlist)
            return null;
        $wishlist = array(
            'user_id' => $this->wishlist->user_id,
            'key' => $this->wishlist->key,
            'email' => $this->wishlist->email
        );
        return $wishlist;
    }

    public function getItems() {
        $this->refresh();
        $items = array();
        if (is_array($this->items)) {
            foreach ($this->items AS $item) {
                $items[] = array(
                    'product_id' => $item->product_id,
                    'product_node_id' => $item->product_node_id,
                    'quantity' => $item->quantity
                );
            }
        }
        return $items;
    }

    public function delete() {
        $this->items->deleteAll();
        $this->wishlist->delete();
    }

    public function count() {
        return ($this->items) ? count($this->items) : 0;
    }

}