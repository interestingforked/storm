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
<?php 
if ($rbkServiceForm) {
    echo $rbkServiceForm; 
}

echo CHtml::beginForm();
echo CHtml::submitButton(Yii::t('app', 'Continue'), array(
    'id' => 'submit_button',
    'class' => 'button',
    'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
    'onmouseover' => "this.style.backgroundColor='#343434'",
    'style' => 'background-color: rgb(31, 31, 31);color:#939393;border-color:#939393;',
    'disabled' => 'disabled',
));
echo CHtml::endForm();

?>

<script type="text/javascript">
$(document).ready(function () {
    $("#paymentForm").submit();
    $("#rules_agree").click(function () {
        
        var checked = $("#rules_agree").attr('checked');
        $("#submit_button").attr('disabled', !checked);
        $("#submit_button").css('color', '#FBF80B');
        $("#submit_button").css('border-color', '#FBF80B');
    });
});
</script>