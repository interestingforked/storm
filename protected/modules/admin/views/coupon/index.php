<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Coupons</h2>
        <ul class="tabs">
            <li><a href="/admin/coupon/add">Add coupon</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$coupons OR count($coupons) == 0): ?>
        <div class="message info"><p>No coupons found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Value</th>
                    <th>Reusable</th>
                    <th>Free delivery</th>
                    <th>Not for sale</th>
                    <th>Used (times)</th>
                    <th>Max</th>
                    <th>Issue date</th>
                    <th>Term date</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($coupons AS $coupon):
                $orderCount = 0;
                $orders = $coupon->orders;
                if ($orders) {
                    $orderCount = count($orders);
                }
            ?>
                <tr>
                    <tr>
                    <td><?php echo CHtml::link($coupon->code, array('/admin/coupon/edit/'.$coupon->id)); ?></td>
                    <td><?php echo $coupon->value.($coupon->percentage ? ' %' : ''); ?></td>
                    <td><?php echo (!$coupon->once ? 'Yes' : 'No'); ?></td>
                    <td><?php echo ($coupon->free_delivery ? 'Yes' : 'No'); ?></td>
                    <td><?php echo ($coupon->not_for_sale ? 'Yes' : 'No'); ?></td>
                    <td><?php echo $orderCount; ?></td>
                    <td><?php echo $coupon->max_count; ?></td>
                    <td><?php echo $coupon->issue_date; ?></td>
                    <td><?php echo $coupon->term_date; ?></td>
                    <td><?php echo $coupon->created; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link('Edit', array('/admin/coupon/edit/'.$coupon->id)); ?>
                        <?php echo CHtml::link('Delete', array('/admin/coupon/delete/'.$coupon->id), array('class' => 'delete')); ?>
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