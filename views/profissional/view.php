<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
// use app\models\Categoria;

/* @var $this yii\web\View */
/* @var $model app\models\Profissional */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Profissionais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profissional-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este profissional?',
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
            [
                'attribute'=>'categoriaId',
                'value'=>$model->categoria->nome,
                'widgetOptions'=>[
                    // 'data'=>ArrayHelper::map(Categoria::find()->orderBy('nome')->select(['nome','id'])->all(), 'id', 'nome'),
                    'data'=>ArrayHelper::map($model->categorias, 'id', 'nome'),
                ]
            ],            
            'excluido:datetime',
          ]
    ]) ?>

</div>
