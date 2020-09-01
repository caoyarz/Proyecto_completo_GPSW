<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../modelos/modelosesion.php';

$examen = $_REQUEST['examen'];
$hora = $_REQUEST['hora'];
$medico = $_REQUEST['medico'];

if (bouncer())
	{
		header("location: index.php");
	}
	
else
	
	{
		$paciente = $_SESSION['user_id'];
	}
	
function insert($conn,$paciente,$examen,$hora,$medico)
	{	
		$sql = "INSERT INTO SGL_CITA(SGL_PACIENTE_RUT,SGL_CITA_HORA,SGL_CITA_MEDICO_SOLICITANTE,SGL_EXAMEN_IDENTIFICADOR)
				VALUES ('".$paciente."','".$hora."','".$medico."',".$examen.");";	
		$execute = $conn->prepare($sql);

		if ($execute->execute())
			{
				$datahorastomadas = $execute->fetchAll();
			}
	}
	//Dejo este espacio por si es necesario validaciones.
	insert($conn,$paciente,$examen,$hora,$medico);

	//generamos un html de respuesta.
	echo '<script language="javascript">';
	echo 'alert("Fecha solicitada con exito.")';
	echo '</script>';
	
?>