<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Equipamento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

    <?= $form->field($model, 'patrimonio')->textInput() ?>

    <?= $form->field($model, 'operacional')->dropDownList([ 'Sim' => 'Sim', 'Não' => 'Não',]) ?>

    <?= $form->field($model, 'manutencao')->widget(DatePicker::classname(), [
            'name' => 'date_manutencao',
            'type' => DatePicker::TYPE_INLINE,
            'layout' => '{picker}{input}{remove}',
            'readonly' => true,
            'options' => ['placeholder' => 'Data de último envio para manutenção...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
                'autoclose' => true,
            ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Incluir' : 'Alterar', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
