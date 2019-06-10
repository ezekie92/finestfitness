<?php

use yii\helpers\Url;
use yii\helpers\Html;

// Define como se verá el listado de monitores
?>

<article class="container" data-key="<?= $model->id ?>">
    <div class="row">
        <div class="col-md-2">
            <?= Html::img(Yii::getAlias('@foto') . '/' . $model->foto, ['class' => 'mini']) ?>
        </div>
        <div class="col-md-4">
            <h2><?= $model->nombre ?><small> (<?= $model->esp->especialidad ?>)</small></h2>
            <p>Disponible de: <?= Yii::$app->formatter->asTime($model->horario_entrada, 'short') ?> hasta: <?= Yii::$app->formatter->asTime($model->horario_salida, 'short') ?></p>
        </div>
        <div class="col-md-1">
            <br>
            <?=Html::button(
                'Solicitar',
                [
                    'value' => Url::to(['entrenamientos/solicitar', 'id' => $model->id]),
                    'class' => 'showModalButton btn btn-success btn',
                ]
            ); ?>
        </div>
    </div>
</article>
<hr>
