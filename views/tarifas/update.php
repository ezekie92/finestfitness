<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

$this->title = 'Modificar tarifa ' . $model->tarifa;
$this->params['breadcrumbs'][] = ['label' => 'Tarifas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tarifa, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="tarifas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
