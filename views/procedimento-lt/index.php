<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcedimentoLtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de Procedimento';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimento-lt-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Incluir Tipo de Procedimento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
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
<?php Pjax::end(); ?></div>
