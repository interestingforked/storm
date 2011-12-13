<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'product-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary(array($model, $contentModel)); 
?>
<p>
    <?php echo Chtml::label('Categories','Categories_1'); ?>
</p>
<p>
    <span style="display:block;float:left;width:300px;">
        <?php 
        echo Chtml::listBox('Categories[]', null, $categories,
                array('id' => 'categories', 'size' => 6, 'style' => 'width:300px;', 'multiple' => 'multiple')); 
        ?>
    </span>
    <span style="display:block;float:left;width:100px;text-align:center;padding-top:30px;">
    &nbsp;<?php echo Chtml::button('     >>     ', array('name' => 'categories2selected_categories', 'class' => 'select_buttons')); ?>
    <br/>
    <?php echo Chtml::button('     <<     ', array('name' => 'selected_categories2categories', 'class' => 'select_buttons')); ?>
    </span>
    <span style="display:block;float:left;width:300px;">
        <?php
        echo Chtml::listBox('SelectedCategories[]', null, $activeCategories,
                array('id' => 'selected_categories', 'size' => 6, 'style' => 'width:300px;', 'multiple' => 'multiple')); 
        ?>
    </span>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'title'); ?><br/>
    <?php echo $form->textField($contentModel,'title', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($contentModel, 'title'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'slug'); ?><br/>
    <?php echo $form->textField($model,'slug', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($model, 'slug'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'language'); ?><br/>
    <?php echo $form->dropDownList($contentModel,'language', $this->languages, array('class' => 'styled small')); ?>
</p>
<p>
    <?php echo $form->labelEx($model, 'sort'); ?><br/>
    <?php echo $form->textField($model,'sort', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($model, 'sort'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'active', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'active'); ?>
    <span class="note error"><?php echo $form->error($model, 'active'); ?></span>
</p>
<hr/>
<p>
    <?php echo $form->labelEx($contentModel, 'additional'); ?><label>: Product specification</label><br/>
    <?php echo $form->textArea($contentModel,'additional', array('class' => 'text medium')); ?>
</p>
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
<hr/>
<div id="tempAttachments"></div>
<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>