<?php
require __DIR__ . '/../modelos/modeloconfirmacion.php';
?>

<?php
echo drawTecnologoDropdown($conn);
drawTabla($conn);
?>

<script src="datepicker/js/confirmacionHoraForm.js"></script>
