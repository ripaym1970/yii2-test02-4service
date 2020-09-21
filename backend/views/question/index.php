<?php

use common\models\Question;
use common\models\searchs\QuestionSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this View */
/* @var $searchModel QuestionSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Вопросы и варианты ответов';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="model-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-4 pr0 mt24">
            <?php
            echo Html::a('Добавить', ['create'], ['class' => 'btn btn-success mr5']);
            echo Html::a('Сбросить фильтры', ['index'], ['class' => 'btn btn-default']);
            ?>
        </div>
        <?php
        //echo $this->render('_search_new', ['filterModel' => $searchModel]);
        ?>
    </div>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '',
                        'headerOptions' => ['width' => '70', ],
                        'template' => '{view} {update}',
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function (Question $model) {
                            $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                            return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    //[
                    //    'value' => function (Question $model) {
                    //        return
                    //            Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id]) .
                    //            Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id]);
                    //    },
                    //    'format' => 'raw',
                    //    'contentOptions' => ['style' => 'text-align: center'],
                    //],
                    [
                        'attribute' => 'active',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::tag('span', Html::encode($data->active?'Да':'Нет'), ['class' => 'span-' . ($data->active?'success':'warning')]);
                        },
                        'headerOptions' => ['style' => 'min-width:75px', ],
                        'contentOptions' => ['align' => 'center', ],
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'active',
                            ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
                            ['class' => 'form-control', ]
                        ),
                    ],
                    //'active:boolean',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['style' => 'min-width:30px;width:30px;', ],
                        'template' => '{delete}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
