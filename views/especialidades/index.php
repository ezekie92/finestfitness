<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EspecialidadesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Especialidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="especialidades-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Especialidad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'headerRowOptions' => ['class' => 'text-primary'],
        'columns' => [
            [
                'attribute' => 'especialidad',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->especialidad, ['especialidades/view', 'id' => $data->id]);
                },

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}'
            ],
        ],
    ]); ?>


</div>
