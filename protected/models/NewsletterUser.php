<?php

/**
 * This is the model class for table "newsletter_users".
 *
 * The followings are the available columns in table 'newsletter_users':
 * @property string $id
 * @property string $newsletter_id
 * @property string $user_id
 * @property string $email
 * @property string $sent
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Newsletters $newsletter
 */
class NewsletterUser extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'newsletter_users';
    }

    public function rules() {
        return array(
            array('newsletter_id, user_id, email', 'required'),
            array('newsletter_id, user_id', 'length', 'max' => 11),
            array('email', 'length', 'max' => 250),
            array('id, newsletter_id, user_id, email, sent', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'newsletter' => array(self::BELONGS_TO, 'Newsletters', 'newsletter_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'newsletter_id' => 'Newsletter',
            'user_id' => 'User',
            'email' => 'Email',
            'sent' => 'Sent',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('newsletter_id', $this->newsletter_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('sent', $this->sent, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
	
	public function countUsersByNewsletter($newsletterId) {
		$criteria = new CDbCriteria;
		$criteria->addCondition("newsletter_id = {$newsletterId}");
		$criteria->addCondition("sent is not null");
		
		return $this->count($criteria);
	}

}