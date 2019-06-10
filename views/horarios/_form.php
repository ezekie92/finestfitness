<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Horarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dia')->dropDownList($dias) ?>

    <?= $form->field($model, 'apertura')->textInput() ?>

    <?= $form->field($model, 'cierre')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
