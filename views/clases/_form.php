<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\Clases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?=
        $form->field($model, 'fecha')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATETIME,
        'widgetOptions' => [
            'pluginOptions' => [
                'autoclose' => true
            ],
        ],
        ]);
    ?>

    <?= $form->field($model, 'monitor')->dropDownList($listaMonitores, ['prompt' => 'Seleccione el monitor']) ?>

    <?= $form->field($model, 'plazas')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
