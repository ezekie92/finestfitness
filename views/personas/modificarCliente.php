<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Modificar cliente: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['clientes']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="personas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_cliente', [
        'model' => $model,
        'listaTarifas' => $listaTarifas,
        'listaMonitores' => $listaMonitores,
    ]) ?>

</div>
