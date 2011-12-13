<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Order overview');
?>

<p class="order-step"><?php echo Yii::t('app', 'Step'); ?>:
    <?php echo CHtml::link('1', array('/checkout')); ?>
    <?php echo CHtml::link('2', array('/checkout/deliveryaddress')); ?>
    <?php echo CHtml::link('3', array('/checkout/deliverymethod')); ?>
    <b>4</b> 5
</p>
<h1><?php echo Yii::t('app', 'Order overview'); ?></h1>
<div class="hr-title"><hr/></div>

<p><?php echo Yii::t('app', 'Информация о заказе.'); ?></p>

<?php if ($messages): ?>
<?php endif; ?>
    
<div id="login-form">
    <?php echo CHtml::beginForm('', 'post', array('id' => 'formdata')); ?>
        <table id="cart" cellpadding="0">
            <thead>
                <tr class="headers">
                    <th><?php echo Yii::t('app', 'Products'); ?></th>
                    <th><?php echo Yii::t('app', 'Color'); ?></th>
                    <th><?php echo Yii::t('app', 'Size'); ?></th>
                    <th><?php echo Yii::t('app', 'Price'); ?></th>
                    <th><?php echo Yii::t('app', 'Quantity'); ?></th>
                    <th><?php echo Yii::t('app', 'Cost'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems AS $item): ?>
                <tr>
                    <td><?php echo $item['product']->content->title; ?></td>
                    <td><?php echo $this->classifier->getValue('color', $item['product']->mainNode->color); ?></td>
                    <td><?php echo $this->classifier->getValue('color', $item['product']->mainNode->size); ?></td>
                    <td><?php echo $item['product']->mainNode->price.Yii::app()->params['currency']; ?></td>
                    <td><?php echo $item['item']['quantity']; ?></td>
                    <td><?php echo number_format($item['item']['subtotal'], 0,'.','').Yii::app()->params['currency']; ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td style="padding-top:20px;" colspan="5"><?php echo Yii::t('app', 'Products price'); ?>:</td>
                    <td style="padding-top:20px;"><?php echo number_format($price, 0,'.','').Yii::app()->params['currency']; ?></td>
                </tr>
                <?php if ($discount): ?>
                <tr>
                    <td style="padding-top:9px;" colspan="5"><?php echo Yii::t('app', 'Coupon discount'); ?>:</td>
                    <td style="padding-top:9px;"><?php 
                    if ($discountType == 'percentage')
                        echo $discount.' %';
                    else
                        echo number_format($discount, 0,'.','').Yii::app()->params['currency']; 
                    ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td style="padding-top:9px;padding-bottom:8px;" colspan="5"><?php echo Yii::t('app', 'Shipping'); ?>:</td>
                    <td style="padding-top:9px;padding-bottom:8px;"><?php echo number_format($shipping, 0,'.','').Yii::app()->params['currency']; ?></td>
                </tr>
                <tr>
                    <td style="padding-bottom:20px;padding-top:8px;" colspan="5"><?php echo Yii::t('app', 'Total sum of order'); ?>:</td>
                    <td style="padding-bottom:20px;padding-top:8px;border-top:solid 1px #ccc;"><?php echo number_format($totalPrice, 0,'.','').Yii::app()->params['currency']; ?></td>
                </tr>
            </tbody>
        </table>
        <table class="order-conf-info"> 
            <tr>
                <td style="width:50%;">
                    <h5><?php echo Yii::t('app', 'Payment information'); ?></h5>
                    <p><?php echo Yii::t('app', 'Click'); ?> <?php echo CHtml::link(Yii::t('app', 'here'), array('/checkout')); ?>, 
                        <?php echo Yii::t('app', 'to change'); ?></p>
                    <p><?php echo $paymentData->name.' '.$paymentData->surname; ?><br/>
                        <?php echo $paymentData->phone; ?><br/>
                        <?php echo $paymentData->email; ?><br/>
                        <?php echo $paymentData->house.', '.$paymentData->street; ?><br/>
                        <?php echo $paymentData->city.', '.$paymentData->district; ?><br/>
                        <?php echo $paymentData->postcode; ?><br/>
                        <?php echo Country::model()->getCountryName($paymentData->country_id); ?></p>
                </td>
                <td style="width:50%;">
                    <h5><?php echo Yii::t('app', 'Shipping information'); ?></h5>
                    <p><?php echo Yii::t('app', 'Click'); ?> <?php echo CHtml::link(Yii::t('app', 'here'), array('/checkout/deliveryaddress')); ?>, 
                        <?php echo Yii::t('app', 'to change'); ?></p>
                    <p><?php echo $shippingData->name.' '.$shippingData->surname; ?><br/>
                        <?php echo $shippingData->phone; ?><br/>
                        <?php echo $shippingData->email; ?><br/>
                        <?php echo $shippingData->house.', '.$shippingData->street; ?><br/>
                        <?php echo $shippingData->city.', '.$shippingData->district; ?><br/>
                        <?php echo $shippingData->postcode; ?><br/>
                        <?php echo Country::model()->getCountryName($paymentData->country_id); ?></p>
                </td>
            </tr>
        </table>
        <div class="checkout-btns">
            <?php 
            echo CHtml::button(Yii::t('app', 'Back'), array(
                'class' => 'button',
                'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
                'onmouseover' => "this.style.backgroundColor='#343434'",
                'style' => 'background-color: rgb(31, 31, 31);',
                'onclick' => "location.href='".CHtml::normalizeUrl(array('/checkout/deliverymethod'))."'",
            ));
            $buttonLabel = ($order->payment_method == 2) ? Yii::t('app', 'Перейти к оплате') : Yii::t('app', 'Подтвердить заказ');
            echo CHtml::submitButton($buttonLabel, array(
                'class' => 'button',
                'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
                'onmouseover' => "this.style.backgroundColor='#343434'",
                'style' => 'background-color: rgb(31, 31, 31);',
            )); 
            ?>
        </div>
    <?php echo CHtml::endForm(); ?>
</div>