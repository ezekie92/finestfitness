<?php
// _list_item.php
use yii\bootstrap\Modal;

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Monitores disponibles';
$js = <<<EOF
$(function(){
    $('.showModalButton').click(function() {
        $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
    });
});
EOF;
$this->registerJs($js);
?>

<!-- Vista modal para solicitar un entrenamiento -->
<?php
    Modal::begin([
        'closeButton' => [
              'label' => "&times;",
        ],
        'header' => 'SOLICITAR MONITOR',
        'headerOptions' => ['id' => 'modalHeader', 'class' => 'bg-primary text-center'],
        'id' => 'modal',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent' class='text-right'></div>";
    Modal::end();
?>


<h1 class="text-center"><?= Html::encode($this->title) ?></h1>
<?=
ListView::widget([
    'dataProvider' => $listaDataProvider,
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_monitores',['model' => $model]);
    },
    'summary' => false,
]);
?>
