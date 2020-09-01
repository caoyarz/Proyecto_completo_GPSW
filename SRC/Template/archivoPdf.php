<!DOCTYPE html>




<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include ("CONEXION_Chicallo.php");
        $db=new Conect_MySql();
            $sql = "SELECT  re.SGL_RESULTADO_EXAMEN_DOCUMENTO
            FROM SGL_RESULTADO_EXAMEN re where re.SGL_RESULTADO_EXAMEN_DOCUMENTO='".$_GET['id']."'";
            $query = $db->execute($sql);
            if($datos=$db->fetch_row($query))
            {
                if($datos['SGL_RESULTADO_EXAMEN_DOCUMENTO']=="")
                {   ?>
                <p>NO tiene archivos</p>
                <?php 
                } else { 
                        header('content-type: application/pdf'); 
                        header('Location: /SRC/Template/'.$_GET['id']);
                        } 
            } 
                 ?>
    </body>


</html>