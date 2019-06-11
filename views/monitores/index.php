<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MonitoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monitores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alta Monitores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'headerRowOptions' => ['class' => 'text-primary'],
        'columns' => [

            [
                'attribute' => 'nombre',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->nombre, ['monitores/view', 'id' => $data->id]);
                },

            ],
            'email:email',
            'fecha_nac:date',
            'telefono',
            'horario_entrada:time',
            'horario_salida:time',
            [
                'attribute' => 'esp.especialidad',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->esp->especialidad, ['especialidades/view', 'id' => $data->esp->id]);
                },

            ],
            'confirmado:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'template' => '{view}{update}{delete}{convertir}',
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return Html::a(
                            'Ver perfil',
                            ['monitores/view', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-xs']
                        );
                    },
                    'update'=>function ($url, $model) {
                        return Html::a(
                            'Modificar',
                            ['monitores/update', 'id' => $model->id],
                            ['class' => 'btn btn-warning btn-xs']
                        );
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a(
                            'Dar de baja',
                            ['monitores/delete', 'id' => $model->id],
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
                            ['monitores/convertir', 'id' => $model->id],
                            [
                                'class' => 'btn btn-success btn-xs',
                                'data' => [
                                    'confirm' => '¿Convertir a ' . $model->nombre . ' en cliente?',
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
