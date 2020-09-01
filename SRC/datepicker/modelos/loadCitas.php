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
 









		$sql = "SELECT    
					PACIENTE.SGL_PACIENTE_NOMBRES AS nombre_cliente, 
					PACIENTE.SGL_PACIENTE_APELLIDOS AS apellido_cliente,
					CITA.SGL_CITA_HORA AS hora,
					TECNOLOGO.SGL_TECNOLOGO_NOMBRES AS nombre_tecnologo,
					TECNOLOGO.SGL_TECNOLOGO_APELLIDOS AS apellido_tecnologo,
					EXAMEN.SGL_EXAMEN_NOMBRE AS examen
				FROM 
					((SGL_CITA AS CITA 
					LEFT JOIN SGL_TECNOLOGO AS TECNOLOGO ON CITA.SGL_TECNOLOGO_RUT = TECNOLOGO.SGL_TECNOLOGO_RUT)
					LEFT JOIN SGL_EXAMEN AS EXAMEN ON CITA.SGL_EXAMEN_IDENTIFICADOR = EXAMEN.SGL_EXAMEN_IDENTIFICADOR)
					LEFT JOIN SGL_PACIENTE AS PACIENTE ON CITA.SGL_PACIENTE_RUT
				WHERE
					CITA.SGL_CITA_ESTADO IS NOT NULL;";
		$execute = $conn->prepare($sql);
		if (!$execute->execute());
		$result = $execute->fetchAll();
		$data = array();
		foreach($result as $row)
			{
				$row["nombre_cliente"] = cleanString($row["nombre_cliente"]);
				$row["apellido_cliente"] = cleanString($row["apellido_cliente"]);
				$row["nombre_tecnologo"] = cleanString($row["nombre_tecnologo"]);
				$row["apellido_tecnologo"] = cleanString($row["apellido_tecnologo"]);
				$row["examen"] = cleanString($row["examen"]);
				$data[] = array(
									'title'   => $row["nombre_cliente"]/*." ".$row["apellido_cliente"]*/,
									'eventContent' => $row["nombre_tecnologo"]/*." ".$row["apellido_tecnologo"]."(".$row["examen"].")"*/,
									'start'   => $row["hora"]
								);
			}
			

	
		echo json_encode($data);
		
?>