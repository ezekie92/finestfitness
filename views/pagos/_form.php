<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pagos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pagos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($this->context->action->id != 'manual'): ?>
        <?= $form->field($model, 'fecha')->textInput() ?>

        <?= $form->field($model, 'cliente_id')->textInput() ?>
    <?php endif; ?>

    <?= $form->field($model, 'concepto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
