<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entrenamientos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entrenamientos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hora_inicio')->textInput() ?>

    <?= $form->field($model, 'hora_fin')->textInput() ?>

    <?= $form->field($model, 'dia')->dropDownList($listaDias) ?>

    <div class="form-group">
        <?= Html::submitButton('Solicitar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
