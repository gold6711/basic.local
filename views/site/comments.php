<?php
use yii\widgets\LinkPager;
?>
<h1>Комментарии</h1>
<p>Последний раз Вы смотрели профиль : <a href="<?=Yii::$app->urlManager->createUrl(['site/user', 'name' =>$name])?>"><?=$name ?></a></p>
<ul>
<?php foreach ($comments as $comment) { ?>
    <li><b><a href="<?=Yii::$app->urlManager->createUrl(['site/user', 'name' => $comment->name])?>"><?= $comment->name ?></a> :</b><?= $comment->text ?></li>
<?php } ?>
</ul>
<?= LinkPager::widget(['pagination' => $pagination]) ?>