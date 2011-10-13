<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property string $id
 * @property string $category_id
 * @property integer $active
 * @property integer $sort
 * @property string $slug
 * @property string $created
 *
 * The followings are the available model relations:
 * @property ProductNode[] $productNodes
 * @property Category $category
 */
class Product extends CActiveRecord {

    public $content;
    public $mainNode;

    /**
     * Returns the static model of the specified AR class.
     * @return Product the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'products';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('active, sort, deleted', 'numerical', 'integerOnly' => true),
            array('slug', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, active, sort, slug, deleted, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cartItems' => array(self::HAS_MANY, 'CartItem', 'product_id'),
            'notifyings' => array(self::HAS_MANY, 'Notifying', 'product_id'),
            'orderItems' => array(self::HAS_MANY, 'OrderItem', 'product_id'),
            'productNodes' => array(self::HAS_MANY, 'ProductNode', 'product_id'),
            'categories' => array(self::MANY_MANY, 'Category', 'product_category(product_id, category_id)'),
            'wishlistItems' => array(self::HAS_MANY, 'WishlistItem', 'product_id'),
        );
    }

    public function behaviors() {
        return array(
            'CSaveRelationsBehavior' => array(
                'class' => 'CSaveRelationsBehavior',
                'relations' => array(
                    'categories' => array("message" => "Please, check the categories"),
                )
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'active' => 'Active',
            'sort' => 'Sort',
            'slug' => 'Slug',
            'deleted' => 'Deleted',
            'created' => 'Created',
        );
    }

    public function defaultScope() {
        return array(
            'condition' => 'deleted = 0',
            'order' => 'sort ASC',
        );
    }

    public function scopes() {
        return array(
            'ordered' => array(
                'order' => 'id ASC',
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
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('sort', $this->sort);
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getByNumber($number) {
        return $this->findByAttributes(array('number' => $number));
    }

    public function getProduct($id = 0) {
        $this->content = Content::model()->getModuleContent('product', $this->id);
        $nodes = array();
        foreach ($this->productNodes AS $node) {
            if ($id == $node->id) {
                $this->mainNode = $node;
            }
            if ($id == 0 AND $node->main == 1) {
                $this->mainNode = $node;
            }
        }
        return $this;
    }
	
}