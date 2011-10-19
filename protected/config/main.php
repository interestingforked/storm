<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Storm london',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'storm',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'user' => array(
            'tableUsers' => 'users',
            'tableProfiles' => 'profiles',
            'tableProfileFields' => 'profiles_fields',
            'captcha' => array('registration' => false),
            'recoveryUrl' => array('/user/recovery'),
        ),
        'crud'
    ),
    'behaviors' => array(
        'ApplicationConfigBehavior'
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login'),
        ),
        'urlManager' => array(
            'class' => 'urlManager',
            'urlFormat' => 'path',
            'rules' => array(
                '/' => 'site/index',
            ),
            'showScriptName' => false,
            'caseSensitive' => false,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=storm_prod',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'persistent' => true,
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                /*
                  array(
                  'class' => 'CFileLogRoute',
                  'levels' => 'error, warning',
                  ),
                 */
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('127.0.0.1'),
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => 'webmaster@example.com',
        'languages' => array(
            'ru' => 'Russian',
        //'lv' => 'Latvian'
        ),
        'defaultLanguage' => 'ru',
        'images' => '/images/products/',
        'categories' => '/images/categories/',
        'backgrounds' => '/images/backgrounds/',
        'thumbUrl' => '/assets/thumb.php',
        'currency' => ' Руб',
        'size_limit' => 10 * 1024 * 1024,
        'tmp_upload_dir' => 'assets/tmp/',
        'ponyExpress' => array(
            'schema' => 'http://www.ponyexpress.ru/tools/tariff_ws.wsdl',
            'currency_code' => 'RUB',
            'org_citycode' => 'MOW',
            'direction' => 2,
            'delivery_mode' => 2,
        ),
        'RBKMoney' => array(
            'requestUrl' => 'https://rbkmoney.ru/acceptpurchase.aspx',
            'successUrl' => array('/checkout/paymentsuccess'),
            'failUrl' => array('/checkout/paymentfailed'),
            'currency' => 'RUB',
            'shopId' => '2009262',
            'secretKey' => 'st0rm',
        )
    ),
);