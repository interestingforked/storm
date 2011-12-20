<?php
// or where ever your yii frameworks is located
$yii=dirname(__FILE__).'/../../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';
 
if(!file_exists($yii) || !file_exists($config))
    die('Framework of config not found.');
require_once $yii;
 
Yii::createConsoleApplication($config)->run();