<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\query\CalendarQuery;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property string $text
 * @property integer $creator
 * @property string $event_start
 * @property string $event_end
 */
class Calendar extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'creator'], 'required'],
            [['text'], 'string'],
            [['creator'], 'integer'],
            [['event_start', 'event_end'], 'safe'],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'creator' => Yii::t('app', 'Creator'),
            'event_start' => Yii::t('app', 'Event Start'),
            'event_end' => Yii::t('app', 'Event End'),
            'user_name' => Yii::t('app', 'CreatorID')
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }

    public function getDateTimeEventStart()
    {
        $date = new \DateTime($this->date_event_start);
        return $date->format('d/m/Y h:m');
    }


    public function getDateTimeEventEnd()
    {
        $date = new \DateTime($this->date_event_end);
        return $date->format('d/m/Y h:m');
    }

    /**
     * @inheritdoc
     * @return \app\models\query\CalendarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalendarQuery(get_called_class());
    }
}
