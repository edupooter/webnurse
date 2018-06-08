<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $provider yii\data\ArrayDataProvider */

$hoje = Yii::$app->formatter->asDateTime('now', 'php: d/m/Y');

$this->title = 'Painel - Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Procedimentos', 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h3><?= Html::encode($this->title) ?></h3>

    <div>
        <?= Html::a('Atualizar', ['view'], ['class' => 'btn btn-success']) ?>
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
                                    <label>Marcações para <?= $hoje ?></label>
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
                                    <label>Situação: Em cirurgia</label>
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
                                    <label>Verifique a situação</label>
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
								<i class="material-icons">update</i>
                                    <label>Situação: Finalizado</label>
							</div>
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
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>Tipo</th>
                                    <th>Total</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Implante de cateter duplo jota</td>
                                        <td><?= Html::encode("{$finalizados}") ?></td>
                                    </tr>
                                    <tr>
                                        <td>Amidalectomia</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Prostatectomia assistida por robô</td>
                                        <td>3</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="orange">
                            <i class="material-icons">airline_seat_flat</i>
                            <h4 class="title">Salas Cirúrgicas</h4>
                            <p class="category">Procedimento atual por sala</p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>Sala</th>
                                    <th>Procedimento</th>
                                    <th>Início</th>
                                    <th>Fim Estimado</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sala 01</td>
                                        <td>Implante de cateter duplo jota</td>
                                        <td>17:25</td>
                                        <td>19:50</td>
                                    </tr>
                                    <tr>
                                        <td>Sala 02</td>
                                        <td>Transplante Pulmonar</td>
                                        <td>13:30</td>
                                        <td>17:50</td>
                                    </tr>
                                    <tr>
                                        <td>Sala 03</td>
                                        <td>Apendicectomia videolaparoscópica</td>
                                        <td>16:45</td>
                                        <td>21:50</td>
                                    </tr>
                                    <tr>
                                        <td>Sala 04</td>
                                        <td>(livre)</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
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
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>Categoria</th>
                                    <th>Total</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Enfermeiro</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Técnico de Enfermagem</td>
                                        <td>11</td>
                                    </tr>
                                    <tr>
                                        <td>Médico-Cirurgião</td>
                                        <td>6</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

			</div>
        </div>
	</div>
