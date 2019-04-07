<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Monitores */

$this->title = 'Modificar: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Monitores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="monitores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaEsp' => $listaEsp,
    ]) ?>

</div>
