<?php
require __DIR__ . '/../config/database.php';	
$id = $_REQUEST['id'];
$sql = "DELETE FROM SGL_CITA WHERE SGL_CITA_IDENTIFICADOR = ".$id.";";
$execute = $conn->prepare($sql);
$execute->execute();
?>