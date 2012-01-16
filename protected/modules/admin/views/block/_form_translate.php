<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'block-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary(array($model, $contentModel)); 
?>
<p>
    <?php echo $form->labelEx($contentModel, 'title'); ?><br/>
    <?php echo $form->textField($contentModel,'title', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($contentModel, 'title'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($contentModel, 'language'); ?><br/>
    <?php echo $form->dropDownList($contentModel,'language', $this->languages, array('class' => 'styled small', 'disabled' => 'disabled')); ?>
</p>
<p>
    <?php echo $form->labelEx($model, 'sort'); ?><br/>
    <?php echo $form->textField($model,'sort', array('class' => 'text tiny', 'disabled' => 'disabled')); ?>
    <span class="note error"><?php echo $form->error($model, 'sort'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'active', array('class' => 'checkbox', 'disabled' => 'disabled')); ?>
    <?php echo $form->labelEx($model, 'active'); ?>
    <span class="note error"><?php echo $form->error($model, 'active'); ?></span>
</p>
<hr/>
<p>
    <?php echo $form->labelEx($contentModel, 'body'); ?><br/>
    <?php echo $form->textArea($contentModel,'body', array('class' => 'wysiwyg')); ?>
</p>
<hr/>
<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>