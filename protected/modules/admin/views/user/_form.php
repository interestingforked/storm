<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
));
echo $form->errorSummary(array($model, $profile)); 
?>
<p>
    <?php echo $form->labelEx($model, 'email'); ?><br/>
    <?php echo $form->textField($model,'email', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($model, 'email'); ?></span>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <?php echo $form->checkBox($model, 'status', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($model, 'status'); ?>
    <span class="note error"><?php echo $form->error($model, 'status'); ?></span>
</p>
<hr/>
<p>
    <?php echo $form->labelEx($profile, 'firstname'); ?><br/>
    <?php echo $form->textField($profile,'firstname', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($profile, 'firstname'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($profile, 'lastname'); ?><br/>
    <?php echo $form->textField($profile,'lastname', array('class' => 'text medium')); ?>
    <span class="note error"><?php echo $form->error($profile, 'lastname'); ?></span>
</p>
<p>
    <?php echo $form->labelEx($profile, 'sex'); ?><br/>
    <?php echo $form->dropDownList($profile, 'sex', Profile::range($rangeSex), array('class' => 'styled')); ?>
</p>
<p>
    <?php echo $form->labelEx($profile, 'age'); ?><br/>
    <?php echo $form->dropDownList($profile, 'age', Profile::range($rangeAge), array('class' => 'styled')); ?>
</p>
<p>
    <?php echo $form->checkBox($profile, 'newsletters', array('class' => 'checkbox')); ?>
    <?php echo $form->labelEx($profile, 'newsletters'); ?>
    <span class="note error"><?php echo $form->error($profile, 'newsletters'); ?></span>
</p>
<hr/>
<div id="tempAttachments"></div>
<p>
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submit', 'class' => 'submit small')); ?>
</p>
<?php $this->endWidget(); ?>