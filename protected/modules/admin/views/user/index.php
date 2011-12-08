<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Users</h2>
    </div>
    <div class="block_content">
        <?php if (!$users OR count($users) == 0): ?>
        <div class="message info"><p>No users found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>E-mail</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Status</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($users AS $user):
                $profile = $user->profile
            ?>
                <tr>
                    <td><?php echo CHtml::link($profile->firstname.' '.$profile->lastname, array('/admin/user/edit/'.$user->id)); ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo Profile::range('1==Младше 18;2==18-25;3==26-35;4==36+', $profile->getAttribute('age')); ?></td>
                    <td><?php echo ($profile->sex ? 'Мужской' : 'Женский'); ?></td>
                    <td>
                    <?php 
                    switch ($user->status) {
                        case User::STATUS_BANED:
                            echo 'Banned'; break;
                        case User::STATUS_NOACTIVE:
                            echo 'Not active'; break;
                        case User::STATUS_ACTIVE:
                            echo 'Active'; break;
                        default:
                            echo '-'; break;
                    }
                    ?>
                    </td>
                    <td><?php echo date('Y-m-d G:i:s', $user->createtime); ?></td>
                    <td class="delete">
                        <?php echo CHtml::link('Edit', array('/admin/user/edit/'.$user->id)); ?>
                        <?php echo CHtml::link('Enable', array('/admin/user/enable/'.$user->id)); ?>
                        <?php echo CHtml::link('Disable', array('/admin/user/disable/'.$user->id), array('class' => 'disable')); ?>
                        <?php echo CHtml::link('Ban', array('/admin/user/ban/'.$user->id), array('class' => 'ban')); ?>
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