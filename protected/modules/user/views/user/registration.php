<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<h1><?php echo UserModule::t("Registration"); ?></h1>
<div class="hr-title"><hr></div>
<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<p><?php echo UserModule::t("Процесс регистрации не займет у Вас много времени, 
    и позволит Вам просматривать историю своих заказов и платежей. 
    Зарегистрировавшись, Вы также получите возможность получать ежемесячно информацию о наших новинках, 
    акциях и конкурсах."); ?></p>
<p><?php echo UserModule::t("Пожалуйста, заполните следующую форму и нажмите \"Зарегестрироваться\"."); ?></p>
<p><span class="nec">*</span> - <?php echo UserModule::t("обязательные поля"); ?></p>

<div id="login-form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <?php echo $form->errorSummary(array($model,$profile)); ?>

    <?php
    $profileFields = $profile->getFields();
    $sexRange = array();
    if ($profileFields) {
        foreach ($profileFields as $field) {
            if ($field->varname == 'newsletters') {
                continue;
            }
            if ($field->varname == 'sex') {
                $sexRange = Profile::range($field->range);
                continue;
            }
            ?>
            <dt><?php echo $form->labelEx($profile, $field->varname); ?></dt>
            <dd><?php
                if ($field->widgetEdit($profile)) {
                    echo $field->widgetEdit($profile);
                } elseif ($field->range) {
                    echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                } elseif ($field->field_type == "TEXT") {
                    echo$form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50));
                } else {
                    echo $form->textField($profile, $field->varname, array('class' => 'field', 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                }
                ?>
            </dd>
            <?php
        }
    }

    ?>
            
    <dt><?php echo $form->labelEx($profile,'sex'); ?></dt>
    <dd><?php echo $form->radioButtonList($profile,'sex',$sexRange,array('separator'=>' &nbsp; &nbsp; ')); ?></dd>

    <dt><?php echo $form->labelEx($model,'email'); ?></dt>
    <dd><?php echo $form->textField($model,'email', array('class' => 'field')); ?></dd>
    
    <dt><?php echo $form->labelEx($model,'password'); ?></dt>
    <dd><?php echo $form->passwordField($model,'password', array('class' => 'field')); ?></dd>

    <dt><?php echo $form->labelEx($model,'verifyPassword'); ?></dt>
    <dd><?php echo $form->passwordField($model,'verifyPassword', array('class' => 'field')); ?></dd>

    <?php if (UserModule::doCaptcha('registration')): ?>
    <dt><?php echo $form->labelEx($model,'verifyCode'); ?></dt>
    <dd>
        <?php $this->widget('CCaptcha'); ?>
        <?php echo $form->textField($model,'verifyCode', array('class' => 'field')); ?>
        <p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
        <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
    </dd>
    <?php endif; ?>
    
    <dt><?php echo $form->labelEx($profile,'newsletters'); ?></dt>
    <dd><?php echo $form->checkBox($profile,'newsletters',array('checked' => 'checked')); ?></dd>
	
    <dt>&nbsp;</dt>
    <dd><?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'button')); ?></dd>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>