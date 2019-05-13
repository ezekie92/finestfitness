<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ejercicios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ejercicios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dia_id')->textInput() ?>

    <?= $form->field($model, 'rutina_id')->textInput() ?>

    <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeticiones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descanso')->textInput() ?>

    <?= $form->field($model, 'peso')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
