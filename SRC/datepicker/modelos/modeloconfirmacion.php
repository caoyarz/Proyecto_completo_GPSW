<?php


function getSolicitudes($conn)
	{
		$sql = "		SELECT  PACIENTE.SGL_PACIENTE_RUT AS rut,
						PACIENTE.SGL_PACIENTE_NOMBRES AS nombres, 
						PACIENTE.SGL_PACIENTE_APELLIDOS AS apellidos,
						PACIENTE.SGL_PACIENTE_CORREO AS correo,
						CITA.SGL_CITA_IDENTIFICADOR AS id,
						CITA.SGL_CITA_HORA AS hora,
						CITA.SGL_CITA_MEDICO_SOLICITANTE AS medico,
						EXAMEN.SGL_EXAMEN_NOMBRE AS examen
				FROM 	(SGL_CITA AS CITA 
				JOIN 	SGL_PACIENTE AS PACIENTE 
				ON		CITA.SGL_PACIENTE_RUT = PACIENTE.SGL_PACIENTE_RUT)
				JOIN	SGL_EXAMEN AS EXAMEN ON EXAMEN.SGL_EXAMEN_IDENTIFICADOR = CITA.SGL_EXAMEN_IDENTIFICADOR
				WHERE   CITA.SGL_CITA_ESTADO IS NULL ;";
		$execute = $conn->prepare($sql);
		if ($execute->execute())
			{
				return $execute->fetchAll();
			}
	}

function drawSolicitudes($solicitudes)
	{
		$HTMLsolicitudes = "<tbody>";
			foreach ($solicitudes as $solicitud)
				{
					
					$HTMLsolicitudes .= "<tr id='tr-".$solicitud['id']."'>";
					$HTMLsolicitudes .= "<td>".$solicitud['nombres']."</td>";
					$HTMLsolicitudes .= "<td>".$solicitud['apellidos']."</td>";
					$HTMLsolicitudes .= "<td>".$solicitud['examen']."</td>";
					$HTMLsolicitudes .= "<td>".$solicitud['hora']."</td>";
					$HTMLsolicitudes .= "<td><button type='button' id='cnf-".$solicitud['id']."' data-id='".$solicitud['id']."' disabled class='btn btn-success btn-confirma'>Confirmar</button></td>";
					$HTMLsolicitudes .= "<td><button type='button' id='del-".$solicitud['id']."' data-id='".$solicitud['id']."' class='btn btn-success btn-rechaza'>Rechazar</button></td>";
					$HTMLsolicitudes .= "</tr>";
				}
		$HTMLsolicitudes .= "</tbody>";
		return $HTMLsolicitudes;
	}
function drawHeaderTabla()
	{
		    $HTMLheader = "<thead>";
			$HTMLheader	.= "<tr>";
			$HTMLheader .= "<th>Nombres</th>";
			$HTMLheader .= "<th>Apellidos</th>";
			$HTMLheader .= "<th>Examen</th>";
			$HTMLheader .= "<th>Hora</th>";
			$HTMLheader .= "<th>Confirmar</th>";
			$HTMLheader .= "<th>Rechazar</th>";
			$HTMLheader .= "</tr>";
			$HTMLheader .= "</thead>";
			return $HTMLheader;
	}
	
function getTecnologos($conn)
	{
				$sql = "SELECT SGL_TECNOLOGO_RUT AS id, 
						SGL_TECNOLOGO_NOMBRES AS nombres, 
						SGL_TECNOLOGO_APELLIDOS AS apellidos
						FROM SGL_TECNOLOGO;";
				$execute = $conn->prepare($sql);
				if ($execute->execute())
					{
						return $execute->fetchAll();
					}
	}

function drawTecnologoOpciones($data)
	{
		$OpcionesHTML = "";
		foreach ($data as $row) 
			{
		$OpcionesHTML .= "<option value='" . 
						$row['id'] . "'>" . 
						$row['nombres'] ." ".$row['apellidos']. "</option> \n";
			}
		return $OpcionesHTML;
	}
function drawTecnologoDropdown($conn)
	{
		$DropdownHTML = "";
		$DropdownHTML .= '<label for="tecnologo">Confirmar hora para el siguiente tecnologo:</label>
						 <select id="tecnologo-drop" name="tecnologo">';
		$DropdownHTML .='<option selected value="base">Seleccione tecnologo deseado...</option>';
		$DropdownHTML .= drawTecnologoOpciones(getTecnologos($conn));
		$DropdownHTML .= '</select>';
		return $DropdownHTML;
	}


function drawTabla($conn)
	{
		$solicitudes = getSolicitudes($conn);
		echo '<table class="table">';
		echo drawHeaderTabla();
		echo drawSolicitudes($solicitudes);
		echo '</table>';
	}
	



	
?>