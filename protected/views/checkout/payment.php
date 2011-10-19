<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Процесс оплаты');
?>

<p class="order-step"><?php echo Yii::t('app', 'Step'); ?>:
    <?php echo CHtml::link('1', array('/')); ?>
    <?php echo CHtml::link('2', array('/')); ?>
    <?php echo CHtml::link('3', array('/')); ?>
    <?php echo CHtml::link('4', array('/')); ?>
    <b>5</b>
</p>
<h1><?php echo Yii::t('app', 'Процесс оплаты'); ?></h1>
<div class="hr-title"><hr/></div>
<p><?php echo Yii::t('app', 'Подготовка данных для платежа'); ?></p>
<?php echo $form; ?>

<script type="text/javascript">
$(document).ready(function () {
    $("#paymentForm").submit();
});
</script>