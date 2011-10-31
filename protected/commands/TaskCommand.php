<?php

class TaskCommand extends CConsoleCommand {

    public function actionNotifying() {
        $objects = Notifying::model()->findNotSent();
        if ($objects) {
            $messageFile = Yii::getPathOfAlias('application.views.mails.notification') . '.php';
            foreach ($objects AS $object) {
                $product = Product::model()->findByPk($object->product_id);
                if ($product) {
                    $productNode = $product->getProduct($object->product_node_id);
                    if ($productNode) {
                        $message = $this->renderFile($messageFile, array('product' => $productNode), true);
                        $subject = 'STORM - Уведомление о продукте';
                        $adminEmail = Yii::app()->params['adminEmail'];
                        $headers = "MIME-Version: 1.0\r\nFrom: {$adminEmail}\r\nReply-To: {$adminEmail}\r\nContent-Type: text/html; charset=utf-8";
                        if (mail($object->email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, $headers)) {
                            $object->sent = new CDbExpression('now()');
                            $object->save();
                        }
                    }
                }
            }
        }
    }

}
