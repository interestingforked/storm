<?php

/**
 * This is the model class for table "contents".
 *
 * The followings are the available columns in table 'contents':
 * @property string $id
 * @property string $module
 * @property integer $module_id
 * @property string $language
 * @property string $title
 * @property string $body
 * @property string $created
 */
class Content extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Content the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'contents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('module, module_id, language', 'required'),
            array('module_id', 'numerical', 'integerOnly' => true),
            array('module', 'length', 'max' => 20),
            array('language', 'length', 'max' => 2),
            array('title, meta_title, background', 'length', 'max' => 250),
            array('body, additional, meta_description, meta_keywords', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, module, module_id, language, title, body, additional, meta_title, meta_description, meta_keywords, background, created', 'safe', 'on' => 'search'),
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
            'module' => 'Module',
            'module_id' => 'Module',
            'language' => 'Language',
            'title' => 'Title',
            'body' => 'Body',
            'additional' => 'Additional',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'background' => 'Background',
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
        $criteria->compare('module', $this->module, true);
        $criteria->compare('module_id', $this->module_id);
        $criteria->compare('language', $this->language, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('additional', $this->additional, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('background', $this->background, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getModuleContent($module, $moduleId, $language = null) {
        if ( ! $language)
            $language = Yii::app()->params['defaultLanguage'];
        return $this->findByAttributes(array(
                    'module' => $module,
                    'module_id' => $moduleId,
                    'language' => $language,
                ));
    }

}