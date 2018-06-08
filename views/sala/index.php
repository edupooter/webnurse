<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salas Cirúrgicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sala-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Incluir Sala', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
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
