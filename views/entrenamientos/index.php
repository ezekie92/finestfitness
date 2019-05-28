<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntrenamientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entrenamientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entrenamientos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'cliente.nombre:text:Cliente',
            [
                'attribute' => 'monitor.nombre',
                'label' => 'Monitor',
                'visible' => Yii::$app->user->identity->getTipoId() == 'administradores',
            ],
            'hora_inicio',
            'hora_fin',
            'diaSemana.dia',
            'estado:boolean',
        ],
    ]); ?>


</div>
