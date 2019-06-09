<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\Entrenamientos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entrenamientos-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <div class="form-group">
        <?= Html::submitButton('Solicitar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
