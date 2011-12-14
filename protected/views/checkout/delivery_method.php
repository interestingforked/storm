<?php 
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Delivery method'); 

$sale = false;
$freeDelivery = false;
$freeDeliveryWithMOW250 = false;
$onlyRBK = false;
if ($order->total > 3499) {
    $sale = true;
}
if ($coupon AND ($coupon->issue_date <= date('Y-m-d') AND $coupon->term_date >= date('Y-m-d'))) {
    $freeDelivery = $coupon->free_delivery == 1;
    $onlyRBK = $coupon->only_rbk == 1;
    $freeDeliveryWithMOW250 = ($coupon->code == 'RBK-STAFF-XMAS-2011' AND $coupon->free_delivery == 1 AND $pointId == 'MOW');
}
?>

<script type="text/javascript">
function setRates(value) {
    switch (value) {
        case '1':
            var cost = 0;
            if (<?php echo ($freeDeliveryWithMOW250 ? 'true' : 'false') ?>) {
                cost = 250;
            }
            $('#delivery_cost').val(cost);
            $('#delivery_days').val(0);
            break;
        case '2':
            $('#delivery_cost').val('<?php echo ((isset($ponyExpress->tariff_including_vat) AND !$sale) ? $ponyExpress->tariff_including_vat : 0) ?>');
            $('#delivery_days').val('<?php echo ((isset($ponyExpress->delivery_days) AND !$sale) ? $ponyExpress->delivery_days : 0) ?>');
            break;
    }
}
$(document).ready(function () {
    $('input[name=delivery_method]').click(function () {
        setRates(this.value);
    });
    $('#formdata').submit(function () {
        var method = $('input[name=delivery_method]').val();
        setRates(method);
        return true;
    });
    $('input[name=delivery_method]:first').attr('checked', true);
    $('input[name=payment_method]:first').attr('checked', true);
});
</script>

<p class="order-step"><?php echo Yii::t('app', 'Step'); ?>:
    <?php echo CHtml::link('1', array('/checkout')); ?>
    <?php echo CHtml::link('2', array('/checkout/deliveryaddress')); ?>
    <b>3</b> 4 5
</p>
<h1><?php echo Yii::t('app', 'Delivery and payment methods'); ?></h1>
<div class="hr-title"><hr/></div>

<p><?php echo Yii::t('app', 'Пожалуйста выберите доступный способ доставки в ваш город.'); ?></p>
    
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
            <?php if ($pointId == 'MOW' AND $freeDeliveryWithMOW250): ?>
            <tr>
                <td><input type="radio" name="delivery_method" value="1" checked="checked"/></td>
                <td><?php if ($sale) echo Yii::t('app', 'Акция'); ?>
                    250 <?php echo Yii::app()->params['currency']; ?>
                </td>
                <td><?php echo Yii::t('app', 'Free shipping'); ?></td>
                <td></td>
            </tr>
            <?php endif; ?>
            <?php if ($pointId == 'MOW' AND !$freeDeliveryWithMOW250): ?>
            <tr>
                <td><input type="radio" name="delivery_method" value="1" checked="checked"/></td>
                <td><?php if ($sale) echo Yii::t('app', 'Акция'); ?>
                    0.00 <?php echo Yii::app()->params['currency']; ?>
                </td>
                <td><?php echo Yii::t('app', 'Free shipping'); ?></td>
                <td></td>
            </tr>
            <?php endif; ?>
            <?php if ($pointId != 'MOW' AND $ponyExpress): ?>
            <tr>
                <td><input type="radio" name="delivery_method" value="2"/></td>
                <td>
                <?php 
                    if ($sale) 
                        echo Yii::t('app', 'Акция').' 0.00';
                    else
                        echo $ponyExpress->tariff_including_vat.Yii::app()->params['currency']; 
                ?>
                </td>
                <td><?php echo Yii::t('app', 'Pony Express'); ?></td>
                <td><?php echo Yii::t('app', 'Стоимость без НДС'); ?>: 
                    <?php 
                    if ($sale) 
                        echo '0.00';
                    else
                        echo $ponyExpress->tariff.Yii::app()->params['currency']; 
                    ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table> 
    <input type="hidden" name="delivery_cost" id="delivery_cost" value="0.00"/>
    <input type="hidden" name="delivery_days" id="delivery_days" value="0.00"/>
    
    <div class="hr-title"><hr/></div>
    
    <table class="delivery-method" cellspacing="10">
        <tbody>
            <tr>
                <th></th>
                <th align="left"><?php echo Yii::t('app', 'Payment method'); ?></th>
                <th align="left"><?php echo Yii::t('app', 'Additional info'); ?></th>
            </tr>
            <?php if (!$onlyRBK AND ($pointId == 'MOW' AND $order->preorder != 1)): ?>
            <tr>
                <td><input type="radio" name="payment_method" value="1" checked="checked"/></td>
                <td><?php echo Yii::t('app', 'Оплата курьеру при получение'); ?></td>
                <td></td>
            </tr>
            <?php endif; ?>
            <?php if(!$onlyRBK AND $countryId != 811): ?>
            <tr>
                <td><input type="radio" name="payment_method" value="3"/></td>
                <td><?php echo Yii::t('app', 'Банковский перевод'); ?></td>
                <td><?php echo Yii::t('app', 'Вам будет выслан счет по электронной почте'); ?></td>
            </tr>
            <?php else: ?>
            <tr>
                <td><input type="radio" name="payment_method" value="2"/></td>
                <td><?php echo Yii::t('app', 'On-line оплата'); ?></td>
                <td><?php echo Yii::t('app', 'Оплата производится через RBK Money'); ?></td>
            </tr>
            <?php endif; ?>
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