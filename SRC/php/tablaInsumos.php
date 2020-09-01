<?php
	include 'conectar.php';
	$query = "SELECT
			    SGL_INSUMO.SGL_INSUMO_IDENTIFICADOR as ID,
			    SGL_CATEGORIA_INSUMO.SGL_CATEGORIA_INSUMO_NOMBRE as Categoria,
			    SGL_PROVEEDOR.SGL_PROVEEDOR_NOMBRE as Proveedor,
			    SGL_INSUMO.SGL_INSUMO_NOMBRE as Nombre,
			    SGL_INSUMO.SGL_INSUMO_STOCK as Catidad,
			    SGL_INSUMO.SGL_INSUMO_LOTE as Lote,
			    SGL_PROVEEDOR.SGL_PROVEEDOR_CORREO as Correo,
			    SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR as IDProverdor
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
			  and SGL_INSUMO.SGL_INSUMO_STOCK<10
			  ORDER BY SGL_INSUMO.SGL_INSUMO_STOCK ASC";
	$datos = mysqli_query($conn, $query);
	echo "<table id='tablaInsumos' class='table table-striped'>";
	echo "<tr><td>ID</td><td>Categoria</td><td>Proovedor</td><td>Nombre Insumo</td><td>Cantidad</td><td>Lote</td><td></td>";
	$pedidos= array();
	$i=0;
	while  ($fila= mysqli_fetch_array($datos)){
		echo "<tr data-id=".$fila ["ID"]."><td>".$fila ["ID"]."</td>";
		echo "<td>".$fila ["Categoria"]."</td>";
		echo "<td>".$fila ["Proveedor"]."</td>";	
		echo "<td>".$fila ["Nombre"]."</td>";	
		echo "<td>".$fila ["Catidad"]."</td>";	
		echo "<td>".$fila ["Lote"]."</td>";
		if(!in_array($fila["IDProverdor"], $pedidos)){
			$pedidos[$i] = $fila["IDProverdor"];
			$i++; 
		}
	}
	echo "</table>";

	//correo

	require 'PHPMailer/PHPMailer.php';
	require 'PHPMailer/SMTP.php';
	require 'PHPMailer/Exception.php';
	require 'PHPMailer/OAuth.php';
	$mail = new PHPMailer\PHPMailer\PHPMailer();

	$enviados = 0;
	$cantidadCorreos = count($pedidos);
	for ($i=0; $i < $cantidadCorreos; $i++) { 
		$mensaje="Se necesitan los siguiente insumos a la brevedad por la cantidad de 20 <br><br>";
		$query = "	SELECT
					    SGL_INSUMO.SGL_INSUMO_NOMBRE as Nombre,
					    SGL_PROVEEDOR.SGL_PROVEEDOR_CORREO as Correo,
					    SGL_PROVEEDOR.SGL_PROVEEDOR_NOMBRE as NombreProveedor
				    FROM
				    	SGL_INSUMO
					INNER JOIN
				    	SGL_PROVEEDOR
					ON
				  		SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR=SGL_INSUMO.SGL_PROVEEDOR_IDENTIFICADOR
				  	AND SGL_INSUMO.SGL_INSUMO_STOCK<10
				  	AND SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR = '$pedidos[$i]' 
				 	ORDER BY SGL_INSUMO.SGL_INSUMO_STOCK ASC";
		$datos = mysqli_query($conn, $query);
		while  ($fila = mysqli_fetch_array($datos)){
			$mensaje =$mensaje . "-". $fila ["Nombre"]."<br> ";
			$correoDestinatario = $fila["Correo"];
			$nombreDestinatario = $fila["NombreProveedor"];
		}
		include 'enviarCorreoAutomatico.php';
	}
	echo "Se enviaron $enviados de $cantidadCorreos correos de manera correcta"
?>