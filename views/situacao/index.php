<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SituacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Situações (status de cirurgia)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="situacao-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Incluir Situação', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header'=>'N.',
            ],

            //'id',
            'nome',
            'excluido:datetime',

            [
              'class' => 'yii\grid\ActionColumn',
              'header'=>'Ações',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
