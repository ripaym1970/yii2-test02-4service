<?php

namespace common\models\listeners;

use common\models\Question;
use common\models\repositories\events\EntityPersisted;
use yii\caching\Cache;
use yii\caching\TagDependency;

class QuestionPersistenceListener
{
    private $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function handle(EntityPersisted $event): void
    {
        if ($event->entity instanceof Question) {
            TagDependency::invalidate($this->cache, ['questions']);
        }
    }
}
