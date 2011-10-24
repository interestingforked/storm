<?php

class ApplicationConfigBehavior extends CBehavior {

    public function events() {
        return array_merge(parent::events(), array(
                    'onBeginRequest' => 'beginRequest',
                ));
    }

    public function beginRequest() {
        $urlManager = Yii::app()->getUrlManager();

        $languages = implode('|', array_keys(Yii::app()->params['languages']));
        $pageRules = array();
        $categoryRules = array();
        $productRules = array();
        $articleRules = array();

        $articleRules["<lang:({$languages})>/news-archive"] = "article/archive";
        $articleRules["<lang:({$languages})>/news/<id:.*?>"] = "article/view";
        
        $pages = Page::model()->getAllPages();
        foreach ($pages AS $page) {
            $slug = str_replace('/', '\/', $page->slug);
            $pageRules["<lang:({$languages})>/<id:{$slug}(.*)?>"] = "{$page->plugin}/index";
        }

        $categories = Category::model()->getAllCategories();
        $rootCategories = array();
        foreach ($categories AS $category) {
            if ($category->parent_id == 1)
                $rootCategories[] = $category->slug;
            $slug = str_replace('/', '\/', $category->slug);
            $categoryRules["<lang:({$languages})>/<id:{$slug}(.*)?>"] = "category/index";
        }
        $rootCategoryRule = implode('|', $rootCategories);
        $productRules["<lang:({$languages})>/<id:({$rootCategoryRule})\/(.*)\/([a-zA-Z0-9\-]+)\-([0-9]+)>"] = "product/index";
        $productRules["<lang:({$languages})>/product/<id:.*?>"] = "product/index";

        $urlManager->addRules(array("<lang:({$languages})>/product/notify" => 'product/notify'));
        
        $urlManager->addRules($articleRules);
        $urlManager->addRules($pageRules);
        $urlManager->addRules($productRules);
        $urlManager->addRules($categoryRules);

        $defaultRoutes = array(
            '<lang:(ru|lv)>/<controller:\w+>' => '<controller>/index',
            '<lang:(ru|lv)>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            '<lang:(ru|lv)>/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            '<lang:(ru|lv)>' => '/',
            '<module:\w+>/<controller:\w+>' => '<module>/<controller>',
            '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
        );
        $urlManager->addRules($defaultRoutes);
    }

}
