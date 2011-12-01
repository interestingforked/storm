<?php

class AdminController extends CController {

    public $layout = '/layout';
    public $pageTitle = '';
    public $menu = array();
    public $user = null;
    
    protected $classifier;

    public function init() {
        parent::init();
        
        $activeMenuId = $this->getId();
        $this->menu = array(
            array(
                'label' => 'Dashboard', 
                'url' => array('/admin'),
                'active' => ($activeMenuId == 'default')
            ),
            array(
                'label' => 'Pages', 
                'url' => array('/admin/page'),
                'active' => ($activeMenuId == 'page')
            ),
            array(
                'label' => 'News', 
                'url' => array('/admin/article'),
                'active' => ($activeMenuId == 'article')
            ),
            array(
                'label' => 'Files', 
                'url' => array('/admin/file'),
                'active' => ($activeMenuId == 'file')
            ),
            array(
                'label' => 'Catalog', 
                'url' => '#',
                'active' => (in_array($activeMenuId, array('category', 'product'))),
                'items' => array(
                    array(
                        'label' => 'Categories', 
                        'url' => array('/admin/category'),
                        'active' => ($activeMenuId == 'category')
                    ),
                    array(
                        'label' => 'Products', 
                        'url' => array('/admin/product'),
                        'active' => ($activeMenuId == 'product')
                    ),
                )
            ),
            array(
                'label' => 'Users', 
                'url' => array('/admin/user'),
                'active' => ($activeMenuId == 'user')
            ),
            array(
                'label' => 'Orders', 
                'url' => array('/admin/order'),
                'active' => ($activeMenuId == 'order')
            ),
            array(
                'label' => 'Newsletters', 
                'url' => array('/admin/newsletter'),
                'active' => ($activeMenuId == 'newsletter')
            ),
            array(
                'label' => 'Reports', 
                'url' => array('/admin/report'),
                'active' => ($activeMenuId == 'report')
            ),
        );
        
        $user = User::model()->findByPk(Yii::app()->user->id);
        $userProfile = $user->profile;
        $this->user = array(
            'user' => $user,
            'profile' => $userProfile,
            'fullname' => $userProfile->firstname.' '.$userProfile->lastname
        );
        
        $this->classifier = Classifier::model();
    }

}
