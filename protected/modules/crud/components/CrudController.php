<?php

class CrudController extends CController {

    public $layout = '/layout';
    public $menu = array();
    public $breadcrumbs = array();
    protected $classifier;

    public function init() {
        parent::init();
        $this->menu = array(
            array(
                'label' => 'Categories', 
                'url' => array('/crud/category'),
                'active' => ($this->getId() == 'category')
            ),
            array(
                'label' => 'Products', 
                'url' => array('/crud/product'),
                'active' => ($this->getId() == 'product')
            ),
            array(
                'label' => 'Product Nodes', 
                'url' => array('/crud/productnode'),
                'active' => ($this->getId() == 'productnode')
            ),
            array(
                'label' => 'Pages', 
                'url' => array('/crud/page'),
                'active' => ($this->getId() == 'page')
            ),
        );
        $this->classifier = Classifier::model();
    }

    protected function performAjaxValidation($model, $formName) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formName . '-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
