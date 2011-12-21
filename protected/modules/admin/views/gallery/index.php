<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Galleries</h2>
        <ul class="tabs">
            <li><a href="/admin/gallery/add">Add gallery</a></li>
            <li><a href="/admin/gallery/addheading">Add gallery heading</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$galleries OR count($galleries) == 0): ?>
        <div class="message info"><p>No news found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Page</th>
                    <th>Status</th>
                    <th>Pagination</th>
                    <th>Heading</th>
                    <th>Sort</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($galleries AS $gallery):
                $gallery->content = Content::model()->getModuleContent('gallery', $gallery->id);
                $title = ($gallery->content) ? $gallery->content->title : 'N/A';
                $page = Page::model()->findByPk($gallery->page_id);
                $page->content = Content::model()->getModuleContent('page', $page->id);
            ?>
                <tr>
                    <td><?php echo CHtml::link($title, array('/admin/gallery/edit/'.$gallery->id)); ?></td>
                    <td><?php echo CHtml::link($page->content->title, array('/admin/page/edit/'.$page->id)); ?></td>
                    <td><?php echo ($gallery->active ? 'Active' : 'Disabled'); ?></td>
                    <td><?php echo ($gallery->pagination ? 'Yes' : 'No'); ?></td>
                    <td><?php echo ($gallery->heading ? 'Yes' : 'No'); ?></td>
                    <td><?php echo $gallery->sort; ?></td>
                    <td><?php echo $gallery->created; ?></td>
                    <td class="delete">
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_up.png'), array('/admin/gallery/moveu/'.$gallery->id)); ?>
                        <?php echo CHtml::link(CHtml::image('/images/admin/arrow_down.png'), array('/admin/gallery/moved/'.$gallery->id)); ?>
                    </td>
                    <td class="delete">
                        <?php echo CHtml::link('View', array('/'.$page->slug.'/'.$gallery->slug), array('target' => '_blank')); ?>
                        <?php 
                        if ($gallery->heading)
                            echo CHtml::link('Edit', array('/admin/gallery/editheading/'.$gallery->id)); 
                        else
                            echo CHtml::link('Edit', array('/admin/gallery/edit/'.$gallery->id)); 
                        ?>
                        <?php echo CHtml::link('Delete', array('/admin/gallery/delete/'.$gallery->id), array('class' => 'delete')); ?>
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