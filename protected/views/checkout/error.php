<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Ошибка обработки');
?>

<p class="order-step"><?php echo Yii::t('app', 'Step'); ?>:
    <?php echo CHtml::link('1', array('/')); ?>
    <?php echo CHtml::link('2', array('/')); ?>
    <?php echo CHtml::link('3', array('/')); ?>
    <?php echo CHtml::link('4', array('/')); ?>
    <b>5</b>
</p>
<h1><?php echo Yii::t('app', 'Ошибка обработки'); ?></h1>
<div class="hr-title"><hr/></div>

<p><?php echo Yii::t('app', 'Ваш заказ отклонён.'); ?></p>