<?php

/**
 * This is the model class for table "blocks".
 *
 * The followings are the available columns in table 'blocks':
 * @property string $id
 * @property integer $active
 * @property integer $position
 * @property integer $sort
 * @property string $created
 */
class Block extends CActiveRecord {
    
    public $content;

    /**
     * Returns the static model of the specified AR class.
     * @return Block the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'blocks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('active, position, sort', 'numerical', 'integerOnly' => true),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, active, position, sort, created', 'safe', 'on' => 'search'),
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
            'active' => 'Active',
            'position' => 'Position',
            'sort' => 'Sort',
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
        $criteria->compare('active', $this->active);
        $criteria->compare('position', $this->position);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function getBlock($position) {
        $block = $this->findByAttributes(array('position' => $position));
        if ( ! $block) {
            return false;
        }
        $content = Content::model()->getModuleContent('block', $block->id);
        return $content->body;
    }

}