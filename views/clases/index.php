<?php

use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ClasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clases';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOF
$(function(){
    $('.showModalButton').click(function() {
        //if modal isn't open; open it and load content
        $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
    });
});
EOF;
$this->registerJs($js);
?>

<!-- Vista modal para cambiar el monitor asignado a una clase -->
<?php
    Modal::begin([
        'closeButton' => [
              'label' => "&times;",
        ],
        'header' => 'CAMBIAR MONITOR',
        'headerOptions' => ['id' => 'modalHeader', 'class' => 'bg-primary text-center'],
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent' class='text-right'></div>";
    Modal::end();
?>

<div class="clases-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Clase', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nombre',
            'hora_inicio',
            'hora_fin',
            'diaClase.dia',
            'monitorClase.nombre',
            'plazas',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'headerOptions' => ['class' => 'text-primary', 'style' => 'width:10%'],
                'template' => '{monitor} {view} {update} {delete}',
                'buttons'=>[
                    'monitor'=>function ($url, $model) {
                        return Html::button(
                            '<i class="glyphicon glyphicon-education"></i>',
                            [
                                'value' => Url::to(['clases/cambiar-monitor', 'id' => $model->id]),
                                'class' => 'showModalButton btn btn-link btn-xs'
                            ]
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>
