<?php

use common\models\forms\AnswerForm;
use yii\web\View;
use yii\helpers\Html;

/* @var $this View */
/* @var $modelForm AnswerForm */

$this->title = 'Редактирование';
$this->title = Yii::t('app','Редактирование');
$this->params['breadcrumbs'][] = ['label' => 'Ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelForm->id, 'url' => ['view', 'id' => $modelForm->id]];
$this->params['breadcrumbs'][] = 'Редактирование';

?>

<div class="model-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo $this->render('_form', [
        'modelForm' => $modelForm,
    ]);
    ?>

</div>
