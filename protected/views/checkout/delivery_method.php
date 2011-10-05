<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Delivery method');
?>

<script type="text/javascript">
$(document).ready(function () {
});
</script>

<p class="order-step"><?php echo Yii::t('app', 'Step'); ?>:
    <?php echo CHtml::link('1', array('/checkout')); ?>
    <?php echo CHtml::link('2', array('/checkout/deliveryaddress')); ?>
    <b>3</b> 4 5
</p>
<h1><?php echo Yii::t('app', 'Delivery method'); ?></h1>
<div class="hr-title"><hr/></div>

<p><?php echo Yii::t('app', 'Пожалуйста выберите доступный способ доставки в ваш город.'); ?></p>

<?php if ($messages): ?>
<?php endif; ?>
    
<div id="login-form">

    <?php echo CHtml::beginForm('', 'post', array('id' => 'formdata')); ?>
    
    <table class="delivery-method" cellspacing="10">
        <tbody>
            <tr>
                <th></th>
                <th align="left"><?php echo Yii::t('app', 'Cost'); ?></th>
                <th align="left"><?php echo Yii::t('app', 'Delivery method'); ?></th>
                <th align="left"><?php echo Yii::t('app', 'Additional info'); ?></th>
            </tr>
            <tr>
                <td><input type="radio" name="delivery_method" value="1" checked="checked"/></td>
                <td>0.00 <?php echo Yii::app()->params['currency']; ?></td>
                <td><?php echo Yii::t('app', 'Free shipping'); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table> 

    <div class="checkout-btns">
        <?php echo CHtml::button(Yii::t('app', 'Back'), array(
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);',
            'onclick' => "location.href='".CHtml::normalizeUrl(array('/checkout/deliveryaddress'))."'",
        )); ?>
        <?php echo CHtml::submitButton(Yii::t('app', 'Continue'), array(
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);',
        )); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>