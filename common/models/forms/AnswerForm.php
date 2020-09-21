<?php

namespace common\models\forms;

use common\models\Answer;
use yii\base\Model;

/**
 * This is the form class for model "common\models\Answer".
 *
 * @property int      $id
 * @property string   $respondent_name  Имя
 * @property string   $respondent_email E-mail
 * @property string   respondent_comment Комментарий
 * @property int      $question_id      Ответ
 * @property int      $created_at       Створено
 * @property int|null $updated_at       Змінено
 */
class AnswerForm extends Model {

    public $id;
    public $respondent_name;
    public $respondent_email;
    public $respondent_comment;
    public $question_id;
    public $created_at;
    public $updated_at;

    private $_model;

    public function __construct(Answer $model = null, $config = []) {
        if ($model) {
            $this->id = $model->id;
            $this->respondent_name    = $model->respondent_name;
            $this->respondent_email   = $model->respondent_email;
            $this->respondent_comment = $model->respondent_comment;
            $this->question_id        = $model->question_id;
            $this->created_at         = $model->created_at;
            $this->updated_at         = $model->updated_at;

            $this->_model = $model;
        }

        parent::__construct($config);
    }

    public function rules(): array {
        return [
            [['respondent_name', 'respondent_email', 'question_id',], 'required'],

            [['question_id', 'question_id',], 'integer'],
            [['respondent_name',], 'safe'],
            [['respondent_email'], 'email'],
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
}
