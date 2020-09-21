<?php

use common\models\forms\AnswerForm;
use yii\web\View;
use yii\helpers\Html;

/* @var $this View */
/* @var $modelForm AnswerForm */

$this->title = 'Добавление';
$this->title = Yii::t('app','Добавление');
$this->params['breadcrumbs'][] = ['label' => 'Ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="model-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo $this->render('_form', [
        'modelForm' => $modelForm,
    ]);
    ?>

</div>
