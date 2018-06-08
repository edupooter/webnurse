<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipamento".
 *
 * @property string $id
 * @property string $nome
 * @property string $operacional Define se o equipamento está disponível para cirurgias
 * @property string $manutencao Último envio para manutenção
 * @property string $patrimonio Número de patrimônio do equipamento
 * @property ProcedimentoEquipamento[] $procedimentoequipamento
 * @property Procedimento[] $procedimentos
 */
class Equipamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{equipamento}}';
    }

    public static function getDb() {
        //return Yii::$app->get('hcpa');
        return Yii::$app->get(Yii::$app->user->identity->hospital);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 40],
            [['nome'], 'trim'],
            [['patrimonio'], 'string', 'max' => 20],
            [['patrimonio'], 'unique'],
            [['patrimonio'], 'trim'],
            [['operacional'], 'string'],
            [['operacional', 'manutencao'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome do Equipamento',
            'patrimonio' => 'Número de Patrimônio',
            'operacional' => 'Está operacional?',
            'manutencao' => 'Último envio para manutenção',
            'excluido' => 'Excluído em',
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => \cornernote\softdelete\SoftDeleteBehavior::className(),
                'attribute' => 'excluido',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public static function getEquipamentoPeloNome($nome)
    {
        $equipamento = Equipamento::find()
            ->where(['nome' => $nome])
            ->andWhere(['is', '[[excluido]]', null])
            ->one();
        // if (!$equipamento) {
        //     $equipamento = new Equipamento();
        //     $equipamento->nome = $nome;
        //     $equipamento->save(false);
        // }
        return $equipamento;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimentoEquipamento()
    {
        return $this->hasMany(ProcedimentoEquipamento::className(), ['equipamentoId' => 'id']);
    }

}
