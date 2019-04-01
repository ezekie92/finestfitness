<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */

if ($model->tipo = 'cliente') {
    $url = 'clientes';
} elseif ($model->tipo = 'monitor') {
    $url = 'monitores';
} else {
    $url = 'index';
}

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => ucfirst($url), 'url' => ["$url"]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="personas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['modificar-' . $model->tipo, 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Dar de baja', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => "¿Seguro que desea dar de baja a este $model->tipo?",
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'email:email',
            'contrasena',
            'fecha_nac',
            'peso',
            'altura',
            'foto',
            'telefono',
            'tarifa',
            'fecha_alta',
            'tipo',
            'monitor',
            'horario_entrada',
            'horario_salida',
            'especialidad',
        ],
    ]) ?>

</div>
