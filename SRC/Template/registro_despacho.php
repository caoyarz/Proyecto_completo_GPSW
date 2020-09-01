<?php
  session_start();
  if ($_SESSION['tipo_usuario'] != 'Tecnico'){
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

  <!-- Funciones -->

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link rel="stylesheet" href="css/registro.css">
  <link rel="stylesheet" href="css/alertify/alertify.css">
  <link rel="stylesheet" href="css/alertify/themes/default.css">
  <script src="js/jquery-3.3.1.js"></script>
  <script src="js/alertify.js"></script>
  <script type="text/javascript">
   function actualizar(){location.reload(true);}
    
  </script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Tecnico Laboratorista.php">
        <div class="sidebar-brand-icon">
          <img src="Logo.png" style="width: 61%">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Heading -->
      <div class="sidebar-heading">
        Insumos Médicos
      </div>


      <!-- Nav Item - Modificar Insumos -->
      <li class="nav-item">
        <a class="nav-link" href="ver_insumos.php">
          <i class="fas fa-fw fa-edit"></i>
          <span>Modificar Insumos</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Muestras
      </div>

      <!-- Nav Item - Registrar despacho de muestra -->
      <li class="nav-item">
        <a class="nav-link" href="registro_despacho.php">
          <i class="fas fa-fw fa-truck"></i>
          <span>Registrar despacho de muestra</span></a>
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
            include("php/conectar.php");
            $sql = "SELECT SGL_EXAMEN_REALIZADO_IDENTIFICADOR as id, SGL_EXAMEN.SGL_EXAMEN_NOMBRE as nombre
                    FROM `SGL_EXAMEN_REALIZADO` as s1
                    JOIN SGL_EXAMEN ON s1.SGL_EXAMEN_IDENTIFICADOR = SGL_EXAMEN.SGL_EXAMEN_IDENTIFICADOR          
                    WHERE NOT EXISTS(
                    SELECT s2.`SGL_examen_REALIZADO_identificador`
                    FROM `SGL_SEGUIMIENTO_MUESTRA` as s2
                    WHERE s2.`SGL_estado`= 'transporte' AND
                        s1.`SGL_examen_REALIZADO_identificador`=s2.`SGL_examen_REALIZADO_identificador`)";
            $resultado = mysqli_query($conn,$sql);
            $sql2 = "SELECT SGL_EXAMEN_REALIZADO_IDENTIFICADOR as listo
                     FROM SGL_TRANSPORTE";
            $registrado = mysqli_query($conn,$sql2);
          ?>
          <div>
            <br><br>
            <center><h1>Env&iacute;o de prueba</h1></center>
            <br><br>
            <form method="POST" action="registro_despacho.php" >
              <?php if(isset($_GET["error_ingreso"])){ ?>
              <div class="alerta">
                <?php echo $_GET["error_ingreso"]?>
              </div>
              <?php } ?>
              <?php if(isset($_GET["ingreso_correcto"])){ ?>
              <div class="correcto">
                <?php echo $_GET["ingreso_correcto"]?>
              </div>
              <?php } ?>
            <div>
              <center>
                <tr>Seleccione tipo de prueba a enviar</tr><br>
                <select  name="prueba" id="prueba">
                <?php while($resultados=mysqli_fetch_array($resultado))  {  ?>
                <option value= "<?php echo $resultados['id'] ?>"><?php echo $resultados['nombre']?><?php echo " (".$resultados['id'].")"?></option>
                <?php     }      ?>
                </select>
              </center>
            </div>
            <br><br>
            <center>
              <input type="submit" value="Enviar" class="btn btn-success" name="btn1">
            </center>
            </form>
            <?php
              if(isset($_POST['btn1'])){
                $rut= $_SESSION['user_id'];
                $hora = date("Y-m-d H:i:s");
                $idprueba = $_POST['prueba'];
                $bandera = false;
                while ($existe = mysqli_fetch_array($registrado)) {
                  if($idprueba == $existe['listo']){
                    $bandera = true;
                  }
                }
                if(!$bandera){
                  if($conn->query("INSERT INTO SGL_TRANSPORTE (SGL_TECNICO_LABORATORIO_RUT, SGL_EXAMEN_REALIZADO_IDENTIFICADOR, SGL_TRANSPORTE_HORA) values ('$rut','$idprueba','$hora')")){
                    echo "<script type='text/javascript'>
                          alertify.success('Prueba enviada con exito!');
                          </script>";
                  echo "<script type='text/javascript'>
                          setInterval('actualizar()',1000);;
                          </script>";        
                  }
                }
              }  
            ?>
            
          </div>
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