<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use common\models\Answer;

/**
 * AnswerSearch represents the model behind the search form about `common\models\Answer`.
 */
class AnswerSearch extends Model {

    public $id;
    public $respondent_name;
    public $respondent_email;
    public $question_id;
    public $created_at;
    public $updated_at;
    public $range_created_at;
    //public $reward_name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'question_id', 'created_at', 'updated_at'], 'integer'],
            [['respondent_name', 'respondent_email'], 'safe'],
            [['range_created_at',], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = static::getQueryList();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort' => [
            //    'defaultOrder' => ['self.id' => SORT_ASC],
            //],
            //'pagination' => ['pageSize' => false],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'self.id' => $this->id,
            'self.question_id' => $this->question_id,
            'self.created_at'  => $this->created_at,
            'self.updated_at'  => $this->updated_at,
        ]);

        if ($this->range_created_at) {
            [$d1, $d2] = explode(' - ', $this->range_created_at);
            //dd([strtotime($d1), strtotime($d2)]);
            $query->andFilterWhere([
                '>=', 'self.created_at', strtotime($d1)
            ]);
            $query->andFilterWhere([
                '<=', 'self.created_at', strtotime($d2)
            ]);
        }
        //dd($query);

        $query->andFilterWhere(['like', 'self.respondent_name', $this->respondent_name])
            ->andFilterWhere(['like', 'self.respondent_email', $this->respondent_email])
            //->andFilterWhere(['like', 're.name', $this->reward_name])
        ;

        return $dataProvider;
    }



    /**
     * @return ActiveQuery
     */
    public static function getQueryList() {
        return Answer::find()
            ->select([
                'self.*',
                //'reward_name'  => 'substring(re.name from 1 for 100)',
            ])
            ->alias('self')
            //->leftJoin(
            //    ['re' => Reward::tableName()],
            //    're.id = oro.reward_id'
            //)
            //->orderBy('oro.op_id')
        ;
    }
}
