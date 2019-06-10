<?php

use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;



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


// $('.grid-view form').on('submit', function (event) {
//     event.preventDefault();
//     var form = $(event.target); // $(this)
//     var data = form.serialize();
//     $.ajax({
//         url: form.attr('action'),
//         type: 'POST',
//         data: data,
//     });
//     $.pjax.reload({container: '#pjax-grid-view'});
// });

EOF;
$this->registerJs($js);
?>

<?php if (Yii::$app->session->hasFlash('warning')) ?>

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

    <?php if (Yii::$app->user->identity->getTipoId() == 'administradores'): ?>
        <p>
            <?= Html::a('Crear Clase', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['id' => 'pjax-grid-view']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'nombre',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->nombre, ['clases/view', 'id' => $data->id]);
                    },

                ],
                'fecha:datetime',
                'monitorClase.nombre',
                [
                    'attribute' => 'plazas',
                    'value' => function ($model) {
                        return $model->plazasLibres();
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acciones',
                    'headerOptions' => ['class' => 'text-primary', 'style' => 'width:10%'],
                    'template' => '{monitor} {view} {update} {delete} {inscribirse}',
                    'buttons'=>[
                        'monitor'=>function ($url, $model) {
                            if (Yii::$app->user->identity->getTipoId() == 'administradores') {
                                return Html::button(
                                    '<i class="glyphicon glyphicon-education"></i>',
                                    [
                                        'value' => Url::to(['clases/cambiar-monitor', 'id' => $model->id]),
                                        'class' => 'showModalButton btn btn-link btn-xs'
                                    ]
                                );
                            }
                        },
                        'update' => function ($url, $model) {
                            if (Yii::$app->user->identity->getTipoId() == 'administradores') {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                    ['clases/update', 'id' => $model->id],
                                );
                            }
                        },
                        'delete' => function ($url, $model) {
                            if (Yii::$app->user->identity->getTipoId() == 'administradores') {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-trash"></span>',
                                    ['clases/delete', 'id' => $model->id],
                                    ['data-method' => 'POST'],
                                );
                            }
                        },
                        'inscribirse' => function ($url, $model) {
                            if (Yii::$app->user->identity->getTipoId() == 'clientes') {
                                if ($model->clienteInscrito()) {
                                    return Html::a(
                                        'No asistir',
                                        ['clientes-clases/delete', 'clase_id' => $model->id, 'cliente_id' => Yii::$app->user->identity->getNId()],
                                        ['class'=>'btn-sm btn-danger', 'data-method' => 'POST'],
                                    );
                                } else {
                                    return Html::beginForm(['clases/inscribirse'],'post')
                                    . Html::hiddenInput('clase_id', $model->id)
                                    . Html::hiddenInput('cliente_id', Yii::$app->user->identity->getNId())
                                    . Html::submitButton('Inscribirse', ['class' => 'btn-xs btn-success'])
                                    . Html::endForm();
                                }
                            }
                        },
                    ]
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>



</div>
