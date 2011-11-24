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
                                                        <h2 style="margin-top: 20px; font: 15px/15px arial,sans-serif;"><strong>Здравствуйте!</strong></h2>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><?php echo $fromWho; ?> отправил (а) Вам свой список предпочтений.</p>
														<p style="font-family: arial,sans-serif; font-size: 14px;"><?php echo $fromWho; ?> оставил (а) свой комментарий.</p>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><?php echo $message; ?></p>
                                                        <h3 style="padding-bottom: 6px; margin-top: 10px; padding-left: 2px; padding-right: 2px; font: 16px/16px arial,sans-serif; margin-bottom: 10px; background: #f1f1f1; padding-top: 6px;"><strong><strong>Информация о товаре</strong>:</strong></h3>
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
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;">Вы можете ознакомиться со списком, перейдя по следующей <a href="<?php echo Yii::app()->getBaseUrl(true).CHtml::normalizeUrl(array('/wishlist/view')).'?key='.$list['key']; ?>" target="_blank">ссылке</a>.</p>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;"><?php echo $fromWho; ?>  поручил (а) StormLondon отправить Вам это письмо</p>
                                                    </td>
                                                </tr>
                                            </tbody>
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