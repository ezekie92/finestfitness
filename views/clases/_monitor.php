<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clases-form">

    <?php $form = ActiveForm::begin(['id' => 'cambiar-monitor', 'enableAjaxValidation' => true])?>

    <?= $form->field($model, 'monitor')->dropDownList($listaMonitores, ['prompt' => 'Seleccione el monitor'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>
