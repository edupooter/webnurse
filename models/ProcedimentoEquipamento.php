<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedimento_equipamento".
 *
 * @property string $procedimentoId
 * @property string $equipamentoId
 *
 * @property Procedimento $procedimento
 * @property Equipamento $equipamento
 */
class ProcedimentoEquipamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procedimento_equipamento';
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
            [['procedimentoId', 'equipamentoId'], 'required'],
            [['procedimentoId', 'equipamentoId'], 'integer'],
            [['procedimentoId'], 'exist', 'skipOnError' => true, 'targetClass' => Procedimento::className(), 'targetAttribute' => ['procedimentoId' => 'id']],
            [['equipamentoId'], 'exist', 'skipOnError' => true, 'targetClass' => Equipamento::className(), 'targetAttribute' => ['equipamentoId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'procedimentoId' => 'Procedimento ID',
            'equipamentoId' => 'Equipamento ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimento()
    {
        return $this->hasOne(Procedimento::className(), ['id' => 'procedimentoId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipamento()
    {
        return $this->hasOne(Equipamento::className(), ['id' => 'equipamentoId']);
    }
}
