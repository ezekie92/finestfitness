<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clases */

$this->title = 'Modificar Clase: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="clases-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaMonitores' => $listaMonitores,
    ]) ?>

</div>
