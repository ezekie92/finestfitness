<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientesClases */

$this->title = 'Update Clientes Clases: ' . $model->cliente_id;
$this->params['breadcrumbs'][] = ['label' => 'Clientes Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cliente_id, 'url' => ['view', 'cliente_id' => $model->cliente_id, 'clase_id' => $model->clase_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clientes-clases-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
