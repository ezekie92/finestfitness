<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title = 'Alta de cliente';
$boton = 'Dar de alta';
if ($this->context->action->id == 'convertir') {
    $this->title = 'Convertir a ' . $model->nombre . ' en cliente';
    $boton = 'Convertir';
}
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaTarifas' => $listaTarifas,
        'boton' => $boton,
    ]) ?>

</div>
