<?php

class UrlManager extends CUrlManager {

    public function createUrl($route, $params = array(), $ampersand = '&') {
        if ( ! isset($params['lang']) OR empty($params['lang'])) {
            $route = Controller::processUrl().'/'.$route;
        }
        if (preg_match('/gii/', $route) > 0) {
            $route = preg_replace("/[a-z]{2}\/gii/", "gii", $route);
        } else if (preg_match('/crud/', $route) > 0) {
            $route = preg_replace("/[a-z]{2}\/crud/", "crud", $route);
        } else if (preg_match('/admin/', $route) > 0) {
            $route = preg_replace("/[a-z]{2}\/admin/", "admin", $route);
        }
        if (preg_match("/user\/(page|category|product)/", $route) > 0) {
            $route = str_replace("user/page", "page", $route);
            $route = str_replace("user/category", "category", $route);
            $route = str_replace("user/product", "product", $route);
        }
        $route = preg_replace("/\/\//", "/", $route);
        return parent::createUrl($route, $params, $ampersand);
    }

}