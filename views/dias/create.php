<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dias */

$this->title = 'Create Dias';
$this->params['breadcrumbs'][] = ['label' => 'Dias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
