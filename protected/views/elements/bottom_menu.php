<?php
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => Yii::t('app', 'Login'), 'url' => array('/user/login'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array('rel' => 'nofollow')),
        array('label' => Yii::t('app', 'Register'), 'url' => array('/user/registration'), 'visible' => Yii::app()->user->isGuest, 'linkOptions' => array('rel' => 'nofollow')),
        array('label' => Yii::t('app', 'Logout'), 'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array('rel' => 'nofollow')),
        array('label' => Yii::t('app', 'My account'), 'url' => array('/user/profile'), 'visible' => !Yii::app()->user->isGuest, 'linkOptions' => array('rel' => 'nofollow')),
        array('label' => Yii::t('app', 'Cart').' ('.$cartCount.')', 'url' => array('/cart'), 'linkOptions' => array('rel' => 'nofollow')),
        array('label' => Yii::t('app', 'Wishlist').' ('.$wishListCount.')', 'url' => array('/wishlist'), 'linkOptions' => array('rel' => 'nofollow')),
    ),
));
$this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => Yii::t('app', 'Sitemap'), 'url' => array('/sitemap')),
    ),
    'htmlOptions' => array('class' => 'bot-links'),
));