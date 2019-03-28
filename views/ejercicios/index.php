<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EjerciciosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ejercicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ejercicios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ejercicios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'series',
            'repeticiones',
            'descanso',
            //'peso',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
