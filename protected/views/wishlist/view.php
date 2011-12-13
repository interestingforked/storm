<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Wishlist');
?>

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
            <th><?php echo Yii::t('app', 'Quantity'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($items AS $item):
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
                <select onchange="" id="" name="" disabled="disabled">
                    <?php foreach($colors AS $ck => $cv): ?>
                    <option value="<?php echo $ck; ?>" <?php echo ($item['item']->product_node_id == $ck) ? 'selected' : ''; ?>><?php echo $this->classifier->getValue('color', $cv); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php else: ?>
                -
                <?php endif; ?>
            </td>
            <td>
                <?php if (count($sizes) > 0): ?>
                <select onchange="" id="" name="" class="selectOption" disabled="disabled">
                    <?php foreach($sizes AS $sk => $sv): ?>
                    <option value="<?php echo $sk; ?>" <?php echo ($item['item']->product_node_id == $sk) ? 'selected' : ''; ?>><?php echo $this->classifier->getValue('size', $sv); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php else: ?>
                -
                <?php endif; ?>
            </td>
            <td><?php echo $item['product']->mainNode->price.Yii::app()->params['currency']; ?></td>
            <td><?php  echo $item['item']->quantity; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>