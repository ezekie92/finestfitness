<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Monitores */

$this->title = 'Alta de monitor';
$this->params['breadcrumbs'][] = ['label' => 'Monitores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="monitores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaEsp' => $listaEsp,
    ]) ?>

</div>
