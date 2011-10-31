<?php

/**
 * This is the model class for table "notifyings".
 *
 * The followings are the available columns in table 'notifyings':
 * @property string $id
 * @property string $product_id
 * @property string $product_node_id
 * @property string $email
 * @property string $sent
 * @property string $created
 */
class Notifying extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Notifying the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'notifyings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, product_node_id, email', 'required'),
            array('product_id, product_node_id', 'length', 'max' => 11),
            array('email', 'length', 'max' => 250),
            array('sent, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, product_id, product_node_id, email, sent, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productNode' => array(self::BELONGS_TO, 'ProductNode', 'product_node_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'product_node_id' => 'Product Node',
            'email' => 'Email',
            'sent' => 'Sent',
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
        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('product_node_id', $this->product_node_id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('sent', $this->sent, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function checkNotify($params) {
        return $this->countByAttributes(array(
                    'product_id' => $params['productId'],
                    'product_node_id' => $params['productNodeId'],
                    'email' => $params['email']
                ));
    }
    
    public function findNotSent() {
        return $this->findAllByAttributes(array(
            'sent' => null
        ));
    }

}