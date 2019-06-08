<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-form">

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

    <?= $form->field($model, 'peso')->textInput() ?>

    <?= $form->field($model, 'altura')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'tarifa')->dropDownList($listaTarifas) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
