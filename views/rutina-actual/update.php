<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RutinaActual */

$this->title = 'Cambiar rutina asignada a ' . $model->cliente->nombre;
$this->params['breadcrumbs'][] = ['label' => $model->cliente->nombre, 'url' => ['clientes/view', 'id' => $model->cliente_id]];
$this->params['breadcrumbs'][] = 'Cambiar rutina';
?>
<div class="rutina-actual-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaRutinas' => $listaRutinas
    ]) ?>

</div>
