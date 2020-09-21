<?php

use common\models\Question;

/* @var $this yii\web\View */
/* @var $modelForm Question */


$this->title = 'Добавление';
$this->params['breadcrumbs'][] = ['label' => 'Вопросы и варианты ответов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="model-create">

    <?= $this->render('_form', [
        'modelForm' => $modelForm,
    ]) ?>

</div>
