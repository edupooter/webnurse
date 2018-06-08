<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Equipamento */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Equipamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipamento-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este equipamento?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Restaurar', ['undelete', 'id' => $model->id],
            ['class' => 'btn btn-sucess']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nome',
            'patrimonio',
            'operacional',
            'manutencao:date',
            'excluido:datetime',
        ],
    ]) ?>

</div>
