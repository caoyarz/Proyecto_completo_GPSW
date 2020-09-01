<?php
require __DIR__ . '/../modelos/modeloformulario.php';
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reserva de hora</title>

<style type="text/css">
select{ 
 width:250px;
 padding:5px;
 border-radius:3px;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<div class="container">
		<?php echo drawExamenDropdown($conn);?>
		<hr />
		<?php echo drawDatepicker();?>
		<hr />
		<label for="medico">Medico solicitante: </label>
		<input name="medico" type="text" id="medico" placeholder="Inserte nombre de medico solicitante." class="form-control">
		<hr />
    
	<label for="hora">Horas Disponibles: </label>
	<select name="hora" id="hora" class="form-control">
		<option value=""> -- </option>
       <!-- Records will be displayed here -->
	</select>
    </div>
	
	<hr />
	<center>
		<button id="submit" disabled class="btn btn-success">Solicitar reserva</button>
	</center>
	
    

<script src="datepicker/js/solicitudHoraForm.js"></script>
