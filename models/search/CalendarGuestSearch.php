<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calendar;
use app\models\CalendarAccess;

/**
 * CalendarSearch represents the model behind the search form about `app\models\Calendar`.
 */


class CalendarGuestSearch extends Calendar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator'], 'integer'],    /////////////////   creatorId   /////////
            [['text', 'event_start'], 'safe'],                  //////////////////////////   event_start ? //////////
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {

        return Model::scenarios();
    }

    public function searchGuest($params)
    {
        $query = Calendar::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $owner = $this->creator;              ////////////////////  creatorId = creator ////////////////////////////////
        $guest = \Yii::$app->user->id;
        $date = $this->event_start;

//        $guestAccess = CalendarAccess::find()
//            ->whereDate($date)
//            ->whereOwner($owner)
//            ->whereGuest($guest)->all();

        $guestAccess = CalendarAccess::find()
            ->whereUserGuest($guest);

        if(isset($owner) && $owner != '') {
            $guestAccess->whereUserOwner($owner);
        }

        if(isset($date) && $date != '') {
            $guestAccess->whereDate($date);
        }


        foreach ($guestAccess->all() as $access) {
            $query->orFilterWhere([
                'id' => $this->id,
                'creator' => $access->user_owner,      ////////////////////   creatorId  ownerId    ///////////////////
                'CAST(event_start AS DATE)' => $access->date
            ]);
        }

        if (empty($guestAccess)) {
            $query->where('0 = 1');
        }


        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}