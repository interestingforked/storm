<?php

/**
 * This is the model class for table "product_nodes".
 *
 * The followings are the available columns in table 'product_nodes':
 * @property string $id
 * @property string $product_id
 * @property integer $active
 * @property integer $new
 * @property integer $main
 * @property integer $sale
 * @property string $price
 * @property string $old_price
 * @property integer $quantity
 * @property integer $sort
 * @property string $color
 * @property string $size
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class ProductNode extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return ProductNode the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_nodes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, price', 'required'),
            array('active, main, new, sale, preorder, notify, quantity, sort, deleted, never_runs_out', 'numerical', 'integerOnly' => true),
            array('product_id', 'length', 'max' => 11),
            array('price, old_price', 'length', 'max' => 15),
            array('color, size', 'length', 'max' => 30),
			array('code', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, product_id, code, active, main, new, sale, preorder, notify, price, old_price, quantity, sort, color, size, never_runs_out, deleted, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
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
            'active' => 'Active',
            'main' => 'Main',
            'new' => 'New',
            'sale' => 'Sale',
            'preorder' => 'Preorder',
            'notify' => 'Notify',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'quantity' => 'Quantity',
            'sort' => 'Sort',
            'color' => 'Color',
            'size' => 'Size',
            'never_runs_out' => 'Never runs out',
            'deleted' => 'Deleted',
            'created' => 'Created',
        );
    }

    public function defaultScope() {
        return array(
            'order' => 'sort ASC',
        );
    }
    
    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'active = 1'
            ),
            'notDeleted' => array(
                'condition' => 'deleted = 0'
            ),
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
        $criteria->compare('active', $this->active);
        $criteria->compare('main', $this->main);
        $criteria->compare('new', $this->new);
        $criteria->compare('sale', $this->sale);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('old_price', $this->old_price, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}