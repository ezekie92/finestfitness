<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Alta de monitor';
$this->params['breadcrumbs'][] = ['label' => 'Monitores', 'url' => ['monitores']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_monitor', [
        'model' => $model,
    ]) ?>

</div>
