<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimento */

$this->title = 'Alterar Procedimento: ' . $model->nome->nome;
$this->params['breadcrumbs'][] = ['label' => 'Procedimentos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Alterar';
?>
<div class="procedimento-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
