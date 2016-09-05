<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\query\CalendarQuery;

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
        return $this->hasMany(User::className(), ['id' => 'user_guest']);
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
        if ($model->creator == Yii::$app->user->id){
            return self::ACCESS_CREATOR;
        }

        $accessCalendar = self::find()
            ->whereUserGuest(Yii::$app->user->id)
            ->whereDate($model->getDateTimeEventStart())
            ->exists();

        if ($accessCalendar)
            return self::ACCESS_GUEST;

        return false;
    }

    /**
     * Check logged user is creator or not
     *
     * @param Calendar $model
     * @return bool
     */
    public static function checkIsCreator ($model)
    {
        return self::checkAccess($model) == self::ACCESS_CREATOR;
    }


    /**
     * @inheritdoc
     * @return \app\models\query\CalendarAccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CalendarAccessQuery(get_called_class());
    }
}
