<div class="block small left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Last Orders</h2>
        <ul class="tabs">
            <li><a href="/admin/order">View orders</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$lastOrders OR count($lastOrders) == 0): ?>
        <div class="message info"><p>No orders found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lastOrders AS $lastOrder): 
                $user = User::model()->findByPk($lastOrder->user_id);
                $profile = $user->profile;
                $fullname = $profile->firstname.' '.$profile->lastname;
                ?>
                <tr>
                    <td><?php echo CHtml::link($fullname, array('/admin/user/view/'.$lastOrder->user_id)); ?></td>
                    <td><?php echo $lastOrder->quantity; ?></td>
                    <td><?php echo $lastOrder->total; ?></td>
                    <td><?php echo $lastOrder->status; ?></td>
                    <td><?php echo date("Y-m-d", strtotime($lastOrder->created)); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>
<div class="block small right">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Last registered users</h2>
        <ul class="tabs">
            <li><a href="/admin/user">View user</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$lastUsers OR count($lastUsers) == 0): ?>
        <div class="message info"><p>No users found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>E-mail</th>
                    <th>Active</th>
                    <th>Date created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lastUsers AS $lastUser): 
                $profile = $lastUser->profile;
                $fullname = $profile->firstname.' '.$profile->lastname;
                ?>
                <tr>
                    <td><?php echo CHtml::link($fullname, array('/admin/user/view/'.$lastUser->id)); ?></td>
                    <td><?php echo $lastUser->email; ?></td>
                    <td><?php echo $lastUser->status; ?></td>
                    <td><?php echo date("Y-m-d", $lastUser->createtime); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>