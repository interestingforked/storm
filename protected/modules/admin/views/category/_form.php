<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'category-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary(array($categoryModel, $contentModel)); 
?>
<p>
    <?php echo $form->labelEx($categoryModel, 'parent_id'); ?>
    <span class="note error"><?php echo $form->error($categoryModel, 'parent_id'); ?></span><br/>
    <select name="Category[parent_id]" id="Category_parent_id" class="styled big">
        <option value="1">---</option>
        <?php 
        $rendered = new Renderer();
        $rendered->renderRecursive($categories['items'], $categoryModel->parent_id, Renderer::RENDER_OPTION_LIST);
        ?>
    </select>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'title'); ?><br/>
    <?php echo $form->textField($contentModel,'title', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($contentModel, 'title'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($categoryModel, 'slug'); ?><br/>
    <?php echo $form->textField($categoryModel,'slug', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($categoryModel, 'slug'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'language'); ?><br/>
    <?php echo $form->dropDownList($contentModel,'language', $this->languages, array('class' => 'styled small')); ?>
</p>
<p>
    <?php echo $form->labelEx($categoryModel, 'sort'); ?><br/>
    <?php echo $form->textField($categoryModel,'sort', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($categoryModel, 'sort'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($categoryModel, 'active', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($categoryModel, 'active'); ?>
    <span class="note error"><?php echo $form->error($categoryModel, 'active'); ?></span>
</p>
<hr/>
<p>
    <?php echo $form->labelEx($contentModel, 'body'); ?><br/>
    <?php echo $form->textArea($contentModel,'body', array('class' => 'wysiwyg')); ?>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'meta_title'); ?><br/>
    <?php echo $form->textField($contentModel,'meta_title', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($contentModel, 'meta_title'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'meta_keywords'); ?><br/>
    <?php echo $form->textField($contentModel,'meta_keywords', array('class' => 'text big')); ?>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'meta_description'); ?><br/>
    <?php echo $form->textArea($contentModel,'meta_description', array('class' => 'text medium')); ?>
</p>
<p class="fileupload">
    <?php echo $form->labelEx($categoryModel, 'image'); ?><br/>
    <?php echo $form->fileField($categoryModel,'image', array('class' => 'file', 'id' => 'fileupload')); ?>
    <span id="uploadmsg">Max size 3Mb</span>
</p>
<?php if (!$categoryModel->isNewRecord): ?>
<p>
    <img src="<?php echo Yii::app()->params['categories'].$categoryModel->image; ?>"/>
</p>
<?php endif; ?>
<hr/>
<div id="tempAttachments"></div>
<p>
    <?php echo CHtml::submitButton($categoryModel->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>