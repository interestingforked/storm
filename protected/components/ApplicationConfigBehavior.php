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
        $pluginRules = array();

        $plugins = array();
        
        $pluginRules["<lang:({$languages})>/news"] = "article/index";
        $pluginRules["<lang:({$languages})>/news-archive"] = "article/archive";
        $pluginRules["<lang:({$languages})>/news/<id:.*?>"] = "article/view";

        $pages = Page::model()->getAllPages();
        foreach ($pages AS $page) {
            $slug = str_replace('/', '\/', $page->slug);
            if ($page->plugin == 'page')
                $pageRules["<lang:({$languages})>/<id:{$slug}(.*)?>"] = "page/index";
            if ($page->plugin == 'gallery')
                $plugins[$page->plugin][] = $slug;
        }
        
        $gallery = implode('|', $plugins['gallery']);
        $pluginRules["<lang:({$languages})>/<plugin:({$gallery})>"] = "gallery/index";
        $pluginRules["<lang:({$languages})>/<plugin:({$gallery})>/<id:.*?>"] = "gallery/view";

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
        
        $urlManager->addRules($pluginRules);
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
