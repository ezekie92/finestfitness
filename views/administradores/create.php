<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Administradores */

$this->title = 'Create Administradores';
$this->params['breadcrumbs'][] = ['label' => 'Administradores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administradores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
