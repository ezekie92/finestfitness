<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientesClasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes Clases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-clases-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Clientes Clases', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cliente_id',
            'clase_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
