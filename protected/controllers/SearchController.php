<?php

class SearchController extends Controller {

    public function actionIndex() {
        $pageTitle = Yii::t('app', 'Search result');
        $query = $_GET['query'];

        $criteria = new CDbCriteria;
        $criteria->addSearchCondition('title', $query);
        $criteria->addSearchCondition('body', $query, true, 'OR');
        $criteria->addSearchCondition('additional', $query, true, 'OR');
        $criteria->addSearchCondition('meta_title', $query, true, 'OR');
        $criteria->addSearchCondition('meta_description', $query, true, 'OR');
        $criteria->addSearchCondition('meta_keywords', $query, true, 'OR');

        $records = Content::model()->findAll($criteria);
        
        $slugs = array();
        $articles = Article::model()->findAll();
        foreach ($articles AS $article) {
            $slugs['article_'.$article->id] = $article->slug;
        }
        $pages = Page::model()->findAll();
        foreach ($pages AS $page) {
            $slugs['page_'.$page->id] = $page->slug;
        }
        
        $results = array();
        foreach ($records AS $record) {
            $data = array(
                'id' => $record->module_id,
                'title' => $record->title,
            );
            switch ($record->module) {
                case 'page':
                    $data['slug'] = $slugs['page_'.$record->module_id];
                    $results['page'][] = $data;
                    break;
                case 'article':
                    $data['slug'] = $slugs['article_'.$record->module_id];
                    $results['article'][] = $data;
                    break;
            }
        }
        
        $this->breadcrumbs[] = $pageTitle;
        $this->render('index', array(
            'page' => $pageTitle,
            'query' => $query,
            'result' => $results,
        ));
    }

}