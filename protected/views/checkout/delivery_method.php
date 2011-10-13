<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Delivery method');
?>

<script type="text/javascript">
$(document).ready(function () {
    $('input[name=delivery_method]').click(function () {
        switch (this.value) {
            case '1':
                $('#delivery_cost').val(0);
                $('#delivery_days').val(0);
                break;
            case '2':
                $('#delivery_cost').val('<?php echo (isset($ponyExpress->tariff_including_vat) ? $ponyExpress->tariff_including_vat : 0) ?>');
                $('#delivery_days').val('<?php echo (isset($ponyExpress->delivery_days) ? $ponyExpress->delivery_days : 0) ?>');
                break;
        }
    });
    $('input[name=delivery_method]:first').attr('checked', true);
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
            <?php if ($point == 'MOW'): ?>
            <tr>
                <td><input type="radio" name="delivery_method" value="1" checked="checked"/></td>
                <td>0.00 <?php echo Yii::app()->params['currency']; ?></td>
                <td><?php echo Yii::t('app', 'Free shipping'); ?></td>
                <td></td>
            </tr>
            <?php endif; ?>
            <?php if ($ponyExpress): ?>
            <tr>
                <td><input type="radio" name="delivery_method" value="2"/></td>
                <td><?php echo $ponyExpress->tariff_including_vat.Yii::app()->params['currency']; ?></td>
                <td><?php echo Yii::t('app', 'Pony Express'); ?></td>
                <td>
                    <?php echo Yii::t('app', 'Срок доставки'); ?>: <?php echo $ponyExpress->delivery_days; ?><br/>
                    <?php echo Yii::t('app', 'Стоимость без НДС'); ?>: <?php echo $ponyExpress->tariff.Yii::app()->params['currency']; ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table> 
    <input type="hidden" name="delivery_cost" id="delivery_cost" value="0.00"/>
    <input type="hidden" name="delivery_days" id="delivery_days" value="0.00"/>
    
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