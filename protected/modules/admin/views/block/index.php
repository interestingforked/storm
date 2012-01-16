<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Blocks</h2>
        <ul class="tabs">
            <li><a href="/admin/block/add">Add block</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$blocks OR count($blocks) == 0): ?>
        <div class="message info"><p>No blocks found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date created</th>
                    <th>Sort</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($blocks AS $block):
                $block->content = Content::model()->getModuleContent('block', $block->id);
            ?>
                <tr>
                    <td><?php echo CHtml::link($block->content->title, array('/admin/block/edit/'.$block->id)); ?></td>
                    <td><?php echo ($block->active ? 'Active' : 'Disabled'); ?></td>
                    <td><?php echo $block->created; ?></td>
                    <td><?php echo $block->sort; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_up.png'), array('/admin/block/moveu/'.$block->id)); ?>
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_down.png'), array('/admin/block/moved/'.$block->id)); ?>
                    </td>
                    <td class="delete">
                        <?php echo CHtml::link('Edit', array('/admin/block/edit/'.$block->id)); ?>
                        <?php echo CHtml::link('Translate', array('/admin/block/translate/'.$block->id)); ?>
                        <?php echo CHtml::link('Delete', array('/admin/block/delete/'.$block->id), array('class' => 'delete')); ?>
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