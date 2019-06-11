<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tarifas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarifas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tarifa')->textInput(['maxlength' => true])->label('Nombre de la tarifa') ?>

    <?= $form->field($model, 'precio')->textInput(['placeholder' => '€']) ?>

    <?= $form->field($model, 'hora_entrada_min')->textInput(['placeholder' => '00:00:00']) ?>

    <?= $form->field($model, 'hora_entrada_max')->textInput(['placeholder' => '00:00:00']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
