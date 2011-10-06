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