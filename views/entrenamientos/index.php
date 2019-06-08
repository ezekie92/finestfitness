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
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => 'Pendiente'],
        'rowOptions' => function ($model, $index, $widget, $grid){
            if ($model->estado === true) {
                return ['class' => 'success'];
            } elseif ($model->estado === false) {
                return ['class' => 'danger'];
            } else {
                return ['class' => 'warning'];
            }
        },
        'columns' => [
            [
                'attribute' => 'cliente.nombre',
                'label' => 'Cliente',
                'visible' => Yii::$app->user->identity->getTipoId() != 'clientes',
            ],
            [
                'attribute' => 'monitor.nombre',
                'label' => 'Monitor',
                'visible' => Yii::$app->user->identity->getTipoId() != 'monitores',
            ],
            'hora_inicio',
            'hora_fin',
            'diaSemana.dia',
            'estado:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Cancelar',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete', 'cliente_id' => $model->cliente_id, 'monitor_id' => $model->monitor_id, 'dia' => $model->dia],
                        [
                            'class' => '',
                            'data' => [
                                'confirm' => '¿Seguro que desea cancelar este entrenamiento?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
