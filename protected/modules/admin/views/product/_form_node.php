<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'product-node-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary($model); 
?>
<p>
    <?php echo $form->labelEx($model, 'sort'); ?><br/>
    <?php echo $form->textField($model,'sort', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($model, 'sort'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'active', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'active'); ?>
    <span class="note error"><?php echo $form->error($model, 'active'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'price'); ?><br/>
    <?php echo $form->textField($model,'price', array('class' => 'text tiny')); ?>
</p>
<p>
    <?php echo $form->labelEx($model, 'old_price'); ?><br/>
    <?php echo $form->textField($model,'old_price', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($model, 'old_price'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'quantity'); ?><br/>
    <?php echo $form->textField($model,'quantity', array('class' => 'text tiny')); ?>
    <span class="note error"><?php echo $form->error($model, 'quantity'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'code'); ?><br/>
    <?php echo $form->textField($model,'code', array('class' => 'text small')); ?>
    <span class="note error"><?php echo $form->error($model, 'code'); ?></span>
</p>
<hr/>
<p>
    <?php echo $form->checkBox($model, 'new', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'new'); ?>
    <span class="note error"><?php echo $form->error($model, 'new'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'sale', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'sale'); ?>
    <span class="note error"><?php echo $form->error($model, 'sale'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'preorder', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'preorder'); ?>
    <span class="note error"><?php echo $form->error($model, 'preorder'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'notify', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'notify'); ?>
    <span class="note error"><?php echo $form->error($model, 'notify'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'never_runs_out', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'never_runs_out'); ?>
    <span class="note error"><?php echo $form->error($model, 'never_runs_out'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($model, 'color'); ?><br/>
    <?php echo $form->dropDownList($model, 'color', CHtml::listData($colors, 'key', 'value'), array('class' => 'styled')); ?>
</p>
<p>
    <?php echo $form->labelEx($model, 'size'); ?><br/>
    <?php echo $form->dropDownList($model, 'size', CHtml::listData($sizes, 'key', 'value'), array('class' => 'styled')); ?>
</p>
<hr/>
<div id="tempAttachments"></div>
<div id="selectedAttachments"></div>
<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>