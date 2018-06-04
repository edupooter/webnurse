<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'value' => null]) ?>

    <!-- <//?= $form->field($model, 'authKey')->textInput(['maxlength' => true]) ?> -->

    <!-- <//?= $form->field($model, 'hospital')->textInput(['maxlength' => true]) ?> -->

    <?= $form->field($model, 'hospital')->radioList([
        'HCPA'=>'HCPA',
        'HDP'=>'HDP',
        'ICFUC'=>'ICFUC',
        'HMD'=>'HMD'
      ]);
    ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Incluir' : 'Alterar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

</div>
