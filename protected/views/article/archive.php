<?php
$this->pageTitle = Yii::app()->name . ' - ' . $title;
?>

<h1><?php echo $title; ?></h1>
<div class="hr-title"><hr/></div>
<div class="news">
    <div style="margin-bottom: 30px;" class="filter">
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
    <?php 
    $i = 0;
    $c = 0;
    foreach ($articles AS $article):
        $i++;
        if ($offset >= $i)
            continue;
        $c++;
        ?>
        <div class="news-line">
            <h2><?php echo CHtml::link($article->content->title, array('/'.$pageModel->slug.'/' . $article->slug)); ?></h2>
            <p><?php 
            if ($article->content->additional)
                    echo $article->content->additional;
            else
                    echo $article->content->body; 
            ?></p>
        </div>
    <?php 
    if ($c == $limit)
        break;
    endforeach; 
    ?>
    <div class="hr-title"><hr></div>
    <div style="margin-bottom: 30px;" class="filter">
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