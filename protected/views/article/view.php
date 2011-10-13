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
            echo CHtml::image(Image::thumb(Yii::app()->params['images'].$image->image, 100), $article->content->title);
        }
        ?>
        <p><?php echo $article->content->body; ?></p>
    </div>
</div>