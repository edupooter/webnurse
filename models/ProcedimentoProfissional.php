<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedimento_profissional".
 *
 * @property string $procedimentoId
 * @property string $profissionalId
 *
 * @property Procedimento $procedimento
 * @property Profissional $profissional
 */
class ProcedimentoProfissional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procedimento_profissional';
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
            [['procedimentoId', 'profissionalId'], 'required'],
            [['procedimentoId', 'profissionalId'], 'integer'],
            [['procedimentoId'], 'exist', 'skipOnError' => true, 'targetClass' => Procedimento::className(), 'targetAttribute' => ['procedimentoId' => 'id']],
            [['profissionalId'], 'exist', 'skipOnError' => true, 'targetClass' => Profissional::className(), 'targetAttribute' => ['profissionalId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'procedimentoId' => 'Procedimento ID',
            'profissionalId' => 'Profissional ID',
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
    public function getProfissional()
    {
        return $this->hasOne(Profissional::className(), ['id' => 'profissionalId']);
    }
}
