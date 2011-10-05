<?php

class CrudModule extends CWebModule {

    public function init() {
        $this->setImport(array(
            'crud.models.*',
            'crud.components.*',
        ));
        Yii::app()->language = 'ru';
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}
