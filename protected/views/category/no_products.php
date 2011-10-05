<?php
$this->pageTitle = Yii::app()->name . ' - ' . $category->content->title;
?>

<h1><?php echo $category->content->title; ?></h1>
<div class="hr-products"><hr/></div>
<p><?php echo Yii::t('app', 'Products not found'); ?></p>