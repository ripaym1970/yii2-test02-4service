<?php

namespace common\models\repositories;

use common\models\Answer;
use common\models\dispatchers\EventDispatcher;
use common\models\repositories\events\EntityPersisted;
use common\models\repositories\events\EntityRemoved;
use RuntimeException;

class AnswerRepository
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function get($id): Answer
    {
        if (!$model = Answer::findOne($id)) {
            throw new NotFoundException('Answer is not found.');
        }
        return $model;
    }

    public function existsByBrand($id): bool
    {
        return Answer::find()->andWhere(['brand_id' => $id])->exists();
    }

    public function existsByMain($id): bool
    {
        return Answer::find()->andWhere(['category_id' => $id])->exists();
    }

    public function save(Answer $model): void
    {
        if (!$model->save()) {
            throw new RuntimeException('Answer. Saving errors.');
        }
        $this->dispatcher->dispatchAll($model->releaseEvents());
        $this->dispatcher->dispatch(new EntityPersisted($model));
    }

    public function remove(Answer $model): void
    {
        if (!$model->delete()) {
            throw new RuntimeException('Answer. Removing errors.');
        }
        $this->dispatcher->dispatchAll($model->releaseEvents());
        $this->dispatcher->dispatch(new EntityRemoved($model));
    }
}
