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
    <p>Nr. <?php echo ($order->key) ? '<a href="#" rel="'.$order->key.'" class="showUserOrderInfo">'.$order->key.'</a>' : 0; ?>, <?php echo date('d.m.Y', strtotime($order->created)); ?> - 
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
    <div class="userOrderInfo" style="display:none;" id="orderInfo<?php echo $order->key; ?>">
    <p>Информация о заказе.</p>
    <div id="login-form">
        <form>
            <table id="cart" cellpadding="0">
                <thead>
                    <tr class="headers">
                        <th>Продукция</th>
                        <th>Цвет</th>
                        <th>Размер</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Стоимость</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order->items as $item): 
                        $product = Product::model()->findByPk($item->product_id);
                        $product->content = Content::model()->getModuleContent('product', $product->id);
                        $product->mainNode = ProductNode::model()->findByPk($item->product_node_id)
                        ?>
                    <tr>
                        <td><?php echo $product->content->title; ?></td>
                        <td><?php echo $this->classifier->getValue('color', $product->mainNode->color); ?></td>
                        <td><?php echo $this->classifier->getValue('color', $product->mainNode->size); ?></td>
                        <td><?php echo number_format($product->mainNode->price, 0,'.','').Yii::app()->params['currency']; ?></td>
                        <td><?php echo $item->quantity; ?></td>
                        <td><?php echo number_format($item->quantity * $product->mainNode->price, 0,'.','').Yii::app()->params['currency']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td style="padding-top:20px;">Стоимость товаров:</td>
                        <td colspan="4"></td>
                        <td style="padding-top:20px;"><?php echo number_format($order->total, 0,'.','').Yii::app()->params['currency']; ?></td>
                    </tr>
                    <tr>
                        <td>Доставка:</td>
                        <td colspan="4">
                            <?php 
                            switch ($order->shipping_method) {
                                case 1: echo Yii::t('app', 'Free shipping'); break;
                                case 2: echo Yii::t('app', 'Pony Express'); break;
                            }
                            ?>
                        </td>
                        <td><?php echo number_format($order->shipping, 0,'.','').Yii::app()->params['currency']; ?></td>
                    </tr>
                    <tr>
                        <td style="padding:20px 0;">Общая сумма заказа:</td>
                        <td colspan="4">&nbsp;</td>
                        <td style="padding:20px 0;border-top:solid 1px #ccc;"><?php echo number_format($order->total + $order->shipping, 0,'.','').Yii::app()->params['currency']; ?></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    </div>
<?php endforeach; ?>
</div>
<?php endif; ?>