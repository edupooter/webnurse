<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Equipamento;

/**
 * EquipamentoSearch represents the model behind the search form about `app\models\Equipamento`.
 */
class EquipamentoSearch extends Equipamento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'patrimonio', 'operacional', 'manutencao'], 'safe'],
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
        $query = Equipamento::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'manutencao' => $this->manutencao,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
		      ->andFilterWhere(['like', 'operacional', $this->operacional])
		      ->andFilterWhere(['like', 'patrimonio', $this->patrimonio]);

        return $dataProvider;
    }

}
