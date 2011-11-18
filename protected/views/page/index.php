<?php
$this->pageTitle = Html::formatTitle($page->content->title, $page->content->meta_title). ' - ' . $this->pageTitle;
?>

<h1><?php echo Html::formatTitle($page->content->title, $page->content->meta_title); ?></h1>
<div class="hr-title"><hr/></div>
<div class="text"><?php echo $page->content->body; ?></div>