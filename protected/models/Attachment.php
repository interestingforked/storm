<?php

/**
 * This is the model class for table "attachments".
 *
 * The followings are the available columns in table 'attachments':
 * @property string $id
 * @property string $module
 * @property integer $module_id
 * @property string $mimetype
 * @property string $image
 * @property string $alt
 * @property string $created
 */
class Attachment extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Attachment the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'attachments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('module, module_id', 'required'),
            array('module_id', 'numerical', 'integerOnly' => true),
            array('module', 'length', 'max' => 20),
            array('mimetype', 'length', 'max' => 30),
            array('image, alt', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, module, module_id, mimetype, image, alt, created', 'safe', 'on' => 'search'),
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
            'mimetype' => 'Mimetype',
            'image' => 'Image',
            'alt' => 'Alt',
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
        $criteria->compare('mimetype', $this->mimetype, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('alt', $this->alt, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getAttachment($module, $moduleId) {
        return $this->findByAttributes(array(
            'module' => $module,
            'module_id' => $moduleId,
        ));
    }

    public function getAttachments($module, $moduleId) {
        if (is_array($module)) {
            $conditions = array();
            foreach ($module AS $mod)
                $conditions[] = " module = '{$mod}' "; 
            $condition = implode('OR', $conditions);
            return $this->findAllBySql(
                "SELECT * FROM attachments WHERE ({$condition}) AND module_id = :module_id", array(
                ':module_id' => $moduleId,
            ));
        }
        if (is_string($module)) {
            return $this->findAllByAttributes(array(
                'module' => $module,
                'module_id' => $moduleId,
            ));
        }
    }
    
    public function saveAttachments($files, $module, $moduleId, $slug) {
        if ( ! is_array($files))
            return false;
        $errors = array();
        foreach ($files AS $file) {
            $fileInfo = explode('|', $file);
            
            // '+responseJSON.filename+'|'+responseJSON.image+'|'+responseJSON.mimetype+'|'+responseJSON.path+'
            $fileName = $fileInfo[0];
            $mimeType = strtolower($fileInfo[2]);
            $tmpFile = realpath($fileInfo[3]);
            
            $extension = explode('.', $fileInfo[1]);
            $extension = end($extension);
            
            $this->isNewRecord = true;
            $this->id = null;
            $this->module = $module;
            $this->module_id = $moduleId;
            $this->mimetype = $mimeType;
            $this->alt = $fileName;
            $this->save();
            
            switch ($module) {
                case 'page': $directory = 'pages'; break;
                case 'gallery': $directory = 'gallery'; break;
                default: $directory = 'images';
            }

            $image = $slug.'-'.$moduleId.'-'.$this->id.'.'.$extension;
            $newFile = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.Yii::app()->params[$directory].$image;
            if (copy($tmpFile, $newFile)) {
                unlink($tmpFile);
            }
            $this->image = $image;
            if ( ! $this->save()) {
                $errors[] = $this->getErrors();
            }
        }
        if (count($errors) > 0)
            return $errors;
        return true;
    }
    
    public function saveImage($file, $module) {
        $fileInfo = explode('|', $file);

        $fileName = $fileInfo[0];
        $tmpFile = realpath($fileInfo[3]);
            
        $extension = explode('.', $fileInfo[1]);
        $extension = end($extension);
        
        switch ($module) {
            case 'page':        $directory = 'pages';       break;
            case 'category':    $directory = 'categories';  break;
            case 'background':  $directory = 'backgrounds'; break;
            default:            $directory = 'images';
        }
            
        $image = $fileName.'.'.$extension;
        $newFile = Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.Yii::app()->params[$directory].$image;
        if (copy($tmpFile, $newFile)) {
            unlink($tmpFile);
        }
        return $image;
    }

}