<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php if ($name) { ?>
    <p>Вы ввели имя: <b><?=$name?></b></p>
    <p>e-mail: <b><?=$email?></b></p>
    <p>и заказ: <b><?=$order?></b></p>
<?php } ?>

<?php $f = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?=$f->field($form, 'name'); ?>
    <?=$f->field($form, 'email'); ?>
    <?=$f->field($form, 'order'); ?>
    <?=$f->field($form, 'file')->fileInput(); ?>
    <?=Html::submitButton('Отправить'); ?>
<?php ActiveForm::end(); ?>