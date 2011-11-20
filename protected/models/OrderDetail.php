<?php

/**
 * This is the model class for table "order_details".
 *
 * The followings are the available columns in table 'order_details':
 * @property string $id
 * @property string $order_id
 * @property string $type
 * @property string $country_id
 * @property string $region_id
 * @property string $district_id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $email
 * @property string $house
 * @property string $street
 * @property string $city
 * @property string $district
 * @property string $postcode
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Countrie $country
 * @property District $district0
 * @property Order $order
 * @property Region $region
 */
class OrderDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return OrderDetail the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'order_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, type', 'required'),
            array('order_id, country_id, region_id, district_id', 'length', 'max' => 11),
            array('type, postcode', 'length', 'max' => 10),
            array('name, surname, house, flat', 'length', 'max' => 30),
            array('phone', 'length', 'max' => 20),
            array('email', 'length', 'max' => 128),
            array('street', 'length', 'max' => 60),
            array('city', 'length', 'max' => 50),
            array('district', 'length', 'max' => 100),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, order_id, type, country_id, region_id, district_id, name, surname, phone, email, house, flat, street, city, district, postcode, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
            'district' => array(self::BELONGS_TO, 'District', 'district_id'),
            'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
            'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'order_id' => 'Order',
            'type' => 'Type',
            'country_id' => 'Country',
            'region_id' => 'Region',
            'district_id' => 'District',
            'name' => 'Name',
            'surname' => 'Surname',
            'phone' => 'Phone',
            'email' => 'Email',
            'house' => 'House',
            'flat' => 'Flat',
            'street' => 'Street',
            'city' => 'City',
            'district' => 'District',
            'postcode' => 'Postcode',
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
        $criteria->compare('order_id', $this->order_id, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('country_id', $this->country_id, true);
        $criteria->compare('region_id', $this->region_id, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('house', $this->house, true);
        $criteria->compare('flat', $this->flat, true);
        $criteria->compare('street', $this->street, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('district', $this->district, true);
        $criteria->compare('postcode', $this->postcode, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getOrderPaymentData($orderId) {
        return $this->findByAttributes(array(
            'order_id' => $orderId,
            'type' => 'payment'
        ));
    }
    
    public function getOrderShipingData($orderId) {
        return $this->findByAttributes(array(
            'order_id' => $orderId,
            'type' => 'shipping'
        ));
    }

}