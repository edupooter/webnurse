<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipamentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Equipamentos Cirúrgicos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipamento-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Incluir Equipamento', ['create'], ['class' => 'btn btn-success']) ?>
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
            'patrimonio',
            'operacional',

            [
                'label'=>'Enviado para manutenção',
                'attribute' => 'manutencao',
                'format' => ['date', 'php:d-m-Y'],
                'filter' => DatePicker::widget([
                    // write model again
                    'model' => $searchModel,
                    // write attribute again
                    'attribute' => 'manutencao',
                    'readonly' => true,
                    'layout' => '{picker}{input}{remove}',
                    'pluginOptions' => [
                        'todayHighlight' => true,
                    	'autoclose' => true,
                  	]
                ]),
            ],

            'excluido:datetime',

            [
              'class' => 'yii\grid\ActionColumn',
              'header'=>'Ações',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
