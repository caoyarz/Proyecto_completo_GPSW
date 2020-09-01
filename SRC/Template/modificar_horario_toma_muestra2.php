<?php
  session_start();
  if ($_SESSION['tipo_usuario'] != 'Secretaria'){
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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Secretaria.php">
        <div class="sidebar-brand-icon">
          <img src="Logo.png" style="width: 61%">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Heading -->
      <div class="sidebar-heading">
        Pacientes
      </div>




      <!-- Nav Item - Registrar llegada de paciente -->
      <li class="nav-item">
        <a class="nav-link" href="RegistrarLlegada.php">
          <i class="fas fa-fw fa fa-check"></i>
          <span>Registrar llegada de paciente</span></a>
      </li>

      <!-- Nav Item - Ver resultados examenes  -->
      <li class="nav-item">
        <a class="nav-link" href="MOSTRAR_EXAMENES_Secretaria.php">
          <i class="fas fa-fw fa fa-file-medical"></i>
          <span>Resultados de examenes</span></a>
      </li>

      <!-- Nav Item - registrar nuevo paciente  -->
      <li class="nav-item">
        <a class="nav-link" href="registro_Secretaria.php">
          <i class="fas fa-fw fa fa-user-plus"></i>
          <span>Registrar nuevo paciente</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Proveedores
      </div>

      <!-- Nav Item - Enviar Correo -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-envelope-open-text"></i>
          <span>Solicitar insumos médicos a proveedores</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Enviar Correos:</h6>
            <a class="collapse-item" href="php/tablaInsumos.php">A todos automaticamente</a>
            <a class="collapse-item" href="porProveedor.php">Seleccionar Proveedor</a>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Gestión de Horas
      </div>

      <!-- Nav Item - Mostrar Citas -->
      <li class="nav-item">
        <a class="nav-link" href="dateshow.php">
          <i class="fas fa-calendar"></i>
          <span>Mostrar Citas</span></a>
      </li>

      <!-- Nav Item - Confirmar Solicitudes de Hora -->
      <li class="nav-item">
        <a class="nav-link" href="dateconfirmar.php">
          <i class="fas fa-clipboard-check"></i>
          <span>Confirmar Solicitudes de Hora</span></a>
      </li>

      <!-- Nav Item - Modificar horario toma de muestras -->
      <li class="nav-item">
        <a class="nav-link" href="modificar_horario_toma_muestra.php">
          <i class="fas fa-fw fa-calendar-alt"></i>
          <span>Modificar horario toma de muestras</span></a>
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
            $cod=$_GET['var'];
            require 'php/conectar.php';
            $sql="select SGL_PACIENTE_RUT from SGL_CITA where SGL_CITA_IDENTIFICADOR=$cod";
            $result=mysqli_query($conn,$sql);
            while($mostrar=mysqli_fetch_array($result)){
                $_rut= $mostrar['SGL_PACIENTE_RUT'];
            }
            date_default_timezone_set('America/Santiago');
            $fechaActual = date('Y-m-d H:i:s');
         ?>
            <form method="post" >
                <p>Rut paciente: <input class="form-control" type="text" name="rut" id="rut" readonly="readonly" value="<?php echo $_rut; ?>"/></p>
                <p>Nueva fecha de cita</p>
                <input class="form-control" type="datetime" name="fecha" id="fecha" value="<?= $fechaActual?>">
                <br><br>
                <center>
                    <input type="submit" value="Cambiar" name="cambiar" class="btn btn-success">
                </center>
                
            </form>
            <?php
                if(isset($_POST['cambiar'])){
                    $fechaingresada=$_POST['fecha'];
                    if($fechaActual<$fechaingresada){
                        $sql="update SGL_CITA set SGL_CITA_HORA='".$fechaingresada."' where SGL_CITA_IDENTIFICADOR=$cod ";
                        if ($conn->query($sql) == TRUE) {
                            echo '<script language="javascript">alert("La fecha fue cambiada exitosamente");</script>';
                        } else {
                            echo "Error al actualizar fecha: " . $conn->error;
                        }
                    }
                    else{
                        echo '<script language="javascript">alert("La fecha ingresada no es valida");</script>';
                    }
                }
            ?>

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
