<?php

/**
 * This is the model class for table "cart".
 *
 * The followings are the available columns in table 'cart':
 * @property string $id
 * @property string $user_id
 * @property string $coupon_id
 * @property string $key
 * @property string $total_price
 * @property integer $total_count
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Coupon $coupon
 * @property User $user
 * @property CartItem[] $items
 * @property Order[] $orders
 */
class Cart extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Cart the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cart';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('total_count', 'numerical', 'integerOnly' => true),
            array('user_id, coupon_id', 'length', 'max' => 11),
            array('key', 'length', 'max' => 32),
            array('total_price', 'length', 'max' => 15),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, coupon_id, key, total_price, total_count, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'coupon' => array(self::BELONGS_TO, 'Coupon', 'coupon_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'items' => array(self::HAS_MANY, 'CartItem', 'cart_id'),
            'orders' => array(self::HAS_MANY, 'Order', 'cart_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'coupon_id' => 'Coupon',
            'key' => 'Key',
            'total_price' => 'Total Price',
            'total_count' => 'Total Count',
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('coupon_id', $this->coupon_id, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('total_count', $this->total_count);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getByUserId($userId) {
        return $this->findByAttributes(array(
            'user_id' => $userId,
            'closed' => 0,
        ));
    }

}