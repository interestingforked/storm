<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Sitemap');
?>

<h1><?php echo Yii::t('app', 'Sitemap'); ?></h1>
<div class="hr-title"><hr/></div>
<div id="sitemap">
    <ul>
        <li><?php echo CHtml::link(Yii::t('app', 'Products'), '/'); ?>
        <?php 
           $this->widget('zii.widgets.CMenu', array(
               'items' => $categories['items'],
               'activeCssClass' => 'current',
               'activateParents' => true,
           ));
        ?>
        </li>
        <li><?php echo CHtml::link(Yii::t('app', 'Home'), '/'); ?>
        <?php
           $this->widget('zii.widgets.CMenu', array(
               'items' => $pages['items'],
               'activeCssClass' => 'current',
               'activateParents' => true,
           ));   
        ?>
        </il>
    </ul>
</div>