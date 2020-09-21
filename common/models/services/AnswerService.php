<?php

namespace common\models\services;

use common\models\Answer;
use common\models\forms\AnswerForm;
use common\models\repositories\AnswerRepository;
use Exception;

class AnswerService {

    private $_models;
    private $transaction;

    public function __construct(AnswerRepository $model, TransactionManager $transaction) {
        $this->_models = $model;
        $this->transaction = $transaction;
    }

    /**
     * @param AnswerForm $form
     *
     * @return Answer
     * @throws Exception
     */
    public function create(AnswerForm $form): Answer {
        $model = new Answer();

        $model->respondent_name    = $form->respondent_name;
        $model->respondent_email   = $form->respondent_email;
        $model->respondent_comment = $form->respondent_comment;
        $model->question_id        = $form->question_id;

        $this->transaction->wrap(function () use ($model) {
            $this->_models->save($model);
        });

        return $model;
    }

    /**
     * @param AnswerForm $form
     *
     * @throws Exception
     */
    public function edit(AnswerForm $form): void {
        $model = $this->_models->get($form->id);

        $model->respondent_name    = $form->respondent_name;
        $model->respondent_email   = $form->respondent_email;
        $model->respondent_comment = $form->respondent_comment;
        $model->question_id        = $form->question_id;

        $this->transaction->wrap(function () use ($model) {
            $this->_models->save($model);
        });
    }

    /**
     * @param int $id
     */
    public function remove($id): void {
        $model = $this->_models->get($id);
        $this->_models->remove($model);
    }
}
