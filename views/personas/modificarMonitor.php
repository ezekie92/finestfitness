<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Modificar monitor: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Monitor', 'url' => ['monitores']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="personas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_monitor', [
        'model' => $model,
    ]) ?>

</div>
