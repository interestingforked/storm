<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'coupon-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary($model); 
?>
<p>
    <?php echo $form->labelEx($model, 'code'); ?><br/>
    <?php echo $form->textField($model,'code', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($model, 'code'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'issue_date'); ?>
    <?php echo $form->textField($model, 'issue_date', array('class' => 'text date_picker')); ?>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->labelEx($model, 'term_date'); ?>
    <?php echo $form->textField($model, 'term_date', array('class' => 'text date_picker')); ?>
</p>
<p>
    <?php echo $form->labelEx($model, 'value'); ?><br/>
    <?php echo $form->textField($model,'value', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($model, 'value'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'percentage', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'percentage'); ?>
    <span class="note error"><?php echo $form->error($model, 'percentage'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'free_delivery', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'free_delivery'); ?>
    <span class="note error"><?php echo $form->error($model, 'free_delivery'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'not_for_sale', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'not_for_sale'); ?>
    <span class="note error"><?php echo $form->error($model, 'not_for_sale'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'only_rbk', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'only_rbk'); ?>
    <span class="note error"><?php echo $form->error($model, 'only_rbk'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'max_count'); ?><br/>
    <?php echo $form->textField($model,'max_count', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($model, 'max_count'); ?></span>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'once', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'once'); ?>
    <span class="note error"><?php echo $form->error($model, 'once'); ?></span>
</p>
<hr/>
<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>