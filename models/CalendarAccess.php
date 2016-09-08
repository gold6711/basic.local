<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\query\CalendarAccessQuery;
use app\controllers;
use dosamigos\datetimepicker\DateTimepicker;

/**
 * This is the model class for table "calendar_access".
 *
 * @property integer $id
 * @property integer $user_owner
 * @property integer $user_guest
 * @property string $date
 */
class CalendarAccess extends ActiveRecord
{
    const ACCESS_FORBIDDEN = 0;
    const ACCESS_CREATOR = 1;
    const ACCESS_GUEST = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_owner', 'user_guest', 'date'], 'required'],
            [['user_owner', 'user_guest'], 'integer'],
            [['date'], 'safe'],
            ['user_guest', 'compare', 'compareAttribute' => 'user_owner', 'operator' => '!=', 'message' => 'Нельзя предоставить доступ для своей учетной записи'],
            ['date', 'unique', 'targetAttribute' => ['user_guest', 'date'], 'message' => 'Доступ для этой учетной записи на эту дату уже предоставлен'],
            [['user_guest'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_guest' => 'id']],
            [['user_owner'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_owner' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_owner' => Yii::t('app', 'User Owner'),
            'user_guest' => Yii::t('app', 'User Guest'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGuest()
    {
        return $this->hasOne(User::className(), ['id' => 'user_guest']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_owner']);
    }

    /**
     * Check access for Calendar note
     *
     * @param Calendar $model
     * @return bool|int
     */
    public static function checkAccess($model)
    {
        $owner = $model->creator;
        $guest = \Yii::$app->user->id;
        $date = date_create($model->event_start)->format('Y-m-d');  //// date_event ->  date  /////

        if ($guest == $model->creator) {                        ///// user_owner   //////////
            return self::ACCESS_CREATOR;
        } else {
            $isGuest = self::find()
                ->whereDate($date)
                ->whereUserGuest($guest)
                ->whereUserOwner($owner)
                ->exists();
            return ($isGuest) ? self::ACCESS_GUEST : self::ACCESS_FORBIDDEN;
        }
    }

//    public static function checkIsCreator ($model)
//    {
//        return self::checkAccess($model) == self::ACCESS_CREATOR;
//    }

    public static function checkIsCreator($model)               //// isOwner -> checkIsCreator  ///////
    {
        return $model->user_owner === \Yii::$app->user->id;
    }



    /**
     * @inheritdoc
     * @return \app\models\query\CalendarAccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalendarAccessQuery(get_called_class());
    }
}
