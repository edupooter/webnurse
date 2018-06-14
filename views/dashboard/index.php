<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $provider yii\data\ArrayDataProvider */

$hoje = Yii::$app->formatter->asDateTime('now', 'php: d/m/Y');
$fimdodia = Yii::$app->formatter->asDateTime('now', 'php: Y-m-d 23%3A59');
$fimestimado = '?ProcedimentoSearch[fimestimado]='.$fimdodia;

$this->title = 'Painel - Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Procedimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h3><?= Html::encode($this->title) ?></h3>

    <div>
        <?= Html::a('Atualizar', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

	<div class="content">
		<div class="container-fluid">
			<div class="row">

				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header" data-background-color="blue">
                            <i class="material-icons">today</i>
						</div>
						<div class="card-content">
							<p class="category">Para hoje</p>
							<h3 class="title">
                                <?= Html::encode("{$marcados}") ?>
                            </h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">today</i>
                  <label>
                    <a href=<?= $url=Url::to(['procedimento/index']) ?>>Marcações de <?= $hoje ?></a>
                  </label>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header" data-background-color="orange">
							<i class="material-icons">directions_run</i>
						</div>
						<div class="card-content">
							<p class="category">Em andamento</p>
                            <h3 class="title">
    							<?= Html::encode("{$andamento}") ?>
                            </h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">local_hospital</i>
                  <label>
                    <a href=<?= $url=Url::to(['procedimento/index?ProcedimentoSearch[situacaoId]=cirurgia']) ?>>Situação: Em cirurgia</a>
                  </label>
							</div>
						</div>
					</div>
				</div>

                <div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
						<div class="card-header" data-background-color="red">
							<i class="material-icons">av_timer</i>
						</div>
						<div class="card-content">
							<p class="category">Atrasados</p>
							<h3 class="title">
                                <?= Html::encode("{$atrasados}") ?>
                            </h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">warning</i>
                  <label>
                    <a href=<?= $url=Url::to(['procedimento/index?ProcedimentoSearch[situacaoId]=agendado']) ?>>Verifique os procedimentos</a>
                  </label>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="card card-stats">
                        <div class="card-header" data-background-color="green">
							<i class="material-icons">done_outline</i>
						</div>
						<div class="card-content">
							<p class="category">Finalizados</p>
							<h3 class="title">
                                <?= Html::encode("{$finalizados}") ?>
                            </h3>
						</div>
						<div class="card-footer">
							<div class="stats">
								<i class="material-icons">check</i>
                  <label>
                    <a href=<?= $url=Url::to(['procedimento/index?ProcedimentoSearch[situacaoId]=finalizado']) ?>>Situação: Finalizado</a>
                  </label>
							</div>
						</div>
					</div>
				</div>

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="blue">
                            <i class="material-icons">airline_seat_flat</i>
                            <h4 class="title">Salas Cirúrgicas</h4>
                            <p class="category">Procedimentos marcados por sala agora</p>
                        </div>
                        <div class="card-content table-responsive">
                            <?= HtmlPurifier::process(
                                    GridView::widget([
                                    'dataProvider' => $salas,
                                    'summary' => '',
                                    'columns' => [
                                        'sala',
                                        'tipo',
                                        //'inicio:datetime',
                                        [
                                            'label'=>'Início',
                                            'attribute'=>'inicio',
                                            'value'=>'inicio',
                                            'format' => ['datetime', 'HH:i'],
                                        ],
                                        //'fimestimado:datetime',
                                        [
                                            'label'=>'Estimado',
                                            'attribute'=>'fimestimado',
                                            'value'=>'fimestimado',
                                            'format' => ['datetime', 'HH:i'],
                                        ],
                                        [
                                            'label'=>'Situação',
                                            'attribute'=>'situacao',
                                            'value'=>'situacao',
                                        ],

                                    ],
                                ])); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="gray">
                            <i class="material-icons">group</i>
                            <h4 class="title">Profissionais</h4>
                            <p class="category">Designados para hoje</p>
                        </div>
                        <div class="card-content table-responsive">
                            <?= HtmlPurifier::process(
                                    GridView::widget([
                                    'dataProvider' => $participantes,
                                    'summary' => '',
                                    'columns' => [
                                        'categoria',
                                        'total',
                                    ],
                                ])); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <i class="material-icons">clear_all</i>
                            <h4 class="title">Procedimentos</h4>
                            <p class="category">Repetidos hoje</p>
                        </div>
                        <div class="card-content table-responsive">
                            <?= HtmlPurifier::process(
                                GridView::widget([
                                'dataProvider' => $repetidos,
                                'summary' => '',
                                'columns' => [
                                    'tipo',
                                    'total',
                                ],
                            ])); ?>
                        </div>
                    </div>
                </div>

			</div>
        </div>
	</div>
