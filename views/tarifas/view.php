<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */

$this->title = $model->tarifa;
$this->params['breadcrumbs'][] = ['label' => 'Tarifas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tarifas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->getTipoId() == 'administradores'): ?>
        <p>
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tarifa',
            'precio:currency',
            'hora_entrada_min:time',
            'hora_entrada_max:time',
        ],
    ]) ?>

</div>
