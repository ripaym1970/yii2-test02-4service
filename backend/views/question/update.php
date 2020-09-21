<?php

use common\models\forms\QuestionForm;
use yii\web\View;

/* @var $this View */
/* @var $modelForm QuestionForm */

$this->title = 'Редактирование: ' . $modelForm->name;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы и варианты ответов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelForm->name, 'url' => ['view', 'id' => $modelForm->id]];
$this->params['breadcrumbs'][] = 'Редактирование';

?>

<div class="model-update">

    <?= $this->render('_form', [
        'modelForm' => $modelForm,
    ]) ?>

</div>
