<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Entrenamientos */

$this->title = 'Update Entrenamientos: ' . $model->cliente_id;
$this->params['breadcrumbs'][] = ['label' => 'Entrenamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cliente_id, 'url' => ['view', 'cliente_id' => $model->cliente_id, 'entrenador_id' => $model->entrenador_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entrenamientos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
