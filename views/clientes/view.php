<?php

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
        <?= Html::a('Modificar datos', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php //Html::a('Dar de baja', ['delete', 'id' => $model->id], [
            // 'class' => 'btn btn-danger',
            // 'data' => [
            //     'confirm' => 'Are you sure you want to delete this item?',
            //     'method' => 'post',
            // ],
        //]) ?>
    </p>
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
        <input type="hidden" name="return" value="http://localhost:8080/index.php?r=clientes%2Fview&id=<?= $model->id ?>">
        <!-- Redirección si transacción cancelada -->
        <input type="hidden" name="cancel_return" value="http://localhost:8080/index.php?r=clientes%2Fview&id=<?= $model->id ?>">
        <input type="submit" value="Pagar" class="btn btn-success">
    </form>

    <hr>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'nombre',
            'email:email',
            // 'contrasena',
            'fecha_nac:date',
            'peso:shortWeight',
            'altura',
            'foto',
            'telefono',
            'tarifas.tarifa',
            'fecha_alta:date',
            'entrenador.nombre:text:Monitor',
        ],
    ]) ?>

</div>
