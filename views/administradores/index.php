<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdministradoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administradores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administradores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Administradores', ['create'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
