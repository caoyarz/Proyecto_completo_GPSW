<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/alertify/alertify.css">
<link rel="stylesheet" href="../css/alertify/themes/default.css">
<script src="../js/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="../js/alertify.js"></script>
<script src="../js/enviarCorreo.js"></script>
<?php
	include 'conectar.php';
	$ID =$_POST['inputIDProveedor'];
	$query = "SELECT
			    SGL_INSUMO.SGL_INSUMO_IDENTIFICADOR as ID,
			    SGL_CATEGORIA_INSUMO.SGL_CATEGORIA_INSUMO_NOMBRE as Categoria,
			    SGL_INSUMO.SGL_INSUMO_NOMBRE as Nombre,
			    SGL_INSUMO.SGL_INSUMO_STOCK as Catidad,
			    SGL_INSUMO.SGL_INSUMO_LOTE as Lote,
			    SGL_PROVEEDOR.SGL_PROVEEDOR_CORREO as Correo,
				SGL_PROVEEDOR.SGL_PROVEEDOR_NOMBRE as nombreProveedor
			FROM
			    SGL_INSUMO
			INNER JOIN
			    SGL_CATEGORIA_INSUMO
			ON
			    SGL_INSUMO.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR = SGL_CATEGORIA_INSUMO.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR 
			INNER JOIN
			    SGL_PROVEEDOR
			ON
			  SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR=SGL_INSUMO.SGL_PROVEEDOR_IDENTIFICADOR
			  AND SGL_INSUMO.SGL_INSUMO_STOCK<10
			  AND SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR = '$ID'
			  ORDER BY SGL_INSUMO.SGL_INSUMO_STOCK ASC";
	$datos = mysqli_query($conn, $query);
	echo"<div class='container'>";
	echo "<table id='tablaInsumos' class='table table-striped'>";
	echo "<tr><td>ID</td><td>Categoria</td><td>Nombre Insumo</td><td>Cantidad</td><td>Lote</td>";
	$correo= "";
	$nombreProveedor = "";
	while  ($fila= mysqli_fetch_array($datos)){
		echo "<tr data-id=".$fila ["ID"]."><td>".$fila ["ID"]."</td>";
		echo "<td>".$fila ["Categoria"]."</td>";	
		echo "<td>".$fila ["Nombre"]."</td>";	
		echo "<td>".$fila ["Catidad"]."</td>";	
		echo "<td>".$fila ["Lote"]."</td>";
		$correo = $fila["Correo"];
		$nombreProveedor = $fila["nombreProveedor"];
	}
	echo "</table>";


	//correo


	$mensaje= "Se necesitan los siguiente insumos a la brevedad por la cantidad de 20 \n";
	$query = "	SELECT
				    SGL_INSUMO.SGL_INSUMO_NOMBRE as Nombre,
				    SGL_PROVEEDOR.SGL_PROVEEDOR_CORREO as Correo
			    FROM
			    	SGL_INSUMO
				INNER JOIN
			    	SGL_PROVEEDOR
				ON
			  		SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR=SGL_INSUMO.SGL_PROVEEDOR_IDENTIFICADOR
			  	AND SGL_INSUMO.SGL_INSUMO_STOCK<10
			 	AND SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR = '$ID' 
			 	ORDER BY SGL_INSUMO.SGL_INSUMO_STOCK ASC";
	$datos = mysqli_query($conn, $query);
	$cant=3;
	while  ($fila = mysqli_fetch_array($datos)){
		$mensaje .="-".$fila["Nombre"]."\n";
		$cant++;
	}
	?>
		<form method='POST'>
			<input type="text" name="correo" id="correo" disabled hidden value=<?php echo $correo; ?> >
			<input type="text" name="nombreProveedor" id="nombreProveedor" disabled hidden value='<?php echo $nombreProveedor; ?>'>
			<textarea  type='fieldtext'class='form-control' name="mensaje" id="mensaje" rows=<?php echo $cant; ?> ><?php echo $mensaje; ?> </textarea>
			<div class="text-center">
				<br><br>
				<input type='buttom' class='btn btn-success' value='Enviar' id='botonBuscar' onclick="Enviar()">
			</div>
		</form>
	</div>;
