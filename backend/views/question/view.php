<?php

use common\models\Question;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Question */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы и варианты ответов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="model-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php
    echo Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data'  => [
            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
            'method'  => 'post',
        ],
    ]);
    ?>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'active:boolean',
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d.m.Y H:i'],
                        'headerOptions' => ['style' => 'min-width:70px;width:70px;', ],
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:d.m.Y H:i'],
                        'headerOptions' => ['style' => 'min-width:70px;width:70px;', ],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
