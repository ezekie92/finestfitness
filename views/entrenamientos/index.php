<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntrenamientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entrenamientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entrenamientos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Entrenamientos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cliente_id',
            'entrenador_id',
            'hora_inicio',
            'hora_fin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>