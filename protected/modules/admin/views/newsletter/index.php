<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Newsletters</h2>
        <ul class="tabs">
            <li><a href="/admin/newsletter/add">Add newsletter</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$newsletters OR count($newsletters) == 0): ?>
        <div class="message info"><p>No newsletters found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>User received</th>
                    <th>Start</th>
                    <th>Sent</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($newsletters AS $newsletter):
                $userCount = 0;
            ?>
                <tr>
                    <tr>
                    <td><?php echo CHtml::link($newsletter->subject, array('/admin/newsletters/edit/'.$newsletter->id)); ?></td>
                    <td><?php echo $userCount; ?></td>
                    <td><?php echo $newsletter->start; ?></td>
                    <td><?php echo $newsletter->sent; ?></td>
                    <td><?php echo $newsletter->created; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link('Edit', array('/admin/newsletter/edit/'.$newsletter->id)); ?>
                        <?php echo CHtml::link('Activate', array('/admin/newsletter/activate/'.$newsletter->id), array('class' => 'activate')); ?>
                        <?php echo CHtml::link('Delete', array('/admin/newsletter/delete/'.$newsletter->id), array('class' => 'delete')); ?>
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