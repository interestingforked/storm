<div class="form">

<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'product-form',
    'enableAjaxValidation' => false,
));
?>
    <?php echo $form->errorSummary(array($productModel, $contentModel)); ?>

    <?php 
    if ($errors): 
        echo '<pre>';
        print_r($errors);
        echo '</pre>';
    endif;
    ?>
    
    <h3>Main info</h3>
    
    <div class="row">
            <?php echo Chtml::label('Categories','Categories_1'); ?>
            <?php echo Chtml::dropDownList('Categories[]',$activeCategories[0]->id.' ',$categories,array('id' => 'Categories_1')); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($productModel,'active'); ?>
            <?php echo $form->dropDownList($productModel,'active',array(0 => 'No', 1 => 'Yes')); ?>
            <?php echo $form->error($productModel,'active'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($productModel,'sort'); ?>
            <?php echo $form->textField($productModel,'sort'); ?>
            <?php echo $form->error($productModel,'sort'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($productModel,'slug'); ?>
            <?php echo $form->textField($productModel,'slug'); ?>
            <?php echo $form->error($productModel,'slug'); ?>
    </div>
    
    <h3>Content</h3>

    <div class="row">
            <?php echo $form->labelEx($contentModel,'language'); ?>
            <?php echo $form->dropDownList($contentModel,'language', Yii::app()->params['languages']); ?>
            <?php echo $form->error($contentModel,'language'); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($contentModel,'title'); ?>
            <?php echo $form->textField($contentModel,'title'); ?>
            <?php echo $form->error($contentModel,'title'); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($contentModel,'body'); ?>
            <?php echo $form->textArea($contentModel,'body'); ?>
            <?php echo $form->error($contentModel,'body'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($contentModel,'additional'); ?>
            <?php echo $form->textArea($contentModel,'additional'); ?>
            <?php echo $form->error($contentModel,'additional'); ?>
    </div>
    
    <h3>Meta data</h3>
    
    <div class="row">
            <?php echo $form->labelEx($contentModel,'meta_title'); ?>
            <?php echo $form->textField($contentModel,'meta_title'); ?>
            <?php echo $form->error($contentModel,'meta_title'); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($contentModel,'meta_description'); ?>
            <?php echo $form->textArea($contentModel,'meta_description'); ?>
            <?php echo $form->error($contentModel,'meta_description'); ?>
    </div>
    
    <div class="row">
            <?php echo $form->labelEx($contentModel,'meta_keywords'); ?>
            <?php echo $form->textArea($contentModel,'meta_keywords'); ?>
            <?php echo $form->error($contentModel,'meta_keywords'); ?>
    </div>
    
    <h3>Images</h3>
    
    <div class="row">
        <div id="photo-uploader"><noscript>Please enable JavaScript to use file uploader.</noscript></div>
        <ul id="tmp-attachment-list"></ul>
        <div class="clear"></div>
        <?php 
        if (isset($attachmentModels)) {
            $path = Yii::app()->params['images'];
        ?>
        <ul class="attachment-list">
            <?php foreach ($attachmentModels AS $file) { ?>
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
            <?php echo CHtml::submitButton($productModel->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
    
<?php $this->endWidget(); ?>
</div>

<script src="/js/fileuploader.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(createUploader('photo-uploader'));
</script>