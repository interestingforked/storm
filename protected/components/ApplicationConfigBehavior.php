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
        $rules = array();
        $plugins = array();
        
        $rules['plugins']["<lang:({$languages})>/news"] = "article/index";
        $rules['plugins']["<lang:({$languages})>/news-archive"] = "article/archive";
        $rules['plugins']["<lang:({$languages})>/news/<id:.*?>"] = "article/view";

        $pages = Page::model()->getAllPages();
        foreach ($pages AS $page) {
            $slug = str_replace('/', '\/', $page->slug);
            if ($page->plugin == 'page')
                $rules['pages']["<lang:({$languages})>/<id:{$slug}(.*)?>"] = "page/index";
            if ($page->plugin == 'gallery')
                $plugins[$page->plugin][] = $slug;
        }
        
        $gallery = implode('|', $plugins['gallery']);
        $rules['plugins']["<lang:({$languages})>/<plugin:({$gallery})>"] = "gallery/index";
        $rules['plugins']["<lang:({$languages})>/<plugin:({$gallery})>/<id:.*?>"] = "gallery/view";

        $categories = Category::model()->getAllCategories();
        $rootCategories = array();
        foreach ($categories AS $category) {
            if ($category->parent_id == 1)
                $rootCategories[] = $category->slug;
            $slug = str_replace('/', '\/', $category->slug);
            $rules['categories']["<lang:({$languages})>/<id:{$slug}(.*)?>"] = "category/index";
        }
        $rootCategoryRule = implode('|', $rootCategories);
        $rules['products']["<lang:({$languages})>/<id:({$rootCategoryRule})\/(.*)\/([a-zA-Z0-9\-]+)\-([0-9]+)>"] = "product/index";
        $rules['products']["<lang:({$languages})>/product/<id:.*?>"] = "product/index";

        $urlManager->addRules(array("<lang:({$languages})>/product/notify" => 'product/notify'));
        
        $urlManager->addRules($rules['plugins']);
        $urlManager->addRules($rules['pages']);
        $urlManager->addRules($rules['products']);
        $urlManager->addRules($rules['categories']);

        $defaultRoutes = array(
            '<lang:(ru|lv)>/<controller:\w+>' => '<controller>/index',
            '<lang:(ru|lv)>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            '<lang:(ru|lv)>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<lang:(ru|lv)>/<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            '<lang:(ru|lv)>' => '/',
            '<module:\w+>/<controller:\w+>' => '<module>/<controller>',
            '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
        );
        $urlManager->addRules($defaultRoutes);
        
        $requestUri = Yii::app()->request->getRequestUri();
        $requestUri = preg_replace('/\/[a-z]{2}\//', '', $requestUri);
        $requestUri = str_replace('/', '_', $requestUri);

        $session = new CHttpSession();
        $session->open();
        $session->remove('sectionBackground');
                
        $background = Background::model()->findBySection($requestUri);
        if ($background) {
            $session->add('sectionBackground', $background->background);
        }
        
    }
    
}
