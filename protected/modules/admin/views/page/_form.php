<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'page-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary(array($pageModel, $contentModel)); 
?>
<p>
    <?php echo $form->labelEx($pageModel, 'parent_id'); ?>
    <span class="note error"><?php echo $form->error($pageModel, 'parent_id'); ?></span><br/>
    <select name="Page[parent_id]" id="Page_parent_id" class="styled big">
        <option value="1">---</option>
        <?php 
        $rendered = new Renderer();
        $rendered->renderRecursive($pages['items'], $pageModel->parent_id, Renderer::RENDER_OPTION_LIST);
        ?>
    </select>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'title'); ?><br/>
    <?php echo $form->textField($contentModel,'title', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($contentModel, 'title'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($pageModel, 'slug'); ?><br/>
    <?php echo $form->textField($pageModel,'slug', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($pageModel, 'slug'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'language'); ?><br/>
    <?php echo $form->dropDownList($contentModel,'language', $this->languages, array('class' => 'styled small')); ?>
</p>
<p>
    <?php echo $form->labelEx($pageModel, 'sort'); ?><br/>
    <?php echo $form->textField($pageModel,'sort', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($pageModel, 'sort'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($pageModel, 'active', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($pageModel, 'active'); ?>
    <span class="note error"><?php echo $form->error($pageModel, 'active'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($pageModel, 'multipage', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($pageModel, 'multipage'); ?>
    <span class="note error"><?php echo $form->error($pageModel, 'multipage'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($pageModel, 'plugin'); ?><br/>
    <?php echo $form->dropDownList($pageModel, 'plugin', $plugins, array('class' => 'styled')); ?>
    <span class="note error"><?php echo $form->error($pageModel, 'plugin'); ?></span>
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
    <?php echo $form->labelEx($contentModel, 'background'); ?><br/>
    <?php echo $form->fileField($contentModel,'background', array('class' => 'file', 'id' => 'fileupload')); ?>
    <span id="uploadmsg">Max size 3Mb</span>
</p>
<hr/>
<div id="tempAttachments"></div>
<p>
    <?php echo CHtml::submitButton($pageModel->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>