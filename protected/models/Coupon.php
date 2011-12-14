<?php

/**
 * This is the model class for table "coupons".
 *
 * The followings are the available columns in table 'coupons':
 * @property string $id
 * @property integer $percentage
 * @property integer $once
 * @property string $code
 * @property string $value
 * @property string $issue_date
 * @property string $term_date
 * @property string $created
 * @property string $used
 *
 * The followings are the available model relations:
 * @property Cart[] $carts
 */
class Coupon extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Coupon the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'coupons';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('percentage, once, free_delivery, max_count, not_for_sale, only_rbk', 'numerical', 'integerOnly' => true),
            array('code, value', 'length', 'max' => 30),
            array('issue_date, term_date, created, used', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, percentage, once, free_delivery, max_count, not_for_sale, only_rbk, code, value, issue_date, term_date, created, used', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'carts' => array(self::HAS_MANY, 'Cart', 'coupon_id'),
            'orders' => array(self::HAS_MANY, 'Order', 'coupon_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'percentage' => 'Percentage',
            'once' => 'Use once',
            'max_count' => 'Max use count',
            'free_delivery' => 'Free delivery',
            'not_for_sale' => 'Not for sale',
            'only_rbk' => 'Only RBK',
            'code' => 'Code',
            'value' => 'Value',
            'issue_date' => 'Issue Date',
            'term_date' => 'Term Date',
            'created' => 'Created',
            'used' => 'Used',
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
        $criteria->compare('percentage', $this->percentage);
        $criteria->compare('once', $this->once);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('issue_date', $this->issue_date, true);
        $criteria->compare('term_date', $this->term_date, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('used', $this->used, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getActiveCoupon($couponId) {
        return $this->findBySql(
                "SELECT * FROM coupons WHERE id = :coupon_id ".
                "AND issue_date <= CURRENT_DATE ".
                "AND (term_date IS NULL OR term_date >= CURRENT_DATE) ".
                "AND (once != 1 OR (once = 1 AND used IS NULL))", 
                array(
                    ':coupon_id' => $couponId,
                ));
    }
    
    public function checkCode($couponCode) {
        return $this->findBySql(
                "SELECT * FROM coupons WHERE code = :coupon_code ".
                "AND issue_date <= CURRENT_DATE ".
                "AND (term_date IS NULL OR term_date >= CURRENT_DATE) ".
                "AND (once != 1 OR (once = 1 AND used IS NULL))", 
                array(
                    ':coupon_code' => $couponCode,
                ));
    }

}