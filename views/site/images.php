<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$gridColumns = [
    [
        'attribute' => 'name',
        'format' => 'raw',
        'value'=>function ($data) {
            return Html::a(Html::encode("$data->name"),"/web/$data->source");},
        'label' => 'Название',
    ],
    [
        'attribute' => 'datetime',
        'format' => 'text',
        'label' => 'Дата загрузки',
    ],
    [
        'attribute' => 'source',
        'format' => 'html',
        'value'=>function ($data) {
            return Html::img("/web/$data->source", ['width' => '150px']);
        },
        'label' => 'Превью',
    ],

];
?>

<h4 style="margin-top: 40px">Загрузка и просмотр изображений</h4>
<div style="margin-top: 40px">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?= Html::submitButton('Отправить', [
        'class' => 'btn btn-primary',
        'name'=>"action",
        'value'=>"clear"]) ?>

    <?php ActiveForm::end() ?>
</div>
<div style="margin-top: 40px">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]) ?>
</div>