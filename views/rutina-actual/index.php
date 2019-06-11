<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RutinaActualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rutina Actuals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rutina-actual-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Rutina Actual', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'headerRowOptions' => ['class' => 'text-primary'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cliente_id',
            'rutina_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
