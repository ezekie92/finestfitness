<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EjerciciosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ejercicios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'dia_id') ?>

    <?= $form->field($model, 'rutina_id') ?>

    <?= $form->field($model, 'series') ?>

    <?php // echo $form->field($model, 'repeticiones') ?>

    <?php // echo $form->field($model, 'descanso') ?>

    <?php // echo $form->field($model, 'peso') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
