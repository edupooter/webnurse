<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProcedimentoLt;

/**
 * ProcedimentoLtSearch represents the model behind the search form about `app\models\ProcedimentoLt`.
 */
class ProcedimentoLtSearch extends ProcedimentoLt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProcedimentoLt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // define o limite de itens para a paginação
            'pagination' => [
                'pageSize' => 20,
            ],
            // define a ordem padrão
            'sort' => [
                'defaultOrder' => [
                    'nome' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', '[[nome]]', $this->nome]);

        return $dataProvider;
    }
}
