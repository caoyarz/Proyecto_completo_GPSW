<?php
    $host="localhost";
    $user="root";
    $password="";
    $database="G1s2gestionres_bd";
    $conn= mysqli_connect($host, $user, $password, $database);
    if(!$conn) echo "Error al conectar a la Base de Datos";		
?>