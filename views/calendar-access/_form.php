<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bootui\datetimepicker\Datepicker;

/* @var $this yii\web\View */
/* @var $model app\models\CalendarAccess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_guest')->textInput() ?>

    <?= $form->field($model, 'date')->widget(Datepicker::className(), [
        'options' => ['class' => 'form-control'],
        //'addon' => ['prepend' => 'Дата и время события'],
        'format' => 'YYYY-MM-DD',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Предоставить доступ') : Yii::t('app', 'Изменить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>