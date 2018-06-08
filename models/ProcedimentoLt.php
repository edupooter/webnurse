<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedimento_lt".
 *
 * @property string $id
 * @property string $nome
 *
 * @property Procedimento[] $procedimentos
 */
class ProcedimentoLt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{procedimento_lt}}';
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
            [['nome'], 'string', 'max' => 50],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimentos()
    {
        return $this->hasMany(Procedimento::className(), ['nomeId' => 'id']);
    }
}
