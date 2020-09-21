<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\traits\EventTrait;

/**
 * This is the model class for table "answer".
 *
 * @property int      id
 * @property string   respondent_name  Имя
 * @property string   respondent_email E-mail
 * @property string   respondent_comment Комментарий
 * @property int      question_id      Ответ
 * @property int      created_at       Створено
 * @property int|null updated_at       Змінено
 *
 * @property Question question
 */
class Answer extends ActiveRecord {

    use EventTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'answer';
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['respondent_name', 'respondent_email', 'question_id',], 'required'],

            [['question_id',], 'integer'],
            [['respondent_name', 'respondent_email'], 'string', 'max' => 255],
            [['respondent_comment',], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id'                 => 'ID',
            'respondent_name'    => 'Имя',
            'respondent_email'   => 'E-mail',
            'respondent_comment' => 'Комментарий',
            'question_id'        => 'Ответ',
            'created_at'         => 'Создано',
            'updated_at'         => 'Изменено',
        ];
    }

    /**
     * Вопрос к ответу
     *
     * @return ActiveQuery
     */
    public function getQuestion(): ActiveQuery {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }
}
