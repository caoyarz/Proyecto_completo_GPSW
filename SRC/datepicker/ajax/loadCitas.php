<?php
require('../config/database.php');

header('Content-Type: text/html; charset=UTF-8');


function cleanString($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á','à','ä','â','ª','Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
	
	return $string;
}
 





function getCliente($conn,$id)
	{
		$sql = "SELECT    
					PACIENTE.SGL_PACIENTE_NOMBRES AS nombre_cliente, 
					PACIENTE.SGL_PACIENTE_APELLIDOS AS apellido_cliente
				FROM SGL_PACIENTE AS PACIENTE
				WHERE SGL_PACIENTE_RUT = '".$id."';";
		$execute = $conn->prepare($sql);
		if (!$execute->execute());
		$result = $execute->fetchAll();
		foreach($result as $row)
			{
				$cliente = $row['nombre_cliente']." ".$row['apellido_cliente'];
			}
		return $cliente;
	}

function getTecnologo($conn,$id)
	{
		$sql = "SELECT    
					TECNOLOGO.SGL_TECNOLOGO_NOMBRES AS nombre_tecnologo,
					TECNOLOGO.SGL_TECNOLOGO_APELLIDOS AS apellido_tecnologo
				FROM SGL_TECNOLOGO AS TECNOLOGO
				WHERE SGL_TECNOLOGO_RUT = '".$id."';";
		$execute = $conn->prepare($sql);
		if (!$execute->execute());
		$result = $execute->fetchAll();
		foreach($result as $row)
			{
				$tecnologo = $row['nombre_tecnologo']." ".$row['apellido_tecnologo'];
			}
		return $tecnologo;
	}

function getExamen($conn,$id)
	{
		$sql = "SELECT    
					EXAMEN.SGL_EXAMEN_NOMBRE AS examen
				FROM SGL_EXAMEN AS EXAMEN
				WHERE SGL_EXAMEN_IDENTIFICADOR = ".$id.";";
		$execute = $conn->prepare($sql);
		if (!$execute->execute());
		$result = $execute->fetchAll();
		foreach($result as $row)
			{
				$examen = $row['examen'];
			}
		return $examen;
	}



		$sql = "SELECT CITA.SGL_TECNOLOGO_RUT AS tecnologo,
					   CITA.SGL_PACIENTE_RUT AS paciente,
					   CITA.SGL_EXAMEN_IDENTIFICADOR AS examen,
					   CITA.SGL_CITA_HORA AS hora
				FROM 
						SGL_CITA AS CITA 

				WHERE
					CITA.SGL_CITA_ESTADO IS NOT NULL;";
		$execute = $conn->prepare($sql);
		if (!$execute->execute());
		$result = $execute->fetchAll();
		$data = array();
		foreach($result as $row)
			{
				$paciente = getCliente($conn,$row['paciente']);
				$tecnologo = getTecnologo($conn,$row['tecnologo']);
				$examen = getExamen($conn,$row['examen']);
				$data[] = array(
									'title'   => $paciente." toma ".$examen." atendido por ".$tecnologo." ",
									'eventContent' => $examen,
									'start'   => $row["hora"]
								);
			}
			

		echo json_encode($data);
		
?>