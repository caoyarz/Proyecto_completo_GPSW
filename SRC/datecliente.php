<?php
require('datepicker/modelos/modelosesion.php');
if (bouncer()) forceLogout();
require('datepicker/config/database.php');
require('datepicker/vistas/formularioreserva.php');
?>