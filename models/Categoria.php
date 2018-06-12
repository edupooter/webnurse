<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property string $id
 * @property string $nome Descrição da Categoria
 * @property string $responsavel Determina se a categoria pode ou não ser responsável por procedimentos
 *
 * @property Profissional[] $profissionals
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{categoria}}';
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
            [['nome'], 'string', 'max' => 40],
            [['nome'], 'unique'],
            [['nome'], 'trim'],
            [['nome', 'responsavel'], 'required'],
            [['responsavel'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Descrição da Categoria',
            'responsavel' => 'Responsável por Procedimentos',
            'excluido' => 'Excluído em',
        ];
    }

    public function behaviors()
    {
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
    public function getProfissionals()
    {
        return $this->hasMany(Profissional::className(), ['categoriaId' => 'id']);
    }

}
