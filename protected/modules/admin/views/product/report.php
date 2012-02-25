<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Product report</h2>
    </div>
    <div class="block_content">
        <?php if (!$products OR count($products) == 0): ?>
        <div class="message info"><p>No products found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date created</th>
                    <th>Total</th>
                    <th>Color</th>
                    <th>Size</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($products AS $product):
            ?>
                <tr>
                    <td><?php echo CHtml::link($product['p_title'], array('/admin/product/edit/'.$product['p_id'])); ?></td>
                    <td><?php echo ($product['p_active'] ? 'Active' : 'Disabled'); ?></td>
                    <td><?php echo $product['p_created']; ?></td>
                    <td><?php echo $product['p_total']; ?></td>
                    <td><?php echo $this->classifier->getValue('color', $product['pn_color'], '-'); ?></td>
                    <td><?php echo $this->classifier->getValue('size', $product['pn_size'], '-'); ?></td>
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
                    <option value="10">10</option>
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