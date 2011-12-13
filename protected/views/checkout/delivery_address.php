<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Delivery Address');
?>

<script type="text/javascript">
var paymentData = {
    name: '<?php echo $paymentData->name ?>',
    surname: '<?php echo $paymentData->surname ?>',
    phone: '<?php echo $paymentData->phone ?>',
    email: '<?php echo $paymentData->email ?>',
    house: '<?php echo $paymentData->house ?>',
    flat: '<?php echo $paymentData->flat ?>',
    street: '<?php echo $paymentData->street ?>',
    city: '<?php echo $paymentData->city ?>',
    district: '<?php echo $paymentData->district ?>',
    postcode: '<?php echo $paymentData->postcode ?>',
    district_id: '<?php echo $paymentData->district_id ?>',
    point_id: '<?php echo $paymentData->point_id ?>',
    country_id: '<?php echo $paymentData->country_id ?>'
}
var formFields = ['name','surname','phone','email','house','street','city','postcode','country_id'];
var previousCity = {
    city: null,
    point_id: null
}
$(document).ready(function () {
    $('#payment_data').click(function () {
        $('#name').val(paymentData.name);
        $('#surname').val(paymentData.surname);
        $('#phone').val(paymentData.phone);
        $('#email').val(paymentData.email);
        $('#house').val(paymentData.house);
        $('#flat').val(paymentData.flat);
        $('#street').val(paymentData.street);
        $('#city').val(paymentData.city);
        $('#district').val(paymentData.district);
        $('#postcode').val(paymentData.postcode);
        $('#country_id').val(paymentData.country_id);
        $('#district_id').val(paymentData.district_id);
        $('#point_id').val(paymentData.point_id);
        $('#country_id').val(paymentData.country_id);
    });
    $('#submit_button').click(function (e) {
        var $formId = $(this).parents('form');
        var cityValue = $('#city').val();
        $(formFields).each(function(index) {
            if ($('#' + formFields[index]).val() == '' || $('#' + formFields[index]).val() == 0) {
                $('#' + formFields[index]).css('border-color','#cc0000');
                accepted = false;
            }
        });
        if ($('#point_id').val() == 0) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('/service/point'); ?>?dontShowFull=true&term=' + encodeURI(cityValue), 
                cache: false,
                contentType: 'application/x-www-form-urlencoded;charset=utf-8',
                dataType: 'json',
                success: function (data) {
                    var pointId = $('#point_id').val();
                    var accepted = true;
                    if ((data == null || data == '') && pointId == 0) {
                        alert('<?php echo Yii::t('app', 'Город который Вы ввели не найден.'); ?>');
                        accepted = false;
                    }
                    if ((data.length > 1) && pointId == 0) {
                        alert('<?php echo Yii::t('app', 'Найдено несколько городов с похожим названием. Воспользуйтесь функцией подсказки.'); ?>');
                        accepted = false;
                    }
                    if ((data.length == 1) && pointId == 0) {
                        $('#point_id').val(data[0].id);
                    }
                    if (data == null && pointId == 0) {
                        if (previousCity.city != null && previousCity.point_id != null) {
                            $('#city').val(previousCity.city);
                            $('#point_id').val(previousCity.point_id);
                        }
                    }
                    if (accepted) {
                        $formId.submit();
                    } else {
                        alert('<?php echo Yii::t('app', 'Пожалуйста заполните все обязательные поля.'); ?>');
                    }
                }
            });
        } else {
            $formId.submit();
        }
        e.preventDefault();
    });
    $('#country_id').change(function () {
        $.get('<?php echo Yii::app()->createUrl('/service/country'); ?>?country_id=' + this.value);
    });
    $('#city').keypress(function () {
        previousCity.city = $('#city').val();
        previousCity.point_id = $('#point_id').val();
        $('#point_id').val(0);
    });
});
</script>

<p class="order-step"><?php echo Yii::t('app', 'Step'); ?>:
    <?php echo Chtml::link(1, array('/checkout')); ?>
    <b>2</b> 3 4 5
</p>
<h1><?php echo Yii::t('app', 'Delivery Address'); ?></h1>
<div class="hr-title"><hr/></div>

<p><?php echo Yii::t('app', 'Пожалуйста введите адрес доставки товара.'); ?></p>
<p><span class="nec">*</span> - <?php echo Yii::t('app', 'обязательные поля'); ?></p>

<?php if ($messages): ?>
<?php endif; ?>
    
<div id="login-form">
    
    <p><?php 
    echo CHtml::checkBox('payment_data'); 
    echo CHtml::label(Yii::t('app', 'Адрес доставки совпадает с платёжным адресом'), 'payment_data'); 
    ?></p>
    
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
    
    <dt><?php echo CHtml::label(Yii::t('app', 'House number').' <span class="nec">*</span>', 'house'); ?></dt>
    <dd><?php echo CHtml::textField('house', $data->house, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Flat number'), 'flat'); ?></dt>
    <dd><?php echo CHtml::textField('flat', $data->flat, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Street').' <span class="nec">*</span>', 'street'); ?></dt>
    <dd><?php echo CHtml::textField('street', $data->street, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'City').' <span class="nec">*</span>', 'city'); ?></dt>
    <dd>
    <?php 
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'name' => 'city',
        'value' => $data->city,
        'source' => Yii::app()->createUrl('/service/point'),
        'options' => array(
            'minLength' => '2',
            'showAnim' => 'fold',
            'select' => 'js: function(event, ui) {
                this.value = ui.item.label;
                $("#point_id").val(ui.item.id);
                return false;
            }',
        ),
        'htmlOptions' => array(
            'maxlength' => 50,
            'class' => 'field'
        ),
    )); 
    echo CHtml::hiddenField('point_id', $data->point_id); 
    ?>
    </dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'District'), 'district'); ?></dt>
    <dd>
    <?php 
    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
        'name' => 'district',
        'value' => $data->district,
        'source' => Yii::app()->createUrl('/service/district'),
        'options' => array(
            'minLength' => '2',
            'showAnim' => 'fold',
            'select' => 'js: function(event, ui) {
                this.value = ui.item.label;
                $("#district_id").val(ui.item.id);
                return false;
            }',
        ),
        'htmlOptions' => array(
            'maxlength' => 50,
            'class' => 'field'
        ),
    )); 
    echo CHtml::hiddenField('district_id', $data->district_id); 
    ?>
    </dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Postcode').' <span class="nec">*</span>', 'postcode'); ?></dt>
    <dd><?php echo CHtml::textField('postcode', $data->postcode, array('class' => 'field')); ?></dd>

    <dt><?php echo CHtml::label(Yii::t('app', 'Country').' <span class="nec">*</span>', 'country_id'); ?></dt>
    <dd><?php echo CHtml::dropDownList('country_id', $data->country_id, $countries, array('class' => 'field')); ?></dd>
    
    <dt><?php echo CHtml::label(Yii::t('app', 'Notes'), 'notes'); ?></dt>
    <dd><?php echo CHtml::textArea('notes', $data->notes, array('class' => 'field')); ?></dd>
    
    <div class="checkout-btns">
        <?php echo CHtml::button(Yii::t('app', 'Back'), array(
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);',
            'onclick' => "location.href='".CHtml::normalizeUrl(array('/checkout'))."'",
        )); ?>
        <?php echo CHtml::submitButton(Yii::t('app', 'Continue'), array(
            'id' => 'submit_button',
            'class' => 'button',
            'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
            'onmouseover' => "this.style.backgroundColor='#343434'",
            'style' => 'background-color: rgb(31, 31, 31);',
        )); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>