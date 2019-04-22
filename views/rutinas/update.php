<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rutinas */

$this->title = 'Modificar Rutina: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rutinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rutinas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaEjercicios' => $listaEjercicios,
        'listaDias' => $listaDias,
    ]) ?>

</div>
