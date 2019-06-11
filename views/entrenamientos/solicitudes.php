<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntrenamientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aceptar/Rechazar Entrenamientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entrenamientos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered'],
        'headerRowOptions' => ['class' => 'text-primary'],
        'columns' => [
            'cliente.nombre:text:Cliente',
            'fecha',

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Aceptar / Rechazar',
                'template'=>'{aceptar} {rechazar}',
                'buttons'=>[
                    'aceptar'=>function ($url, $model) {
                        return Html::beginForm(['entrenamientos/decidir', 'cliente_id' => $model->cliente_id, 'monitor_id' => $model->monitor_id, 'fecha' => $model->fecha], 'post')
                        . Html::hiddenInput('estado', 1)
                        . Html::submitButton('Aceptar', ['class' => 'btn-xs btn-success'])
                        . Html::endForm();
                    },
                    'rechazar' => function ($url, $model) {
                        return Html::beginForm(['entrenamientos/decidir', 'cliente_id' => $model->cliente_id, 'monitor_id' => $model->monitor_id, 'fecha' => $model->fecha], 'post')
                        . Html::hiddenInput('estado', 0)
                        . Html::submitButton('Rechazar', ['class' => 'btn-xs btn-danger'])
                        . Html::endForm();
                    }
                ],
            ],
        ],
        'summary' => false,
    ]); ?>


</div>
