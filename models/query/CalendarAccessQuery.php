<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\CalendarAccess]].
 *
 * @see \app\models\CalendarAccess
 */
class CalendarAccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\CalendarAccess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\CalendarAccess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function whereUserOwner($ownerId)
    {
        return $this->andWhere('user_owner = :user_owner', ['user_owner' => $ownerId]);
    }


    public function whereUserGuest($guestId)
    {
        return $this->andWhere('user_guest = :user_guest', ['user_guest' => $guestId]);
    }


    public function whereDate($date)
    {
        return $this->andWhere('date = :date', ['date' => date_create($date)->format('Y-m-d')]);
    }
}
