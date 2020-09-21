<?php

namespace common\models\services;

use common\models\repositories\AnswerRepository;
use common\models\repositories\QuestionRepository;
use common\models\forms\QuestionForm;
use common\models\Question;
use DomainException;

class QuestionService {

    private $_questions;
    private $_answers;

    public function __construct(QuestionRepository $questions, AnswerRepository $answers) {
        $this->_questions = $questions;
        $this->_answers   = $answers;
    }

    public function create(QuestionForm $form): Question {
        $parent = $this->_questions->get($form->parentId);
        $model = Question::create($form);
        $model->appendTo($parent);
        $this->_questions->save($model);

        return $model;
    }

    /**
     * @param QuestionForm $form
     */
    public function edit(QuestionForm $form) {
        $model = $this->_questions->get($form->id);
        $this->assertIsNotRoot($model);
        $model->edit($form);
        if ($form->parentId !== $model->parent->id) {
            $parent = $this->_questions->get($form->parentId);
            $model->appendTo($parent);
        }
        $this->_questions->save($model);
    }

    public function moveUp($id): void {
        $model = $this->_questions->get($id);
        $this->assertIsNotRoot($model);
        if ($prev = $model->prev) {
            $model->insertBefore($prev);
        }
        $this->_questions->save($model);
    }

    public function moveDown($id): void {
        $model = $this->_questions->get($id);
        $this->assertIsNotRoot($model);
        if ($next = $model->next) {
            $model->insertAfter($next);
        }
        $this->_questions->save($model);
    }

    public function remove($id): void {
        $model = $this->_questions->get($id);
        $this->assertIsNotRoot($model);
        if ($this->_answers->existsByMain($model->id)) {
            throw new DomainException('Unable to remove question with answers.');
        }
        $this->_questions->remove($model);
    }

    private function assertIsNotRoot(Question $model): void {
        if ($model->isRoot()) {
            throw new DomainException('Unable to manage the root question.');
        }
    }
}
