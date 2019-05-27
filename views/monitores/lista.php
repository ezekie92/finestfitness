<?php
// _list_item.php
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Lista Monitores';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<?=
ListView::widget([
    'dataProvider' => $listaDataProvider,
    'options' => [
        'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
    ],
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_monitores',['model' => $model]);
        // echo "string";
        // or just do some echo
        // return $model->title . ' posted by ' . $model->author;
    },
    'summary' => false,
]);
?>
