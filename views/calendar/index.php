<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use dosamigos\datetimepicker\DateTimepicker;
use yii\helpers\StringHelper;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchOwnerModel app\models\search\CalendarSearch */
/* @var $searchGuestModel app\models\search\CalendarGuestSearch */
/* @var $ownerDataProvider yii\data\ActiveDataProvider */
/* @var $guestDataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Календарь');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Мои события',
                'content' => Yii::$app->controller->renderPartial('ownerGridView', [
                        'searchOwnerModel' => $searchOwnerModel,
                        'ownerDataProvider' => $ownerDataProvider,
                    ]),
                'active' => true
            ],
            [
                'label' => 'Предоставленные события',
                'content' => Yii::$app->controller->renderPartial('guestGridView', [
                        'searchGuestModel' => $searchGuestModel,
                        'guestDataProvider' => $guestDataProvider,
                    ]),
            ],
        ]]);
    ?>
</div>
