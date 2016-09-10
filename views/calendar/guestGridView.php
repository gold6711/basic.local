<?php

use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\grid\ActionColumn;
use bootui\datetimepicker\Datepicker;

?>
<div class="owner-calendar">
    <br>
    <?= GridView::widget([
        'dataProvider' => $guestDataProvider,
        'filterModel' => $searchGuestModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'text',
                'format' => 'text',
                'value' => function ($model) {
                        return StringHelper::truncate($model->text, 75);
                    }
            ],
            'creator',
            [
                'attribute' => 'event_start',
                'value' => 'event_start',
                'format' => 'datetime',
                'filter' => Datepicker::widget([
                        'name' => 'CalendarGuestSearch[event_start]',
                        'options' => ['class' => 'form-control'],
                        'value' => Yii::$app->getRequest()->get('CalendarGuestSearch')['event_start']
                    ]),
            ],
            [
                'class' => ActionColumn::className(),
                'buttons' => [
                    'update' => function () {
                            return false;
                        },
                    'delete' => function () {
                            return false;
                        },
                ],
            ],
        ],
    ]); ?>

</div>