<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <table align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td style="background-color: rgb(255, 255, 255);" valign="top">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="550">
                            <tbody>
                                <tr>
                                    <td bgcolor="#000000" height="98"><a target="_blank" shape="rect" href="<?php echo Yii::app()->getBaseUrl(true); ?>"><img alt="STORM London" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/email-logo.gif" border="0" height="98" width="164"></a></td>
                                </tr>
                                <tr>
                                    <td style="background-color: rgb(255, 255, 255);" height="28"><img alt="" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/spacer.gif" height="28" width="550"></td>
                                </tr>
                                <tr>
                                    <td style="background-color: rgb(255, 255, 255);" align="center">
                                        <table style="border-width: 1px; border-style: solid; border-color: rgb(225, 225, 225);" align="center" cellpadding="9" cellspacing="0" width="497">
                                            <tbody>
                                                <tr>
                                                    <td style="background-color: rgb(255, 255, 255);">
                                                        <h2 style="margin-top: 20px; font: 15px/15px arial,sans-serif;">Уважаемый администратор заказов StormLondon.ru!</h2>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;">Поступил новый заказ с сайта. Ниже смотри информацию о заказе..</p>
                                                        <h3 style="padding-bottom: 6px; margin-top: 10px; padding-left: 2px; padding-right: 2px; font: 16px/16px arial,sans-serif; margin-bottom: 10px; background: #f1f1f1; padding-top: 6px;"><strong>Данные заказа</strong></h3>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Код заказа:</strong> <strong><?php echo $order->key; ?></strong></p>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Вид платежа:</strong> <strong><?php echo ($order->payment_method == 2) ? 'Предоплата' : 'Оплата курьеру при получении'; ?></strong></p>
                                                        <?php if ($order->payment_method == 2 AND $order->status == 3): ?>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>ID транзакции РБК:</strong> <?php echo $order->rbk_payment_id; ?></p>
                                                        <?php endif; ?>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Статус заказа:</strong> <?php echo Order::model()->orderStatus($order); ?></p>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Email:</strong> <?php echo $user->email; ?></p>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Сумма заказа:</strong> <?php echo ($order->total + $order->shipping); ?> руб. (Включая доставку <?php echo $order->shipping; ?> Руб.)</p>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Способ доставки:</strong> <?php echo Yii::t('vars', 'shipping'.$order->shipping_method); ?></p>
                                                        <br>
                                                        <table style="margin-bottom: 20px;" cellpadding="0" cellspacing="0" width="497">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="248">
                                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Адрес счета:</strong><br>
                                                                            <?php echo $payment->name.' '.$payment->surname; ?><br>
                                                                            <?php echo $payment->phone; ?><br/>
                                                                            <?php echo $payment->email; ?><br/>
                                                                            <?php echo $payment->house.', '.$payment->street; ?><br/>
                                                                            <?php echo $payment->city.', '.$payment->district; ?><br/>
                                                                            <?php echo $payment->postcode; ?><br/>
                                                                            <?php echo Country::model()->getCountryName($payment->country_id); ?></p>
                                                                    </td>
                                                                    <td width="249">
                                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong><strong>Адрес доставки</strong>:</strong><br>
                                                                            <?php echo $shipping->name.' '.$shipping->surname; ?><br>
                                                                            <?php echo $shipping->phone; ?><br/>
                                                                            <?php echo $shipping->email; ?><br/>
                                                                            <?php echo $shipping->house.', '.$shipping->street; ?><br/>
                                                                            <?php echo $shipping->city.', '.$shipping->district; ?><br/>
                                                                            <?php echo $shipping->postcode; ?><br/>
                                                                            <?php echo Country::model()->getCountryName($shipping->country_id); ?></p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <h3 style="padding-bottom: 6px; margin-top: 10px; padding-left: 2px; padding-right: 2px; font: 16px/16px arial,sans-serif; margin-bottom: 10px; background: #f1f1f1; padding-top: 6px;"><strong><strong>Информация о заказе</strong>:</strong></h3>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><strong>Дата заказа:</strong> <?php echo $order->created; ?></p>
                                                        <span style="font-family: arial,sans-serif; font-size: 14px;">
                                                            <table style="margin-top: 20px; margin-bottom: 20px;" cellpadding="0" cellspacing="0" width="497">
                                                                <tbody>
                                                                    <?php 
                                                                    $i = 0;
                                                                    foreach ($items AS $item): 
                                                                    $i++;
                                                                    $product = Product::model()->findByPk($item['product_id']);
                                                                    $productNode = $product->getProduct($item['product_node_id']);   
                                                                    ?>
                                                                    <tr>
                                                                        <td width="90">
                                                                            <?php
                                                                            $attachedImage = Attachment::model()->getAttachment('productNode', $item['product_node_id']);
                                                                            if ($attachedImage):
                                                                                echo CHtml::image(Yii::app()->getBaseUrl(true).Image::thumb(Yii::app()->params['images'].$attachedImage->image, 63));
                                                                            endif;
                                                                            ?>
                                                                        </td>
                                                                        <td><p><?php echo $i; ?> <strong><?php echo $productNode->content->title; ?></strong> Руб <?php echo $productNode->mainNode->price; ?></p></td>
                                                                        <td><p>Colour: <?php echo Classifier::model()->getValue('color', $productNode->mainNode->color, 'N/A'); ?></p></td><td><p>Size: <?php echo Classifier::model()->getValue('size', $productNode->mainNode->size, 'N/A'); ?></p></td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;">
                                                            Не забудьте проверить наличие оплаты н счете.
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: rgb(255, 255, 255);" height="28"><img alt="" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/spacer.gif" height="28" width="550"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0px; background-color: rgb(0, 0, 0); color: rgb(255, 255, 255);" align="center" valign="top"><strong style="line-height: 11px; font-family: tahoma,sans-serif; font-size: 11px;"><img alt="" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/email-logo2.gif" align="bottom" border="0" height="10" width="33"> </strong></td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table style="font-family: arial,sans-serif; color: rgb(173, 173, 173); font-size: 9px;" align="center" border="0" cellpadding="0" cellspacing="0" width="497">
                                            <tbody>
                                                <tr>
                                                    <td><img alt="" src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/spacer.gif" height="20" width="497"><br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><!-- DISCLAIMER --></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>