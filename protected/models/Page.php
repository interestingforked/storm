<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property string $id
 * @property string $parent_id
 * @property integer $active
 * @property integer $sort
 * @property string $slug
 * @property string $created
 */
class Page extends CActiveRecord {

    public $content;

    /**
     * Returns the static model of the specified AR class.
     * @return Page the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pages';
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
            array('slug', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, parent_id, active, sort, slug, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'getparent' => array(self::BELONGS_TO, 'Page', 'parent_id'),
            'childs' => array(self::HAS_MANY, 'Page', 'parent_id', 'order' => 'sort ASC'),
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
    
    public function getAllPages() {
        return $this->findAll("parent_id > 0");
    }

    public function getListed($id = '', $visibleAll = false) {
        $subitems = array();
        if ($this->childs)
            foreach ($this->childs as $child) {
                if ($child->active != 1)
                    continue;
                $subitems[] = $child->getListed($id, $visibleAll);
            }
        
        $pageContent = Content::model()->getModuleContent('page', $this->id);
        $active = (preg_match("/" . str_replace("/", "\/", $this->slug) . "/", $id) > 0);
        $parent = $this->getparent;
        $activeParent = false;
        if ($parent) {
            $activeParent = (preg_match("/" . str_replace("/", "\/", $parent->slug) . "/", $id) > 0);
        }
        $returnarray = array(
            'label' => (isset($pageContent->title)) ? $pageContent->title : '',
            'url' => array('/' . $this->slug),
            'active' => ($active AND $activeParent),
            'visible' => ($active OR $activeParent OR $this->parent_id == 1 OR $visibleAll)
        );
        if ($subitems != array())
            $returnarray = array_merge($returnarray, array('items' => $subitems));
        return $returnarray;
    }

    public function getPage($slug) {
        $page = $this->findByAttributes(array('slug' => $slug));
        $page->content = Content::model()->getModuleContent('page', $page->id);
        return $page;
    }
    
    public function getPageByPlugin($plugin) {
        $page = $this->findByAttributes(array('plugin' => $plugin));
        $page->content = Content::model()->getModuleContent('page', $page->id);
        return $page;
    }

}