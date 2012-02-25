<?php

class UpdateQuantityTask extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'update_quantity';
    }
    
}