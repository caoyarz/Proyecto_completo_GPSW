<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='datepicker/lib/main.css' rel='stylesheet' />
<script src='datepicker/lib/main.js'></script>
<script src='datepicker/lib/locales/es.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
	  initialView: 'listMonth',
	  locale: 'es',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true,
	  events: 'datepicker/ajax/loadCitas.php'// display business hours
    });

    calendar.render();
  });

</script>
<style>



  #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>