<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (!Yii::$app->user->isGuest) {
    $usuario = explode('-', Yii::$app->user->identity->getid());
}
?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            [
                'label' => 'Clases',
                'items' => [
                    ['label' => 'Clases', 'url' => ['/clases/index']],
                ],
            ],
            [
                'label' => 'Administradores',
                'items' => [
                    ['label' => 'Gestionar', 'url' => ['/administradores/index']],
                    ['label' => 'Alta Administradores', 'url' => ['/administradores/create']],
                    ['label' => 'Clases', 'url' => ['/clases/index']],
                ],
            ],
            [
                'label' => 'Clientes',
                'items' => [
                    ['label' => 'Gestionar', 'url' => ['/clientes/index']],
                    ['label' => 'Alta Clientes', 'url' => ['/clientes/create']],
                ],
            ],
            [
                'label' => 'Monitores',
                'items' => [
                    ['label' => 'Gestionar', 'url' => ['/monitores/index']],
                    ['label' => 'Alta Monitores', 'url' => ['/monitores/create']],
                ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                [
                    'label' => Yii::$app->user->identity->getNombre(),
                    'items' => [
                        [
                            'label' => 'Mi perfil',
                            'url' => Url::to(["/$usuario[0]/view", 'id'=> $usuario[1]])
                        ],
                        [
                            'label' => 'Logout',
                            'url' => ['site/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ],
                    ],
                ]

            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
