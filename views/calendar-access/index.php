<?php

use yii\helpers\Html;
use yii\grid\GridView;
use bootui\datetimepicker\Datepicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CalendarAccessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Доступ к событиям');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-access-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Предоставить доступ к событиям'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([

        'dataProvider' => $ownerDataProvider = $searchModel->search(Yii::$app->request->queryParams),
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_guest',
            [
                'attribute' => 'date',
                'value' => 'date',
                'format' => 'date',
                'filter' => Datepicker::widget([
                        'name' => 'CalendarAccessSearch[date]',
                        'options' => ['class' => 'form-control'],
                        'value' => Yii::$app->getRequest()->get('CalendarAccessSearch')['date']
                    ]),
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
