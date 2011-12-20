<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'newsletter-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary($model); 
?>
<p>
    <?php echo $form->labelEx($model, 'subject'); ?><br/>
    <?php echo $form->textField($model,'subject', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($model, 'subject'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'message'); ?><br/>
    <?php echo $form->textArea($model,'message', array('class' => 'wysiwyg')); ?>
</p>
<hr/>
<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>