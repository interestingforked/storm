<?php
$this->pageTitle = Yii::app()->name;
?>

<h1><?php echo Html::formatTitle($page->content->title, $page->content->meta_title); ?></h1>
<div class="hr-title"><hr/></div>
<?php echo $page->content->body; ?>