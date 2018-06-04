<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especialidade".
 *
 * @property string $id
 * @property string $nome
 *
 * @property Procedimento[] $procedimentos
 */
class Especialidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'especialidade';
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
            [['nome'], 'string', 'max' => 22],
            [['nome'], 'unique'],
            [['nome'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimentos()
    {
        return $this->hasMany(Procedimento::className(), ['especialidadeId' => 'id']);
    }
}
