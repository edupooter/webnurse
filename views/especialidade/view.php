<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Especialidade */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Especialidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="especialidade-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir esta especialidade?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Restaurar', ['undelete', 'id' => $model->id],
            ['class' => 'btn btn-sucess']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nome',
            'excluido:datetime',
        ],
    ]) ?>

</div>
