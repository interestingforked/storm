<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Users</h2>
    </div>
    <div class="block_content">
        <?php echo CHtml::beginForm(); ?>
        <table cellpadding="0" cellspacing="1" width="100%">
            <tr>
                <td><label for="start_date">Registered from</label><br/><?php echo CHtml::textField('start_date', $userStartDate, array('class' => 'text date_picker')); ?></td>
                <td><label for="start_date">Registered to</label><br/><?php echo CHtml::textField('end_date', $userEndDate, array('class' => 'text date_picker')); ?></td>
                <td><label for="status">Status</label><br/><?php echo CHtml::dropDownList('status', $userStatus, $userStatuses, array('class' => 'styled small')); ?></td>
                <td><br/><?php echo CHtml::checkBox('tocsv', false, array('class' => 'checkbox')); ?> &nbsp; <label for="tocsv">Get CSV format</label></td>
                <td><br/><?php echo CHtml::submitButton('Filter', array('class' => 'submit small')); ?></td>
            </tr>
        </table>
        <?php echo CHtml::endForm(); ?>
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