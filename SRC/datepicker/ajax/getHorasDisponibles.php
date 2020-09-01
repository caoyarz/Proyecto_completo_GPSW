<?php
require __DIR__ . '/../config/database.php';	
$fecha = $_REQUEST['fecha'];
// Obteniendo registro de HORAS ocupadas
$sql = "SELECT HOUR(SGL_CITA_HORA) AS hora, SGL_CITA_ESTADO AS estado 
		FROM SGL_CITA 
		WHERE DATE(SGL_CITA_HORA) = DATE('".$fecha."')";
// AND SGL_CITA_ESTADO IS NOT NULL
$execute = $conn->prepare($sql);
	if ($execute->execute())
		{
			$datahorastomadas = $execute->fetchAll();
		}
	
 //inicializando arrays para guardar los resultados, también inicializada una variable de dominio, con posibles horas a tomar.
 $horastomadas = array();
 $horasdominio = array(8,9,10,11,12,13,14,15,16,17,18);
 $horasdisponibles = array();
 
 
 //Push de resultado de las consultas a los array.
 if (!empty($datahorastomadas))
	{
	 foreach ($datahorastomadas as $row)
		{
		array_push($horastomadas,$row['hora']);
		}
	}
 var_dump($horastomadas);
 //Buscamos por ocurrencias de horas libres que no esten en el array de tomadas pero si en dominio. Push a un array.
 foreach ($horasdominio as $horadom)
	{
		$flag = true;
		foreach ($horastomadas as $horataken)
		{
			if ($horadom == $horataken)
				{
					$flag = false;
				}
		}
		if ($flag) array_push($horasdisponibles,$horadom);
	}
	
	//Si existen ocurrencias entonces creamos un string para generar un documento html de respuesta.
	if(!empty($horasdisponibles))
	{
		$opcionesHora = "<option value=''>--</option>";
		foreach ($horasdisponibles as $hora) 
			{
		$opcionesHora .= '<option value="';
		$opcionesHora .= $fecha." ".strval($hora).":00:00";
		$opcionesHora .= '">';
		$opcionesHora .= strval($hora) . ":00";
		$opcionesHora .= "</option> \n";
			}
	}
	
	//generamos un html de respuesta.
	echo $opcionesHora;

?>