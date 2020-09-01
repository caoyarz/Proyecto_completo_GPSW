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
              #si el post no viene vacio ,deja el mensaje de alerta vacio, recupera los parametros enviados del formulario a esta misma pagina

                $nombre=$_POST['nombre'];
                $categoria=$_POST['categoria'];
                $proveedor=$_POST['proveedor'];
                $t_minima=$_POST['t_minima'];
                $t_maxima=$_POST['t_maxima'];
                $stock=$_POST['stock'];
                $lote=$_POST['lote'];

                if($stock <=0){
                  $alerta= '<p class="msg_error"><strong>La cantidad del insumo debe ser mayor a 1</strong></p>';
                }else{
            #sql para la insersion de los datos a la base de datos
                $insertar=mysqli_query($conn,"INSERT into SGL_INSUMO (SGL_CATEGOTIA_INSUMO_IDENTIFICADOR,SGL_PROVEEDOR_IDENTIFICADOR,SGL_INSUMO_NOMBRE,SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MINIMA,SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MAXIMA,SGL_INSUMO_STOCK,SGL_INSUMO_LOTE) values ($categoria,'$proveedor','$nombre','$t_minima','$t_maxima','$stock','$lote')");

                #mensajes de respuesta 
                if($insertar){
                
                 $alerta= '<p class="msg_save"><strong>Registro exitoso</strong></p>';
               
                }else{
                  $alerta= '<p class="msg_error"><strong>El nombre de insumo ya se encuentra registrado</strong></p>';
                }
              }
            }

            ?>
              <section class="container">
              <div class="form_registro_insumo">
                <h1>Registro insumo</h1>
                <hr>
                <div class="alerta"> <?php echo isset($alerta) ? $alerta : ''; ?> </div>
                <form action="" method="POST">
                <!--ingresar nombre  -->
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" id="nombre" required>
                <!-- ingresar categorias-->
                  <label for="categoria">Categoria</label>
                  <select name="categoria" id="categoria" required>
                <!--traer categorias de la BD -->
                  <?php
                    
                    $consulta_categorias ="SELECT * FROM SGL_CATEGORIA_INSUMO";
                    $resultado_categorias = mysqli_query($conn, $consulta_categorias);
                    if (!$resultado_categorias) {
                      echo "Ocurrió un error.";
                      exit;
                    }
                    while ($row =mysqli_fetch_array($resultado_categorias)) { ?>
                      <option value=" <?php echo $row[0]; ?>" > <?php echo $row[1]; ?></option>
                      
                   <?php 
                      } 
                    ?>
                  </select>

                  <!-- ingresar proveedores-->
                  <label for="proveedor">Proveedor</label>
                  <select name="proveedor" id="proveedor" required>
                <!--traer proveedores de la BD -->
                  <?php
                    $consulta_proevedores ="SELECT * FROM SGL_PROVEEDOR";
                    $resultado_proveedores = mysqli_query($conn, $consulta_proevedores);
                    if (!$resultado_proveedores) {
                      echo "Ocurrió un error.";
                      exit;
                    }
                    while ($row =mysqli_fetch_array($resultado_proveedores)) { ?>
                      <option value="<?php echo $row[0]; ?>" > <?php echo $row[1]; ?></option>
                   <?php 
                      } 
                    ?>
                  </select>
                  
                  <!--  ingreso temperatura minima-->
                  <label for="t_minima">Temperatura mínima</label>
                  <input type="number" id="t_minima" name="t_minima" min="0" max="100" required>
                  <!--  ingreso temperatura maxima-->
                    <label for="t_maxima">Temperatura máxima</label>
                  <input type="number" id="t_maxima" name="t_maxima" min="0" max="100" required>
                  <!--  ingreso stock-->
                    <label for="stock">Cantidad</label>
                  <input type="number" id="stock" name="stock" required>
                  <!--  ingreso lote-->
                    <label for="lote">Lote</label>
                  <input type="text" id="lote" name="lote" required>

                  <input type="submit" value="Agregar insumo" class="boton_agregar">

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