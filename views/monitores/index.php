<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MonitoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monitores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Monitores', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'email:email',
            'contrasena',
            'fecha_nac',
            //'foto',
            //'telefono',
            //'horario_entrada',
            //'horario_salida',
            //'especialidad',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
