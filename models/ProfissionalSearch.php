<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Profissional;

/**
 * ProfissionalSearch represents the model behind the search form about `app\models\Profissional`.
 */
class ProfissionalSearch extends Profissional
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'categoriaId'], 'safe'],
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
        $query = Profissional::find();

                // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // join tabela categoria
        $query->joinWith('categoria');


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '[[id]]' => $this->id,
            //'categoriaId' => $this->categoriaId,
        ]);

        // filtra por nome de profissional ou nome da categoria
        $query->andFilterWhere(['like', '[[profissional.nome]]', $this->nome])
            ->andFilterWhere(['like', '[[categoria.nome]]', $this->categoriaId]);

        return $dataProvider;
    }
}
