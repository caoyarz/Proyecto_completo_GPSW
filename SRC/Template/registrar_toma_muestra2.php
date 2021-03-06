<?php
  session_start();
  if ($_SESSION['tipo_usuario'] != 'Tecnologo'){
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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Tecnologo Medico.php">
        <div class="sidebar-brand-icon">
          <img src="Logo.png" style="width: 61%">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Heading -->
      <div class="sidebar-heading">
        Muestras
      </div>




      <!-- Nav Item - Registrar toma de muestras -->
      <li class="nav-item">
        <a class="nav-link" href="registrar_toma_muestra.php">
          <i class="fas fa-fw fa fa-clipboard-check"></i>
          <span>Registrar toma de muestras</span></a>
      </li>

      <!-- Nav Item - Registrar recepcion de muestra  -->
      <li class="nav-item">
        <a class="nav-link" href="recepcion_examen.php">
          <i class="fas fa-fw fa fa-truck"></i>
          <span>Registrar recepcion de muestra</span></a>
      </li>

      <!-- Nav Item - Subir Resultado Exámen  -->
      <li class="nav-item">
        <a class="nav-link" href="revisar_examenes.php">
          <i class="fas fa-fw fa fa-file-upload"></i>
          <span>Subir Resultado Exámen</span></a>
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

          <?php
            $Cod=$_GET['var'];
            require 'php/conectar.php';
            $sql="select SGL_CITA_IDENTIFICADOR,SGL_PACIENTE_RUT,SGL_EXAMEN_IDENTIFICADOR from SGL_CITA where SGL_CITA_IDENTIFICADOR=$Cod";
            $result=mysqli_query($conn,$sql);
            while($mostrar=mysqli_fetch_array($result)){
                $_rut= $mostrar['SGL_PACIENTE_RUT'];
                $_cita=$mostrar['SGL_CITA_IDENTIFICADOR'];
                $id_examen=$mostrar['SGL_EXAMEN_IDENTIFICADOR'];
            }
        ?>
        <form method="post">
            <p>Rut paciente: <input class="form-control" type="text" name="rut" id="rut" readonly="readonly" value="<?php echo $_rut; ?>"/></p>
            <p>Identificador cita: <input class="form-control" type="text" name="codigo" id="codigo" readonly="readonly" value="<?php echo $_cita; ?>"/></p>
            <?php
                $sql="select SGL_EXAMEN_NOMBRE from SGL_EXAMEN where SGL_EXAMEN_IDENTIFICADOR=$id_examen";
                $result=mysqli_query($conn,$sql);
                while($mostrar=mysqli_fetch_array($result)){
                    $tipo_examen=$mostrar['SGL_EXAMEN_NOMBRE'];
                }
            ?>
            <p>Examen que se realiza: <input class="form-control" type="text" name="NombreExamen" id="NombreExamen" readonly="readonly" value="<?php echo $tipo_examen; ?>"/></p>
            <br><br>
            <center>
               <input type="submit" value="Enviar" name="enviar" class="btn btn-success"> 
            </center>
            <?php
                if(isset($_POST['enviar'])){
                    $inserion="insert into SGL_EXAMEN_REALIZADO values('$_cita','$_rut','$id_examen',$_cita)";
                    if($conn->query($inserion)==true){
                        $sql="update SGL_CITA set SGL_CITA_ESTADO='Realizada' where SGL_CITA_IDENTIFICADOR=$_cita ";
                        if ($conn->query($sql) == TRUE) {
                            echo '<script language="javascript">alert("La fecha fue cambiada exitosamente");</script>';
                        } else {
                            echo "Error al actualizar fecha: " . $conn->error;
                        }
                    }
                    else{
                        die("Error al enviar datos: " .$conn->error);
                    }
                }
            ?>
        </form>

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
