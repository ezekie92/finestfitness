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
        <?= Html::a('Alta administrador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'nombre',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->nombre, ['administradores/view', 'id' => $data->id]);
                },

            ],
            'email:email',
            'confirmado:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return null;
                    },
                    'update'=>function ($url, $model) {
                        return null;
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a(
                            'Dar de baja',
                            ['administradores/delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'confirm' => '¿Seguro que desea dar de baja a ' . $model->nombre . '? Se trata de un administrador',
                                    'method' => 'post',
                                ],
                            ],
                        );
                    }
                ]
            ],
        ],
    ]); ?>


</div>
