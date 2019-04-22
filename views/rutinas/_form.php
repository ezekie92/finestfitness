<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rutinas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rutinas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ejercicio')->dropDownList($listaEjercicios, ['prompt' => 'Seleccione el ejercicio a añadir']) ?>

    <?= $form->field($model, 'dia')->dropDownList($listaDias, ['prompt' => 'Seleccione el día de la semana']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
