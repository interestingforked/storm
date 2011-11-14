<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Wishlist');
?>

<script type="text/javascript">
function changeNode(formId, nodeId) {
    $('#' + formId + 'newProductNodeId').val(nodeId);
    $('#' + formId).submit();
}
</script>

<h1><?php echo Yii::t('app', 'Wishlist'); ?></h1>
<div class="hr-title"><hr/></div>

<?php if (count($items) == 0): ?>
<p><?php echo Yii::t('app', 'Wishlist is empty'); ?></p>
<?php else: ?>
<table id="cart" cellpadding="0">
    <thead>
        <tr class="headers">
            <th><?php echo Yii::t('app', 'Products'); ?></th>
            <th></th>
            <th><?php echo Yii::t('app', 'Color'); ?></th>
            <th><?php echo Yii::t('app', 'Size'); ?></th>
            <th><?php echo Yii::t('app', 'Price'); ?></th>
            <th colspan="4"><?php echo Yii::t('app', 'Buy quantity'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
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
            echo CHtml::beginForm(array('/wishlist'), 'post', array('id' => $formId));
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
            <td><?php echo $item['product']->mainNode->price.Yii::app()->params['currency']; ?></td>
            <td>
                <?php 
                echo CHtml::beginForm(array('/wishlist'));
                echo CHtml::hiddenField('action', 'changeQuantity');
                echo CHtml::hiddenField('productId', $item['item']['product_id']);
                echo CHtml::hiddenField('productNodeId', $item['item']['product_node_id']);
                echo CHtml::textField('quantity', $item['item']['quantity'], array('class' => 'text-quantity'));
                ?>
            <td></td>
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
                echo CHtml::beginForm(array('/wishlist'));
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
<div class="send-wish">
    <?php 
        echo CHtml::beginForm(array('/cart'));
        echo CHtml::hiddenField('action', 'copy_from_wishlist');
        echo CHtml::submitButton(Yii::t('app', 'Купить выбранные'), array(
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);margin:0 0 10px;',
        ));
        echo CHtml::endForm(); 
        ?>
</div>
<div class="send-wish">
    <?php 
    if ( ! Yii::app()->user->isGuest) {
        echo CHtml::link(Yii::t('app', 'Send wishlist to friend'), array('/wishlist/send'), array('class' => 'button')); 
    }
    ?>
</div>
<?php endif; ?>
<div class="cont-shop"><a href="<?php echo $referer; ?>"><?php echo Yii::t('app', 'Continue shopping'); ?> &gt;</a></div>