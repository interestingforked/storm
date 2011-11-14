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
<p><?php echo Yii::t('app', 'Пожалуйста внимательно прочитайте условия оплаты и заказа товара.'); ?></p>
<p><?php echo Yii::t('app', 'После подтверждения условий Вы перейдете на защищенную страницу платежной системы RBK Money.'); ?></p>
<p><?php echo Yii::t('app', 'Важно! При оплате в платежной системе RBK Money, пожалуйста убедитесь, что счет оплачен полностью. Срок действия счета,  до момента полной оплаты  в системе RBK Money составляет 3 рабочих дня. Отправка заказа производится в течение 1-2 рабочих дней с момента получения подтверждения полной оплаты заказа в системе RBK Money.'); ?></p>
<label>С условиями согласен <span>*</span></label> &nbsp; <?php echo CHtml::checkBox('rules_agree'); ?>
<p><?php echo $form; ?></p>

<script type="text/javascript">
$(document).ready(function () {
    $("#rbk_money_submit_button").click(function () {
        $("#paymentForm").submit();
    });
    $("#rules_agree").click(function () {
        var checked = $("#rules_agree").attr('checked');
        $("#rbk_money_submit_button").attr('disabled', !checked);
    });
});
</script>