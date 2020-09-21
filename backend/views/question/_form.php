<?php

use common\models\forms\QuestionForm;
use common\models\Question;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $modelForm QuestionForm */
/* @var $form ActiveForm */

$model = new Question();
$list = $model->parentList();

//var_dump($modelForm);
//exit;

?>

<div class="model-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
<!--        <div class="box-header with-border">Common</div>-->
        <div class="box-body">
            <?php
            echo $form->field($modelForm, 'parentId')
                ->dropDownList($list);
            ?>
            <?php
            echo $form->field($modelForm, 'name')
                ->textInput(['maxlength' => true]);
            ?>
            <?php
            echo $form->field($modelForm, 'active')
                ->checkbox();
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
