<?php
$this->pageTitle = Html::formatTitle($page->content->title, $page->content->meta_title). ' - ' . $this->pageTitle;
?>

<h1><?php echo Html::formatTitle($page->content->title, $page->content->meta_title); ?></h1>
<?php 
if ($page->multipage): 
    $childPages = $page->childs;
    $pages = count($childPages);
    ?>
<div class="filter">
    <div class="pages">
    <em>
    <?php 
    $i = 0;
    if ($page->slug == $_GET['id']):
        $current = Page::model()->getPage($childPages[0]->slug);
    else:
        $current = Page::model()->getPage($_GET['id']);
    endif;
    $pageArray = array();
    foreach ($childPages as $pagem):
        $i++;
        if ($pagem->sort + 1 == $current->sort):
            $pageArray[0] = CHtml::link(Yii::t('app', 'previous'), array('/'.$pagem->slug));
        endif;
        if ($pagem->id == $current->id):
            $pageArray[$i] = $i;
        else:
            $pageArray[$i] = CHtml::link($i, array('/'.$pagem->slug));
        endif;
        if ($pagem->sort - 1 == $current->sort):
            $pageArray[$pages + 1] = CHtml::link(Yii::t('app', 'next'), array('/'.$pagem->slug));
        endif;
    endforeach; 
    ksort($pageArray);
    foreach ($pageArray as $k => $v):
        echo $v;
        if ($k != $pages + 1) {
            echo ' | ';
        }
    endforeach;
    ?>
    </em>
    </div>
</div>
<div class="hr-title"><hr/></div>
<div class="text"><?php echo $current->content->body; ?></div>
<?php else: ?>
<div class="hr-title"><hr/></div>
<div class="text"><?php echo $page->content->body; ?></div>
<?php endif; ?>