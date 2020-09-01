<?php

function proteinuria_tohtml($protes,$comentarios,$conclusiones){
$html='<br><br><br>
		<label>Proteinas Totales Sericas: '.$protes.'</label><br>
		<br><br><br>
		<label>Conclusiones:</label><br>
		"'.$conclusiones.'"<br><br><br><br>
		<label>Comentarios:</label><br>
		"'.$comentarios.'"<br><br><br>
';
return $html;
}

function Proteinuria_Aislada(){
return '
<h1>Registrar resultado de exámen de proteinuria aislada</h1><br>
<div class="form-group">
	<form name="Proteinuria_Aislada" id="Proteinuria_Aislada" action="to_pdf.php" method="post">
			<input hidden type="text" value="Proteinuria_Aislada" name="examen" class="form-control">
		<h5>Proteinas</h5>
            <input type="text" name="protes" class="form-control" >
	</form>
	</div>
	<h5>Comentarios</h5>
	<textarea name="comentarios" form="Proteinuria_Aislada" class="form-control"></textarea>
	<h5>Conclusiones</h5> 
	<textarea name="conclusiones" form="Proteinuria_Aislada"class="form-control" ></textarea><br>
	<center>
		<input type="submit" form="Proteinuria_Aislada" value="generar PDF" class="btn btn-success">
	</center>
        
';
  }
