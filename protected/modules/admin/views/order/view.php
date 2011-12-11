<div class="block withsidebar">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Order nr: <?php echo $order->key; ?></h2>
        <ul class="tabs">
            <li><a href="/admin/order">Go to order list</a></li>
        </ul>
    </div>
    <div class="block_content">
        <div class="sidebar">
            <ul class="sidemenu">
                <li><a href="#sb1">Order info</a></li>
                <li><a href="#sb2">Order details</a></li>
                <li><a href="#sb3">Order items</a></li>
            </ul>
        </div>
        <div class="sidebar_content" id="sb1">
            <ul class="list">
                <li><strong>Number</strong>: <?php echo $order->key; ?></li>
                <li><strong>Cart ID</strong>: <?php echo $order->cart_id; ?></li>
                <li><strong>User</strong>: <?php echo $userProfile->firstname.' '.$userProfile->lastname; ?></li>
                <li><strong>Coupon</strong>: <?php echo $order->coupon_id; ?></li>
                <li><strong>E-mail sent</strong>: <?php echo ($order->sent ? 'Yes' : 'No'); ?></li>
                <li><strong>RBK payment ID</strong>: <?php echo $order->rbk_payment_id; ?></li>
                <li><strong>Status</strong>: 
                <?php switch ($order->status) {
                    case 1: echo 'New order'; break;
                    case 2: echo 'Waiting for payment'; break;
                    case 3: echo 'Completed'; break;
                } ?></li>
                <li><strong>Payment method</strong>: 
                <?php switch ($order->payment_method) {
                    case 1: echo 'Оплата курьеру при получении'; break;
                    case 2: echo 'On-line оплата'; break;
                    case 3: echo 'Банковский перевод'; break;
                } ?></li>
                <li><strong>Shipping method</strong>: <?php echo Yii::t('vars', 'shipping'.$order->shipping_method); ?></li>
                <li><strong>Preorder</strong>: <?php echo ($order->preorder ? 'Yes' : 'No'); ?></li>
                <li><strong>Item quantity</strong>: <?php echo $order->quantity; ?></li>
                <li><strong>Total sum</strong>: <?php echo $order->total; ?></li>
                <li><strong>Shipping sum</strong>: <?php echo $order->shipping; ?></li>
                <li><strong>Discount</strong>: <?php echo $order->discount; ?></li>
                <li><strong>IP address</strong>: <?php echo $order->ip; ?></li>
                <li><strong>Comment</strong>: <?php echo $order->comment; ?></li>
            </ul>
        </div>
        <div class="sidebar_content" id="sb2">
            <div style="width:45%;float:left;">
            <h3>Payment details</h3>
            <ul class="list">
                <li><strong>Name</strong>: <?php echo $paymentDetails->name; ?></li>
                <li><strong>Surname</strong>: <?php echo $paymentDetails->surname; ?></li>
                <li><strong>Phone</strong>: <?php echo $paymentDetails->phone; ?></li>
                <li><strong>E-mail</strong>: <?php echo $paymentDetails->email; ?></li>
                <li><strong>District</strong>: <?php echo $paymentDetails->district; ?></li>
                <li><strong>Country</strong>: <?php echo Country::model()->getCountryName($paymentDetails->country_id); ?></li>
                <li><strong>City</strong>: <?php echo $paymentDetails->city; ?></li>
                <li><strong>Street</strong>: <?php echo $paymentDetails->street; ?></li>
                <li><strong>House</strong>: <?php echo $paymentDetails->house; ?></li>
                <li><strong>Flat</strong>: <?php echo $paymentDetails->flat; ?></li>
                <li><strong>Postcode</strong>: <?php echo $paymentDetails->postcode; ?></li>
            </ul>
            </div>
            <div style="width:45%;float:left;">
            <h3>Shipping details</h3>
            <ul class="list">
                <li><strong>Name</strong>: <?php echo $shippingDetails->name; ?></li>
                <li><strong>Surname</strong>: <?php echo $shippingDetails->surname; ?></li>
                <li><strong>Phone</strong>: <?php echo $shippingDetails->phone; ?></li>
                <li><strong>E-mail</strong>: <?php echo $shippingDetails->email; ?></li>
                <li><strong>District</strong>: <?php echo $shippingDetails->district; ?></li>
                <li><strong>Country</strong>: <?php echo Country::model()->getCountryName($shippingDetails->country_id); ?></li>
                <li><strong>City</strong>: <?php echo $shippingDetails->city; ?></li>
                <li><strong>Street</strong>: <?php echo $shippingDetails->street; ?></li>
                <li><strong>House</strong>: <?php echo $shippingDetails->house; ?></li>
                <li><strong>Flat</strong>: <?php echo $shippingDetails->flat; ?></li>
                <li><strong>Postcode</strong>: <?php echo $shippingDetails->postcode; ?></li>
            </ul>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div class="sidebar_content" id="sb3">
            <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Date created</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach ($orderItems AS $item):
                    $product = $products['item_'.$item->id];
                    $attachedImage = Attachment::model()->getAttachment('productNode', $product->mainNode->id);
                    ?>
                    <tr>
                        <td><?php echo CHtml::image(Image::thumb(Yii::app()->params['images'].$attachedImage->image, 60));; ?></td>
                        <td><?php echo CHtml::link($product->content->title, array('/product/'.$product->slug.'-'.$product->id), array('target' => '_blank')); ?></td>
                        <td><?php echo $item->quantity; ?></td>
                        <td><?php echo $item->price; ?></td>
                        <td><?php echo $item->subtotal; ?></td>
                        <td><?php echo $item->created; ?></td>
                        <td class="delete">
                            <?php echo CHtml::link('View', array('/admin/product/edit/'.$item->product_id)); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
       </div>
    </div>
    <div class="bendl"></div>
    <div class="bendr"></div>
</div>