<?php

function orina_tohtml($aspecto,$glucosuria,$proteina,$hemoglobina,$ph,$densidad,$cetonicos,$bilirrubina,$urobili,$nitri,$comentarios,$conclusiones){
$html='<br><br><br>
		<label>Aspecto: '.$aspecto.'</label><br>
		<label>Glucosuria: '.$glucosuria.'</label><br>
		<label>Proteína: '.$proteina.'</label><br>
		<label>Hemoglobina: '.$hemoglobina.'</label><br>
		<label>Ph: '.$ph.'</label><br>
		<label>Densidad: '.$densidad.'</label><br>
		<label>C. Cetónicos: '.$cetonicos.'</label><br>
		<label>Bilirrubina: '.$bilirrubina.'</label><br>
		<label>Urobilinógeno: '.$urobili.'</label><br>
		<label>Nitritos: '.$nitri.'</label><br>
		<br><br><br>
		<label>Conclusiones:</label><br>
		"'.$conclusiones.'"<br><br><br><br>
		<label>Comentarios:</label><br>
		"'.$comentarios.'"<br><br><br>
';
return $html;
}

function orina_completa(){
return '
<h1>Registrar resultado de exámen de orina</h1><br>
<div class="form-group">
	<form name="orina_completa" id="orina_completa" action="to_pdf.php" method="post">
			<input hidden type="text" value="orina_completa" name="examen">
		<label class="">Aspecto</label>
            <input type="text" name="aspecto" class="form-control">
		<label class="">Glucosuria</label>
            <input type="text" name="glucosuria" class="form-control">
		<label class="">Proteína</label>
            <input type="text" name="proteina" class="form-control">
        <label class="">Hemoglobina</label>
            <input type="text" name="hemoglobina" class="form-control">
		<label class="">Ph</label>
            <input type="number" max="12" min="1" step="0.01" name="ph" class="form-control">
		<label class="">Densidad</label>
            <input type="number" min="0" name="densidad" class="form-control">
		<label class="">C. Cetónicos</label>
            <input type="text" name="cetonicos" class="form-control">
		<label class="">Bilirrubina</label>
            <input type="text" name="bilirrubina" class="form-control">
		<label class="">Urobilinógeno</label>
            <input type="text" name="urobili" class="form-control">
		<label class="">Nitritos</label>
            <input type="text" name="nitri" class="form-control"><br>

	</form>
	</div>
	<h5>Comentarios</h5>
	<textarea name="comentarios" form="orina_completa" class="form-control"></textarea>
	<h5>Conclusiones</h5> 
	<textarea name="conclusiones" form="orina_completa" class="form-control"></textarea><br>
	<center>
		<input type="submit" form="orina_completa" value="generar PDF" class="btn btn-success" >
	</center>
        
';
  }
