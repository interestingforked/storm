<h1>Product Nodes</h1>

<table class="data">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Product</th>
        <th>Price</th>
        <th>Color</th>
        <th>Size</th>
        <th>Main</th>
        <th>New</th>
        <th>Sale</th>
        <th>Status</th>
        <th>Sort</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
<?php 
foreach ($data AS $node): 
    $productModel = $node->product;
    $product = $productModel->getProduct();
?>
<tr>
    <td align="center"><?php echo $node->id; ?></td>
    <td align="center"><?php 
    $image = Attachment::model()->getAttachment('productNode', $node->id);
    if ($image):
        echo CHtml::image(Image::thumb(Yii::app()->params['images'].$image->image, 50));
    endif; 
    ?></td>
    <td align="center"><?php echo CHtml::link($product->content->title, array('/crud/product/edit/'.$product->id)); ?></td>
    <td align="right"><?php echo $node->price; ?></td>
    <td align="center"><?php echo $this->classifier->getValue('color', $node->color, '-'); ?></td>
    <td align="center"><?php echo $this->classifier->getValue('size', $node->size, '-'); ?></td>
    <td align="center"><?php echo ($node->main == 1) ? 'Yes' : 'No'; ?></td>
    <td align="center"><?php echo ($node->new == 1) ? 'Yes' : 'No'; ?></td>
    <td align="center"><?php echo ($node->sale == 1) ? 'Yes' : 'No'; ?></td>
    <td align="center"><?php echo ($node->active == 1) ? 'Active' : 'Not active'; ?></td>
    <td align="center"><?php echo $node->sort; ?></td>
    <td align="center"><?php echo $node->created; ?></td>
    <td align="center">
        <?php
        echo CHtml::link('View', array('/product/'.$product->slug.'-'.$product->id));
        echo ' / ';
        echo CHtml::link('Edit', array('/crud/productnode/edit/'.$node->id));
        echo ' / ';
        echo CHtml::link('Delete', array('/crud/productnode/delete/'.$node->id));
        ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
<div class="action-area">
    <?php 
    if ($id > 0):
        echo CHtml::link('New product node', array('/crud/productnode/new/'.$id)); 
    endif;
    ?>
</div>
