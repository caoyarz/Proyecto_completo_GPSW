<?php
  session_start();
  if ($_SESSION['tipo_usuario'] != 'Secretaria'){
    header('Location: /SRC/Template/login.php');
  }
  date_default_timezone_set("America/Santiago");

?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laboratorio Clínico del Doctor Novis Seltsam</title>

  <!-- Custom fonts for this template-->
  <link rel="icon" type="image/jpeg" href="../logo.jpeg" />
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">


  <!-- Funciones -->

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/alertify/alertify.css">
  <link rel="stylesheet" href="../css/alertify/themes/default.css">
  <script src="../js/jquery-3.3.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="../js/alertify.js"></script>
  <script src="../js/enviarCorreo.js"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../Secretaria.php">
        <div class="sidebar-brand-icon">
          <img src="../Logo.png" style="width: 61%">
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
        <a class="nav-link" href="../RegistrarLlegada.php">
          <i class="fas fa-fw fa fa-check"></i>
          <span>Registrar llegada de paciente</span></a>
      </li>

      <!-- Nav Item - Ver resultados examenes  -->
      <li class="nav-item">
        <a class="nav-link" href="../MOSTRAR_EXAMENES_Secretaria.php">
          <i class="fas fa-fw fa fa-file-medical"></i>
          <span>Resultados de examenes</span></a>
      </li>

      <!-- Nav Item - registrar nuevo paciente  -->
      <li class="nav-item">
        <a class="nav-link" href="../registro_Secretaria.php">
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
            <a class="collapse-item" href="tablaInsumos.php">A todos automaticamente</a>
            <a class="collapse-item" href="../porProveedor.php">Seleccionar Proveedor</a>
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
        <a class="nav-link" href="../dateshow.php">
          <i class="fas fa-calendar"></i>
          <span>Mostrar Citas</span></a>
      </li>

      <!-- Nav Item - Confirmar Solicitudes de Hora -->
      <li class="nav-item">
        <a class="nav-link" href="../dateconfirmar.php">
          <i class="fas fa-clipboard-check"></i>
          <span>Confirmar Solicitudes de Hora</span></a>
      </li>

      <!-- Nav Item - Modificar horario toma de muestras -->
      <li class="nav-item">
        <a class="nav-link" href="../modificar_horario_toma_muestra.php">
          <i class="fas fa-fw fa-calendar-alt"></i>
          <span>Modificar horario toma de muestras</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <a type="button" href="logout.php" class="btn btn-danger" >Cerrar sesion</a>


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
        	include 'conectar.php';
			$ID =$_POST['inputIDProveedor'];
			$query = "SELECT
			    	SGL_CATEGORIA_INSUMO.SGL_CATEGORIA_INSUMO_NOMBRE as Categoria,
				    SGL_INSUMO.SGL_INSUMO_NOMBRE as Nombre,
				    SGL_INSUMO.SGL_INSUMO_STOCK as Cantidad,
				    SGL_INSUMO.SGL_INSUMO_LOTE as Lote,
				    SGL_PROVEEDOR.SGL_PROVEEDOR_CORREO as Correo,
					SGL_PROVEEDOR.SGL_PROVEEDOR_NOMBRE as nombreProveedor
				FROM
			    	SGL_INSUMO
				INNER JOIN
				    SGL_CATEGORIA_INSUMO
				ON
				    SGL_INSUMO.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR = SGL_CATEGORIA_INSUMO.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR 
				INNER JOIN
				    SGL_PROVEEDOR
				ON
				  SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR=SGL_INSUMO.SGL_PROVEEDOR_IDENTIFICADOR
				  AND SGL_INSUMO.SGL_INSUMO_STOCK<10
				  AND SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR = '$ID'
				  ORDER BY SGL_INSUMO.SGL_INSUMO_STOCK ASC";
			$datos = mysqli_query($conn, $query);
			echo"<div class='container'>";
			echo "<table id='tablaInsumos' class='table table-striped'>";
			echo "<tr><td>Categoria</td><td>Nombre Insumo</td><td>Cantidad</td><td>Lote</td>";
			$correo= "";
			$nombreProveedor = "";
			while  ($fila= mysqli_fetch_array($datos)){
				echo "<tr data-id=".$fila ["Categoria"]."> <td>".$fila ["Categoria"]."</td>";	
				echo "<td>".$fila ["Nombre"]."</td>";	
				echo "<td>".$fila ["Cantidad"]."</td>";	
				echo "<td>".$fila ["Lote"]."</td>";
				$correo = $fila["Correo"];
				$nombreProveedor = $fila["nombreProveedor"];
			}
			echo "</table>";


			//correo


			$mensaje= "Se necesitan los siguiente insumos a la brevedad por la cantidad de 20 \n";
			$query = "	SELECT
						    SGL_INSUMO.SGL_INSUMO_NOMBRE as Nombre,
						    SGL_PROVEEDOR.SGL_PROVEEDOR_CORREO as Correo
					    FROM
					    	SGL_INSUMO
						INNER JOIN
					    	SGL_PROVEEDOR
						ON
					  		SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR=SGL_INSUMO.SGL_PROVEEDOR_IDENTIFICADOR
					  	AND SGL_INSUMO.SGL_INSUMO_STOCK<10
					 	AND SGL_PROVEEDOR.SGL_PROVEEDOR_IDENTIFICADOR = '$ID' 
					 	ORDER BY SGL_INSUMO.SGL_INSUMO_STOCK ASC";
			$datos = mysqli_query($conn, $query);
			$cant=3;
			while  ($fila = mysqli_fetch_array($datos)){
				$mensaje .="-".$fila["Nombre"]."\n";
				$cant++;
			}
			?>
			<form method='POST'>
				<input type="text" name="correo" id="correo" disabled hidden value=<?php echo $correo; ?> >
				<input type="text" name="nombreProveedor" id="nombreProveedor" disabled hidden value='<?php echo $nombreProveedor; ?>'>
				<textarea  type='fieldtext'class='form-control' name="mensaje" id="mensaje" rows=<?php echo $cant; ?> ><?php echo $mensaje; ?> </textarea>
				<div class="text-center">
					<br><br>
					<input type='buttom' class='btn btn-success' value='Enviar' id='botonBuscar' onclick="Enviar()">
				</div>
			</form>
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
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>