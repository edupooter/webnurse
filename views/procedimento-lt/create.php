<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProcedimentoLt */

$this->title = 'Incluir Tipo de Procedimento';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Procedimento', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimento-lt-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
