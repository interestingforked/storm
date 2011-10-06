<?php

class PonyExpressService {
    
    private $_config;
    
    public function __construct($config) {
        $this->_config = $config;
    }
    
    public function getRate($data) {
        $request = new getRateRequest();
        $request->currency_code = $this->_config['currency_code'];
        $request->delivery_mode = $this->_config['delivery_mode'];
        $request->dest_citycode = $data['citycode'];
        $request->dest_district = $data['district'];
        $request->direction = $this->_config['direction'];
        $request->item_count = $data['count'];
        $request->org_citycode = $this->_config['org_citycode'];
        $request->weight = $data['weight'];
        
        $client = new SoapClient($this->_config['schema']);
        $response = $client->getRate($request);
        
        return $response;
    }
    
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