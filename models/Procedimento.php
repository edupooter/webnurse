<?php

namespace app\models;

use Yii;
use DateTime;
use DateInterval;
use yii\helpers\ArrayHelper;
use app\models\ProcedimentoSearch;
use app\models\Categoria;
use cornernote\linkall\LinkAllBehavior;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "procedimento".
 *
 * @property string $id
 * @property integer $parent_id
 * @property string $nomeId Descrição do Procedimento
 * @property string $situacaoId Situação da cirurgia
 * @property string $especialidadeId Especialidade Médica do procedimento
 * @property string $salaId Local do procedimento
 * @property string $responsavelId Profissional responsável pelo procedimento
 * @property string $inicio Data e hora de início da cirurgia
 * @property string $fim Data e hora de fim efetivo da cirurgia
 * @property string $fimestimado Data e hora de fim estimado da cirurgia
 * @property string $contaminado Procedimento contaminado
 *
 * @property ProcedimentoLt $nome
 * @property Especialidade $especialidade
 * @property Sala $sala
 * @property Profissional $responsavel
 * @property Situacao $situacao
 * @property ProcedimentoEquipamento[] $procedimentoEquipamentos
 * @property ProcedimentoProfissional[] $procedimentoProfissionals
 * @property Procedimento[] $subProcedimentos

 */
class Procedimento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $profissionais_ids;
    public $equipamentos_ids;

    public static function tableName()
    {
        return 'procedimento';
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
            [['nomeId', 'especialidadeId', 'salaId', 'responsavelId', 'situacaoId'], 'required'],
            //[['inicio', 'fimestimado', 'profissionais_ids', 'equipamentos_ids'], 'required'],
            [['nomeId', 'situacaoId', 'especialidadeId', 'salaId', 'responsavelId'], 'integer'],
            [['contaminado'], 'string'],
            //[['inicio', 'fim', 'fimestimado'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['inicio', 'fim', 'fimestimado', 'profissionais_ids', 'equipamentos_ids', 'contaminado'], 'safe'],
            [['salaId', 'inicio'], 'unique', 'targetAttribute' => ['salaId', 'inicio'],
                  'message' => 'Já existe outro procedimento marcado para esta sala neste horário.'],

            [['fim'], 'validaDatas', 'skipOnEmpty' => true],
            [['situacaoId'], 'definefim'],
            [['inicio', 'fimestimado'], 'validaDatasEstimado'],
            //[['inicio'], 'validaConflitoSalaHorario'],

            [['inicio', 'situacaoId', 'contaminado'], 'default'],
            [['nomeId'], 'exist', 'skipOnError' => true, 'targetClass' => ProcedimentoLt::className(), 'targetAttribute' => ['nomeId' => 'id']],
            [['situacaoId'], 'exist', 'skipOnError' => true, 'targetClass' => Situacao::className(), 'targetAttribute' => ['situacaoId' => 'id']],
            [['especialidadeId'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidade::className(), 'targetAttribute' => ['especialidadeId' => 'id']],
            [['salaId'], 'exist', 'skipOnError' => true, 'targetClass' => Sala::className(), 'targetAttribute' => ['salaId' => 'id']],
            [['responsavelId'], 'exist', 'skipOnError' => true, 'targetClass' => Profissional::className(), 'targetAttribute' => ['responsavelId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomeId' => 'Nome do Procedimento',
            'situacaoId' => 'Situação',
            'especialidadeId' => 'Especialidade',
            'salaId' => 'Sala',
            'responsavelId' => 'Responsável',
            'profissionais_ids' => 'Equipe de Profissionais',
            'equipamentos_ids' => 'Kit de Equipamentos',
            'inicio' => 'Início',
            'fim' => 'Fim',
            'fimestimado' => 'Fim estimado',
            'contaminado' => 'Contaminado?',
            'excluido' => 'Excluído em',
        ];
    }

    public function behaviors()
    {
        return [
            LinkAllBehavior::className(),
            [
                'class' => \cornernote\softdelete\SoftDeleteBehavior::className(),
                'attribute' => 'excluido',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public function validaDatas()
    {
        $agora = Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');
        if(strtotime($this->fim) < strtotime($this->inicio))// || strtotime($this->fim) < strtotime($agora))
        {
            //$this->addError('inicio','O início da cirurgia deve ser anterior ao fim da mesma.');
            $this->addError('fim','O fim deve ser posterior ao início do procedimento. Verifique a hora de início e fim.');
        }
    }

    public function validaDatasEstimado()
    {
        $agora = Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');
        if(strtotime($this->fimestimado) < strtotime($this->inicio))// || strtotime($this->fimestimado) < strtotime($agora))
        {
            $this->addError('fimestimado','O fim estimado deve ser posterior ao início do procedimento. Verifique a hora de início e fim estimado.');
        } //elseif (strtotime($this->fimestimado) < $agora) {
        //     $this->addError('fimestimado','O fim estimado deve ser posterior ao início do procedimento. Verifique a hora de início e fim estimado.');
        // }
    }

    public function definefim()
    {
        $agora = Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');

        switch ($this->situacaoId) {
            case (!empty($this->fim)):
                $this->situacaoId = 9;
                break;
            case ($this->situacaoId == 9) && (empty($this->fim)):
                $this->fim = $agora;
                break;
            case ($this->situacaoId == 7):
                $this->excluido = $agora;
                break;
            default:
                // echo "outra situacao ";
        }
    }

    // public function validaConflitoSalaHorario()
    // {
    //     // Consulta outros procedimentos na mesma sala e horário
    //     $conflito = Procedimento::find()
    //         ->select([
    // 		    'p1.id',
    // 		    'p1.salaId',
    //             'p1.inicio',
    // 		    'p1.fim',
    //             'p1.fimestimado',
    //             'p2.id as id2',
    //             'p2.nomeId as nomeId2',
    // 		    'p2.salaId as salaId2',
    //             'p2.inicio as inicio2',
    // 		    'p2.fim as fim2',
    //             'p2.fimestimado fimestimado2',
    //         ])
    //         ->from('procedimento p1')
    //         ->join('INNER JOIN', 'procedimento p2')
    //         ->where(['p1.id' => $this->id])
    //         ->andWhere(['=', 'p1.salaId', 'p2.salaId'])
    //         ->andWhere(['<>', 'p1.id', 'p2.id'])
    //         ->andWhere('
    //             p1.inicio
    //             BETWEEN p2.inicio AND p2.fim)
    //               OR (p1.fim
    //             BETWEEN p2.inicio AND p2.fim)
    //           	  OR (p1.inicio
    //             BETWEEN p2.inicio AND p2.fimestimado)
    //           	  OR (p1.fimestimado
    //             BETWEEN p2.inicio AND p2.fimestimado)
    //           	  OR (p1.fimestimado
    //             BETWEEN p2.inicio AND p2.fim)
    //           	  OR (p1.fim
    //             BETWEEN p2.inicio AND p2.fimestimado
    //         ')
    //         ->andWhere(['is', 'p2.excluido', null])
    //         ->one();
    //
    //     $cirurgiaconflito = ArrayHelper::toArray($conflito, [
    //         'app\models\Procedimento' => [
    //             'id2' => 'id',
    //             'nomeId2' => 'nomeId',
    //             'inicio2' => 'inicio',
    //             'fim2' => 'fim',
    //             'fimestimado2' => 'fimestimado',
    //         ],
    //     ]);
    //
    //     // echo('</br> --------- </br>');
    //     // var_dump($cirurgiaconflito);
    //
    //     $outroproced = ArrayHelper::getValue($cirurgiaconflito, 'id2');
    //     $outroprocednomeId = ArrayHelper::getValue($cirurgiaconflito, 'nomeId2');
    //     $outroprocedinicio = ArrayHelper::getValue($cirurgiaconflito, 'inicio2');
    //     $outroprocedfim = ArrayHelper::getValue($cirurgiaconflito, 'fim2');
    //     $outroprocedfimest = ArrayHelper::getValue($cirurgiaconflito, 'fimestimado2');
    //     // echo($outroproced.'</br>'.$outroprocednomeId.'</br>'.$outroprocedinicio.'</br>'.$outroprocedfim.'</br>'.$outroprocedfimest.'</br>');
    //     // die;
    //
    //     if($outroproced !== null)
    //     {
    //         $nomep = ProcedimentoLt::find()
    //             ->select('nome')
    //             ->where(['id' => $outroprocednomeId])
    //             ->scalar();
    //
    //         $ini = date("d-m-Y H:i", strtotime($outroprocedinicio));
    //         $fim = date("d-m-Y H:i", strtotime($outroprocedfim));
    //         $fimestimado = date("d-m-Y H:i", strtotime($outroprocedfimest));
    //
    //         $this->addError('salaId','Já está marcado nesta sala. Sugestão: escolha outra sala e tente novamente.');
    //         $this->addError('inicio','Outro procedimento inicia em: '.$ini);
    //         $this->addError('fimestimado','Outro procedimento está previsto para acabar em: '.$fimestimado);
    //
    //         if(!empty($fim))
    //         {
    //             $this->addError('fim','Outro procedimento encerrou em: '.$fim);
    //         }
    //     }
    // }

    public function duracaoEstimada()
    {
        //$nomeId = $params;

        $query = (new Query())
            ->select('avg(TIMESTAMPDIFF(MINUTE, [[inicio]], [[fim]]) DIV 60)*60 AS tempom')
            ->from('{{procedimento}}')
            ->where(['is not', '[[fim]]', null])
            ->andWhere(['is', '[[excluido]]', null])
            ->andWhere(['=', '[[nomeId]]', $this->nomeId])
            ->andWhere(['=', '[[responsavelId]]', $this->responsavelId])
            ->andWhere(['=', '[[especialidadeId]]', $this->especialidadeId])
            ->scalar();

        return $query;
    }

    public function kitEstimado($params)
    {
        $query = (new Query())
            ->select(['[[equipamento.nome]]'])
            ->from('{{procedimento}}')
            ->join('INNER JOIN', '{{profissional}}',
                '[[profissional.id]] = [[procedimento.responsavelId]]')
            ->join('INNER JOIN', '{{procedimento_equipamento}}',
                '[[procedimento_equipamento.procedimentoId]] = [[procedimento.id]]')
            ->join('INNER JOIN', '{{equipamento}}',
                '[[procedimento_equipamento.equipamentoId]] = [[equipamento.id]]')
            ->where(['is not', '[[procedimento.fim]]', null])
            ->andWhere(['is', '[[procedimento.excluido]]', null])
            ->andWhere(['=', '[[procedimento.nomeId]]', $this->nomeId])
            ->andWhere(['=', '[[procedimento.responsavelId]]', $this->responsavelId])
            ->andWhere(['=', '[[procedimento.especialidadeId]]', $this->especialidadeId])
            ->andWhere(['=', '[[equipamento.operacional]]', 'Sim'])
            ->groupBy(['[[equipamento.id]]'])
            ->all();

        return $query;
    }

    // public function preencheEquipamentos()
    // {
    //
    // }

    // Para popular o dropDownList do form
    public function getResponsaveis()
    {
        // return Profissional::find()
        //   ->where(['categoriaId'=>'3'])
        //   ->all();

        $query = (new \yii\db\Query())
            ->select([
                '[[profissional.id]]',
                '[[profissional.nome]]',
                '[[categoria.responsavel]]'
            ])
            ->from('{{profissional}}')
            ->join('INNER JOIN', '{{categoria}}',
                '[[profissional.categoriaId]] = [[categoria.id]]')
            ->where(['=', '[[categoria.responsavel]]', 'Sim'])
            ->andWhere(['is', '[[profissional.excluido]]', null])
            ->andWhere(['is', '[[categoria.excluido]]', null])
            ->orderBy('nome')
            ->all();

        return $query;
    }

    public function getEquipe()
    {
        return Profissional::find()
            ->where(['is', '[[excluido]]', null])
            ->orderBy('nome')
            ->all();
    }

    public function getKitEquipam()
    {
        return Equipamento::find()
            ->where(['[[operacional]]'=>'Sim'])
            ->andWhere(['is', '[[excluido]]', null])
            ->orderBy('nome')
            ->all();
    }

    public function getProcedimentoLtNome()
    {
        return $this->ProcedimentoLt->nome;
    }

    public function getSituacaoNome()
    {
        return $this->Situacao->nome;
    }

    public function getEspecialidadeNome()
    {
        return $this->Especialidade->nome;
    }

    public function getSalaNome()
    {
        return $this->Sala->nome;
    }

    public function getResponsavelNome()
    {
        return $this->Profissional->nome;
    }

    // Para popular o dropDownList do form
    public function getProcedimentosLt()
    {
        return ProcedimentoLt::find()->where(['is', '[[excluido]]', null])->orderBy('nome')->all();
    }

    public function getSituacoes()
    {
        return Situacao::find()->where(['is', '[[excluido]]', null])->all();
    }

    public function getEspecialidades()
    {
        return Especialidade::find()->where(['is', '[[excluido]]', null])->orderBy('nome')->all();
    }

    public function getSalas()
    {
        return Sala::find()->where(['is', '[[excluido]]', null])->orderBy('nome')->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsavel()
    {
        return $this->hasOne(Profissional::className(), ['id' => 'responsavelId']);
    }

    public function getProfissionais()
    {
        return $this->hasMany(Profissional::className(), ['id' => 'profissionalId'])
            ->viaTable('{{procedimento_profissional}}', ['procedimentoId' => 'id']);
    }

    public function getEquipamentos()
    {
        return $this->hasMany(Equipamento::className(), ['id' => 'equipamentoId'])
            ->viaTable('{{procedimento_equipamento}}', ['procedimentoId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimentoProfissional()
    {
        return $this->hasMany(ProcedimentoProfissional::className(), ['procedimentoId' => 'id']);
    }

	  /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedimentoEquipamento()
    {
        return $this->hasMany(ProcedimentoEquipamento::className(), ['equipamentoId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNome()
    {
        return $this->hasOne(ProcedimentoLt::className(), ['id' => 'nomeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialidade()
    {
        return $this->hasOne(Especialidade::className(), ['id' => 'especialidadeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSala()
    {
        return $this->hasOne(Sala::className(), ['id' => 'salaId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSituacao()
    {
        return $this->hasOne(Situacao::className(), ['id' => 'situacaoId']);
    }

    /**
     * {@inheritdoc}
     * @return ProcedimentoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProcedimentoQuery(get_called_class());
    }

    // function converterHorasMins($tempom, $formato = '%02d:%02d') {
    //     if ($tempom < 1) { return; }
    //     $horas = floor($tempom / 60);
    //     $minutos = ($tempom % 60);
    //     return sprintf($formato, $horas, $minutos);
    // }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            // Preenche o campo Fim Estimado somando a duração média ao início
            $agora = Yii::$app->formatter->asDateTime('now', 'php:Y-m-d H:i:s');
            if ($this->inicio == null)
            {
                $this->inicio = $agora;
            }
            if ($this->fimestimado == null)
            {
                $duracao = Procedimento::duracaoEstimada();
                if ($duracao == null)
                {
                    $duracao = 60;
                }
                $minutos = round($duracao);
                // $duracaohm = $this->converterHorasMins($duracao, '%02d:%02d');
                $datetime = new DateTime($this->inicio);
                // echo $datetime->format('Y-m-d H:i:s');
                $datetime->modify('+'.$minutos.' minute');
                $this->fimestimado = $datetime->format('Y-m-d H:i:s');
                // echo(' - '.$minutos.' | '.$this->inicio.' | '.$this->fimestimado.' | '.$datetime->format('Y-m-d H:i:s'));die;
            }

            // Preenche o Kit de Equipamentos com os equipamentos mais utilizados por procedimento e responsasável
            if (empty($this->equipamentos_ids))
            {
                $equipamentos = [];

                $this->equipamentos_ids = Procedimento::kitEstimado($this->nomeId, $this->responsavelId);

                function secure_iterable2($var)
                {
                    return is_iterable($var) ? $var : array();
                }
                foreach (secure_iterable2($this->equipamentos_ids) as $nome)
                {
                    $equipamento = Equipamento::getEquipamentoPeloNome($nome);
                    if ($equipamento)
                    {
                        $equipamentos[] = $equipamento;
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        // Mantém as tabelas de junção
        $profissionais = [];
        $equipamentos = [];

        function secure_iterable($var)
        {
            return is_iterable($var) ? $var : array();
        }
        foreach (secure_iterable($this->profissionais_ids) as $nome)
        {
            $profissional = Profissional::getProfissionalPeloNome($nome);
            if ($profissional)
            {
                $profissionais[] = $profissional;
            }
        }
        foreach (secure_iterable($this->equipamentos_ids) as $nome)
        {
            $equipamento = Equipamento::getEquipamentoPeloNome($nome);
            if ($equipamento)
            {
                $equipamentos[] = $equipamento;
            }
        }

        $this->linkAll('profissionais', $profissionais);
        $this->linkAll('equipamentos', $equipamentos);
        parent::afterSave($insert, $changedAttributes);
    }

}
