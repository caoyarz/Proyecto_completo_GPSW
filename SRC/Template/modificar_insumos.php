<?php
  session_start();
  if ($_SESSION['tipo_usuario'] != 'Tecnico' ){
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
              if(empty($_POST['nombre']) || empty($_POST['stock'])|| empty($_POST['lote'])){
             $alerta= '<p class="msg_error"><strong>Falta ingresar datos</strong></p>';
             
              }else{
                #recibe los datos
                $idInsumo=$_POST['idinsumo'];
                $nombre=$_POST['nombre'];
                $categoria=$_POST['categoria'];
                $proveedor=$_POST['proveedor'];
                $t_minima=$_POST['t_minima'];
                $t_maxima=$_POST['t_maxima'];
                $stock=$_POST['stock'];
                $lote=$_POST['lote'];
                
                if($stock<=0){
                  $alerta= '<p class="msg_error"><strong>La cantidad del insumo debe ser mayor a 1</strong></p>';
                }else{
            #sql para acutalizar el insumo con los nuevos datos ingresados
                $actualizar=mysqli_query($conn,"UPDATE SGL_INSUMO SET SGL_CATEGOTIA_INSUMO_IDENTIFICADOR='$categoria',SGL_PROVEEDOR_IDENTIFICADOR='$proveedor',SGL_INSUMO_NOMBRE='$nombre',SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MINIMA='$t_minima',SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MAXIMA='$t_maxima',SGL_INSUMO_STOCK='$stock',SGL_INSUMO_LOTE='$lote' WHERE SGL_INSUMO_IDENTIFICADOR = '$idInsumo'");

                if($actualizar){
                
                 $alerta= '<p class="msg_save"><strong>Actualización exitosa</strong></p>';
               
                }else{
                  $alerta= '<p class="msg_error"><strong>Error en la actualización.</strong></p>';
                   
                }
              }
              }
            }

            if(empty($_GET['id'])){
             header( 'Location: ver_insumos.php' );
            }
            $idinsumo=$_GET['id']; #guarda el id recibido de la pagina ver_insumos
            #trae de la BD los datos correspondientes al id recuperado 
            $sql=mysqli_query($conn,"SELECT S.SGL_INSUMO_IDENTIFICADOR,S.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR,C.SGL_CATEGORIA_INSUMO_NOMBRE, S.SGL_PROVEEDOR_IDENTIFICADOR,P.SGL_PROVEEDOR_NOMBRE,S.SGL_INSUMO_NOMBRE,S.SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MINIMA,S.SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MAXIMA,S.SGL_INSUMO_STOCK,S.SGL_INSUMO_LOTE  FROM SGL_INSUMO S , SGL_CATEGORIA_INSUMO C, SGL_PROVEEDOR P WHERE S.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR=C.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR AND S.SGL_PROVEEDOR_IDENTIFICADOR=P.SGL_PROVEEDOR_IDENTIFICADOR AND SGL_INSUMO_IDENTIFICADOR='$idinsumo'");

            $respuesta=mysqli_num_rows($sql);
            if($respuesta==0){ #si no encuentra respuesta de la consulta redirige a la lista de insumos
              header('Location: ver_insumos.php');
            }else{
              while($datos=mysqli_fetch_array($sql)){
                #recupera los datos de la consulta para mostrarlos en los inputs
                $id_insumo = $datos['SGL_INSUMO_IDENTIFICADOR'];
                $nombre_categoria = $datos['SGL_CATEGORIA_INSUMO_NOMBRE'];
                $nombre_proveedor= $datos['SGL_PROVEEDOR_NOMBRE'];
                $insumo_nombre = $datos['SGL_INSUMO_NOMBRE'];
                $insumo_t_min = $datos['SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MINIMA'];
                $insumo_t_max = $datos['SGL_INSUMO_TEMPERATURA_ALMACENAMIENTO_MAXIMA'];
                $insumo_stock = $datos['SGL_INSUMO_STOCK'];
                $insumo_lote = $datos['SGL_INSUMO_LOTE'];
              }
            }
            ?>

              <section class="container">
              <div class="form_registro_insumo">
                <h1>Actualización datos insumo</h1>
                <hr>
                <div class="alerta"> <?php echo isset($alerta) ? $alerta : ''; ?> </div>
                <!-- en los value se ingresan los datos recuperados en la consulta-->
                <form action="" method="POST">
                  <input type="hidden" name="idinsumo" value="<?php echo $id_insumo; ?>">
                <!--ingresar nombre  -->
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" id="nombre" value="<?php echo $insumo_nombre; ?>" required>
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
                  <input type="number" id="t_minima" name="t_minima" value="<?php echo $insumo_t_min; ?>" min="0" max="100" required>
                  <!--  ingreso temperatura maxima-->
                    <label for="t_maxima">Temperatura máxima</label>
                  <input type="number" id="t_maxima" name="t_maxima" value="<?php echo $insumo_t_max; ?>" min="0" max="100" required>
                  <!--  ingreso stock-->
                    <label for="stock">Cantidad</label>
                  <input type="number" id="stock" name="stock" value="<?php echo $insumo_stock; ?>" required>
                  <!--  ingreso lote-->
                    <label for="lote">Lote</label>
                  <input type="text" id="lote" name="lote" value="<?php echo $insumo_lote; ?>" required>

                  <input type="submit" value="Actualizar" class="boton_agregar">

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
