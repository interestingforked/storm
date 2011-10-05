<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change Password"),
);
?>

<h1><?php echo UserModule::t("Change password"); ?></h1>
<div class="hr-title"><hr></div>
<?php echo $this->renderPartial('menu'); ?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo CHtml::errorSummary($model); ?>

                <table class="update-profile" cellpadding="0" width="100%">
            <tr>
                <td>
        
            <dt><?php echo $form->labelEx($model,'password'); ?></dt>
		<dd><?php echo $form->passwordField($model,'password'); ?></dd>
            
            <dt><?php echo $form->labelEx($model,'verifyPassword'); ?></dt>
		<dd><?php echo $form->passwordField($model,'verifyPassword'); ?></dd>

        </td>
            </tr>
            <tr><td class="but-row">
                <?php echo CHtml::submitButton(UserModule::t("Save"),array('class'=>'button')); ?>
                </td></tr>
        </table>
        
<?php $this->endWidget(); ?>
</div><!-- form -->