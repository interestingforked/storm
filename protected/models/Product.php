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

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'products';
    }

    public function rules() {
        return array(
            array('active, sort, deleted', 'numerical', 'integerOnly' => true),
            array('slug', 'length', 'max' => 250),
            array('id, active, sort, slug, deleted, created', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
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
            'SaveRelationsBehavior' => array(
                'class' => 'SaveRelationsBehavior',
                'relations' => array(
                    'categories' => array("message" => "Please, check the categories"),
                )
            )
        );
    }

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

    public function scopes() {
        return array(
            'notDeleted' => array(
                'condition' => 'deleted = 0'
            ),
            'orderById' => array(
                'order' => 'id ASC',
            ),
            'orderBySort' => array(
                'order' => 'sort ASC',
            ),
            'active' => array(
                'condition' => 'active = 1'
            ),
        );
    }

    public function getProduct($id = 0) {
        $this->content = Content::model()->getModuleContent('product', $this->id);
        foreach ($this->productNodes AS $node) {
            if ($node->deleted == 1) {
                continue;
            }
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