<?php
$this->pageTitle = Yii::app()->name . ' - ' . $article->content->title;
?>

<h1><?php echo $article->content->title; ?></h1>
<div class="hr-title"><hr/></div>
<div class="news">
    <div class="news-line">
        <?php 
        $image = Attachment::model()->getAttachment('article', $article->id);
        if ($image) {
            $imageLink = Yii::app()->params['articles'].$image->image;
            echo CHtml::link(CHtml::image(Image::thumb($imageLink, 200), $article->content->title), $imageLink, array('class' => 'modal'));
        }
        ?>
        <p><?php echo $article->content->body; ?></p>
    </div>
</div>