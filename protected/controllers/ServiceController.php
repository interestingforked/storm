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
                    $label = $record->title;
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
                    $order->status = 3;
                    $order->save();
                    $order->processQuantity();
                }
            }
            mail('pavel@csscat.com', 'Payment response', CJSON::encode($_POST));
            Yii::app()->end();
        } else
            Yii::app()->controller->redirect(array('/'));
    }

}