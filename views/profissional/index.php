<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use app\models\Categoria;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfissionalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profissionais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profissional-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Incluir Profissional', ['create'], ['class' => 'btn btn-success']) ?>
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
            //'categoriaId',

            [
                'attribute'=>'categoriaId',
                'value'=>'categoria.nome',
            ],
            
            'excluido:datetime',

            [
              'class' => 'yii\grid\ActionColumn',
              'header'=>'Ações',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
