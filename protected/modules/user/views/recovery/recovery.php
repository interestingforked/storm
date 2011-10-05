<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<h1><?php echo UserModule::t("Restore"); ?></h1>
<div class="hr-title"><hr></div>
<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>
<p><?php echo UserModule::t("Пожалуйста введите адрес Вашей эл.почты."); ?></p>
<div id="login-form">
<?php echo CHtml::beginForm(); ?>
    
    <?php echo CHtml::errorSummary($form); ?>
    
    <dt><?php echo CHtml::activeLabel($form,'login_or_email'); ?></dt>
    <dd><?php echo CHtml::activeTextField($form,'login_or_email', array('class' => 'field')); ?></dd>
    <dt>&nbsp;</dt>
    <dd><?php echo CHtml::submitButton(UserModule::t("Restore"), array('class' => 'button')); ?></dd>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>