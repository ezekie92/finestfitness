<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RutinasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rutinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rutinas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Rutina', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nombre',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['class' => 'text-primary'],
                'template' => '{ejercicios}',
                'buttons' => [
                    'ejercicios'=>function ($url, $model) {
                        return Html::a(
                            'Ver rutina',
                            ['ejercicios/rutina', 'id' => $model->id],
                            ['class' => 'btn btn-primary btn-xs']
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>
