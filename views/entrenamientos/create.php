<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Entrenamientos */

$this->title = 'Create Entrenamientos';
$this->params['breadcrumbs'][] = ['label' => 'Entrenamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entrenamientos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
