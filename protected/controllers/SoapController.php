<?php

class SoapController extends CController {

    public function actionAddress() {
        $client = new SoapClient("http://www.ponyexpress.ru/tools/address_ws.wsdl");

        $request = new PointRequest();

        $request->latin_names = false;
        $model = new Point();
        $response = $client->getPoints($request);
        foreach ($response->point_el AS $element) {
            $model->isNewRecord = true;
            $model->id = $element->point_id;
            $model->country_id = $element->country_id;
            $model->region_id = $element->region_id;
            $model->district_id = $element->district_id;
            $model->title = $element->title;
            $model->save();
        }

        $request->latin_names = true;
        $response = $client->getPoints($request);
        foreach ($response->point_el AS $element) {
            $model = Point::model()->findByPk($element->point_id);
            $model->latin = $element->title;
            $model->save();
        }
    }

    public function actionRate() {
        $ponyExpress = new PonyExpressService(Yii::app()->params['ponyExpress']);
        $response = $ponyExpress->getRate(array(
            'citycode' => 'SRW004',
            'region' => 418,
            'district' => 2626,
            'count' => 3,
            'weight' => 0.3,
                ));
        print_r($response);
    }

    public function actionRenameImages() {
        $attachments = Attachment::model()->findAll();
        foreach ($attachments AS $attachment) {
            if ($attachment->module == 'productNode') {
                $productNode = ProductNode::model()->findByPk($attachment->module_id);
                $moduleId = $productNode->product_id;
            } else {
                $moduleId = $attachment->module_id;
            }
            $product = Product::model()->findByPk($moduleId);
            if (!$product) {
                echo '<b>';
                echo $moduleId;
                echo ' / ';
                echo $attachment->image;
                echo ' / ';
                echo $attachment->module;
                echo ' / ';
                echo $attachment->id;
                echo '</b><br>';
            } else {
                echo $attachment->id . ' - ' . $attachment->image . ' -> ' . $product->slug . '-' . $product->id . '-' . $attachment->id . '<br/>';
            }
            continue;
            if ($attachment->mimetype == 'image/png') {
                $extension = 'png';
            } else if ($attachment->mimetype == 'image/gif') {
                $extension = 'gif';
            } else {
                $extension = 'jpg';
            }
            $image = $product->slug . '-' . $moduleId . '-' . $attachment->id . '.' . $extension;

            $exFile = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params['images'] . $attachment->image;
            if (!file_exists($exFile)) {
                continue;
            }
            $newFile = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . Yii::app()->params['images'] . $image;
            if (copy($exFile, $newFile)) {
                unlink($exFile);
            }
            $attachment->image = $image;
            $attachment->save();
        }
    }

    public function actionRequest() {
        $service = new RBKMoneyService(Yii::app()->params['RBKMoney']);
        echo $service->generateRequestForm(array(
            'order' => '1110001',
            'service' => 'watches',
            'amount' => 547.34
        ));
    }

    public function actionPayment() {
        $message = "";
        if ($_POST) {
            foreach ($_POST AS $k => $v) {
                $message .= "{$k} : {$v} <br>\r\n";
            }
        }
        $message = "<pre>{$message}</pre>";
        $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        mail('pavel@csscat.com', 'paymentRequest', $message, $headers);
    }
    
    public function actionUsers() {
        Yii::app()->setImport(array(
            'admin.models.*',
            'admin.components.*',
            'application.modules.*',
            'application.modules.user.*',
            'application.modules.user.models.*',
            'application.modules.user.components.*',
        ));
        $row = 0;
        $handle = fopen(Yii::app()->basePath.'/../assets/StormWatchesCustomers.csv', "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $row++;
            if ($row == 1) continue;
            
            $model = new User;
            $profile = new Profile;
            
            $model->username = preg_replace("/[\.\-_@]+/", "", $data[0]);
            $model->email = $data[0];
            
            $firstPart = array('q','a','f','d','s','v','n','t','z','x','o','p');
            $secondPart = array('i','u','y','b','m','c','h','g','l','k','j','r');
            $password = '';
            for ($i = 0; $i < 4; $i++) {
                $password .= $firstPart[rand(0, count($firstPart) - 1)];
                $password .= $secondPart[rand(0, count($secondPart) - 1)];
            }
            $model->password = UserModule::encrypting($password);
            $model->activkey = UserModule::encrypting(microtime() . $password);
            $model->createtime = time();
            $model->lastvisit = 0;
            $model->superuser = 0;
            $model->status = 0;
            
            $link = 'http://' . $_SERVER['HTTP_HOST'] . '/ru/user/recovery?activkey='.$model->activkey.'&email='.$model->email;
            
            if ($model->save()) {
                $profile->user_id = $model->id;
                $profile->firstname = $data[2];
                $profile->lastname = $data[3];
                $profile->newsletters = ($data[4] == 'Yes') ? 1 : 0;
                if (in_array($data[1], array('K-dze','Госпожа','Mrs')))
                    $profile->sex = 0;
                else
                    $profile->sex = 1;
                $profile->age = 3;
                if ($profile->save()) {
                    $mail = $this->renderPartial('//mails/usermail', array('link' => $link), true);
                    $subject = 'Уважаемый клиент STORM London!';
                    $email = $model->email;
                    $headers = "MIME-Version: 1.0\r\nFrom: info@stormlondon.ru\r\nReply-To: info@stormlondon.ru\r\nContent-Type: text/html; charset=utf-8";
                    //mail($email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $mail, $headers);
                } else {
                    print_r($profile->getErrors());
                    print_r($data);
                }
            } else {
                print_r($model->getErrors());
            }
        }
        fclose($handle);
    }

}

class CountryRequest {

    public $latin_names;

}

class RegionRequest {

    public $latin_names;

}

class DistrictRequest {

    public $latin_names;

}

class PointRequest {

    public $latin_names;

}