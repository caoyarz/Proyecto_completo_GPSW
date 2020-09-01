<?php
  session_start();
  if ($_SESSION['tipo_usuario'] != 'Paciente'){
    header('Location: /SRC/Template/login.php');
  }
  date_default_timezone_set("America/Santiago");

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laboratorio Clínico del Doctor Novis Seltsam</title>

  <!-- Custom fonts for this template-->
  <link rel="icon" type="image/jpeg" href="logo.jpeg" />
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Paciente.php">
        <div class="sidebar-brand-icon">
          <img src="Logo.png" style="width: 61%">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">


      <!-- Nav Item - Reservar hora para examen -->
      <li class="nav-item">
        <a class="nav-link" href="datecliente.php">
          <i class="fas fa-fw fa fa-calendar-plus"></i>
          <span>Reservar hora para examen</span></a>
      </li>

      <!-- Nav Item - Ver resultados examenes  -->
      <li class="nav-item">
        <a class="nav-link" href="MOSTRAR_EXAMENES.php">
          <i class="fas fa-fw fa fa-file-medical"></i>
          <span>Resultados de examenes</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <a type="button" href="php/logout.php" class="btn btn-danger" >Cerrar sesion</a>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <h3>Laboratorio Clínico</h3>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <form method="POST" action="MOSTRAR_EXAMENES.php" >
        <?php 
            include ("CONEXION_Chicallo.php");
            $db=new Conect_MySql();
            $rut = $_SESSION['user_id'];
            $sql2 = "SELECT s.SGL_SECRETARIA_RUT FROM SGL_SECRETARIA s" ;
            $query2 = $db->execute($sql2);
            $bandera = 0;
            // A continuacion se verifica si es que el usuario es secretaria o un paciente
            while($dato2=$db->fetch_row($query2)){
                if($rut == $dato2['SGL_SECRETARIA_RUT'])
                $bandera = 1;
            }
            if($bandera == 0){
        ?>
                <h1> Resultados examenes </h1>
                <br>
                <br>
                <!-- Se crea una tabla con los datos de los examenes del paciente que ha iniciado la sesion -->
                <table class="table table-bordered dataTable ">
                    <tr>
                        <td>Examen </td>
                        <td>Medico </td>
                        <td>Fecha </td>
                        <td>Ver </td>
                    </tr>
                    <?php
                        $sql = "SELECT  e.SGL_EXAMEN_NOMBRE, c.SGL_CITA_MEDICO_SOLICITANTE, c.SGL_CITA_HORA, re.SGL_RESULTADO_EXAMEN_DOCUMENTO
                                FROM SGL_RESULTADO_EXAMEN re
                                INNER JOIN SGL_EXAMEN_REALIZADO er
                                ON re.SGL_EXAMEN_REALIZADO_IDENTIFICADOR = er.SGL_EXAMEN_REALIZADO_IDENTIFICADOR
                                INNER JOIN SGL_EXAMEN e
                                ON er.SGL_EXAMEN_IDENTIFICADOR = e.SGL_EXAMEN_IDENTIFICADOR
                                INNER JOIN SGL_CITA c
                                ON er.SGL_CITA_IDENTIFICADOR = c.SGL_CITA_IDENTIFICADOR
                                WHERE re.SGL_PACIENTE_RUT = '".$rut." '   
                                ORDER BY (c.SGL_CITA_HORA) DESC;";
                        $query = $db->execute($sql);
                        while($dato=$db->fetch_row($query)){?>
                            <tr>
                                <td> <?php echo $dato['SGL_EXAMEN_NOMBRE']; ?>    </td>
                                <td> <?php echo $dato['SGL_CITA_MEDICO_SOLICITANTE']; ?>    </td>
                                <td> <?php echo $dato['SGL_CITA_HORA']; ?>    </td>
                                <td><a href="archivoPdf.php?id=<?php echo $dato['SGL_RESULTADO_EXAMEN_DOCUMENTO']?>"><?php echo $dato['SGL_RESULTADO_EXAMEN_DOCUMENTO']; ?> </a></td>
                            </tr>
                        <?php  } ?>
                </table>
        <?php }else{ ?>

                <h1> Resultados examenes pacientes </h1>
                <br>
                <br>
                <!-- se crea un campo para escribir el rut del usuario -->
                <div class="form-group">
                    <label for="rut_paciente">Rut</label>
                    <input type="text" name="rut_paciente" class="form-control" id="rut_paciente" placeholder="12.345.678-9" required maxlength="12">
                    <input type="submit" value="Buscar Citas" class="btn btn-success" name="btn1">
                </div>

                <br>

                <div>
                    <?php
                        //  Al presionar el boton de buscar citas se realizaran las siguientes acciones
                        if(isset($_POST['btn1']))
                        {
                            $sql5= "SELECT SGL_PACIENTE_RUT from SGL_PACIENTE  ;";
                            $query5 = $db->execute($sql5);
                            $rut5 = $_POST['rut_paciente'];
                            $rut_existe = 0;
                            // Se verifica si es que el rut fue ingresado correctamente
                            while($dato5=$db->fetch_row($query5)){
                                if ($rut5 == $dato5['SGL_PACIENTE_RUT'])
                                $rut_existe = 1;
                            }
                            // Se creara una tabla con la informacion de los examenes del paciente solicitado y en caso de que este mal ingresado se mostrara una alerta
                            if($rut_existe == 1)
                            {
                                    $rut_paciente = $_POST['rut_paciente'];
                                    $sql3= "SELECT  e.SGL_EXAMEN_NOMBRE, c.SGL_CITA_MEDICO_SOLICITANTE, c.SGL_CITA_HORA, re.SGL_RESULTADO_EXAMEN_DOCUMENTO
                                            FROM SGL_RESULTADO_EXAMEN re
                                            INNER JOIN SGL_EXAMEN_REALIZADO er
                                            ON re.SGL_EXAMEN_REALIZADO_IDENTIFICADOR = er.SGL_EXAMEN_REALIZADO_IDENTIFICADOR
                                            INNER JOIN SGL_EXAMEN e
                                            ON er.SGL_EXAMEN_IDENTIFICADOR = e.SGL_EXAMEN_IDENTIFICADOR
                                            INNER JOIN SGL_CITA c
                                            ON er.SGL_CITA_IDENTIFICADOR = c.SGL_CITA_IDENTIFICADOR
                                            WHERE re.SGL_PACIENTE_RUT = '".$rut_paciente."'
                                            ORDER BY (c.SGL_CITA_HORA) DESC;";
                                    $query3 = $db->execute($sql3); 
                                ?>
                                    <tr><i><b>Citas </b></i> </tr>
                                </div>
                                <br>
                                <br>
                                <table class="table table-bordered dataTable ">
                                    <tr>
                                        <td>Examen </td>
                                        <td>Medico </td>
                                        <td>Fecha </td>
                                        <td>Ver </td>
                                    </tr>
                                    <?php
                                        while($dato3=$db->fetch_row($query3)){?>
                                            <tr>
                                                <td> <?php echo $dato3['SGL_EXAMEN_NOMBRE']; ?>    </td>
                                                <td> <?php echo $dato3['SGL_CITA_MEDICO_SOLICITANTE']; ?>    </td>
                                                <td> <?php echo $dato3['SGL_CITA_HORA']; ?>    </td>
                                                <td><a href="archivoPdf.php?id=<?php echo $dato3['SGL_RESULTADO_EXAMEN_DOCUMENTO']?>"><?php echo $dato3['SGL_RESULTADO_EXAMEN_DOCUMENTO']; ?> </a></td>
                                            </tr>
                                        <?php  } ?>
                                </table>
        <?php     
                            }else{
                                //alerta
                                echo '<script language="javascript">';
                                echo 'alert("Rut no valido")';
                                echo '</script>';
                                exit;
                            }  
        } }?>
        
        

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Novis Seltsam 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>