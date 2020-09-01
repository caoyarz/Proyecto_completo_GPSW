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
  <link rel="stylesheet" href="css_insumos/formulario.css">
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
          include ("php/conectar.php");

          if(!empty($_POST)){
            $alerta='';
            #recupera el id enviado a la pagina y hace la consulta para eliminarlo
            $idinsumo=$_POST['idinsumo'];
            $sql_eliminar=mysqli_query($conn,"DELETE FROM SGL_INSUMO WHERE SGL_INSUMO_IDENTIFICADOR='$idinsumo'");
            if($sql_eliminar){
          header( 'Location: ver_insumos.php' );
            }else{
          $alerta= '<p class="msg_error"><strong>Error en la eliminación del registro</strong></p>';
            }
          }

          if(empty($_REQUEST['id'])){
           header( 'Location: ver_insumos.php' );
          }else{
            $idinsumo=$_GET['id'];
            #se guarda el id enviado a la pagina y se traen sus datos desde la BD
            $sql_mostrar=mysqli_query($conn,"SELECT S.SGL_INSUMO_IDENTIFICADOR,S.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR,C.SGL_CATEGORIA_INSUMO_NOMBRE, S.SGL_PROVEEDOR_IDENTIFICADOR,P.SGL_PROVEEDOR_NOMBRE,S.SGL_INSUMO_NOMBRE,S.SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MINIMA,S.SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MAXIMA,S.SGL_INSUMO_STOCK,S.SGL_INSUMO_LOTE  FROM SGL_INSUMO S , SGL_CATEGORIA_INSUMO C, SGL_PROVEEDOR P WHERE S.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR=C.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR AND S.SGL_PROVEEDOR_IDENTIFICADOR=P.SGL_PROVEEDOR_IDENTIFICADOR AND SGL_INSUMO_IDENTIFICADOR='$idinsumo'");

            $respuesta=mysqli_num_rows($sql_mostrar);

            if($respuesta > 0){
              #recuperacion de los datos
              while($datos=mysqli_fetch_array($sql_mostrar)){
              $id_insumo = $datos['SGL_INSUMO_IDENTIFICADOR'];
              $nombre_categoria = $datos['SGL_CATEGORIA_INSUMO_NOMBRE'];
              $nombre_proveedor= $datos['SGL_PROVEEDOR_NOMBRE'];
              $insumo_nombre = $datos['SGL_INSUMO_NOMBRE'];
              $insumo_t_min = $datos['SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MINIMA'];
              $insumo_t_max = $datos['SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MAXIMA'];
              $insumo_stock = $datos['SGL_INSUMO_STOCK'];
              $insumo_lote = $datos['SGL_INSUMO_LOTE'];
              }
            }else{
              header( 'Location: ver_insumos.php' );
            }
            }
          ?>
          <section class="container">
          <!--mostrar los datos del id que se quiere eliminar-->
          <div class="form_registro_insumo">
          <h2>¿Está seguro de eliminar el registro?</h2>
          <div class="alerta"> <?php echo isset($alerta) ? $alerta : ''; ?> </div>
            <form action="" method="POST">
            <p>Nombre:<span><?php echo  $insumo_nombre;?> </span></p>
            <p>Categoría:<span><?php echo  $nombre_categoria;?> </span></p>
            <p>Proveedor:<span><?php echo  $nombre_proveedor;?> </span></p>
            <p>Cantidad:<span><?php echo  $insumo_stock;?> </span></p>
            <p>Lote:<span><?php echo  $insumo_lote;?> </span></p>
          <input type="hidden" name="idinsumo" value="<?php echo  $idinsumo;?>">
            <input type="submit" value="Eliminar Registro" class="boton_borrar">

                  <a href="ver_insumos.php"><input type="button" value="Cancelar" class="boton_cancelar"></a>
            </form>
          </div>
          </section>


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
