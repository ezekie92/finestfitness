<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ClientesClases */

$this->title = $model->cliente_id;
$this->params['breadcrumbs'][] = ['label' => 'Clientes Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clientes-clases-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cliente_id' => $model->cliente_id, 'clase_id' => $model->clase_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cliente_id' => $model->cliente_id, 'clase_id' => $model->clase_id], [
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
            'clase_id',
        ],
    ]) ?>

</div>
