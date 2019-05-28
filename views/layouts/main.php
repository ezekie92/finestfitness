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

<?php
if (!Yii::$app->user->isGuest) {
    if (Yii::$app->user->identity->getTipoId() == 'administradores') {
        $menu = [
            ['label' => 'Horario', 'url' => ['/horarios/index']],
            ['label' => 'Clases', 'url' => ['/clases/index']],
            ['label' => 'Entrenos', 'url' => ['/entrenamientos/index']],
            [
               'label' => 'Administradores',
               'items' => [
                   ['label' => 'Gestionar', 'url' => ['/administradores/index']],
                   ['label' => 'Alta Administradores', 'url' => ['/administradores/create']],
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
        ];
    } elseif (Yii::$app->user->identity->getTipoId() == 'monitores') {
        $menu = [
            [
                'label' => 'Clases',
                'items' => [
                    ['label' => 'Clases', 'url' => ['/clases/index']],
                    ['label' => 'Mis clases', 'url' => ['/clases/clases-monitor']],
                ],
            ],
            [
                'label' => 'Entranamientos',
                'items' => [
                    ['label' => 'Mis entrenamientos', 'url' => ['/entrenamientos/clientes-entrenador']],
                    ['label' => 'Solicitudes', 'url' => ['/entrenamientos/solicitudes']],
                ]
            ],
        ];
    } elseif (Yii::$app->user->identity->getTipoId() == 'clientes') {
        $menu = [
            ['label' => 'Rutinas', 'url' => ['/rutinas/index']],
            [
                'label' => 'Clases',
                'items' => [
                    ['label' => 'Clases', 'url' => ['/clases/index']],
                    // ['label' => 'Mis clases', 'url' => ['/clases/clases-monitor']],
                ],
            ],
            [
                'label' => 'Entrenamientos',
                'items' => [
                    ['label' => 'Monitores', 'url' => ['/monitores/lista-monitores']],
                    // ['label' => 'Entrenos', 'url' => ['/entrenamientos/index']],
                    // ['label' => 'Mis entrenos', 'url' => ['/entrenamientos/clientes-entrenador']],
                ],
            ],
        ];
    }
    $perfil = [
        'label' => Yii::$app->user->identity->getNombre(),
        'items' => [
            [
                'label' => 'Mi perfil',
                'url' => Url::to(
                    [
                        '/' . Yii::$app->user->identity->getTipoId() .'/view',
                        'id'=> Yii::$app->user->identity->getNId()
                    ]
                )
            ],
            [
                'label' => 'Logout',
                'url' => ['site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ],
        ],
    ];
    array_push($menu, $perfil);
    array_unshift($menu, ['label' => 'Home', 'url' => ['/site/index']]);
} else {
    $menu = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Login', 'url' => ['/site/login']]
    ];
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
        'items' => $menu,
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
