<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimento */

$this->title = $model->nome->nome;
$this->params['breadcrumbs'][] = ['label' => 'Procedimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimento-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este procedimento?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Restaurar', ['undelete', 'id' => $model->id],
            ['class' => 'btn btn-sucess']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'nomeId',
            [
                'attribute'=>'nomeId',
                'value'=>$model->nome->nome,
                'widgetOptions'=>[
                    //'data'=>ArrayHelper::map(ProcedimentoLt::find()->orderBy('nome')->select(['nome','id'])->all(), 'id', 'nome'),
                    'data'=>ArrayHelper::map($model->procedimentosLt, 'id', 'nome'),
                ]
            ],
            //'situacaoId',
            [
                'attribute'=>'situacaoId',
                'value'=>$model->situacao->nome,
                'widgetOptions'=>[
                    //'data'=>ArrayHelper::map(Situacao::find()->orderBy('nome')->select(['nome','id'])->all(), 'id', 'nome'),
                    'data'=>ArrayHelper::map($model->situacoes, 'id', 'nome'),
                ]
            ],
            //'salaId',
            [
                'attribute'=>'salaId',
                'value'=>$model->sala->nome,
                'widgetOptions'=>[
                    'data'=>ArrayHelper::map($model->salas, 'id', 'nome'),
                ]
            ],
            //'responsavelId',
            [
                'attribute'=>'responsavelId',
                'value'=>$model->responsavel->nome,
                'widgetOptions'=>[
                    'data'=>ArrayHelper::map($model->responsaveis, 'id', 'nome'),
                ]
            ],

            // // Não funciona, pois DetailView não serve para exibir múltiplos modelos relacionados
            // [
            //     'attribute'=>'profissionais_ids',
            //     'value'=>$model->equipe->nome,
            //     'widgetOptions'=>[
            //         'data' => ArrayHelper::map($model->equipe, 'nome', 'nome'),
            //     ]
            // ],

            // [
            //     'label'=>'Categoria do Responsável',
            //     'attribute'=>'responsavelId',
            //     'value'=>$model->responsavel->categoria->nome,
            //     'widgetOptions'=>[
            //         'data'=>ArrayHelper::map(Categoria::find()->orderBy('nome')->select(['nome','id'])->all(), 'id', 'nome'),
            //     ]
            // ],

            //'especialidadeId',
            [
                'attribute'=>'especialidadeId',
                'value'=>$model->especialidade->nome,
                'widgetOptions'=>[
                    'data'=>ArrayHelper::map($model->especialidades, 'id', 'nome'),
                ]
            ],

            'inicio:datetime',

            'fimestimado:datetime',

            'fim:datetime',

            'contaminado',

            'excluido:datetime',
        ],
    ]) ?>

</div>
