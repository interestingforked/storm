<?php
$this->pageTitle = Yii::app()->name . ' - ' . $category->content->title;
?>

<h1><?php echo $category->content->title; ?></h1>
<?php 
$link = '';
if (isset($_GET['orderby']))
    $link .= (empty($link)?'?':'&').'orderby='.$_GET['orderby'];
if (isset($_GET['viewall']))
    $link .= (empty($link)?'?':'&').'viewall='.$_GET['viewall'];
if (isset($_GET['page']))
    $link .= (empty($link)?'?':'&').'page='.$_GET['page'];
$link = $link.(empty($link)?'?':'&');

$viewAll = (isset($_GET['viewall']) AND $_GET['viewall'] == 'true');
if ($viewAll) {
    $offset = 0;
    $limit = $total;
}
?>
<div class="filter">
    <em><?php echo $offset + 1; ?>-<?php echo (($offset + $limit) <= $total) ? ($offset + $limit) : $total; ?> из <?php echo $total; ?></em>
    <?php if (!$viewAll): ?>
    <em>
        <?php if ($page > 1): ?>
            <a href="<?php echo preg_replace("/(&)?page=[0-9]+/", "", $link); ?>page=<?php echo $prevpage; ?>"><?php echo Yii::t('app', 'previous'); ?></a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <?php if ($page == $i): ?>
                <?php echo $i; ?>
            <?php else: ?>
                <a href="<?php echo preg_replace("/(&)?page=[0-9]+/", "", $link); ?>page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?> | 
        <?php endfor; ?>
        <?php if ($page != $pages): ?>
            <a href="<?php echo preg_replace("/(&)?page=[0-9]+/", "", $link); ?>page=<?php echo $nextpage; ?>"><?php echo Yii::t('app', 'next'); ?></a>
        <?php endif; ?>
    </em>
    <?php endif; ?>
    <em>Сортировать по: 
        <?php 
        if (isset($_GET['orderby']) AND $_GET['orderby'] == 'price'): 
            echo Yii::t('app', 'by price'); 
        else: 
            $link = preg_replace("/(&)?orderby=(price|name|popularity)/", "", $link);
            $link = preg_replace("/\?&/", "?", $link);
            echo CHtml::link(Yii::t('app', 'by price'), $link.'orderby=price');
        endif;
        echo ' | ';
        if (isset($_GET['orderby']) AND $_GET['orderby'] == 'name'): 
            echo Yii::t('app', 'by name'); 
        else: 
            $link = preg_replace("/(&)?orderby=(price|name|popularity)/", "", $link);
            $link = preg_replace("/\?&/", "?", $link);
            echo CHtml::link(Yii::t('app', 'by name'), $link.'orderby=name');
        endif;
        echo ' | ';
        if (isset($_GET['orderby']) AND $_GET['orderby'] == 'popularity'): 
            echo Yii::t('app', 'by popularity'); 
        else: 
            $link = preg_replace("/(&)?orderby=(price|name|popularity)/", "", $link);
            $link = preg_replace("/\?&/", "?", $link);
            echo CHtml::link(Yii::t('app', 'by popularity'), $link.'orderby=popularity');
        endif;
        echo ' | ';
        if (isset($_GET['viewall']) AND $_GET['viewall'] == 'true'): 
            $link = preg_replace("/(&)?page=[0-9]+/", "", $link);
            $link = preg_replace("/(&)?viewall=(false|true)/", "", $link);
            $link = preg_replace("/\?&/", "?", $link);
            echo CHtml::link(Yii::t('app', 'viewbypage'), $link);
        else: 
            $link = preg_replace("/(&)?page=[0-9]+/", "", $link);
            $link = preg_replace("/(&)?viewall=(false|true)/", "", $link);
            $link = preg_replace("/\?&/", "?", $link);
            echo CHtml::link(Yii::t('app', 'viewall'), $link.'viewall=true');
        endif;
        ?>
    </em>
</div>
<div class="hr-products"><hr/></div>
<?php if ($products): ?>
<div class="prod-wrapper">
<?php 
$i = 0;
$c = 0;
foreach ($products as $product):
    $i++;
    if ($offset >= $i AND !$viewAll) {
        continue;
    }
    $c++;
    $image = "";
    $link = CHtml::normalizeUrl(array('/'.$category->slug.'/'.$product->slug.'-'.$product->id));
    $attachetImage = Attachment::model()->getAttachment('productNode', $product->mainNode->id);
    if ($attachetImage)
        $image = CHtml::image(Image::thumb(Yii::app()->params['images'].$attachetImage->image, 187), $product->content->title);

?>
<div class="prod-list">
  <?php echo CHtml::link($image, $link, array('title' => $product->content->title)); ?>
    <p><strong><?php echo CHtml::link($product->content->title, $link, array('title' => $product->content->title)); ?></strong>
    <?php echo number_format($product->mainNode->price,0).Yii::app()->params['currency']; ?>
    <span class="tabs">
     <?php if ($product->mainNode->new == 1): ?>
        <span class="new"><?php echo Yii::t('app', 'New'); ?></span>
     <?php endif; ?>
     <?php if ($product->mainNode->sale == 1): ?>
        <span class="sale"><?php echo Yii::t('app', 'Sale'); ?></span>
     <?php endif; ?>
    </span>
    </p>
</div>
<?php
    //if (in_array($c, array(3,6,9,))) {
    if ($c % 3 == 0) {
        echo '<div class="hr-products"><hr/></div>';
    }
    if ($c == $limit AND !$viewAll) {
        break;
    }
endforeach;
if ($c < 3) {
    echo '<div class="hr-products"><hr/></div>';
}
?>
</div>
<?php endif; ?>