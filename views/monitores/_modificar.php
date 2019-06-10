<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\Monitores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monitores-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
