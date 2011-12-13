<?php
$this->pageTitle = Yii::app()->name . ' - ' . $page->content->title;

?>

<h1><?php echo $page->content->title; ?></h1>
<div class="hr-title"><hr/></div>
<?php echo $page->content->body; ?>
<div class="news">
    <?php foreach ($articles AS $article): ?>
    <div class="news-line">
        <?php 
        $image = Attachment::model()->getAttachment('article', $article->id);
        if ($image) {
            echo CHtml::image(Image::thumb(Yii::app()->params['articles'].$image->image, 100), $article->content->title);
        }
        ?>
        <h2><?php echo CHtml::link($article->content->title, array('/'.$page->slug.'/'.$article->slug)); ?></h2>
        <p><?php 
        if ($article->content->additional)
                echo $article->content->additional;
        else
                echo $article->content->body; 
        ?></p>
    </div>
    <?php endforeach; ?>
    <div class="hr-title"><hr></div>
    <div class="archive-link"><?php echo CHtml::link(Yii::t('app', 'Архив новостей'), array('/'.$page->slug.'-archive')); ?></div>
</div>