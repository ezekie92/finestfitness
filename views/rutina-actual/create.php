<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RutinaActual */

$this->title = 'Asignar rutina a ' . $model->cliente->nombre;
$this->params['breadcrumbs'][] = ['label' => $model->cliente->nombre, 'url' => ['clientes/view', 'id' => $model->cliente_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rutina-actual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaRutinas' => $listaRutinas,
    ]) ?>

</div>
