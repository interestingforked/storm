<?php
$this->pageTitle = Yii::app()->name . ' - ' . $gallery->content->title;
?>

<h1><?php echo $gallery->content->title; ?></h1>
<div class="hr-title"><hr/></div>
<div class="gallery">
    <?php echo $gallery->content->body; ?>
</div>