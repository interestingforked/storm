<?php

class Language {

    public static function getdefaultLanguage() {
        return Yii::app()->params['defaultLanguage'];
    }

    public static function getLanguageByCode($code, $route, $redirect = true) {
        $code = substr($code, 0, 2);
        $lang = (in_array($code, array_keys(Yii::app()->params['languages']))) ? $code : '';
        if (empty($lang)) {
            $lang = self::getdefaultLanguage();

            if ($redirect == true AND preg_match("/gii/", $route) == 0) {
                if (preg_match("/index/", $route))
                    Yii::app()->controller->redirect(Yii::app()->homeUrl . $lang . '/');
                else
                    Yii::app()->controller->redirect(Yii::app()->homeUrl . $lang . '/' . $route);
            } else
                return $lang;
        } else
            return $lang;
    }

}