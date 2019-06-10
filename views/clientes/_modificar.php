<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


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

        <?= $form->field($model, 'foto')->widget(FileInput::class, [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showPreview' => true,
                'showRemove' => false,
                'showUpload' => false,
                'maxFileSize'=>5000,
                'browseLabel' =>  'Subir foto'
            ]
            ])  ?>
    <?php else : ?>
        <?= $form->field($model, 'tarifa')->dropDownList($listaTarifas) ?>
    <?php endif ?>


    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
