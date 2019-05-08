<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ClasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clases';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Vista modal para cambiar el monitor asignado a una clase -->
<div class="modal remote fade" id="modalmonitor">
        <div class="modal-dialog">
            <div class="modal-content loader-lg"></div>
        </div>
</div>

<div class="clases-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Clase', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nombre',
            'hora_inicio',
            'hora_fin',
            'diaClase.dia',
            'monitorClase.nombre',
            'plazas',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['class' => 'text-primary', 'style' => 'width:8%'],
                'template' => '{monitor} {view} {update} {delete}',
                'buttons'=>[
                    'monitor'=>function ($url, $model) {
                        return Html::a(
                            '<i class="glyphicon glyphicon-education"></i>',
                            ['clases/cambiar-monitor', 'id' => $model->id],
                            [
                                'title' => 'Cambiar monitor',
                                'data-toggle'=>'modal',
                                'data-target'=>'#modalmonitor',
                            ]
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>
