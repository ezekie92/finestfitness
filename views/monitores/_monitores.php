<?php
// Define como se verá el listado de monitores
?>

<article class="container" data-key="<?= $model->id ?>">
    <div class="row">
        <div class="col-md-1">
            <img src="" alt="Aquí irá la foto">
        </div>
        <div class="col-md-9">
            <h2><?= $model->nombre ?><small> (<?= $model->esp->especialidad ?>)</small></h2>
            <p>Disponible de: <?= Yii::$app->formatter->asTime($model->horario_entrada, 'short') ?> hasta: <?= Yii::$app->formatter->asTime($model->horario_salida, 'short') ?></p>
        </div>
    </div>
</article>
<hr>
