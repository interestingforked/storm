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
                        $headers = "MIME-Version: 1.0\r\nFrom: {$adminEmail}\r\nReply-To: {$adminEmail}\r\nReturn-Path: {$adminEmail}\r\nContent-Type: text/html; charset=utf-8";
                        if (mail($object->email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, $headers, "-f {$adminEmail}")) {
                            $object->sent = new CDbExpression('now()');
                            $object->save();
                        }
                    }
                }
            }
        }
    }

    public function actionNewsletters() {
        $newsletter = Newsletter::model()->notSent()->find();
        if ($newsletter) {
            $newsletterUsers = $newsletter->users;
            if ($newsletterUsers) {
                $c = 0;
                $sent = 0;
                $max = Yii::app()->params['newslettersMaxMailSend'];
                foreach ($newsletterUsers AS $newsletterUser) {
                    if ($newsletterUser->sent) {
                        $sent++;
                        continue;
                    }
                    if ($c == $max) {
                        break;
                    }
                    $c++;
                    $message = $newsletter->message;
                    $subject = $newsletter->subject;
                    $adminEmail = Yii::app()->params['adminEmail'];
                    $headers = "MIME-Version: 1.0\r\nFrom: {$adminEmail}\r\nReply-To: {$adminEmail}\r\nReturn-Path: {$adminEmail}\r\nContent-Type: text/html; charset=utf-8";
                    if (mail($newsletterUser->email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, $headers, "-f {$adminEmail}")) {
                        $newsletterUser->sent = new CDbExpression('CURRENT_TIMESTAMP');
                        $newsletterUser->save();
                    }
                }
                if ($c < $max) {
                    $newsletter->sent = new CDbExpression('CURRENT_TIMESTAMP');
                    $newsletter->save();
                }
            }
        }
    }

    public function actionUpdateQuantity() {
        $filePath = Yii::app()->params['filePath'];
        $fileDate = date('ymd');

        $task = new UpdateQuantityTask();
        $task->started = date('Y-m-d G:i:s');
        $task->date = $fileDate;
        $task->process = date('Y-m-d G:i:s').' : '.'Task started' . "\r\n";

        $ruFile = $filePath . 'STOCK_R1_' . $fileDate . '.txt';
        $lvFile = $filePath . 'STOCK_L2_' . $fileDate . '.txt';

        $productArray = array();

        $task->process .= date('Y-m-d G:i:s').' : '.'Start reading files' . "\r\n";
        $task->process .= date('Y-m-d G:i:s').' : '.'Start reading ' . $ruFile . "\r\n";
        $fileHandler = fopen($ruFile, 'r');
        if ($fileHandler) {
            while (($buffer = fgets($fileHandler, 4096)) !== false) {
                $code = trim(substr($buffer, 0, 20));
                $quantity = trim(substr($buffer, 20, 12));
                $productArray[$code] = (int) $quantity;
            }
            fclose($fileHandler);
        }
        unset($fileHandler);

        $task->process .= date('Y-m-d G:i:s').' : '.'Start reading ' . $lvFile . "\r\n";
        $fileHandler = fopen($lvFile, 'r');
        if ($fileHandler) {
            while (($buffer = fgets($fileHandler, 4096)) !== false) {
                $code = trim(substr($buffer, 0, 20));
                $quantity = trim(substr($buffer, 20, 12));
                if (isset($productArray[$code]))
                    $productArray[$code] += (int) $quantity;
                else
                    $productArray[$code] = (int) $quantity;
            }
            fclose($fileHandler);
        }
        unset($fileHandler);
        unset($code);
        unset($quantity);

        $task->process .= date('Y-m-d G:i:s').' : '.'Reading completed' . "\r\n";
        $task->process .= date('Y-m-d G:i:s').' : '.'Updating' . "\r\n";

        foreach ($productArray as $code => $quantity) {
            $model = ProductNode::model()->findByAttributes(array(
                'code' => $code
                    ));
            if ($model) {
                $task->process .= date('Y-m-d G:i:s').' : '.'Found ' . $code . ' (' . $model->quantity . ')';
                if ($model->quantity = $quantity) {
                    $task->process .= ' and quantity updated to ' . $quantity . "\r\n";
                    $model->save();
                }
            }
        }

        $task->process .= date('Y-m-d G:i:s').' : '.'Task ended' . "\r\n";
        $task->ended = date('Y-m-d G:i:s');
        $task->save();
    }

}
