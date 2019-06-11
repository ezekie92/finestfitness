<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientesClasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes inscritos en clases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-clases-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'cliente.nombre',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->cliente->nombre, ['clientes/view', 'id' => $data->cliente->id]);
                },
            ],
            [
                'attribute' => 'clase.nombre',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->clase->nombre, ['clases/view', 'id' => $data->clase->id]);
                },
            ],
        ],
    ]); ?>


</div>
