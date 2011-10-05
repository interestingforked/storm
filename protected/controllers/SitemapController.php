<?php

class SitemapController extends Controller {

    public function actionIndex() {
        $rootCategory = Category::model()->findByPk(1);
        $categories = $rootCategory->getListed();
        
        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getListed();

        $this->breadcrumbs[] = Yii::t('app', 'Sitemap');
        $this->metaTitle = Yii::t('app', 'Sitemap');
        
        $this->render('index', array(
            'categories' => $categories,
            'pages' => $pages,
        ));
        
    }

}