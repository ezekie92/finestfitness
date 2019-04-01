<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monitores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Personas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nombre',
            'email:email',
            'fecha_nac:date',
            'peso:shortWeight',
            'altura:decimal',
            'foto',
            'telefono',
            'fecha_alta:date',
            'horario_entrada',
            'horario_salida',
            'especialidad',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
