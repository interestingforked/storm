<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Change password"),
);
?>

<h1><?php echo UserModule::t("Change password"); ?></h1>
<div class="hr-title"><hr></div>

Вы запросили смену пароля для своей учетной записи на сайте StormLondon.ru.
Пожалуйста введите новый пароль и войдите с ним в свою учетную запись.

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>

                <table class="update-profile" cellpadding="0" width="100%">
            <tr>
                <td>
        
            <dt><?php echo CHtml::activeLabelEx($form,'password'); ?></dt>
		<dd><?php echo CHtml::activePasswordField($form,'password'); ?></dd>
            
            <dt><?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?></dt>
		<dd><?php echo CHtml::activePasswordField($form,'verifyPassword'); ?></dd>

        </td>
            </tr>
            <tr><td class="but-row">
                <?php echo CHtml::submitButton(UserModule::t("Save"),array('class'=>'button')); ?>
                </td></tr>
        </table>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->