<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $password
 * @property string $access_token
 * @property string $create_date
 */
class User extends ActiveRecord implements IdentityInterface
{
    const PASS_MIN_LENGTH = 5;
    const PASS_MAX_LENGTH = 255;
    const USERNAME_MAX_LENGTH = 128;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'password'], 'required'],
            [['create_date'], 'safe'],
            [['username'], 'string', 'max' => self::USERNAME_MAX_LENGTH],
            [['password'], 'string', 'min' => self::PASS_MIN_LENGTH, 'max' => self::PASS_MAX_LENGTH],
            [['username', 'access_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Логин'),
            'name' => Yii::t('app', 'Имя'),
            'surname' => Yii::t('app', 'Фамилия'),
            'password' => Yii::t('app', 'Пароль'),
            'access_token' => Yii::t('app', 'Ключ авторизации'),
            'create_date' => Yii::t('app', 'Дата регистрации'),
        ];
    }

    /**
     * Before save event handler
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->getIsNewRecord() && !empty($this->password)) {
                $this->access_token = Yii::$app->security->generateRandomString();
            }
            if (!empty($this->password)) {
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            } else {
                unset($this->password);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }


    /**
     * @inheritdoc
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }
}
