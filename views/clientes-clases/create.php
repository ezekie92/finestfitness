<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientesClases */

$this->title = 'Create Clientes Clases';
$this->params['breadcrumbs'][] = ['label' => 'Clientes Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-clases-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
