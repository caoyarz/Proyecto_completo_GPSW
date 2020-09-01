<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modificar horario de toma de muestra</title>
</head>
<body>
 <?php
    $cod=$_GET['var'];
    $host = "mysqltrans.face.ubiobio.cl";
    $user = "G1gestions2";
     $password = "G1s2gestion20-1";
    $bd = "G1s2gestion_bd";
    $conexion = mysqli_connect($host, $user, $password, $bd);
    $sql="select SGL_PACIENTE_RUT from SGL_CITA where SGL_CITA_IDENTIFICADOR=$cod";
    $result=mysqli_query($conexion,$sql);
    while($mostrar=mysqli_fetch_array($result)){
        $_rut= $mostrar['SGL_PACIENTE_RUT'];
    }
    date_default_timezone_set('America/Santiago');
    $fechaActual = date('Y-m-d H:i:s');
 ?>
    <form method="post" >
        <p>Rut paciente: <input type="text" name="rut" id="rut" readonly="readonly" value="<?php echo $_rut; ?>"/></p>
        <p>Nueva fecha de cita</p>
        <input type="datetime" name="fecha" id="fecha" value="<?= $fechaActual?>">
        <br><br>
        <input type="submit" value="Cambiar" name="cambiar">
    </form>
    <?php
        if(isset($_POST['cambiar'])){
            $fechaingresada=$_POST['fecha'];
            if($fechaActual<$fechaingresada){
                $sql="update SGL_CITA set SGL_CITA_HORA='".$fechaingresada."' where SGL_CITA_IDENTIFICADOR=$cod ";
                if ($conexion->query($sql) == TRUE) {
                    echo '<script language="javascript">alert("La fecha fue cambiada exitosamente");</script>';
                } else {
                    echo "Error al actualizar fecha: " . $conexion->error;
                }
            }
            else{
                echo '<script language="javascript">alert("La fecha ingresada no es valida");</script>';
            }
        }
    ?>
</body>
</html>