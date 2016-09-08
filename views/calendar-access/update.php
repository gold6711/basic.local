<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CalendarAccess */

$this->title = Yii::t('app', 'Изменение записи доступа ') . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Доступ к событиям'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Изменение');
?>
<div class="calendar-access-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>