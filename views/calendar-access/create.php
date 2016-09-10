<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CalendarAccess */

$this->title = Yii::t('app', 'Create Calendar Access');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Calendar Accesses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-access-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
