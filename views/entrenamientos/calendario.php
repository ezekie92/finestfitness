<?php

use yii\helpers\Url;

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
        <?php foreach ($entrenamientos as $key => $value): ?>
        {
            title: "<?= $value->cliente->nombre ?>",
            start: "<?= $value->fecha ?>",
            url: "<?= Url::toRoute(['clientes/view', 'id' => $value->cliente_id]) ?>",
        },
        <?php endforeach; ?>
      ]
    });

    calendar.render();
    });
</script>

 <div id='calendar'></div>
