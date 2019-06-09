<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clases';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'list' ],
      locale: 'es-us',

      header: {
        left: 'title',
        center: '',
        right: 'listDay,listWeek,dayGridMonth'
      },

      // customize the button names,
      // otherwise they'd all just say "list"
      views: {
        listDay: { buttonText: 'Hoy' },
        listWeek: { buttonText: 'Semana' }
      },

      defaultView: 'listWeek',
      defaultDate: "<?= date('Y-m-d') ?>",
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: [
        <?php foreach ($clases as $key => $value): ?>
        {
            title: "<?= $value->nombre ?>",
            start: "<?= $value->fecha ?>",
            url: "<?= Url::toRoute(['clases/calendario', 'filtro' => $value->nombre]) ?>",
        },
        <?php endforeach; ?>
      ]
    });

    calendar.render();
    });
</script>

<?php if (isset($_GET['filtro'])) : ?>
    <?= Html::a('Limpar filtro', ['clases/calendario'], ['class' => 'btn btn-primary']) ?>
<?php endif ?>

 <div id='calendar'></div>
