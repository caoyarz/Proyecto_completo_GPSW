<?php
session_start();
require 'php/conectar.php';
date_default_timezone_set("America/Santiago");
$numero_examen=1;
if (isset($_POST['boton'])) {
	while ( isset( $_POST[ 'examen' . $numero_examen ] ) ) {
		if ($_POST[ 'examen' . $numero_examen ]=='on') {
			$sql = "INSERT INTO `SGL_RECEPCIONA` (`SGL_TECNOLOGO_RUT`, `SGL_EXAMEN_REALIZADO_IDENTIFICADOR`, `SGL_RECEPCIONA_HORA`) 
				VALUES ('" . $_SESSION['user_id'] . "','" . $_SESSION[ 'examen' . $numero_examen ] . "','" . date( "Y-m-d H:i:s" ) . "')";
			$numero_examen ++;
			mysqli_query( $conn, $sql );
		}
	}
}
header('Location: /SRC/Template/recepcion_examen.php');
