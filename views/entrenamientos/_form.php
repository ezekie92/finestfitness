<?php

use kartik\datecontrol\DateControl;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entrenamientos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entrenamientos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cliente_id')->textInput() ?>

    <?= $form->field($model, 'monitor_id')->textInput() ?>

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

    <?= $form->field($model, 'estado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Crear', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
