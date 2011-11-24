<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login"); ?>

<h1><?php echo $title; ?></h1>
<div class="hr-title"><hr></div>
<div class="form">
<?php echo $content; ?>

</div>

<?php if (isset($loginModule)): ?>
<br/>
<p><?php echo UserModule::t("Пожалуйста введите ваш адрес эл.почты и пароль."); ?></p>
<div id="login-form">
<?php echo CHtml::beginForm(array('/user/login')); ?>
    <dt><?php echo CHtml::activeLabelEx($loginModule,'username'); ?></dt>
    <dd><?php echo CHtml::activeTextField($loginModule,'username',array('class'=>'field')) ?></dd>
    <dt><?php echo CHtml::activeLabelEx($loginModule,'password'); ?></dt>
    <dd><?php echo CHtml::activePasswordField($loginModule,'password',array('class'=>'field')) ?></dd>
<div><br>
<?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'button')); ?>
<?php echo CHtml::button(UserModule::t("Забытый пароль?"), array('class' => 'button', 'onclick' => "location='/".Yii::app()->language.Yii::app()->getModule('user')->recoveryUrl[0]."'")); ?>
<?php echo CHtml::button(UserModule::t("Зарегистрироваться"), array('class' => 'button', 'onclick' => "location='/".Yii::app()->language.Yii::app()->getModule('user')->registrationUrl[0]."'")); ?>
</div>
<?php echo CHtml::endForm(); ?>
</div>
<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),
    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $loginModule);
?>
<?php endif; ?>
