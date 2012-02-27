<?php
$this->pageTitle = Yii::app()->name . ' - ' . $pluginPage->content->title;
?>

<h1><?php echo $pluginPage->content->title; ?></h1>
<?php if (count($galleries) > 0 AND $pages > 1): ?>
<div class="filter">
    <div class="pages">
    <em>
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $prevpage; ?>"><?php echo Yii::t('app', 'previous'); ?></a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php if ($page == $i): ?>
            <?php echo $i; ?>
        <?php else: ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endif; ?> | 
    <?php endfor; ?>
    <?php if ($page != $pages): ?>
        <a href="?page=<?php echo $nextpage; ?>"><?php echo Yii::t('app', 'next'); ?></a>
    <?php endif; ?>
    </em>
    </div>
</div>
<?php endif; ?>
<div class="hr-title"><hr/></div>
<?php 
if ($page == 1):
    echo $pluginPage->content->body; 
endif;
?>
<div class="gallery">
<?php 
$i = 0;
$c = 0;
$t = count($galleries);
foreach ($galleries AS $gallery): 
    $i++;
    if ($offset >= $i)
        continue;
    $c++;
    if (in_array($c, array(1,4,7)))
        echo '<div class="row">';
    echo '<div class="item">';
    $image = '';
    $imageAttachment = Attachment::model()->getAttachment('gallery', $gallery->id);
    if ($imageAttachment) {
        $title = (isset($gallery->content->title)) ? $gallery->content->title : '';
        $image = CHtml::image(Image::thumb(Yii::app()->params['gallery'].$imageAttachment->image, 147), $title);
    }
    echo CHtml::link($image, array('/'.$pluginPage->slug.'/'.$gallery->slug)); 
    echo '</div>';
    if (in_array($c, array(3,6,9)) OR $c == $t)
        echo '</div>';
    if ($c == $limit)
        break;
endforeach; 
?>
</div>