<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Calendar */

$this->title = Yii::t('app', 'Создать событие');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Календарь'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
