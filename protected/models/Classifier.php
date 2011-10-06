<?php

/**
 * This is the model class for table "classifier".
 *
 * The followings are the available columns in table 'classifier':
 * @property string $id
 * @property string $group
 * @property string $key
 * @property string $value
 * @property integer $active
 * @property string $created
 */
class Classifier extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Classifier the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'classifier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('group, key, value', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('group, key', 'length', 'max' => 20),
            array('value', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, group, key, value, active, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'group' => 'Group',
            'key' => 'Key',
            'value' => 'Value',
            'active' => 'Active',
            'created' => 'Created',
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
        $criteria->compare('group', $this->group, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getValue($group, $key, $default = '') {
        $classiefier = $this->findByAttributes(array(
            'group' => $group,
            'key' => $key
                ));
        return ($classiefier) ? $classiefier->value : $default;
    }

    public function getGroup($group) {
        return $this->ordered()->findAllByAttributes(array('group' => $group,));
    }

    public function scopes() {
        return array(
            'ordered' => array(
                'order' => 'value ASC',
            ),
        );
    }

}