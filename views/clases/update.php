<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clases */

$this->title = 'Modificar Clase: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clases-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaDias' => $listaDias,
        'listaMonitores' => $listaMonitores,
    ]) ?>

</div>
