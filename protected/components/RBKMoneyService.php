<?php

class RBKMoneyService {

    private $_config;

    public function __construct($config) {
        $this->_config = $config;
    }

    public function generateRequestForm($data, $buttonHtmlOptions = array()) {
        $content  = CHtml::beginForm('https://rbkmoney.ru/acceptpurchase.aspx', 'post', array('id' => 'paymentForm'));
        $content .= CHtml::hiddenField('eshopId', $this->_config['shopId']);
        $content .= CHtml::hiddenField('recipientCurrency', $this->_config['currency']);
        
        $successUrl = $this->createAbsoluteUrl($this->_config['successUrl']).'?key='.$data['order'];
        $content .= CHtml::hiddenField('successUrl', $successUrl);
        $content .= CHtml::hiddenField('failUrl', $this->createAbsoluteUrl($this->_config['failUrl']));
        $content .= CHtml::hiddenField('language', Yii::app()->language);
        
        $content .= CHtml::hiddenField('orderId', $data['order']);
        $content .= CHtml::hiddenField('serviceName', $data['service']);
        $content .= CHtml::hiddenField('recipientAmount', $data['amount']);
        
        $buttonHtmlOptions['disabled'] = true;
        $buttonHtmlOptions['id'] = 'rbk_money_submit_button';
        $buttonHtmlOptions['style'] = 'display:none;';
        $content .= CHtml::submitButton(Yii::t('app', 'Перейти к оплате'), $buttonHtmlOptions);
        
        $content .= CHtml::endForm();

        return $content;
    }
    
    public function checkPaymentResponse($data) {
        $digestString = $this->generateDigestString($data);
        return ($data['hash'] == md5($digestString));
    }
    
    private function generateDigestString($params) {
        $data = array(
            $this->formatParameter($params, 'eshopId'),
            $this->formatParameter($params, 'orderId'),
            $this->formatParameter($params, 'serviceName'),
            $this->formatParameter($params, 'eshopAccount'),
            $this->formatParameter($params, 'recipientAmount'),
            $this->formatParameter($params, 'recipientCurrency'),
            $this->formatParameter($params, 'paymentStatus'),
            $this->formatParameter($params, 'userName'),
            $this->formatParameter($params, 'userEmail'),
            $this->formatParameter($params, 'paymentData'),
            $this->_config['secretKey']
        );
        return implode('::', $data);
    }
    
    private function formatParameter($array, $key) {
        if ( ! isset($array[$key]))
            return '';
        else
            return $array[$key];
    }
    
    private function createAbsoluteUrl($url) {
        return Yii::app()->getBaseUrl(true).CHtml::normalizeUrl($url);
    }

}