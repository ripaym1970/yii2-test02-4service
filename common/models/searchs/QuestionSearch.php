<?php

namespace common\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use common\models\Question;

/**
 * QuestionSearch represents the model behind the search form about `common\models\Question`.
 */
class QuestionSearch extends Model {

    public $id;
    public $name;
    public $description;
    public $active;
    public $created_at;
    public $updated_at;
    //public $reward_name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'active', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description'], 'safe'],
            //[['reward_name',], 'safe'],
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
            'self.active' => $this->active,
            'self.created_at' => $this->created_at,
            'self.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'self.name', $this->name])
            ->andFilterWhere(['like', 'self.description', $this->description])
            //->andFilterWhere(['like', 're.name', $this->reward_name])
        ;

        return $dataProvider;
    }



    /**
     * @return ActiveQuery
     */
    public static function getQueryList() {
        return Question::find()
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
