<?php

class SoapController extends CController {

    public function actionIndex() {
        $client = new SoapClient("http://www.ponyexpress.ru/tools/address_ws.wsdl");
        
        $request = new PointRequest();
        /*
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
         */
        $request->latin_names = true;
        $response = $client->getPoints($request);
        foreach ($response->point_el AS $element) {
            $model = Point::model()->findByPk($element->point_id);
            $model->latin = $element->title;
            $model->save();
        }
        
    }
    
    public function actionRate() {
        $client = new SoapClient("http://www.ponyexpress.ru/tools/address_ws.wsdl");
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
class getRateRequest {
    public $org_citycode;
    public $dest_citycode;
    public $dest_region;
    public $dest_district;
    public $item_count;
    public $weight;
    public $direction;
    public $delivery_mode;
    public $currency_code;
}