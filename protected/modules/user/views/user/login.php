<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<h1><?php echo UserModule::t("Login"); ?></h1>
<div class="hr-title"><hr></div>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php endif; ?>

<p><?php echo UserModule::t("Уважаемый покупатель"); ?><br/>
   <?php echo UserModule::t("если вы впервые делаете покупку на нашем сайте, вам нужно сначала зарегестрироваться."); ?></p>
<p><?php echo UserModule::t("Зарегистрированные пользователи,<br/>пожалуйста введите ваш адрес эл.почты и пароль."); ?></p>

<div id="login-form">
<?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($model); ?>
    <dt><?php echo CHtml::activeLabelEx($model,'username'); ?></dt>
    <dd><?php echo CHtml::activeTextField($model,'username',array('class'=>'field')) ?></dd>
    <dt><?php echo CHtml::activeLabelEx($model,'password'); ?></dt>
    <dd><?php echo CHtml::activePasswordField($model,'password',array('class'=>'field')) ?></dd>
    <!--
    <dt>&nbsp;</dt>
    <dd><?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
	<?php echo CHtml::activeLabelEx($model,'rememberMe'); ?></dd>
    -->
<div><br>
<?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'button')); ?>
<?php echo CHtml::button(UserModule::t("Забытый пароль?"), array('class' => 'button', 'onclick' => "location='/".Yii::app()->language.Yii::app()->getModule('user')->recoveryUrl[0]."'")); ?>
<?php echo CHtml::button(UserModule::t("Зарегистрироваться"), array('class' => 'button', 'onclick' => "location='/".Yii::app()->language.Yii::app()->getModule('user')->registrationUrl[0]."'")); ?>
</div>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->


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
), $model);
?>