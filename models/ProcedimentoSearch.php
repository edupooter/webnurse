<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Procedimento;

/**
 * ProcedimentoSearch represents the model behind the search form of `app\models\Procedimento`.
 */
class ProcedimentoSearch extends Procedimento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nomeId', 'situacaoId', 'especialidadeId', 'salaId', 'responsavelId', 'inicio', 'fim', 'fimestimado', 'contaminado'], 'safe'],
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
        $query = Procedimento::find()->where(['is', '[[procedimento.excluido]]', null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // define o limite de itens para a paginação
            'pagination' => [
                'pageSize' => 20,
            ],
            // define a ordem padrão pela data de início do mais antigo para o mais recente
            'sort' => [
                'defaultOrder' => [
                    'inicio' => SORT_ASC,
                ]
            ],
        ]);

        // join tabelas pelo atributo da classe
        $query->innerjoinWith('nome');
        $query->innerjoinWith('situacao');
        $query->innerjoinWith('especialidade');
        $query->innerjoinWith('sala');
        $query->innerjoinWith('responsavel');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '[[id]]' => $this->id,
            //'nomeId' => $this->nomeId,
            //'especialidadeId' => $this->especialidadeId,
            //'salaId' => $this->salaId,
            //'responsavelId' => $this->responsavelId,
            //'inicio' => $this->inicio,
            //'fim' => $this->fim,
        ]);

        // filtra pela descrição da coluna: tipo, tabela.coluna, objeto->chave
        $query->andFilterWhere(['like', '[[procedimento_lt.nome]]', $this->nomeId])
              ->andFilterWhere(['like', '[[situacao.nome]]', $this->situacaoId])
              ->andFilterWhere(['like', '[[especialidade.nome]]', $this->especialidadeId])
              ->andFilterWhere(['like', '[[sala.nome]]', $this->salaId])
              ->andFilterWhere(['like', '[[profissional.nome]]', $this->responsavelId])
              ->andFilterWhere(['>=', '[[inicio]]', $this->inicio])
              ->andFilterWhere(['<=', '[[fim]]', $this->fim])
              ->andFilterWhere(['<=', '[[fimestimado]]', $this->fimestimado])
              ->andFilterWhere(['like', '[[contaminado]]', $this->contaminado])
              ->andFilterWhere(['is', '[[excluido]]', null]);

        return $dataProvider;
    }

}
