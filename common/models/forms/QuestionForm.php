<?php

namespace common\models\forms;

use common\models\Question;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * This is the form class for model "common\models\Question".
 *
 * @property int         $id
 * @property string      $name        Вопрос
 * @property string|null $description Описание
 * @property int         $active      Активно
 * @property int         $created_at  Створено
 * @property int|null    $updated_at  Змінено
 *
 * @property int|null    $parentId
 * @property Question    $_question
 */
class QuestionForm extends Model {

    public $id;
    public $name;
    public $description;
    public $active;
    public $parentId;

    private $_question;

    public function __construct(Question $question = null, $config = []) {
        if ($question) {
            $this->id          = $question->id;
            $this->name        = $question->name;
            $this->description = $question->description;
            $this->active      = $question->active;
            $this->parentId    = $question->parent ? $question->parent->id : null;

            $this->_question   = $question;
        }
        parent::__construct($config);
    }

    public function rules(): array {
        return [
            [['name',], 'required'],
            [['name',], 'unique',],
            [['parentId'], 'integer'],
            [['name',], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id'          => 'ID',
            'name'        => 'Вопрос/Вариант ответа',
            'description' => 'Описание',
            'active'      => 'Активно',
            'created_at'  => 'Создано',
            'updated_at'  => 'Изменено',
        ];
    }

    public function parentList(): array {
        return ArrayHelper::map(Question::find()->orderBy('lft')->asArray()->all(), 'id', function (array $question) {
            return ($question['depth'] > 1 ? str_repeat('-- ', $question['depth'] - 1) . ' ' : '') . $question['name'];
        });
    }
}
