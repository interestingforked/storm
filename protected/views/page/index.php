<?php
$this->pageTitle = Yii::app()->name . ' - ' . $page->content->title;
?>

<h1><?php echo $page->content->title; ?></h1>
<div class="hr-title"><hr/></div>
<?php echo $page->content->body; ?>