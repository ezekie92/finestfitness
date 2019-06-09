<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Entrenamientos */

$this->title = $model->cliente_id . $model->monitor_id . $model->diaSemana->dia;
$this->params['breadcrumbs'][] = ['label' => 'Entrenamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="entrenamientos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cliente_id' => $model->cliente_id, 'monitor_id' => $model->monitor_id, 'dia' => $model->dia], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cliente_id' => $model->cliente_id, 'monitor_id' => $model->monitor_id, 'dia' => $model->dia], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cliente_id',
            'monitor_id',
            'fecha',
        ],
    ]) ?>

</div>
