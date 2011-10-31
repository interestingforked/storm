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
                                    <td bgcolor="#000000" height="98"><a target="_blank" shape="rect" href="<?php echo Yii::app()->params['baseUrl']; ?>"><img alt="STORM London" src="<?php echo Yii::app()->params['baseUrl']; ?>/images/email-logo.gif" border="0" height="98" width="164"></a></td>
                                </tr>
                                <tr>
                                    <td style="background-color: rgb(255, 255, 255);" height="28"><img alt="" src="<?php echo Yii::app()->params['baseUrl']; ?>/images/spacer.gif" height="28" width="550"></td>
                                </tr>
                                <tr>
                                    <td style="background-color: rgb(255, 255, 255);" align="center">
                                        <table style="border-width: 1px; border-style: solid; border-color: rgb(225, 225, 225);" align="center" cellpadding="9" cellspacing="0" width="497">
                                            <tbody>
                                                <tr>
                                                    <td style="background-color: rgb(255, 255, 255);">
                                                        <h2 style="margin-top: 20px; font: 15px/15px arial,sans-serif;"><strong>Здравствуйте!</strong></h2>
                                                        <p style="font-family: arial,sans-serif; font-size: 14px;">Вы просили уведомить вас, когда интересующий вас товар появиться на нашем складе. <br/>Спешим вам об этом сообщить.</p>
                                                        <h3 style="padding-bottom: 6px; margin-top: 10px; padding-left: 2px; padding-right: 2px; font: 16px/16px arial,sans-serif; margin-bottom: 10px; background: #f1f1f1; padding-top: 6px;"><strong><strong>Информация о товаре</strong>:</strong></h3>
                                                        <span style="font-family: arial,sans-serif; font-size: 14px;">
                                                            <table style="margin-top: 20px; margin-bottom: 20px;" cellpadding="0" cellspacing="0" width="497">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="90">
                                                                            <?php
                                                                            $attachedImage = Attachment::model()->getAttachment('productNode', $product->mainNode->id);
                                                                            if ($attachedImage):
                                                                                echo CHtml::image(Yii::app()->params['baseUrl'].Image::thumb(Yii::app()->params['images'].$attachedImage->image, 63));
                                                                            endif;
                                                                            ?>
                                                                        </td>
                                                                        <td><p><strong><?php echo $product->content->title; ?></strong> Руб <?php echo $product->mainNode->price; ?></p></td>
                                                                        <td><p>Colour: <?php echo Classifier::model()->getValue('color', $product->mainNode->color, 'N/A'); ?></p></td><td><p>Size: <?php echo Classifier::model()->getValue('size', $product->mainNode->size, 'N/A'); ?></p></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <p style="font-family: arial,sans-serif; font-size: 14px;">
                                                            Вы можете ознакомиться и приобрести товар перейдя по следующей 
                                                            <a target="_blank" shape="rect" href="<?php echo Yii::app()->params['baseUrl'].'/'.Yii::app()->params['defaultLanguage'].'/product/'.$product->slug.'-'.$product->id.'?node='.$product->mainNode->id; ?>">ссылке</a>.</p>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: rgb(255, 255, 255);" height="28"><img alt="" src="<?php echo Yii::app()->params['baseUrl']; ?>/images/spacer.gif" height="28" width="550"></td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0px; background-color: rgb(0, 0, 0); color: rgb(255, 255, 255);" align="center" valign="top"><strong style="line-height: 11px; font-family: tahoma,sans-serif; font-size: 11px;"><img alt="" src="<?php echo Yii::app()->params['baseUrl']; ?>/images/email-logo2.gif" align="bottom" border="0" height="10" width="33"> </strong></td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table style="font-family: arial,sans-serif; color: rgb(173, 173, 173); font-size: 9px;" align="center" border="0" cellpadding="0" cellspacing="0" width="497">
                                            <tbody>
                                                <tr>
                                                    <td><img alt="" src="<?php echo Yii::app()->params['baseUrl']; ?>/images/spacer.gif" height="20" width="497"><br>
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