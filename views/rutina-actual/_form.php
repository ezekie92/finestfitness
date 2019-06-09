<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RutinaActual */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rutina-actual-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rutina_id')->dropDownList($listaRutinas, ['prompt' => 'Seleccione la rutina a asignar']) ?>

    <div class="form-group">
        <?= Html::submitButton('Asignar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
