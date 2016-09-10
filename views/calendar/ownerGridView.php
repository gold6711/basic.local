<?php

use yii\helpers\Html;
use yii\grid\GridView;
use bootui\datetimepicker\Datepicker;
use yii\helpers\StringHelper;


?>
<div class="owner-calendar">
    <br>
    <p>
        <?= Html::a(Yii::t('app', 'Создать событие'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Предоставить доступ к событиям', ['/calendar-access/create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $ownerDataProvider,
        'filterModel' => $searchOwnerModel,
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
            [
                'attribute' => 'event_start',
                'value' => 'event_start',
                'format' => 'datetime',
                'filter' => Datepicker::widget([
                        'name' => 'CalendarSearch[event_start]',
                        'options' => ['class' => 'form-control'],
                        'value' => Yii::$app->getRequest()->get('CalendarSearch')['event_start'],
                    ]),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
