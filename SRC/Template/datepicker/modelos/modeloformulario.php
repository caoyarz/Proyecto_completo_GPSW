<?php
require __DIR__ . '/../config/database.php';




function getExamenes($conn)
	{
		$sql = "SELECT SGL_EXAMEN_IDENTIFICADOR AS id, 
				SGL_EXAMEN_INSTRUCCIONES AS tooltip, 
				SGL_EXAMEN_NOMBRE AS examen 
				FROM SGL_EXAMEN";
		$execute = $conn->prepare($sql);
		if ($execute->execute())
			{
				return $execute->fetchAll();
			}
		//else dieHandler("Error crítico de conexión a la base de datos",$execute->error);
	}

function drawExamenOpciones($data)
	{
		$OpcionesHTML = "";
		foreach ($data as $row) 
			{
		$OpcionesHTML .= "<option value='" . 
						$row['id'] . "' title='". 
						$row['tooltip'] . "'>" . 
						$row['examen'] . "</option> \n";
			}
		return $OpcionesHTML;
	}


	
function drawExamenDropdown($conn)
	{
		$DropdownHTML = "";
		$DropdownHTML .= '<label for="examen">Examen:</label>
						 <select id="examen" name="examen" class="form-control">';
		$DropdownHTML .='<option selected value="base">Seleccione examen deseado...</option>';
		$DropdownHTML .= drawExamenOpciones(getExamenes($conn));
		$DropdownHTML .= '</select>';
		return $DropdownHTML;
	}

function drawDatepicker()
	{
		$today = date('Y-m-d',time());
//<input type="date" name="cumpleanios" step="1" min="2013-01-01" max="2013-12-31" value="<?php echo date("Y-m-d");">
		$DateHTML = "";
		$DateHTML .= '<label for="agenda">Consultar disponibilidad de fecha deseada: </label>';
		$DateHTML .= '<input type ="date" ';
		$DateHTML .= 'name="agenda" ';
		$DateHTML .= 'id="agenda" ';
		$DateHTML .= 'step="1" ';
		$DateHTML .= 'min="';
		$DateHTML .= $today;
		$DateHTML .= '" value="';
		$DateHTML .= $today;
		$DateHTML .= '" class="form-control">';
		return $DateHTML;
	}
?>