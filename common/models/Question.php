<?php

namespace common\models; //\Question
use common\models\forms\QuestionForm;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "question".
 *
 * @property int         $id
 * @property string      $name        Вопрос
 * @property int         $active      Активно
 * @property int         $created_at  Створено
 * @property int|null    $updated_at  Змінено
 *
 * @property Question   $parent
 * @property Question[] $parents
 * @property Question[] $children
 * @property Question   $prev
 * @property Question   $next
 *
 * @mixin NestedSetsBehavior
 */
class Question extends ActiveRecord {

    //public $parentId;
    //
    //public function __construct(Question $category = null, $config = []) {
    //    if ($category) {
    //        $this->name = $category->name;
    //        $this->parentId = $category->parent ? $category->parent->id : null;
    //    }
    //    parent::__construct($config);
    //}

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'question';
    }

    /**
     * @return array
     */
    public function behaviors(): array {
        return [
            // При добавлении записи задается только created_at, а при редактировании только updated_at
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            NestedSetsBehavior::class,
        ];
    }

    public function transactions(): array {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    //public function rules(): array {
    //    return [
    //        [['name',], 'required'],
    //
    //        [['name',], 'unique'],
    //        [['parentId'], 'integer'],
    //        [['name',], 'string', 'max' => 255],
    //        [['description'], 'string'],
    //    ];
    //}

    public function parentList(): array {
        return ArrayHelper::map(Question::find()->orderBy('lft')->asArray()->all(), 'id', function (array $model) {
            return ($model['depth'] > 1 ? str_repeat('-- ', $model['depth'] - 1) . ' ' : '') . $model['name'];
        });
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id'          => 'ID',
            'name'        => 'Вопрос/Вариант ответа',
            'active'      => 'Активно',
            'created_at'  => 'Создано',
            'updated_at'  => 'Изменено',
        ];
    }

    /**
     * Все ответы
     *
     * @return ActiveQuery
     */
    public function getAnswers(): ActiveQuery {
        return $this->hasMany(Answer::class, ['question_id' => 'id']);
    }

    public static function create(QuestionForm $modelForm): self {
        $model = new static();
        $model->name        = $modelForm->name;
        $model->description = $modelForm->description;
        $model->active      = true;

        return $model;
    }

    public function edit(QuestionForm $modelForm): void {
        $this->name        = $modelForm->name;
        $this->description = $modelForm->description;
        $this->active      = $modelForm->active;
    }
}
