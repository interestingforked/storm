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

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'pages';
    }

    public function rules() {
        return array(
            array('slug', 'required'),
            array('active, sort, deleted', 'numerical', 'integerOnly' => true),
            array('parent_id', 'length', 'max' => 11),
            array('slug', 'length', 'max' => 250),
			array('plugin', 'length', 'max' => 100),
            array('id, parent_id, active, sort, plugin, deleted, slug, created', 'safe', 'on' => 'search'),
        );
    }


    public function relations() {
        return array(
            'getparent' => array(self::BELONGS_TO, 'Page', 'parent_id'),
            'childs' => array(self::HAS_MANY, 'Page', 'parent_id', 'order' => 'sort ASC'),
        );
    }

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
    
    public function getAllPages() {
        return $this->notDeleted()->findAll("parent_id > 0");
    }

    public function getPage($slug) {
        $page = $this->notDeleted()->findByAttributes(array('slug' => $slug));
		if (!$page) {
			return false;
		}
        $page->content = Content::model()->getModuleContent('page', $page->id);
        return $page;
    }
    
    public function getPageByPlugin($plugin) {
        $page = $this->notDeleted()->findByAttributes(array('plugin' => $plugin));
		if (!$page) {
			return false;
		}
        $page->content = Content::model()->getModuleContent('page', $page->id);
        return $page;
    }
    
    public function getListed($id = '', $visibleAll = false) {
        $subitems = array();
        if ($this->childs)
            foreach ($this->childs as $child) {
                if ($child->active != 1 OR $child->deleted == 1)
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
            'active' => ($this->parent_id > 1 ? ($active AND $activeParent) : $active),
            'visible' => ($active OR $activeParent OR $this->parent_id == 1 OR $visibleAll)
        );
        if ($subitems != array())
            $returnarray = array_merge($returnarray, array('items' => $subitems));
        return $returnarray;
    }
    
    public function getTableRows($level = 0) {
        $subitems = array();
        $returnRows = array();
        if ($this->id != 1) {
            $level = $level + 1;
        }
        if ($this->childs)
            foreach ($this->childs as $child) {
                if ($child->deleted == 1)
                    continue;
                $subitems[] = $child->getTableRows($level);
            }
        if ($this->id != 1) {
            $content = Content::model()->getModuleContent('page', $this->id);
            $returnRows = array(
                'level' => $level,
                'controller' => 'page',
                'id' => $this->id,
                'slug' => $this->slug,
                'linkTitle' => $content->title,
                'active' => $this->active,
                'created' => $this->created,
                'additional' => $this->plugin,
            );
        }
        
        if ($subitems != '')
            $returnRows = array_merge($returnRows, array('items' => $subitems));
        return $returnRows;
    }

}