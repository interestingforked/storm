<div class="block withsidebar">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Deleted items</h2>
    </div>
    <div class="block_content">
        <div class="sidebar">
            <ul class="sidemenu">
                <li><a href="#sb2">Products</a></li>
                <li><a href="#sb3">Product nodes</a></li>
                <li><a href="#sb4">Pages</a></li>
                <li><a href="#sb5">Articles</a></li>
                <li><a href="#sb6">Galleries</a></li>
            </ul>
        </div>
        <div class="sidebar_content" id="sb2">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Date created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products AS $item):  ?>
                    <tr>
                        <td><?php echo CHtml::link($item['p_title'], array('/admin/product/edit/'.$item['p_id'])); ?></td>
                        <td><?php echo $item['p_created']; ?></td>
                        <td class="delete">
                            <?php echo CHtml::link('Restore', array('/admin/deleted/restore/'.$item['p_id'].'?module=product')); ?>
                            <?php echo CHtml::link('Delete', array('/admin/deleted/delete/'.$item['p_id'].'?module=product'), array('class' => 'delete')); ?>
                        </td>
                    </tr>
                <?php endforeach; $item = null; ?>
                </tbody>
            </table>
        </div>
        <div class="sidebar_content" id="sb3">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Product node</th>
                        <th>Date created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($productNodes AS $item):  ?>
                    <tr>
                        <td><?php echo CHtml::link($item['p_title'], array('/admin/product/editnode/'.$item['p_id'])); ?></td>
                        <td><?php echo $item['p_created']; ?></td>
                        <td class="delete">
                            <?php echo CHtml::link('Restore', array('/admin/deleted/restore/'.$item['p_id'].'?module=productnode')); ?>
                            <?php echo CHtml::link('Delete', array('/admin/deleted/delete/'.$item['p_id'].'?module=productnode'), array('class' => 'delete')); ?>
                        </td>
                    </tr>
                <?php endforeach; $item = null; ?>
                </tbody>
            </table>
        </div>
        <div class="sidebar_content" id="sb4">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>Date created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pages AS $item):  ?>
                    <tr>
                        <td><?php echo CHtml::link($item['p_title'], array('/admin/page/edit/'.$item['p_id'])); ?></td>
                        <td><?php echo $item['p_created']; ?></td>
                        <td class="delete">
                            <?php echo CHtml::link('Restore', array('/admin/deleted/restore/'.$item['p_id'].'?module=page')); ?>
                            <?php echo CHtml::link('Delete', array('/admin/deleted/delete/'.$item['p_id'].'?module=page'), array('class' => 'delete')); ?>
                        </td>
                    </tr>
                <?php endforeach; $item = null; ?>
                </tbody>
            </table>
        </div>
        <div class="sidebar_content" id="sb5">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Date created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($articles AS $item):  ?>
                    <tr>
                        <td><?php echo CHtml::link($item['p_title'], array('/admin/article/edit/'.$item['p_id'])); ?></td>
                        <td><?php echo $item['p_created']; ?></td>
                        <td class="delete">
                            <?php echo CHtml::link('Restore', array('/admin/deleted/restore/'.$item['p_id'].'?module=article')); ?>
                            <?php echo CHtml::link('Delete', array('/admin/deleted/delete/'.$item['p_id'].'?module=article'), array('class' => 'delete')); ?>
                        </td>
                    </tr>
                <?php endforeach; $item = null; ?>
                </tbody>
            </table>
        </div>
        <div class="sidebar_content" id="sb6">
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Gallery</th>
                        <th>Date created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($galleries AS $item):  ?>
                    <tr>
                        <td><?php echo CHtml::link($item['p_title'], array('/admin/gallery/edit/'.$item['p_id'])); ?></td>
                        <td><?php echo $item['p_created']; ?></td>
                        <td class="delete">
                            <?php echo CHtml::link('Restore', array('/admin/deleted/restore/'.$item['p_id'].'?module=gallery')); ?>
                            <?php echo CHtml::link('Delete', array('/admin/deleted/delete/'.$item['p_id'].'?module=gallery'), array('class' => 'delete')); ?>
                        </td>
                    </tr>
                <?php endforeach; $item = null; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>