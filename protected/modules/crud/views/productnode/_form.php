<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-node-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php 
    if ($errors): 
        echo '<pre>';
        print_r($errors);
        echo '</pre>';
    endif;
    ?>
    
    <h3>Main info</h3>

    <div class="row">
            <?php echo $form->labelEx($model,'active'); ?>
            <?php echo $form->dropDownList($model,'active',array(0 => 'No', 1 => 'Yes')); ?>
            <?php echo $form->error($model,'active'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'main'); ?>
            <?php echo $form->dropDownList($model,'main',array(0 => 'No', 1 => 'Yes')); ?>
            <?php echo $form->error($model,'main'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'new'); ?>
            <?php echo $form->dropDownList($model,'new',array(0 => 'No', 1 => 'Yes')); ?>
            <?php echo $form->error($model,'new'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'sale'); ?>
            <?php echo $form->dropDownList($model,'sale',array(0 => 'No', 1 => 'Yes')); ?>
            <?php echo $form->error($model,'sale'); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($model,'preorder'); ?>
            <?php echo $form->dropDownList($model,'preorder',array(0 => 'No', 1 => 'Yes')); ?>
            <?php echo $form->error($model,'preorder'); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($model,'notify'); ?>
            <?php echo $form->dropDownList($model,'notify',array(0 => 'No', 1 => 'Yes')); ?>
            <?php echo $form->error($model,'notify'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'price'); ?>
            <?php echo $form->textField($model,'price',array('size'=>15,'maxlength'=>15)); ?>
            <?php echo $form->error($model,'price'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'old_price'); ?>
            <?php echo $form->textField($model,'old_price',array('size'=>15,'maxlength'=>15)); ?>
            <?php echo $form->error($model,'old_price'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'quantity'); ?>
            <?php echo $form->textField($model,'quantity'); ?>
            <?php echo $form->error($model,'quantity'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'sort'); ?>
            <?php echo $form->textField($model,'sort'); ?>
            <?php echo $form->error($model,'sort'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'color'); ?>
            <?php echo $form->dropDownList($model,'color',CHtml::listData($colors, 'key', 'value')); ?>
            <?php echo $form->error($model,'color'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'size'); ?>
            <?php echo $form->dropDownList($model,'size',CHtml::listData($sizes, 'key', 'value')); ?>
            <?php echo $form->error($model,'size'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'weight'); ?>
            <?php echo $form->textField($model,'weight'); ?>
            <?php echo $form->error($model,'weight'); ?>
	</div>
    
    <h3>Images</h3>
    
    <div class="row">
        <div id="photo-uploader"><noscript>Please enable JavaScript to use file uploader.</noscript></div>
        <ul id="tmp-attachment-list"></ul>
        <div class="clear"></div>
        <?php 
        if (isset($attachments)) {
            $path = Yii::app()->params['images'];
        ?>
        <ul class="attachment-list">
            <?php foreach ($attachments AS $file) { ?>
            <li id="file<?php echo $file->id; ?>">
                <a href="<?php echo $path.$file->image; ?>" class="modal"><img src="/assets/thumb.php?src=<?php echo $path.$file->image; ?>&amp;w=100" alt="<?php echo $file->alt; ?>" /></a>
                <div>
                    <a class="<?php echo ($file->module=='productBig') ? 'main-media' : ''; ?>" id="mainMedia<?php echo $file->id; ?>" href="javascript:setAsMain(<?php echo $file->id; ?>);">Main</a> |
                    <a href="javascript:deleteAttachment(<?php echo $file->id; ?>);">Delete</a>
                </div>
            </li>
            <?php } ?>
        </ul>
        <div class="clear"></div>
        <?php } ?>
    </div>

    <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div>
<script src="/js/fileuploader.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(createUploader('photo-uploader'));
</script>