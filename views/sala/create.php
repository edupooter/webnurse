<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sala */

$this->title = 'Incluir Sala Cirúrgica';
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sala-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
