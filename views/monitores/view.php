<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Monitores */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Monitores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="monitores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::img(Yii::getAlias('@foto') . '/' . $model->foto, ['class' => 'mini']) ?>

        <?= Html::a('Modificar datos', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php // Html::a('Dar de baja', ['delete', 'id' => $model->id], [
            // 'class' => 'btn btn-danger',
            // 'data' => [
            //     'confirm' => 'Are you sure you want to delete this item?',
            //     'method' => 'post',
            // ],
        //]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            'fecha_nac:date',
            'telefono',
            'horario_entrada:time',
            'horario_salida:time',
            [
                'attribute' => 'esp.especialidad',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->esp->especialidad, ['especialidades/view', 'id' => $data->esp->id]);
                },

            ],
        ],
    ]) ?>

</div>
