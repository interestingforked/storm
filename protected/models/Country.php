<?php

/**
 * This is the model class for table "countries".
 *
 * The followings are the available columns in table 'countries':
 * @property string $id
 * @property integer $active
 * @property string $title
 * @property string $latin
 *
 * The followings are the available model relations:
 * @property OrderDetail[] $orderDetails
 * @property Region[] $regions
 */
class Country extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Country the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'countries';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('id', 'length', 'max' => 11),
            array('title, latin', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, active, title, latin', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'country_id'),
            'regions' => array(self::HAS_MANY, 'Region', 'country_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'active' => 'Active',
            'title' => 'Title',
            'latin' => 'Latin',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('latin', $this->latin, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getActive() {
        return $this->findAllByAttributes(array(
            'active' => 1
        ));
    }
    
    public function getCountryName($countryId, $latin = false) {
        $country = $this->findbyPk($countryId);
        if ( ! $country)
            return null;
        return ($latin) ? $country->latin : $country->title;
    }

}