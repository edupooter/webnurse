<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Profissional */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profissional-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

    <!-- ?= ;$form->field($model, 'categoriaId')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'categoriaId')
      //->dropDownList(ArrayHelper::map(Categoria::find()->select(['nome','id'])->all(), 'id', 'nome'),['prompt'=>' '])
      ->dropDownList(ArrayHelper::map($model->categorias, 'id', 'nome'),
      ['prompt'=>'Selecione...']
      ) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Incluir' : 'Alterar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
