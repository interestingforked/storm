<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Orders</h2>
    </div>
    <div class="block_content">
        <?php if (!$orders OR count($orders) == 0): ?>
        <div class="message info"><p>No orders found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="1" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Coupon</th>
                    <th>Status</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($orders AS $order):
                $user = User::model()->findByPk($order->user_id);
                $profile = $user->profile;
                $fullname = $profile->firstname.' '.$profile->lastname;
            ?>
                <tr>
                    <td><?php echo CHtml::link($fullname, array('/admin/order/user/'.$order->user_id)); ?></td>
                    <td><?php echo $order->quantity; ?></td>
                    <td><?php echo $order->total; ?></td>
                    <td><?php echo ($order->coupon_id > 0 ? 'Yes' : 'No'); ?></td>
                    <td><?php 
                        switch ($order->status) {
                            case 1: echo 'New order'; break;
                            case 2: echo 'Waiting for payment'; break;
                            case 3: echo 'Completed'; break;
                        }
                    ?></td>
                    <td><?php echo $order->created; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link('View', array('/admin/order/view/'.$order->id)); ?>
                        <?php echo CHtml::link('Delete', array('/admin/order/delete/'.$order->id), array('class' => 'delete')); ?>
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
        <?php endif;  ?> 
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>