<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EjerciciosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rutina: ' . $dataProvider->models[0]->rutina->nombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ejercicios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ejercicios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <pre>
        <?php
        // $dias = 0;
        // foreach ($dataProvider->models as $key => $value) {
        //     $dataProvider->models[$key]->dia_id != 1;
        //     $dias++;
        // }
        // var_dump($dias);
        ?>
    </pre> -->


    <?php foreach ($dias as $key => $value): ?>
        <table class="table table-condensed">
            <caption><h3><?= $value ?></h3></caption>
            <thead>
                <th>Ejercicio</th>
                <th>Series</th>
                <th>Repeticiones</th>
                <th>Descanso</th>
                <th>Peso</th>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->models as $value): ?>
                    <?php if ($value->dia_id == $key): ?>
                        <tr>
                            <td><?= $value->nombre ?></td>
                            <td><?= $value->series ?></td>
                            <td><?= $value->repeticiones ?></td>
                            <td><?= $value->descanso ?></td>
                            <td><?= $value->peso ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

    <?php
    // GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     // 'filterModel' => $searchModel,
    //     'columns' => [
    //
    //         'nombre',
    //         'dia.dia',
    //         'rutina.nombre',
    //         'series',
    //         'repeticiones',
    //         'descanso',
    //         'peso',
    //
    //         ['class' => 'yii\grid\ActionColumn'],
    //     ],
    // ]);
    ?>


</div>
