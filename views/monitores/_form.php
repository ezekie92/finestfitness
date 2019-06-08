<?php

use kartik\datecontrol\DateControl;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Monitores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monitores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?=
        $form->field($model, 'horario_entrada')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_TIME,
        ])
    ?>

    <?=
        $form->field($model, 'horario_salida')->widget(DateControl::classname(), [
            'type'=>DateControl::FORMAT_TIME,
        ])
    ?>

    <?= $form->field($model, 'especialidad')->dropDownList($listaEsp, ['prompt' => 'Seleccione una especialidad']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
