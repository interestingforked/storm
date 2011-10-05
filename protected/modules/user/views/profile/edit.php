<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
?><h1><?php echo UserModule::t('Edit profile'); ?></h1>
<div class="hr-title"><hr></div>
<?php echo $this->renderPartial('menu'); ?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'profile-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>
    
    <?php echo $form->errorSummary(array($model,$profile)); ?>
    
        <table class="update-profile" cellpadding="0" width="100%">
            <tr>
                <td>
        
            <dt><?php echo $form->labelEx($model,'username'); ?></dt>
		<dd><?php echo $form->textField($model,'username',array('class'=>'field','maxlength'=>20)); ?></dd>
            
            <dt><?php echo $form->labelEx($model,'email'); ?></dt>
		<dd><?php echo $form->textField($model,'email',array('class'=>'field','maxlength'=>128)); ?></dd>
            
        
        </td><td>

            <?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
            <dt><?php echo $form->labelEx($profile,$field->varname); ?></dt><br/>
            <dd><?php
		if ($field->widgetEdit($profile)) {
			echo $field->widgetEdit($profile);
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range),array('class'=>'field'));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('class'=>'field','maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		?>
            </dd>
		<?php
			}
		}
                ?>
            </td>
            </tr>
            <tr><td colspan="2" class="but-row">
                <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'),array('class'=>'button')); ?>
                </td></tr>
        </table>      

<?php $this->endWidget(); ?>

</div><!-- form -->