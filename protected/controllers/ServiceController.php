<?php

class ServiceController extends Controller {

    public function actionCountry() {
        $term = Yii::app()->getRequest()->getParam('term');

        if (Yii::app()->request->isAjaxRequest && $term) {
            $criteria = new CDbCriteria;

            $criteria->addSearchCondition('title', $term);
            $criteria->addSearchCondition('latin', $term, true, 'OR');
            $criteria->addCondition('active = 1');

            $records = Country::model()->findAll($criteria);

            $result = array();
            foreach ($records as $record) {
                if (Yii::app()->language != 'ru' OR ! $record->title)
                    $label = $record->latin ? $record->latin : $record->title;
                else
                    $label = $record->title;
                $result[] = array('id' => $record->id, 'label' => $label, 'value' => $label);
            }
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }
    
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
                if (Yii::app()->language != 'ru' OR ! $record->title)
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

            $records = Point::model()->findAll($criteria);

            $result = array();
            foreach ($records as $record) {
                if (Yii::app()->language != 'ru' OR ! $record->title)
                    $label = $record->latin ? $record->latin : $record->title;
                else
                    $label = $record->title;
                $result[] = array('id' => $record->id, 'label' => $label, 'value' => $label);
            }
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }

}