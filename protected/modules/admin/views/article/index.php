<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>News</h2>
        <ul class="tabs">
            <li><a href="/admin/article/add">Add article</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$articles OR count($articles) == 0): ?>
        <div class="message info"><p>No news found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Special</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($articles AS $article):
                $article->content = Content::model()->getModuleContent('article', $article->id);
            ?>
                <tr>
                    <td><?php echo CHtml::link($article->content->title, array('/admin/article/edit/'.$article->id)); ?></td>
                    <td><?php echo ($article->active ? 'Active' : 'Disabled'); ?></td>
                    <td>
                        <?php 
                        if ($article->hot) 
                            echo 'Hot'; 
                        else if($article->home):
                            echo 'Home'; 
                        else:
                            echo 'None'; 
                        endif;
                        ?>
                    </td>
                    <td><?php echo $article->created; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_up.png'), array('/admin/article/moveu/'.$article->id)); ?>
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_down.png'), array('/admin/article/moved/'.$article->id)); ?>
                    </td>
                    <td class="delete">
                        <?php echo CHtml::link('View', array('/news/'.$article->slug), array('target' => '_blank')); ?>
                        <?php echo CHtml::link('Edit', array('/admin/article/edit/'.$article->id)); ?>
                        <?php echo CHtml::link('Delete', array('/admin/article/delete/'.$article->id), array('class' => 'delete')); ?>
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