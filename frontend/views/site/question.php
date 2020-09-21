<?php

use common\models\forms\AnswerForm;
use common\models\Question;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

//use yii\captcha\Captcha;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model Question */
/* @var $models array */
/* @var $modelForm AnswerForm */

$this->title = 'Текущий опрос';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Текущий вопрос:
    </p>
    <p class="bold">
        <?= $model->name; ?>
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'answer-form']); ?>

            <?php
            echo $form->field($modelForm, 'question_id')
                ->radioList($models)
                ->label('Пожалуйста, выберите ваш ответ на вопрос.')
            ;
            ?>

            <?php
            echo $form->field($modelForm, 'respondent_comment')
                ->textInput(['autofocus' => true]);
            ?>
            <?php
            echo $form->field($modelForm, 'respondent_name');
            ?>

            <?php
            echo $form->field($modelForm, 'respondent_email');
            ?>

            <?php
            //echo $form->field($modelForm, 'verifyCode')
            //    ->widget(Captcha::class, [
            //    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            //]);
            ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
