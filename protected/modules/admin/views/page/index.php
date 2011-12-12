<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Pages</h2>
        <ul class="tabs">
            <li><a href="/admin/page/add">Add page</a></li>
        </ul>
    </div>
    <div class="block_content">
        <?php if (!$pages OR count($pages) == 0): ?>
        <div class="message info"><p>No pages found!</p></div>
        <?php else: ?>
        <table cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date created</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rendered = new Renderer(Yii::app()->params['adminIcons']);
                $rendered->renderRecursive($pages);
                ?>
            </tbody>
        </table>
        <?php endif; ?> 
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>