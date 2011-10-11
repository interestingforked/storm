<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Cart');
?>

<script type="text/javascript">
function changeNode(formId, nodeId) {
    $('#' + formId + 'newProductNodeId').val(nodeId);
    $('#' + formId).submit();
}
</script>

<h1><?php echo Yii::t('app', 'Cart'); ?></h1>
<div class="hr-title"><hr/></div>

<?php if (count($items) == 0): ?>
<p><?php echo Yii::t('app', 'Cart is empty'); ?></p>
<?php else: ?>
<table id="cart" cellpadding="0">
    <thead>
        <tr class="headers">
            <th><?php echo Yii::t('app', 'Products'); ?></th>
            <th></th>
            <th><?php echo Yii::t('app', 'Color'); ?></th>
            <th><?php echo Yii::t('app', 'Size'); ?></th>
            <th><?php echo Yii::t('app', 'Price'); ?></th>
            <th colspan="4"><?php echo Yii::t('app', 'Quantity'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $available = array(
            'items' => array(),
            'total_count' => 0,
            'total_price' => 0.00
        );
        foreach ($items AS $item):
            $formId = 'form'.$item['item']['product_id'].'-'.$item['item']['product_node_id'];
            $colors = array();
            $sizes = array();
            foreach ($item['product']->productNodes AS $node):
			 if ($node->active == 0)
				continue;
             if ( ! empty($node->color))
                $colors[$node->id] = $node->color;
             if ( ! empty($node->size))
                $sizes[$node->id] = $node->size;
            endforeach;
            echo CHtml::beginForm(array('/cart'), 'post', array('id' => $formId));
            echo CHtml::hiddenField('action', 'changeNode');
            echo CHtml::hiddenField('productId', $item['item']['product_id']);
            echo CHtml::hiddenField('productNodeId', $item['item']['product_node_id']);
            echo CHtml::hiddenField('newProductNodeId', 0, array('id' => $formId.'newProductNodeId'));
            echo CHtml::endForm();
        ?>
        <tr>
            <td><?php echo $item['product']->content->title; ?></td>
            <td width="60">
                <?php
                $attachedImage = Attachment::model()->getAttachment('productNode', $item['product']->mainNode->id);
                if ($attachedImage):
                    echo CHtml::link(CHtml::image(Image::thumb(Yii::app()->params['images'].$attachedImage->image, 60), 
                        $item['product']->content->title, array(
                            'id' => 'thumbnail', 'class' => 'prod-details', 'alt' => $attachedImage->alt,
                        )), array('/product/'.$item['product']->slug.'-'.$item['product']->id),
                        array('title' => $item['product']->content->title));
                endif;
                ?>
            </td>
            <td>
                <?php if (count($colors) > 0): ?>
                <select onchange="changeNode('<?php echo $formId; ?>', this.options[this.selectedIndex].value)" id="" name="">
                    <?php foreach($colors AS $ck => $cv): ?>
                    <option value="<?php echo $ck; ?>" <?php echo ($item['item']['product_node_id'] == $ck) ? 'selected' : ''; ?>><?php echo $this->classifier->getValue('color', $cv); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php else: ?>
                -
                <?php endif; ?>
            </td>
            <td>
                <?php if (count($sizes) > 0): ?>
                <select onchange="" id="" name="" class="selectOption">
                    <?php foreach($sizes AS $sk => $sv): ?>
                    <option value="<?php echo $sk; ?>" <?php echo ($item['item']['product_node_id'] == $sk) ? 'selected' : ''; ?>><?php echo $this->classifier->getValue('size', $sv); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php else: ?>
                -
                <?php endif; ?>
            </td>
            <td><nobr><?php echo $item['product']->mainNode->price.Yii::app()->params['currency']; ?></nobr></td>
            <td>
                <?php 
                echo CHtml::beginForm(array('/cart'));
                echo CHtml::hiddenField('action', 'changeQuantity');
                echo CHtml::hiddenField('productId', $item['item']['product_id']);
                echo CHtml::hiddenField('productNodeId', $item['item']['product_node_id']);
                echo CHtml::textField('quantity', $item['item']['quantity'], array('class' => 'text-quantity'));
                ?>
            </td>
            <td>
                <?php 
                if ($item['product']->mainNode->quantity < $item['item']['quantity']) {
                    if ($item['product']->mainNode->quantity == 0) {
                        echo Yii::t('app', 'Out of stock');
                    } else {
                        echo Yii::t('app', 'Only');
                        echo ' '.$item['product']->mainNode->quantity.' ';
                        echo Yii::t('app', 'item available');
                    }
                    $available['items'][] = $item;
                    $available['total_count'] += $item['product']->mainNode->quantity;
                    $available['total_price'] += $item['product']->mainNode->quantity * $item['product']->mainNode->price;
                } else {
                    $available['items'][] = $item;
                    $available['total_count'] += $item['item']['quantity'];
                    $available['total_price'] += $item['item']['quantity'] * $item['item']['price'];
                }
                ?>
            </td>
            <td class="cart-link">
                <?php
                echo CHtml::submitButton(Yii::t('app', 'Refresh'), array(
                    'style' => 'text-decoration: none;',
                    'onmouseout' => "this.style.textDecoration='None'",
                    'onmouseover' => "this.style.textDecoration='Underline'",
                ));
                echo CHtml::endForm(); 
                ?>
            </td>
            <td class="cart-link">
                <?php 
                echo CHtml::beginForm(array('/cart'));
                echo CHtml::hiddenField('action', 'removeItem');
                echo CHtml::hiddenField('productId', $item['item']['product_id']);
                echo CHtml::hiddenField('productNodeId', $item['item']['product_node_id']);
                echo CHtml::submitButton('x '.Yii::t('app', 'Cancel'), array(
                    'style' => 'color: rgb(102, 102, 102);',
                    'onmouseout' => "this.style.color='#666666'",
                    'onmouseover' => "this.style.color='#FFFFFF'",
                ));
                echo CHtml::endForm(); 
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<table id="cart-info" cellpadding="0">
<tbody>
    <tr>
        <td style="width:36%"><?php echo Yii::t('app', 'Мы принимаем заказы на доставку в следующие страны'); ?>: 
            <?php echo implode(', ', $countries); ?></td>
        <td><?php echo Yii::t('app', 'Позиций в корзине'); ?>:</td>
        <td><b><?php echo $list['total_count']; ?></b></td>
        <td class="continue-shop"><a href="/"><?php echo Yii::t('app', 'Continue shopping'); ?> &gt;</a></td>
    </tr>
    <tr>
        <td></td>
        <td class="under"><?php echo Yii::t('app', 'Сумма в корзине'); ?>:</td>
        <td class="under"><b><?php echo number_format($list['total_price'], 2).Yii::app()->params['currency']; ?> </b></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><br/><?php echo Yii::t('app', 'Позиций в корзине'); ?>,<br><?php echo Yii::t('app', 'доступных к заказу'); ?>:</td>
        <td><br/><b><?php echo $available['total_count']; ?></b></td>
        <td></td>
    </tr>
    <?php if ($discount): ?>
    <tr>
        <td></td>
        <td><br/><?php echo Yii::t('app', 'Coupon discount'); ?>:</td>
        <td><br/><b><?php 
                    if ($discountType == 'percentage') {
                        echo number_format($discount, 0).' %';
                        $available['total_price'] = $available['total_price'] - ($available['total_price'] / 100 * $discount);
                    } else {
                        echo $discount.Yii::app()->params['currency']; 
                        $available['total_price'] = $available['total_price'] - $discount;
                    }
                    ?>
            </b></td>
        <td></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td></td>
        <td><br><?php echo Yii::t('app', 'Всего к оплате'); ?>:</td>
        <td><br><b><?php echo number_format($available['total_price'], 2).Yii::app()->params['currency']; ?></b></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align:right;padding-top:20px;" colspan="2">
            <?php echo CHtml::button(Yii::t('app', 'Checkout'), array(
                'class' => 'button',
                'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
                'onmouseover' => "this.style.backgroundColor='#343434'",
                'style' => 'background-color: rgb(31, 31, 31);',
                'onclick' => "location.href='".CHtml::normalizeUrl(array('/checkout'))."'",
            )); ?>
        </td>
        <td></td>
    </tr>
</tbody>
</table>
<br>
<hr/>
<div class="coupon">
<div class="left"><b><?php echo Yii::t('app', 'Купоны для скидок и подарочные сертификаты.'); ?></b><br>
    <?php echo Yii::t('app', 'Введите код Вашего купона для скидки или подарочного сертификата, и нажмите кнопку "Применить". После этого сумма Вашей покупки изменится соответсвенно условиям действия купона/сертификата. Вы можете вводить несколько подарочных сертификатов (по одному за раз). В одной покупке можно использовать только один купон для скидки.'); ?></div>
    <div class="right">
        <?php 
        echo CHtml::beginForm(array('/cart/coupon'));
        echo CHtml::textField('code', null, array('class' => 'field'));
        echo '<br/>';
        echo CHtml::submitButton(Yii::t('app', 'Submit'), array(
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);',
        ));
        echo CHtml::endForm(); 
        ?>
    </div>
</div>
<?php endif; ?>