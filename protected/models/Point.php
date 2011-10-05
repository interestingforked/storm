<?php

/**
 * This is the model class for table "points".
 *
 * The followings are the available columns in table 'points':
 * @property string $id
 * @property string $country_id
 * @property string $region_id
 * @property string $district_id
 * @property integer $active
 * @property string $title
 * @property string $latin
 *
 * The followings are the available model relations:
 * @property District $district
 * @property Country $country
 * @property Region $region
 */
class Point extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Point the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'points';
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
            array('id', 'length', 'max' => 10),
            array('country_id, region_id, district_id', 'length', 'max' => 11),
            array('title, latin', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, country_id, region_id, district_id, active, title, latin', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'district' => array(self::BELONGS_TO, 'District', 'district_id'),
            'country' => array(self::BELONGS_TO, 'Countrie', 'country_id'),
            'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'country_id' => 'Country',
            'region_id' => 'Region',
            'district_id' => 'District',
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
        $criteria->compare('country_id', $this->country_id, true);
        $criteria->compare('region_id', $this->region_id, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('latin', $this->latin, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}