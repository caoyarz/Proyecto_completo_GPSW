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

          <h1>Registrar toma de muestra</h1>
          <?php require 'php/conectar.php';    ?>
          <table class="table table-bordered dataTable">
              <tr>
                  <th>Rut paciente</th>
                  <th>hora cita</th>
              </tr>
              <?php
                $fecha_inicial = date('Y-m-d 00:00:00');
                $fecha_final=date('Y-m-d 23:59:59');
                  $id=$_SESSION['user_id'];
                  $fecha_actual=date("Y-m-d ");
                  $sql="select SGL_PACIENTE_RUT,SGL_CITA_HORA,SGL_CITA_IDENTIFICADOR from SGL_CITA where SGL_TECNOLOGO_RUT='".$id."' 
                        and SGL_CITA_IDENTIFICADOR not in (select SGL_CITA_IDENTIFICADOR from SGL_CITA 
                                                           where SGL_PACIENTE_RUT='".$id."' and SGL_CITA_ESTADO='Realizada')";
                  $result=mysqli_query($conn,$sql);
                  while($mostrar=mysqli_fetch_array($result)){
                  if($mostrar['SGL_CITA_HORA']>$fecha_inicial && $mostrar['SGL_CITA_HORA']<$fecha_final){
                          $rut=$mostrar['SGL_CITA_IDENTIFICADOR'];
                          echo "<tr>";
                          echo"<th> <a href='registrar_toma_muestra2.php?var=$rut'>";
                          echo $mostrar['SGL_PACIENTE_RUT'];
                          echo"</a></th>";
                          echo"<th>";
                          echo $mostrar['SGL_CITA_HORA'];
                          echo"</th>";
                          echo"</tr>";
                  }
                  }
              ?>
          </table>

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
