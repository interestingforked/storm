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

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'gallery';
    }

    public function rules() {
        return array(
            array('page_id, active, deleted, sort, heading, pagination', 'numerical', 'integerOnly' => true),
            array('slug', 'length', 'max' => 250),
            array('created', 'safe'),
            array('id, page_id, active, deleted, sort, slug, heading, pagination, created', 'safe', 'on' => 'search'),
        );
    }

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

    public function search() {
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
            'order' => 'sort ASC',
        );
    }

    public function scopes() {
        return array(
            'ordered' => array(
                'order' => 'hot DESC, created DESC',
            ),
            'sorted' => array(
                'order' => 'sort ASC',
            ),
            'sorted2' => array(
                'order' => 'page_id ASC, sort ASC',
            ),
            'active' => array(
                'condition' => 'active = 1'
            ),
            'notDeleted' => array(
                'condition' => 'deleted = 0'
            ),
        );
    }

    public function getGalleries($pageId) {
        $galleries = $this->notDeleted()->findAllByAttributes(array('page_id' => $pageId));
        foreach ($galleries AS $gallery) {
            $gallery->content = Content::model()->getModuleContent('gallery', $gallery->id);
        }
        return $galleries;
    }

    public function getGalleryBySlug($slug) {
        $gallery = $this->notDeleted()->findByAttributes(array('slug' => $slug));
        $gallery->content = Content::model()->getModuleContent('gallery', $gallery->id);
        return $gallery;
    }

}