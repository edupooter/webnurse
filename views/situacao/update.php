<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Situacao */

$this->title = 'Alterar Situação: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Situações', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Alterar';
?>
<div class="situacao-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
