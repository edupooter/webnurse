<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profissional".
 *
 * @property string $id
 * @property string $nome
 * @property string $categoriaId
 *
 * @property ProcedimentoProfissional[] $procedimentoprofissional
 * @property Procedimento[] $procedimentos
 * @property Categoria $categoria
 */
class Profissional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profissional';
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
            [['nome', 'categoriaId'], 'required'],
            [['categoriaId'], 'integer'],
            [['nome'], 'string', 'max' => 50],
            [['nome'], 'unique'],
            [['nome'], 'trim'],
            [['categoriaId'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoriaId' => 'id']],

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
            'categoriaId' => 'Categoria Profissional',
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

    public static function getProfissionalPeloNome($nome)
    {
        $profissional = Profissional::find()->where(['nome' => $nome])
            ->one();
        // if (!$profissional) {
        //     $profissional = new Profissional();
        //     $profissional->nome = $nome;
        //     $profissional->save(false);
        // }
        return $profissional;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimentoProfissional()
    {
        return $this->hasMany(ProcedimentoProfissional::className(), ['profissionalId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimentos()
    {
        return $this->hasMany(Procedimento::className(), ['responsavelId' => 'id']);
    }

    // Para popular o dropDownList do form
    public function getCategorias()
    {
        return Categoria::find()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoriaId']);
    }

    public function getCategoriaNome()
    {
        return $this->Categoria->nome;
    }

    /* public function getProcedimentos()
    {
        return $this->hasMany(Procedimento::className(), ['id' => 'procedimentoId'])
            ->viaTable('ProcedimentoProfissional', ['profissionalId' => 'id']);
    } */

    /* public function getNomeAmostra()
    {
        $categ = $this->getCategoriaNome();
        return $this->nome.' - '.$categ;
    } */

}
