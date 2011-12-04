<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Product nodes</h2>
        <ul class="tabs">
            <li><a href="/admin/product/addnode/<?php echo $productId; ?>">Add product node</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$products OR count($products) == 0): ?>
        <div class="message info"><p>No products found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Product title</th>
                    <th>Status</th>
                    <th>Main</th>
                    <th>New</th>
                    <th>Sale</th>
                    <th>Preorder</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($products AS $productNode):
                $product = $productNode->product;
                $product->content = Content::model()->getModuleContent('product', $product->id);
            ?>
                <tr>
                    <td><?php echo CHtml::link($product->content->title, array('/admin/product/edit/'.$product->id)); ?></td>
                    <td><?php echo ($product->active ? 'Active' : 'Not active'); ?></td>
                    <td><?php echo ($productNode->main ? 'Yes' : '-'); ?></td>
                    <td><?php echo ($productNode->new ? 'Yes' : '-'); ?></td>
                    <td><?php echo ($productNode->sale ? 'Yes' : '-'); ?></td>
                    <td><?php echo ($productNode->preorder ? 'Yes' : '-'); ?></td>
                    <td><?php echo $productNode->price; ?></td>
                    <td><?php echo $productNode->quantity; ?></td>
                    <td><?php echo $this->classifier->getValue('color', $productNode->color, '-'); ?></td>
                    <td><?php echo $this->classifier->getValue('size', $productNode->size, '-'); ?></td>
                    <td><?php echo $product->created; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_up.png'), array('/admin/product/movenu/'.$productNode->id)); ?>
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_down.png'), array('/admin/product/movend/'.$productNode->id)); ?>
                    </td>
                    <td class="delete">
                        <?php echo CHtml::link('View', array('/product/'.$product->slug.'-'.$product->id), array('target' => '_blank')); ?>
                        <?php echo CHtml::link('Edit', array('/admin/product/editnode/'.$productNode->id)); ?>
                        <?php echo CHtml::link('Delete', array('/admin/product/deletenode/'.$productNode->id), array('class' => 'delete')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php $this->widget('LinkPager', array(
            'pages' => $pagination,
        )); ?>
        <?php endif; ?> 
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>