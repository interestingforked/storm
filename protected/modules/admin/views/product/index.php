<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Products</h2>
        <ul class="tabs">
            <li><a href="/admin/product/add">Add product</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$products OR count($products) == 0): ?>
        <div class="message info"><p>No products found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Title</th>
                    <?php if (!$categoryId): ?>
                    <th>Categories</th>
                    <?php endif; ?>
                    <th>Status</th>
                    <th>Date created</th>
                    <?php if ($categoryId): ?>
                    <th>Sort</th>
                    <th>&nbsp;</th>
                    <?php endif; ?>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($products AS $product):
                $product->content = Content::model()->getModuleContent('product', $product->id);
            ?>
                <tr>
                    <td><?php echo CHtml::link($product->content->title, array('/admin/product/nodes/'.$product->id)); ?></td>
                    <?php if (!$categoryId): ?>
                    <td>
                        <?php
                        $categoryArray = array();
                        foreach ($product->categories AS $category) {
                            $category->content = Content::model()->getModuleContent('category', $category->id);
                            $categoryArray[] = CHtml::link($category->content->title, array('/admin/category/edit/'.$category->id));
                        }
                        echo implode(" / ", $categoryArray);
                        ?>
                    </td>
                    <?php endif; ?>
                    <td><?php echo ($product->active ? 'Active' : 'Not active'); ?></td>
                    <td><?php echo $product->created; ?></td>
                    <?php if ($categoryId): ?>
                    <td><?php echo $product->sort; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_up.png'), array('/admin/product/movepu/'.$product->id.($categoryId?'?category_id='.$categoryId:''))); ?>
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_down.png'), array('/admin/product/movepd/'.$product->id.($categoryId?'?category_id='.$categoryId:''))); ?>
                    </td>
                    <?php endif; ?>
                    <td class="delete">
                        <?php echo CHtml::link('View', array('/product/'.$product->slug.'-'.$product->id), array('target' => '_blank')); ?>
                        <?php echo CHtml::link('Product nodes', array('/admin/product/nodes/'.$product->id)); ?>
                        <?php echo CHtml::link('Edit', array('/admin/product/edit/'.$product->id)); ?>
                        <?php echo CHtml::link('Delete', array('/admin/product/delete/'.$product->id), array('class' => 'delete')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div id="pager" class="pagination right">
            <form>
                <a class="first" href="#">&laquo;&laquo;</a>
                <a class="prev previous" href="#">&laquo;</a>
                <input type="text" class="pagedisplay"/>
                <a class="next" href="#">&raquo;</a>
                <a class="last" href="#">&raquo;&raquo;</a>
                <select class="pagesize">
                    <option selected="selected" value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                </select>
            </form>
        </div>
        <?php endif; ?> 
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>