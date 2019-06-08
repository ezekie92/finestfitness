<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\models\HorariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="horarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

<table class="table horario">
        <thead>
            <tr>
                <td></td>
                <?php foreach ($dataProvider->models as $key => $value) : ?>
                    <th><?= Html::a($value->nombreDia->dia, ['update', 'id' => $value->id], ['data-toggle'=>"tooltip", 'title'=>"Modificar horario"]) ?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Apertura</th>
                <?php foreach ($dataProvider->models as $key => $value) : ?>
                    <td><?= $value->apertura ?></td>
                <?php endforeach ?>
            </tr>
            <tr>
                <th>Cierre</th>
                <?php foreach ($dataProvider->models as $key => $value) : ?>
                    <td><?= $value->cierre ?></td>
                <?php endforeach ?>
            </tr>
        </tbody>
    </table>

</div>
