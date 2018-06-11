<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedimento */

$this->title = 'Incluir Procedimento';
$this->params['breadcrumbs'][] = ['label' => 'Procedimentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedimento-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <!-- <//?= Html::encode("Duração média deste tipo de procedimento: {$duracao}") ?> -->

    <!-- <//?= $this->render('_form2', [
        'model' => $model,
    ]) ?> -->

</div>
