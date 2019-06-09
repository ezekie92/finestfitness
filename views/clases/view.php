<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clases */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="clases-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->identity->getTipoId() == 'clientes'): ?>
            <?php if ($model->clienteInscrito()): ?>
                <?= Html::a(
                    'No asistir',
                    ['clientes-clases/delete', 'clase_id' => $model->id, 'cliente_id' => Yii::$app->user->identity->getNId()],
                    ['class'=>'btn-sm btn-danger', 'data-method' => 'POST'],
                );?>
            <?php else: ?>
                <?= Html::beginForm(['clases/inscribirse'],'post')
                . Html::hiddenInput('clase_id', $model->id)
                . Html::hiddenInput('cliente_id', Yii::$app->user->identity->getNId())
                . Html::submitButton('Inscribirse', ['class' => 'btn-xs btn-success'])
                . Html::endForm(); ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fecha:date',
            'fecha:time:Hora',
            'monitorClase.nombre',
            'plazas',
        ],
    ]) ?>

</div>
