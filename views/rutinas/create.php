<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rutinas */

$this->title = 'Create Rutinas';
$this->params['breadcrumbs'][] = ['label' => 'Rutinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rutinas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
