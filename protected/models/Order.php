<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property string $id
 * @property string $cart_id
 * @property string $user_id
 * @property integer $status
 * @property integer $shipping_method
 * @property integer $payment_method
 * @property integer $quantity
 * @property string $total
 * @property string $comment
 * @property string $ip
 * @property string $created
 *
 * The followings are the available model relations:
 * @property OrderDetail[] $orderDetails
 * @property User $user
 * @property Cart $cart
 */
class Order extends CActiveRecord {

    public $number;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'orders';
    }

    public function rules() {
        return array(
            array('cart_id, user_id', 'required'),
            array('status, shipping_method, payment_method, quantity', 'numerical', 'integerOnly' => true),
            array('cart_id, user_id', 'length', 'max' => 11),
            array('total, ip', 'length', 'max' => 15),
            array('comment, created', 'safe'),
            array('id, cart_id, user_id, status, shipping_method, payment_method, quantity, total, shipping, discount, comment, ip, created', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'order_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'cart' => array(self::BELONGS_TO, 'Cart', 'cart_id'),
            'items' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
            'coupon' => array(self::BELONGS_TO, 'Coupon', 'coupon_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cart_id' => 'Cart',
            'user_id' => 'User',
            'status' => 'Status',
            'shipping_method' => 'Shiping Method',
            'payment_method' => 'Payment Method',
            'quantity' => 'Quantity',
            'total' => 'Total',
            'shipping' => 'Shipping',
            'discount' => 'Discount',
            'comment' => 'Comment',
            'ip' => 'Ip',
            'created' => 'Created',
        );
    }
    
    public function scopes() {
        return array(
            'ordered' => array(
                'order' => 'id DESC',
            ),
            'last' => array(
                'order' => 'created DESC',
            ),
        );
    }
    
    public function limited($limit = 5) {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $limit,
        ));
        return $this;
    }

    public function getByUserId($userId, $status = 1) {
        return $this->ordered()->findByAttributes(array(
                    'user_id' => $userId,
                    'status' => $status,
                ));
    }

    public function getByOrderKey($orderKey) {
        return $this->ordered()->findByAttributes(array(
                    'key' => $orderKey,
                ));
    }

    public function getLastOrders($limit = 5) {
        return $this->last()->limited($limit)->findAll();
    }
    
    public function getMaxNumber($date = null) {
        if (!$date)
            $date = date('ym');
        $maxNumber = $this->findBySql("SELECT SUBSTRING(MAX(`key`),5) AS number FROM orders WHERE SUBSTRING(`key`,1,4) = '{$date}'");
        if (!$maxNumber)
            return sprintf("%s%03s", $date, 1);
        else
            return sprintf("%s%03s", $date, ((int) $maxNumber->number) + 1);
    }

    public function processQuantity() {
        $orderItems = $this->items;
        if ($orderItems) {
            foreach ($orderItems AS $orderItem) {
                $productNode = ProductNode::model()->findByPk($orderItem->product_node_id);
                if ($productNode) {
                    if ($productNode->quantity > $orderItem->quantity)
                        $productNode->quantity = $productNode->quantity - $orderItem->quantity;
                    else
                        $productNode->quantity = 0;
                    $productNode->save();
                }
            }
        }
    }
    
    public function orderStatus($order) {
        if ($order->payment_method == 1 AND $order->status == 3)
            return 'Оплата наличными курьеру';
        if ($order->payment_method == 2 AND $order->status == 2)
            return 'Оплата ожидается через RBK';
        if ($order->payment_method == 2 AND $order->status == 4)
            return 'Оплачено через RBK';
    }

}