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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <!-- Full Calendar -->
    <link href='fullcalendar/core/main.css' rel='stylesheet' />
    <link href='fullcalendar/list/main.css' rel='stylesheet' />
    <script src='fullcalendar/core/main.js'></script>
    <script src='fullcalendar/list/main.js'></script>


    <!-- Nigth mode -->
    <script src="jquery-night-mode-master/js/jquery.night.mode.js"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="jquery-night-mode-master/css/night-mode.css">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<script type="text/javascript">

    $("body").nightMode({
    // element(s) to keep normal styles
    keepNormal: "button",
    // shows brightness controller
    adjustBrightness: true,
    // auto enable night mode at 8 pm to 4 am
    autoEnable: false,
    // success text
    successText: "¡Modo noche activado!",
    });
</script>

<?php
if (!Yii::$app->user->isGuest) {
    if (Yii::$app->user->identity->getTipoId() == 'administradores') {
        $menu = [
            ['label' => 'Horario', 'url' => ['/horarios/index']],
            ['label' => 'Tarifas', 'url' => ['/tarifas/index']],
            [
                'label' => 'Clases',
                'items' => [
                    ['label' => 'Clases', 'url' => ['/clases/index']],
                    ['label' => 'Calendario', 'url' => ['/clases/calendario']],

                ],
            ],            ['label' => 'Entrenos', 'url' => ['/entrenamientos/index']],
            [
               'label' => 'Administradores',
               'items' => [
                   ['label' => 'Gestionar', 'url' => ['/administradores/index']],
                   ['label' => 'Alta Administradores', 'url' => ['/administradores/create']],
               ],
           ],
           [
               'label' => 'Monitores',
               'items' => [
                   ['label' => 'Gestionar', 'url' => ['/monitores/index']],
                   ['label' => 'Alta Monitores', 'url' => ['/monitores/create']],
                   ['label' => 'Especialidades', 'url' => ['/especialidades/index']],
               ],
           ],
           [
               'label' => 'Clientes',
               'items' => [
                   ['label' => 'Gestionar', 'url' => ['/clientes/index']],
                   ['label' => 'Alta Clientes', 'url' => ['/clientes/create']],
                   ['label' => 'Clientes inscritos en clases', 'url' => ['/clientes-clases/index']],
                   ['label' => 'Pagos', 'url' => ['/pagos/index']],
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
                    ['label' => 'Calendario', 'url' => ['/clases/calendario']],
                ],
            ],
            [
                'label' => 'Entranamientos',
                'items' => [
                    ['label' => 'Mis entrenamientos', 'url' => ['/entrenamientos/clientes-entrenador']],
                    ['label' => 'Solicitudes', 'url' => ['/entrenamientos/solicitudes']],
                    ['label' => 'Calendario', 'url' => ['/entrenamientos/calendario']],
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
                    ['label' => 'Calendario', 'url' => ['/clases/calendario']],
                ],
            ],
            [
                'label' => 'Entrenamientos',
                'items' => [
                    ['label' => 'Solicitar', 'url' => ['/monitores/lista-monitores']],
                    ['label' => 'Mis entrenamientos', 'url' => ['/entrenamientos/index']],
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
        <p class="pull-left">&copy; FinestFitness </p>

        <p class="pull-right"><b>Vísitanos en:</b> Av. de Huelva, s/n, 11540 Sanlúcar de Barrameda, Cádiz</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
