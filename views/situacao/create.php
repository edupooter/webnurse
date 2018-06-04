<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Situacao */

$this->title = 'Incluir Situação (status de cirurgia)';
$this->params['breadcrumbs'][] = ['label' => 'Situações', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="situacao-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
