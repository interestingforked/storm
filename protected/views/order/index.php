<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'My orders');
?>

<h1><?php echo Yii::t('app', 'My orders'); ?></h1>
<div class="hr-title"><hr/></div>
<?php if (!$orders OR count($orders) == 0): ?>
<p><?php echo Yii::t('app', 'You don\'t have any orders yet.'); ?></p>
<?php else: ?>
<div class="orders">
<?php foreach ($orders AS $order): ?>
    <p>Nr. <?php echo ($order->key) ? $order->key : 0; ?>, <?php echo date('d.m.Y', strtotime($order->created)); ?> - 
        <?php  
        switch ($order->status) {
            case 1: echo Yii::t('app', 'New order'); break;
            case 2: echo Yii::t('app', 'Waiting for payment'); break;
            case 3: echo Yii::t('app', 'Payed'); break;
        }
        if ($order->status == 2):
            echo ' - ';
            echo CHtml::link(Yii::t('app', 'Pay through RBK').' &rarr;', array('/checkout/sendpayment/'.$order->id));
        endif;
        ?>
    </p>
<?php endforeach; ?>
</div>
<?php endif; ?>

