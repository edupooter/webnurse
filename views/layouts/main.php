<?php

/* @var $this \yii\web\View */
/* @var $content string */

/*
use yii\dependencies
*/

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\nav\NavX;

AppAsset::register($this);
//Register class
if (class_exists('ramosisw\CImaterial\web\MaterialAsset')) {
    ramosisw\CImaterial\web\MaterialAsset::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    NavBar::begin([
        'brandLabel' => 'WebNurse',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    // everyone can see Home page
    //$menuItems[] = ['label' => Yii::t('app', 'Início'), 'url' => ['/site/index']];

    // we do not need to display Article/index, About and Contact pages to editor+ roles
    if (!Yii::$app->user->isGuest)
    {
        $menuItems[] = ['label' => Yii::t('app', 'Painel'), 'url' => ['/dashboard/view']];
        $menuItems[] = ['label' => Yii::t('app', 'Procedimentos'), 'url' => ['/procedimento/index']];
        $menuItems[] = ['label' => 'Cadastro', 'items' => [
            ['label' => Yii::t('app', 'Profissionais'), 'url' => ['/profissional/index']],
            ['label' => Yii::t('app', 'Equipamentos Cirúrgicos'), 'url' => ['/equipamento/index']],
            ['label' => Yii::t('app', 'Especialidades Médicas'), 'url' => ['/especialidade/index']],
            ['label' => Yii::t('app', 'Categorias Profissionais'), 'url' => ['/categoria/index']],
            ['label' => Yii::t('app', 'Tipos de Procedimento'), 'url' => ['/procedimento-lt/index']],
            ['label' => Yii::t('app', 'Salas Cirúrgicas'), 'url' => ['/sala/index']],
            ['label' => Yii::t('app', 'Situações (status de cirurgias)'), 'url' => ['/situacao/index']]
        ]];
        $menuItems[] = ['label' => Yii::t('app', 'Ajuda'), 'url' => ['/site/ajuda']];
    }

    // display Signup and Login pages to guests of the site
    if (Yii::$app->user->isGuest)
    {
        //$menuItems[] = ['label' => Yii::t('app', 'Registro'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'Contato'), 'url' => ['/site/contact']];
        $menuItems[] = ['label' => Yii::t('app', 'Entrar'), 'url' => ['/site/login']];
    }
    // display Logout to all logged in users
    else
    {
        $menuItems[] = [
            'label' => Yii::t('app', 'Sair'). ' (' . Yii::$app->user->identity->username . ' - ' . Yii::$app->user->identity->hospital . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }

    // Menu padrão do Yii
    // echo Nav::widget([
    //     'options' => ['class' => 'navbar-nav navbar-right'],
    //     'items' => $menuItems,
    // ]);

    // widget NavX, que possibilita o uso de submenus
    echo NavX::widget([
      // Nav pills do bootstrap
      // 'options'=>['class'=>'nav nav-pills'],
      'options'=>['class'=>'navbar-nav navbar-right'],
      'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">WebNurse <?= date('Y') ?></p>

        <p class="pull-right"><?php echo 'Eduardo Pooter Reis - '.Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
