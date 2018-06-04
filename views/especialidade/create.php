<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Especialidade */

$this->title = 'Incluir Especialidade Médica';
$this->params['breadcrumbs'][] = ['label' => 'Especialidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="especialidade-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
