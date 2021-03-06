<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <!--  ?= $form->field($model, 'nomeId')->textInput(['maxlength' => true]) ? -->

    <?= $form->field($model, 'nomeId')
        // ->dropDownList(ArrayHelper::map(ProcedimentoLt::find()->select(['nome','id'])->all(), 'id', 'nome'),
        ->dropDownList(ArrayHelper::map($model->procedimentosLt, 'id', 'nome'),
        ['prompt'=>'Selecione...']
        ) ?>

    <?= $form->field($model, 'situacaoId')
        ->dropDownList(ArrayHelper::map($model->situacoes, 'id', 'nome')
        ) ?>

    <?= $form->field($model, 'especialidadeId')
        ->dropDownList(ArrayHelper::map($model->especialidades, 'id', 'nome'),
        ['prompt'=>'Selecione...']
        ) ?>

    <?= $form->field($model, 'salaId')
        ->dropDownList(ArrayHelper::map($model->salas, 'id', 'nome'),
        ['prompt'=>'Selecione...']
        ) ?>

    <!-- Exibe os nomes de todos os profissionais
    <//?= $form->field($model, 'responsavelId')
      ->dropDownList(ArrayHelper::map(Profissional::find()->select(['nome','id'])->all(), 'id', 'nome'),['prompt'=>'Selecione... ']) ?>
    -->

    <!-- Exibe apenas profissionais das categorias definidas como responsáveis por cirurgias -->
    <?= $form->field($model, "responsavelId")
        ->dropDownList(ArrayHelper::map($model->responsaveis, 'id', 'nome'),
        ['prompt' => 'Selecione...']
        ) ?>

    <?= $form->field($model, 'profissionais_ids')->widget(Select2::className(), [
        'model' => $model,
        'attribute' => 'profissionais_ids',
        //'data' => ArrayHelper::map(Profissional::find()->all(), 'nome', 'nome'),
        'data' => ArrayHelper::map($model->equipe, 'nome', 'nome'),
        'size' => Select2::MEDIUM,
        'options' => [
            'placeholder' => 'Digite aqui os nomes dos profissionais...',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'equipamentos_ids')->widget(Select2::className(), [
        'model' => $model,
        'attribute' => 'equipamentos_ids',
        // 'data' => ArrayHelper::map(Equipamento::find()->all(), 'nome', 'nome'),
        'data' => ArrayHelper::map($model->kitEquipam, 'nome', 'nome'),
        'size' => Select2::MEDIUM,
        'options' => [
            'placeholder' => 'Digite aqui os equipamentos utilizados...',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

  	<!-- //?= $form->field($model, 'inicio')->textInput() ?
    -->
  	<?= $form->field($model, 'inicio')->widget(DateTimePicker::classname(), [
  	    'name' => 'datetime_inicio',
        'options' => [
            'placeholder' => 'Data e hora de início',
            //'value' => Yii::$app->formatter->asDatetime($model->inicio),
      	],
  	    'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
  	    'layout' => '{picker}{input}{remove}',
  	    'readonly' => true,
        'language' => 'pt',
  	    //'convertFormat' => true,
  	    'pluginOptions' => [
  	         'todayHighlight' => true,
             'todayBtn' => true,
             'autoclose' => true,
             'language' => 'pt',
             //'format' => 'php:d-m-Y H:i:s',
  	         //'startDate' => date('d-m-Y h:i'),
  	         //'hoursDisabled' => '0,1,2,3,4,5,6,19,20,21,22',
             //'daysOfWeekDisabled' => '0,6',
  	         //'format' => 'dd-m-yyyy hh:i:s',
      	]
      ]); ?>

    <?= $form->field($model, 'fimestimado')->widget(DateTimePicker::classname(), [
        'name' => 'datetime_fimestimado',
        'options' => [
            'placeholder' => 'Previsão de encerramento',
            //'value' => Yii::$app->formatter->asDatetime($model->fimestimado),
        ],
        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
        'layout' => '{picker}{input}{remove}',
        'readonly' => true,
        'language' => 'pt',
        //'convertFormat' => true,
        'pluginOptions' => [
            'todayHighlight' => false,
            'todayBtn' => true,
            'autoclose' => true,
            //'format' => 'php:d-m-Y H:i:s',
        ]
    ]); ?>

    <?= $form->field($model, 'fim')->widget(DateTimePicker::classname(), [
        'name' => 'datetime_fim',
        'options' => [
            'placeholder' => 'Data e hora de fim',
            //'value' => Yii::$app->formatter->asDatetime($model->fim),
        ],
  	    'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
        'layout' => '{picker}{input}{remove}',
        'readonly' => true,
        'language' => 'pt',
        //'convertFormat' => true,
	      'pluginOptions' => [
  	        'todayHighlight' => false,
            'todayBtn' => true,
            'autoclose' => true,
            'language' => 'pt',
            //'format' => 'php:d-m-Y H:i:s',
      	]
    ]); ?>

    <?= $form->field($model, 'contaminado')->dropDownList([ 'Não' => 'Não', 'Sim' => 'Sim', ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Incluir' : 'Alterar',
          ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
