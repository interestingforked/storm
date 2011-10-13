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

    /**
     * Returns the static model of the specified AR class.
     * @return Order the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cart_id, user_id', 'required'),
            array('status, shipping_method, payment_method, quantity', 'numerical', 'integerOnly' => true),
            array('cart_id, user_id', 'length', 'max' => 11),
            array('total, ip', 'length', 'max' => 15),
            array('comment, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, cart_id, user_id, status, shipping_method, payment_method, quantity, total, shipping, discount, comment, ip, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'order_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'cart' => array(self::BELONGS_TO, 'Cart', 'cart_id'),
            'items' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
            'coupon' => array(self::BELONGS_TO, 'Coupon', 'coupon_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('cart_id', $this->cart_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('shipping_method', $this->shipping_method);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('shipping', $this->shipping, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getByUserId($userId, $status = 1) {
        return $this->ordered()->findByAttributes(array(
                    'user_id' => $userId,
                    'status' => $status,
                ));
    }

    public function getMaxNumber($date = null) {
        if (!$date)
            $date = date('ym');
        $maxNumber = $this->findBySql("SELECT SUBSTRING(MAX(key),5) AS number FROM orders WHERE SUBSTRING(key,1,4) = '{$date}'");
        if (!$maxNumber)
            return sprintf("%s%03s", $date, 1);
        else
            return sprintf("%s%03s", $date, ((int) $maxNumber->key) + 1);
    }

    public function scopes() {
        return array(
            'ordered' => array(
                'order' => 'id DESC',
            ),
        );
    }

}