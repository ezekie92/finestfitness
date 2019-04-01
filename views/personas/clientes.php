<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alta de Clientes', ['alta-cliente'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nombre',
            'email:email',
            'fecha_nac:date',
            'peso:shortWeight',
            'altura:decimal',
            'telefono',
            'tarifa',
            'fecha_alta:date',
            'tipo',
            'monitor',

            ['class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return null;
                },
                'update'=>function ($url, $model) {
                    return Html::a(
                        'Modificar',
                        ['personas/modificar-cliente', 'id' => $model->id],
                        [
                            'class' => 'btn btn-warning btn-xs'
                        ]
                    );
                },
                'delete'=>function ($url, $model) {
                    return Html::a(
                        'Dar de baja',
                        ['personas/delete', 'id' => $model->id],
                        [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => '¿Seguro que desea dar de baja a este cliente?',
                                'method' => 'post',
                            ],
                        ],
                    );
                }
            ],],
        ],
    ]); ?>


</div>
