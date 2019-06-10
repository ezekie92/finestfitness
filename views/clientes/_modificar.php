<?php

use kartik\datecontrol\DateControl;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($this->context->action->id != 'tarifa'): ?>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'contrasena')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'contrasena_repeat')->passwordInput(['maxlength' => true]) ?>

        <?=
        $form->field($model, 'fecha_nac')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_DATE,
            'widgetOptions' => [
                'pluginOptions' => [
                    'autoclose' => true,
                ],
            ],
        ])
        ?>
        <?= $form->field($model, 'peso')->textInput() ?>

        <?= $form->field($model, 'altura')->textInput() ?>

        <?= $form->field($model, 'telefono')->textInput() ?>
    <?php else : ?>
        <?= $form->field($model, 'tarifa')->dropDownList($listaTarifas) ?>
    <?php endif ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
