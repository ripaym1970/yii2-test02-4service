<?php

use common\models\forms\AnswerForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $modelForm AnswerForm */

?>

<div class="model-form">

    <?php
    $form = ActiveForm::begin();
    echo $form->errorSummary($modelForm);

    echo $form->field($modelForm, 'respondent_name')->textInput(['maxlength' => true]);
    echo $form->field($modelForm, 'respondent_email')->textInput(['maxlength' => true]);
    echo $form->field($modelForm, 'respondent_comment');
    echo $form->field($modelForm, 'question_id');
    ?>

    <div class="form-group">
        <?php
        echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
