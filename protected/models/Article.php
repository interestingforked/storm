<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property string $id
 * @property integer $active
 * @property integer $sort
 * @property string $slug
 * @property integer $hot
 * @property integer $home
 * @property string $created
 */
class Article extends CActiveRecord {

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
        return 'articles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('active, deleted, sort, hot, home', 'numerical', 'integerOnly' => true),
            array('slug', 'length', 'max' => 250),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, active, deleted, sort, slug, hot, home, created', 'safe', 'on' => 'search'),
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
            'hot' => 'Hot',
            'home' => 'Home',
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
        $criteria->compare('hot', $this->hot);
        $criteria->compare('home', $this->home);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function defaultScope() {
        return array(
            'condition' => 'deleted = 0',
            'order' => 'created DESC',
        );
    }

    public function scopes() {
        return array(
            'ordered' => array(
                'order' => 'hot DESC, created DESC',
            ),
        );
    }

    public function recently($limit = 5) {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $limit,
        ));
        return $this;
    }

    public function getArticles($limit = false) {
        if ($limit)
            $articles = $this->recently($limit)->ordered()->findAll();
        else
            $articles = $this->findAll();
        foreach ($articles AS $article) {
            $article->content = Content::model()->getModuleContent('article', $article->id);
        }
        return $articles;
    }
    
    public function getHomeArticle($limit = false) {
        $articles = $this->recently(3)->findAllByAttributes(array('home' => 1));
        foreach ($articles AS $article) {
            $article->content = Content::model()->getModuleContent('article', $article->id);
        }
        return $articles;
    }

    public function getArticleBySlug($slug) {
        $article = $this->findByAttributes(array('slug' => $slug));
        $article->content = Content::model()->getModuleContent('article', $article->id);
        return $article;
    }

}