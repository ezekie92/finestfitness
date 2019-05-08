<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clases-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => true])?>

    <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cambiar monitor</h4>
    </div>

    <div class="modal-body">
        <?= $form->field($model, 'monitor')->dropDownList($listaMonitores, ['prompt' => 'Seleccione el monitor'])->label(false) ?>
    </div>

    <div class="modal-footer">
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
