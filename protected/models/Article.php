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

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'articles';
    }

    public function rules() {
        return array(
            array('active, deleted, sort, hot, home', 'numerical', 'integerOnly' => true),
            array('slug', 'length', 'max' => 250),
            array('created', 'safe'),
            array('id, active, deleted, sort, slug, hot, home, created', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'sort' => 'Sort',
            'slug' => 'Slug',
            'hot' => 'Actual article',
            'home' => 'Show on homepage',
            'created' => 'Created',
        );
    }

    public function defaultScope() {
        return array(
            'order' => 'created DESC',
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
            'active' => array(
                'condition' => 'active = 1'
            ),
            'notDeleted' => array(
                'condition' => 'deleted = 0'
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
            $articles = $this->notDeleted()->recently($limit)->ordered()->findAll();
        else
            $articles = $this->notDeleted()->findAll();
        foreach ($articles AS $article) {
            $article->content = Content::model()->getModuleContent('article', $article->id);
        }
        return $articles;
    }

    public function getHomeArticle($limit = false) {
        $articles = $this->notDeleted()->recently(3)->findAllByAttributes(array('home' => 1));
        foreach ($articles AS $article) {
            $article->content = Content::model()->getModuleContent('article', $article->id);
        }
        return $articles;
    }

    public function getArticleBySlug($slug) {
        $article = $this->notDeleted()->findByAttributes(array('slug' => $slug));
        if (!$article) {
            return false;
        }
        $article->content = Content::model()->getModuleContent('article', $article->id);
        return $article;
    }

}