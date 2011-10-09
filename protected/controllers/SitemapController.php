<?php

class SitemapController extends Controller {

    public function actionIndex() {
        $rootCategory = Category::model()->findByPk(1);
        $categories = $rootCategory->getListed('', true);
        
        $rootPage = Page::model()->findByPk(1);
        $pages = $rootPage->getListed('', true);

        $this->breadcrumbs[] = Yii::t('app', 'Sitemap');
        $this->metaTitle = Yii::t('app', 'Sitemap');
        
        $this->render('index', array(
            'categories' => $categories,
            'pages' => $pages,
        ));
        
    }

}