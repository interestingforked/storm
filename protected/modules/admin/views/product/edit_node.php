<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Products / Nodes / Edit node</h2>
    </div>
    <div class="block_content">
        <?php 
        echo $this->renderPartial('_form_node', array(
            'errors' => $errors,
            'model' => $model,
            'colors' => $colors,
            'sizes' => $sizes,
        ));
        ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>
<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Attachments</h2>
    </div>
    <div class="block_content">
        <div id="photo-uploader"><noscript>Please enable JavaScript to use file uploader.</noscript></div>
        <ul id="tmp-attachment-list" class="imglist"></ul>
        <hr/>
        <?php 
        if (isset($attachmentModels)) {
            $path = Yii::app()->params['images'];
        ?>
        <ul class="attachment-list imglist">
            <?php foreach ($attachmentModels AS $file) { ?>
            <li id="file<?php echo $file->id; ?>">
                <img src="/assets/thumb.php?src=<?php echo $path.$file->image; ?>&amp;w=100" alt="<?php echo $file->alt; ?>" />
                <ul>
                    <li class="view"><a href="<?php echo $path.$file->image; ?>" rel="facebox">View</a></li>
                    <li class="delete"><a href="javascript:deleteAttachment(<?php echo $file->id; ?>);">Delete</a></li>
                </ul>
            </li>
            <?php } ?>
        </ul>
        <div class="clear"></div>
        <?php } ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>
<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>All product attachments</h2>
    </div>
    <div class="block_content">
        <?php 
        if (isset($productAttachments)) {
            $path = Yii::app()->params['images'];
        ?>
        <ul class="attachment-list imglist">
            <?php foreach ($productAttachments AS $file) { ?>
            <li id="file<?php echo $file->id; ?>">
                <img src="/assets/thumb.php?src=<?php echo $path.$file->image; ?>&amp;w=100" alt="<?php echo $file->alt; ?>" />
                <ul>
                    <li class="view"><a href="<?php echo $path.$file->image; ?>" rel="facebox">View</a></li>
                    <li class="delete nowarning"><a href="javascript:selectAttachment(<?php echo $file->id; ?>);">Select</a></li>
                </ul>
            </li>
            <?php } ?>
        </ul>
        <div class="clear"></div>
        <?php } ?>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>
<script src="/js/fileuploader.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(createUploader('photo-uploader'));
</script>