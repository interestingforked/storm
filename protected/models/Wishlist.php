<?php

/**
 * This is the model class for table "wishlist".
 *
 * The followings are the available columns in table 'wishlist':
 * @property string $id
 * @property integer $user_id
 * @property string $key
 * @property string $title
 * @property string $email
 * @property string $created
 */
class Wishlist extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'wishlist';
    }

    public function rules() {
        return array(
            array('user_id, key', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('key', 'length', 'max' => 32),
            array('title, email', 'length', 'max' => 250),
            array('id, user_id, key, title, email, created', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'items' => array(self::HAS_MANY, 'WishlistItem', 'wishlist_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'key' => 'Key',
            'title' => 'Title',
            'email' => 'Email',
            'created' => 'Created',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getByUserId($userId) {
        return $this->findByAttributes(array(
            'user_id' => $userId
        ));
    }
    
    public function findByWishlistKey($key) {
        return $this->findByAttributes(array('key' => $key));
    }

}