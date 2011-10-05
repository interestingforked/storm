<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Your data');
?>

<script type="text/javascript">
var formFields = ['name','surname','phone','email','house','street','city','district','postcode','country_id'];
$(document).ready(function () {
    $('#formdata').submit(function () {
        var accepted = true;
        $(formFields).each(function(index) {
            if ($('#' + formFields[index]).val() == '') {
                $('#' + formFields[index]).css('border-color','#cc0000');
                accepted = false;
            }
        });
        if ( ! accepted) {
            alert('<?php echo Yii::t('app', 'Fill all required fields please!'); ?>');
        }
        return accepted;
    });
});
</script>

<p class="order-step"><?php echo Yii::t('app', 'Step'); ?>:<b>1</b> 2 3 4 5</p>
<h1><?php echo Yii::t('app', 'Your data'); ?></h1>
<div class="hr-title"><hr/></div>

<p><?php echo Yii::t('app', 'Пожалуйста введите адрес плательщика.'); ?></p>
<p><span class="nec">*</span> - <?php echo Yii::t('app', 'обязательные поля'); ?></p>

<?php if ($messages): ?>
<?php endif; ?>

<div id="login-form">
    <?php echo CHtml::beginForm('', 'post', array('id' => 'formdata')); ?>
    <dt><?php echo CHtml::label(Yii::t('app', 'Name').' <span class="nec">*</span>', 'name'); ?></dt>
    <dd><?php echo CHtml::textField('name', $data->name, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Surname').' <span class="nec">*</span>', 'surname'); ?></dt>
    <dd><?php echo CHtml::textField('surname', $data->surname, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Phone').' <span class="nec">*</span>', 'phone'); ?></dt>
    <dd><?php echo CHtml::textField('phone', $data->phone, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'E-mail').' <span class="nec">*</span>', 'email'); ?></dt>
    <dd><?php echo CHtml::textField('email', $data->email, array('class' => 'field')); ?></dd>
    
    <br/>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'House/flat number').' <span class="nec">*</span>', 'house'); ?></dt>
    <dd><?php echo CHtml::textField('house', $data->house, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Street').' <span class="nec">*</span>', 'street'); ?></dt>
    <dd><?php echo CHtml::textField('street', $data->street, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'City').' <span class="nec">*</span>', 'city'); ?></dt>
    <dd><?php echo CHtml::textField('city', $data->city, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'District').' <span class="nec">*</span>', 'district'); ?></dt>
    <dd><?php echo CHtml::textField('district', $data->district, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Postcode').' <span class="nec">*</span>', 'postcode'); ?></dt>
    <dd><?php echo CHtml::textField('postcode', $data->postcode, array('class' => 'field')); ?></dd>

    <dt><?php echo CHtml::label(Yii::t('app', 'Country').' <span class="nec">*</span>', 'country_id'); ?></dt>
    <dd><?php echo CHtml::dropDownList('country_id', $data->country_id, $countries, array('class' => 'field')); ?></dd>

    <div class="checkout-btns">
        <?php echo CHtml::button(Yii::t('app', 'Back'), array(
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);',
            'onclick' => "location.href='".CHtml::normalizeUrl(array('/cart'))."'",
        )); ?>
        <?php echo CHtml::submitButton(Yii::t('app', 'Continue'), array(
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);',
        )); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>