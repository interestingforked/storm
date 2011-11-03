<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property string $id
 * @property integer $active
 * @property integer $sort
 * @property string $slug
 * @property integer $heading
 * @property integer $pagination
 * @property string $created
 */
class Gallery extends CActiveRecord {

    public $content;

    /**
     * Returns the static model of the specified AR class.
     * @return Article the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gallery';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('active, deleted, sort, heading, pagination', 'numerical', 'integerOnly' => true),
            array('slug', 'length', 'max' => 250),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, active, deleted, sort, slug, heading, pagination, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'sort' => 'Sort',
            'slug' => 'Slug',
            'heading' => 'Heading',
            'pagination' => 'Pagination',
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
        $criteria->compare('active', $this->active);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('heading', $this->hot);
        $criteria->compare('pagination', $this->home);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
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
                'order' => 'sort ASC',
            ),
        );
    }

    public function getGalleries($pageId) {
        $galleries = $this->findAllByAttributes(array('page_id' => $pageId));
        foreach ($galleries AS $gallery) {
            $gallery->content = Content::model()->getModuleContent('gallery', $gallery->id);
        }
        return $galleries;
    }

    public function getGalleryBySlug($slug) {
        $gallery = $this->findByAttributes(array('slug' => $slug));
        $gallery->content = Content::model()->getModuleContent('gallery', $gallery->id);
        return $gallery;
    }

}