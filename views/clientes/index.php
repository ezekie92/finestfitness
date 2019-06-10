<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alta Clientes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'nombre',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->nombre, ['clientes/view', 'id' => $data->id]);
                },

            ],
            'email:email',
            'fecha_nac:date',
            'peso:shortWeight',
            'altura',
            'telefono',
            [
                'attribute' => 'tarifaNombre.tarifa',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->tarifaNombre->tarifa, ['tarifas/view', 'id' => $data->tarifaNombre->id]);
                },

            ],
            'fecha_alta:date',
            'confirmado:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'template' => '{view}{update}{delete}{convertir}',
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return Html::a(
                            'Ver perfil',
                            ['clientes/view', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-xs']
                        );
                    },
                    'update'=>function ($url, $model) {
                        return Html::a(
                            'Modificar',
                            ['clientes/update', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-xs']
                        );
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a(
                            'Dar de baja',
                            ['clientes/delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'confirm' => '¿Seguro que desea dar de baja a ' . $model->nombre . '?',
                                    'method' => 'post',
                                ],
                            ],
                        );
                    },
                    'convertir'=>function ($url, $model) {
                        return Html::a(
                            'Convertir',
                            ['clientes/convertir', 'id' => $model->id],
                            [
                                'class' => 'btn btn-success btn-xs',
                                'data' => [
                                    'confirm' => '¿Convertir a ' . $model->nombre . ' en monitor?',
                                    'method' => 'post',
                                ],
                            ],
                        );
                    }
                ]
            ],
        ],
    ]); ?>
</div>
