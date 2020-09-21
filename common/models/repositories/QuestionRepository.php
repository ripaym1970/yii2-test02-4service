<?php

namespace common\models\repositories;

use common\models\Question;
use common\models\dispatchers\EventDispatcher;
use common\models\repositories\events\EntityPersisted;
use common\models\repositories\events\EntityRemoved;
use RuntimeException;

class QuestionRepository {

    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    public function get($id): Question {
        if (!$model = Question::findOne($id)) {
            throw new NotFoundException('Question is not found.');
        }

        return $model;
    }

    public function save(Question $category): void {
        if (!$category->save()) {
            throw new RuntimeException('Question. Saving errors.');
        }
        $this->dispatcher->dispatch(new EntityPersisted($category));
    }

    public function remove(Question $category): void {
        if (!$category->delete()) {
            throw new RuntimeException('Question. Removing errors.');
        }
        $this->dispatcher->dispatch(new EntityRemoved($category));
    }
}
