<?php
$this->pageTitle = Yii::app()->name . ' - ' . $pluginPage->content->title;
?>

<h1><?php echo $pluginPage->content->title; ?></h1>
<div class="hr-title"><hr/></div>
<?php echo $pluginPage->content->body; ?>
<div class="gallery">
<?php 
$c = 0;
foreach ($galleries AS $gallery): 
    if ($gallery->heading) {
        echo '<div class="row"><h1>'.$gallery->content->title.'</h1></div>';
        continue;
    }
    $c++;
    if ($c % 3 == 0) {
        echo '<div class="row">';
    }
    echo '<div class="item">';
    $image = '';
    $imageAttachment = Attachment::model()->getAttachment('gallery', $gallery->id);
    if ($imageAttachment) {
        $title = (isset($gallery->content->title)) ? $gallery->content->title : '';
        $image = CHtml::image(Image::thumb(Yii::app()->params['gallery'].$imageAttachment->image, 147), $title);
    }
    echo CHtml::link($image, array('/'.$pluginPage->slug.'/'.$gallery->slug)); 
    echo '</div>';
    if ($c % 3 == 0) {
        echo '</div>';
    }
endforeach; 
?>
</div>