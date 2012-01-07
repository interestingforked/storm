<?php

class SearchController extends Controller {

    public function actionIndex() {
        $pageTitle = Yii::t('app', 'Search result');

        $criteria = new CDbCriteria;

        $query = trim($_GET['query']);
        $criteria->addSearchCondition('title', $query);
        $criteria->addSearchCondition('meta_title', $query, true, 'OR');

        $query = ' ' . $query . ' ';
        $criteria->addSearchCondition('body', $query, true, 'OR');
        $criteria->addSearchCondition('additional', $query, true, 'OR');
        $criteria->addSearchCondition('meta_description', $query, true, 'OR');
        $criteria->addSearchCondition('meta_keywords', $query, true, 'OR');

        $records = Content::model()->findAll($criteria);

        $slugs = array();
        $articles = Article::model()->active()->findAll();
        foreach ($articles AS $article) {
            $slugs['article_' . $article->id] = $article->slug;
        }
        $pages = Page::model()->active()->findAll();
        foreach ($pages AS $page) {
            $slugs['page_' . $page->id] = $page->slug;
        }
        $products = Product::model()->notDeleted()->active()->findAll();
        foreach ($products AS $product) {
            $slugs['product_' . $product->id] = $product->slug;
        }

        $results = array();
        foreach ($records AS $record) {
            $data = array(
                'id' => $record->module_id,
                'title' => $record->title,
            );
            switch ($record->module) {
                case 'page':
                    if (!isset($slugs['page_' . $record->module_id]))
                        continue;
                    $data['slug'] = $slugs['page_' . $record->module_id];
                    $results['page'][] = $data;
                    break;
                case 'article':
                    if (!isset($slugs['article_' . $record->module_id]))
                        continue;
                    $data['slug'] = $slugs['article_' . $record->module_id];
                    $results['article'][] = $data;
                    break;
                case 'product':
                    if (!isset($slugs['product_' . $record->module_id]))
                        continue;
                    $data['slug'] = $slugs['product_' . $record->module_id];
                    $results['product'][] = $data;
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