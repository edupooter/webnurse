<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedimentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procedimentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimento-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Incluir Procedimento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'N.',
            ],

            //'id',
            //'nomeId',
            [
                'label' => 'Procedimento',
                'attribute' => 'nomeId',
                'value' => 'nome.nome',
                'options' => ['style' => 'min-width:200px;'],
            ],
            //'situacaoId',
            [
                'label' => 'Situação',
                'attribute' => 'situacaoId',
                'value' => 'situacao.nome',
                'options' => ['style' => 'width:120px;'],
            ],
            //'salaId',
            [
                'label' => 'Local',
                'attribute' => 'salaId',
                'value' => 'sala.nome',
                'options' => ['style' => 'min-width:70px;'],
            ],
            //'responsavelId',
            // [
            //     'attribute' => 'responsavelId',
            //     'value' => 'responsavel.nome',
            // ],

            //'especialidadeId',
            // [
            //     'label' => 'Especialidade',
            //     'attribute' => 'especialidadeId',
            //     'value' => 'especialidade.nome',
            // ],
            //'inicio:datetime',
            [
                'label' => 'Início',
                'attribute' => 'inicio',
                'format' => ['datetime', 'php:d-m-Y H:i'],
                'options' => ['style' => 'min-width:125px;'],
                'filter' => DateTimePicker::widget([
                    // write model again
                    'model' => $searchModel,
                    // write attribute again
                    'attribute' => 'inicio',
                    'readonly' => true,
                    'layout' => '{picker}{input}{remove}',
                    'language' => 'pt',
                    'pluginOptions' => [
                        'todayHighlight' => true,
                    	'autoclose' => true,
                  	]
                ]),
            ],
            //'fimestimado:datetime',
            [
                'label' => 'Fim Estimado',
                'attribute' => 'fimestimado',
                'format' => ['datetime', 'php:d-m-Y H:i'],
                'options' => ['style' => 'min-width:125px;'],
                'filter' => DateTimePicker::widget([
                    // write model again
                    'model' => $searchModel,
                    // write attribute again
                    'attribute' => 'fimestimado',
                    'readonly' => true,
                    'layout' => '{picker}{input}{remove}',
                    'language' => 'pt',
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ],
                ]),
            ],
            //'fim:datetime',
            [
                'label' => 'Fim',
                'attribute' => 'fim',
                'format' => ['datetime', 'php:d-m-Y H:i'],
                'options' => ['style' => 'min-width:125px;'],
                'filter' => DateTimePicker::widget([
                    // write model again
                    'model' => $searchModel,
                    // write attribute again
                    'attribute' => 'fim',
                    'readonly' => true,
                    'layout' => '{picker}{input}{remove}',
                    'language' => 'pt',
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ],
                ]),
            ],
            [
                'label' => 'Contam.',
                'attribute' => 'contaminado',
                'value' => 'contaminado',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
