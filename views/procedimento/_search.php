<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProcedimentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedimento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomeId') ?>

    <?= $form->field($model, 'situacaoId') ?>

    <?= $form->field($model, 'especialidadeId') ?>

    <?= $form->field($model, 'salaId') ?>

    <?= $form->field($model, 'responsavelId') ?>

    <?php // echo $form->field($model, 'inicio') ?>

    <?php // echo $form->field($model, 'fim') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
