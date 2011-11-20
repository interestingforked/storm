<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property string $id
 * @property string $parent_id
 * @property integer $active
 * @property integer $sort
 * @property string $slug
 * @property string $image
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class Category extends CActiveRecord {

    public $content;

    /**
     * Returns the static model of the specified AR class.
     * @return Category the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('slug', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('parent_id', 'length', 'max' => 11),
            array('slug, image', 'length', 'max' => 250),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, parent_id, active, sort, slug, image, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'getparent' => array(self::BELONGS_TO, 'Category', 'parent_id'),
            'childs' => array(self::HAS_MANY, 'Category', 'parent_id', 'order' => 'sort ASC'),
            'products' => array(self::MANY_MANY, 'Product', 'product_category(category_id, product_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'parent_id' => 'Parent',
            'active' => 'Active',
            'sort' => 'Sort',
            'slug' => 'Slug',
            'image' => 'Image',
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
        $criteria->compare('slug', $this->slug, true);
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getAllCategories() {
        return $this->findAll("id > 1");
    }

    public function getListed($id = '', $visibleAll = false) {
        $subitems = array();
        if ($this->childs)
            foreach ($this->childs as $child) {
                if ($child->active != 1)
                    continue;
                $subitems[] = $child->getListed($id, $visibleAll);
            }
        $categoryContent = Content::model()->getModuleContent('category', $this->id);
        $active = (preg_match("/" . str_replace("/", "\/", $this->slug) . "/", $id) > 0);
        $parent = $this->getparent;
        $activeParent = false;
        if ($parent)
            $activeParent = (preg_match("/" . str_replace("/", "\/", $parent->slug) . "/", $id) > 0);
        $returnarray = array(
            'label' => (isset($categoryContent->title)) ? $categoryContent->title : '',
            'url' => array('/' . $this->slug),
            'active' => $active,
            'visible' => ($active OR $activeParent OR $this->parent_id == 1 OR $this->parent_id == 2 OR $visibleAll)
        );
        if ($subitems != array())
            $returnarray = array_merge($returnarray, array('items' => $subitems));
        return $returnarray;
    }

    public function getOptionList($parent = '') {
        $subitems = array();
        $categoryContent = Content::model()->getModuleContent('category', $this->id);
        $title = (isset($categoryContent->title)) ? $categoryContent->title : '';
        if ($this->childs)
            foreach ($this->childs as $child) {
                $subitems[] = $child->getOptionList($title);
            }
        if ($this->id > 1) {
            $returnArray[$this->id . ' '] = ($parent ? $parent . ' > ' : '') . $categoryContent->title;
        } else {
            $returnArray = array();
        }
        if ($subitems != array())
            foreach ($subitems AS $subitem) {
                $returnArray = array_merge($returnArray, $subitem);
            }
        return $returnArray;
    }

    public function getCategory($slug) {
        $category = $this->findByAttributes(array('slug' => $slug));
        $category->content = Content::model()->getModuleContent('category', $category->id);
        return $category;
    }

}