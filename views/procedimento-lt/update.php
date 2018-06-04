<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcedimentoLt */

$this->title = 'Alterar Tipo de Procedimento: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Procedimento', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Alterar';
?>
<div class="procedimento-lt-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
