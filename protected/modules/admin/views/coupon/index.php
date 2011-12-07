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
                    <th>Used (times)</th>
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
                    <td><?php echo CHtml::link($coupon->code, array('/admin/coupon/view/'.$coupon->id)); ?></td>
                    <td><?php echo $coupon->value.($coupon->percentage ? ' %' : ''); ?></td>
                    <td><?php echo (!$coupon->once ? 'Yes' : '-'); ?></td>
                    <td><?php echo $orderCount; ?></td>
                    <td><?php echo $coupon->issue_date; ?></td>
                    <td><?php echo $coupon->term_date; ?></td>
                    <td><?php echo $coupon->created; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link('View', array('/admin/coupon/view/'.$coupon->id)); ?>
                        <?php echo CHtml::link('Edit', array('/admin/coupon/edit/'.$coupon->id)); ?>
                        <?php echo CHtml::link('Delete', array('/admin/coupon/delete/'.$coupon->id), array('class' => 'delete')); ?>
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