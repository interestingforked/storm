<?php

/**
 * This is the model class for table "newsletters".
 *
 * The followings are the available columns in table 'newsletters':
 * @property string $id
 * @property string $subject
 * @property string $message
 * @property string $sent
 * @property string $created
 */
class Newsletter extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'newsletters';
    }

    public function rules() {
        return array(
            array('subject, message', 'required'),
            array('filter', 'numerical', 'integerOnly' => true),
            array('subject', 'length', 'max' => 250),
            array('sent', 'safe'),
            array('id, filter, subject, message, start, sent, created', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'users' => array(self::HAS_MANY, 'NewsletterUser', 'newsletter_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'start' => 'Start',
            'sent' => 'Sent',
            'created' => 'Created',
        );
    }
    
    public function scopes() {
        return array(
            'notSent' => array(
                'condition' => "sent is null"
            ),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('sent', $this->sent, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}