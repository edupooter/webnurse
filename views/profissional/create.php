<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Profissional */

$this->title = 'Incluir Profissional';
$this->params['breadcrumbs'][] = ['label' => 'Profissionais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profissional-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
