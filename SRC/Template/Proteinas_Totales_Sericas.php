<?php

function proteina_tohtml($protes,$comentarios,$conclusiones){
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

function Proteinas_Totales_Sericas(){
return '
<h1>Registrar resultado de exámen de proteínas totales Sericas</h1><br>
<div class="form-group">
	<form name="Proteinas_Totales_Sericas" id="Proteinas_Totales_Sericas" action="to_pdf.php" method="post">
			<input hidden type="text" value="Proteinas_Totales_Sericas" name="examen">
		<h5 >Proteinas Totales</h5>
            <input type="text" name="protes" class="form-control">
	</form>
	</div>
	<h5>Comentarios</h5>
	<textarea name="comentarios" form="Proteinas_Totales_Sericas"  class="form-control"></textarea>
	<h5>Conclusiones</h5> 
	<textarea name="conclusiones" form="Proteinas_Totales_Sericas" class="form-control"></textarea><br>
	<center>
		<input class="btn btn-success" type="submit" form="Proteinas_Totales_Sericas" value="generar PDF" >
	</center>
        
';
  }
