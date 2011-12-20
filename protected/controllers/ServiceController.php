<?php

class ServiceController extends Controller {

    public function actionDistrict() {
        $term = Yii::app()->getRequest()->getParam('term');

        if (Yii::app()->request->isAjaxRequest && $term) {
            $criteria = new CDbCriteria;

            $criteria->addSearchCondition('title', $term);
            $criteria->addSearchCondition('latin', $term, true, 'OR');
            $criteria->addCondition('active = 1');
            
            $records = District::model()->findAll($criteria);

            $result = array();
            foreach ($records as $record) {
                if (Yii::app()->language != 'ru' OR !$record->title)
                    $label = $record->latin ? $record->latin : $record->title;
                else
                    $label = $record->title;
                $result[] = array('id' => $record->id, 'label' => $label, 'value' => $label);
            }
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }

    public function actionPoint() {
        $term = Yii::app()->getRequest()->getParam('term');
        $dontShowFull = Yii::app()->getRequest()->getParam('dontShowFull') == 'true';

        if (Yii::app()->request->isAjaxRequest && $term) {
            $criteria = new CDbCriteria;

            $criteria->addSearchCondition('title', $term);
            $criteria->addSearchCondition('latin', $term, true, 'OR');
            $criteria->addCondition('active = 1');

            $session = new CHttpSession;
            $session->open();
            $countryId = (isset($session['country_id'])) ? $session['country_id'] : 811;
            $criteria->addCondition('country_id = '.$countryId);
            
            $records = Point::model()->findAll($criteria);

            $result = array();
            foreach ($records as $record) {
                if (Yii::app()->language != 'ru' OR !$record->title)
                    $label = $record->latin ? $record->latin : $record->title;
                else
                    $label = $dontShowFull ? $record->title : $record->full_title;
                $result[] = array('id' => $record->id, 'label' => $label, 'value' => $label);
            }
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }

    public function actionCountry() {
        $id = Yii::app()->getRequest()->getParam('country_id');
        if ($id) {
            $session = new CHttpSession;
            $session->open();
            $session['country_id'] = $id;
        }
    }

    public function actionPayment() {
        if ($_POST) {
            $rbkService = new RBKMoneyService(Yii::app()->params['RBKMoney']);
            if ($rbkService->checkPaymentResponse($_POST)) {
                $order = Order::model()->getByOrderKey($_POST['orderId']);
                if ($_POST['paymentStatus'] == 5) {
                    $order->rbk_payment_id = $_POST['paymentId'];
                    $order->status = 4;
                    $order->save();
                    if ($order->sent != 1) {
                        if ($this->sendConfirmMail($order)) {
                            $order->sent = 1;
                            $order->save();
                        }
                    }
                }
            }
            mail('pavel@csscat.com', 'Payment response', CJSON::encode($_POST));
            Yii::app()->end();
        } else
            Yii::app()->controller->redirect(array('/'));
    }
    
    private function sendConfirmMail($order) {
        $paymentData = OrderDetail::model()->getOrderPaymentData($order->id);
        $shippingData = OrderDetail::model()->getOrderShipingData($order->id);
        $items = $order->items;

        $user = User::model()->findByPk($order->user_id);

        $mail = $this->renderPartial('//mails/confirm', array(
            'order' => $order,
            'payment' => $paymentData,
            'shipping' => $shippingData,
            'items' => $items,
            'user' => $user
                ), true);
        $subject = 'STORM - Подтверждение заказа';
        $email = Yii::app()->user->email;

        $adminMail = $this->renderPartial('//mails/admin_confirm', array(
            'order' => $order,
            'payment' => $paymentData,
            'shipping' => $shippingData,
            'items' => $items,
            'user' => $user
                ), true);
        $adminSubject = 'STORM - Подтверждение заказа';
        $adminEmail = Yii::app()->params['adminEmail'];

        $headers = "MIME-Version: 1.0\r\nFrom: {$adminEmail}\r\nReply-To: {$adminEmail}\r\nContent-Type: text/html; charset=utf-8";
        return (mail($email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $mail, $headers)
                AND mail($adminEmail, '=?UTF-8?B?' . base64_encode($adminSubject) . '?=', $adminMail, $headers));
    }

}