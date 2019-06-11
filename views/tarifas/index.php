<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TarifasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tarifas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarifas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->getTipoId() == 'administradores'): ?>
        <p>
            <?= Html::a('Añadir tarifa', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'headerRowOptions' => ['class' => 'text-primary'],
        'columns' => [

            'tarifa',
            'precio:currency',
            'hora_entrada_min:time',
            'hora_entrada_max:time',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                'visible' => Yii::$app->user->identity->getTipoId() == 'administradores',
            ],
        ],
    ]); ?>


</div>
