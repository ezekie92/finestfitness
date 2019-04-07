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
        <?= Html::a('Create Clientes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'email:email',
            'fecha_nac:date',
            'peso:shortWeight',
            'altura',
            'telefono',
            'tarifa',
            'fecha_alta:date',
            'entrenador.nombre:text:Monitor',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return null;
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
                    }
                ]
            ],
        ],
    ]); ?>


</div>
