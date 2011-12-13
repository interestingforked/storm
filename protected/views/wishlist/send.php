<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Wishlist');
?>

<h1><?php echo Yii::t('app', 'Wishlist'); ?></h1>
<div class="hr-title"><hr/></div>

<?php if (count($items) == 0): ?>
<p><?php echo Yii::t('app', 'Wishlist is empty'); ?></p>
<?php else: ?>
    <?php 
    if ($message) {
        echo '<h4>'.$message.'</h4>';
    }
    ?>
    <?php echo CHtml::beginForm(array('/wishlist/send')); ?>
        <table>
            <tr>
                <td style="width:50%;">
                    <label><?php echo Yii::t('app', 'Введите адреса эл. почты, один в строчку'); ?>:</label>
                    <textarea style="width:85%;height:10em;" name="emails"></textarea>
                </td>
                <td style="width:50%">
                    <label><?php echo Yii::t('app', 'Ваше сообщение'); ?>:</label>
                    <textarea style="width:100%;height:10em;" name="message"></textarea>
                </td>
            </tr>
            <tr>
                <td><span style="font-size:85%;"><?php echo Yii::t('app', 'STORM использует данный адрес эл.почты лишь для отсылки вашего списка предпочтений'); ?></span></td>
                <td></td>
            </tr>
        </table>
        <div class="send-wish">
            <?php 
            echo CHtml::submitButton(Yii::t('app', 'Отправить список предпочтений'), array(
                'class' => 'button',
                'onmouseout' => "this.style.backgroundColor='#1F1F1F'",
                'onmouseover' => "this.style.backgroundColor='#343434'",
                'style' => 'background-color: rgb(31, 31, 31);margin:0 0 10px;',
            ));
            ?>
        </div>
    <?php echo CHtml::endForm(); ?>
<?php endif; ?>