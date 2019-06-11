<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ejercicios */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Añadir ejercicio';
$this->params['breadcrumbs'][] = ['label' => 'Ejercicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ejercicios-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dia_id')->dropDownList($listaDias, ['prompt' => 'Seleccione el día']) ?>

    <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeticiones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descanso')->textInput(['placeholder' => 'En segundos, ej: 90']) ?>

    <?= $form->field($model, 'peso')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Añadir', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Volver', ['ejercicios/rutina', 'id' => $_GET['rutina']], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
