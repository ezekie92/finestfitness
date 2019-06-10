<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="clientes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?php if (Yii::$app->user->identity->getTipoId() != 'monitores'): ?>
            <?= Html::a('Modificar datos', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php if (Yii::$app->user->identity->getTipoId() == 'administradores'): ?>
                <?= Html::a('Cambiar tarifa', ['tarifa', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Dar de baja', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                    ])
                ?>
            <?php endif ?>
        <?php else : ?>
            <?php if ($model->rutinaActual): ?>
                <?= Html::a('Asignar rutina', ['rutina-actual/update', 'cliente_id' => $model->id, 'rutina_id' => $model->rutinaActual->rutina_id], ['class' => 'btn btn-primary']) ?>
            <?php else: ?>
                <?= Html::a('Asignar rutina', ['rutina-actual/create', 'cliente_id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
        <?php endif; ?>
    </p>
    <?php if (Yii::$app->user->identity->getTipoId() == 'clientes' && $model->tiempoUltimoPago > 20 && date('d') >= 1 && date('d') <= 5): ?>
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <!-- Tipo de transacción -->
            <input type="hidden" name="cmd" value="_xclick">
            <!-- Evita que pregunte por una dirección de entrega -->
            <input type="hidden" name="no_shipping" value="1">
            <!-- Receptor -->
            <input type="hidden" name="business" value="<?= Yii::$app->params['pagosEmail']; ?>">
            <!-- Producto o servicio -->
            <input type="hidden" name="item_name" value="Mensualidad <?= $model->tarifas->tarifa ?>">
            <!-- Moneda -->
            <input type="hidden" name="currency_code" value="EUR">
            <!-- Cuantía -->
            <input type="hidden" name="amount" value="<?= $model->tarifas->precio ?>">
            <!-- Cantidad -->
            <input type="hidden" name="quantity" value="1">
            <!-- Redirección si transacción exitosa -->
            <input type="hidden" name="return" value="<?= Url::base(true).Yii::$app->request->url ?>">
            <!-- Redirección si transacción cancelada -->
            <input type="hidden" name="cancel_return" value="<?= Url::base(true).Yii::$app->request->url ?>">
            <input type="submit" value="Pagar" class="btn btn-success">
        </form>
    <?php endif; ?>

    <hr>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'email',
                'label' => 'Email',
                'format' => 'email',
                'visible' => Yii::$app->user->identity->getTipoId() != 'monitores',
            ],
            'fecha_nac:date',
            'peso:shortWeight',
            'altura',
            [
                'attribute' => 'telefono',
                'visible' => Yii::$app->user->identity->getTipoId() != 'monitores',
            ],
            [
                'attribute' => 'tarifas.tarifa',
                'visible' => Yii::$app->user->identity->getTipoId() != 'monitores',
            ],
            [
                'attribute' => 'fecha_alta',
                'format' => 'date',
                'visible' => Yii::$app->user->identity->getTipoId() != 'monitores',
            ],
            'rutinaActual.rutina.nombre:text:Rutina Actual'
        ],
    ]) ?>

</div>
