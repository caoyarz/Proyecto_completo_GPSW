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

  <!-- Funciones -->

  <link rel="stylesheet" href="css_insumos/tablas.css">

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

            <center><h1>Inventario de insumos médicos</h1></center>
            <a href="registrar_insumos.php"><input type="button" value="+ Ingresar nuevo insumo" class="boton_registrar"></a>

            <!-- Cabecera de la tabla-->
            <table class="tabla">
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th >Lote</th>
                    <th >Cantidad</th>
                    <th >Acciones</th>
                </tr>
            <?php

            include ("php/conectar.php");
            # Obtiene el total de insumos registrados
            $sql_registro=mysqli_query($conn,"SELECT COUNT(*) AS total_registro FROM SGL_INSUMO");
            $resultado_sql_registro=mysqli_fetch_array($sql_registro);
            $total_registro=$resultado_sql_registro['total_registro'];

            #variable para guardar el total de registros que se mostraran por pagina
            $cantidad_pagina=10;

            if(empty($_GET['pagina'])){
                $pagina=1; #si el get esta vacio dirige a la primera pagina
            }else{
                $pagina = $_GET['pagina']; #recupera el dato del get que es la pagina que corresponde
            }
            $desde = ($pagina-1)*$cantidad_pagina;# guarda desde que registro se mostrara en la tabla 
            $total_paginas=ceil($total_registro/$cantidad_pagina);#total de paginas para todos los registros 

            #obtiene los datos de insumos para la tabla ordenados por nombre y limitado por la cantidad de registros por paginas
                $query =
                    "SELECT  S.SGL_INSUMO_IDENTIFICADOR,S.SGL_INSUMO_NOMBRE,C.SGL_CATEGORIA_INSUMO_NOMBRE,S.SGL_INSUMO_LOTE,S.SGL_INSUMO_STOCK FROM SGL_INSUMO S INNER JOIN SGL_CATEGORIA_INSUMO C ON S.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR=C.SGL_CATEGOTIA_INSUMO_IDENTIFICADOR ORDER BY S.SGL_INSUMO_NOMBRE ASC LIMIT $desde,$cantidad_pagina";

                $result = mysqli_query($conn, $query);
                    if (!$result) {
                        echo "Ocurrió un error.";
                        exit;
                    }
                    while ($row =mysqli_fetch_array($result)) { ?> <!--obtiene el resultado de la consulta como array-->
                        <tr><!--agrega los datos de la consulta a la tabla-->
                            <td  ><?php echo "$row[1]" ?></td>
                            <td ><?php echo "$row[2]" ?></td>
                            <td ><?php echo "$row[3]" ?></td>
                            <td ><?php echo "$row[4]" ?></td>
                            <!-- botones para editar y modificar insumos, mandan como parametro el id de la fila-identificador del insumo-->
                           <td> <a href="modificar_insumos.php?id=<?php echo "$row[0]" ?>" class="boton-editar">Editar </a>
                           |
                            <a href="eliminar_insumos.php?id=<?php echo "$row[0]" ?>" class="boton-eliminar">Eliminar</a></td>
                        </tr>
                        <?php
                        }
                        ?>
            </table>
            <div class="paginador">
                <ul>
                    <?php
                    #paginador- 
                    if($pagina != 1){
                    ?>
                    <li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
                    <li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
                    <?php
                    }
                    for ($i=1; $i<=$total_paginas; $i++) { 
                        if($i == $pagina){
                            echo '<li class="pagina_seleccionada">'.$i.'</li>';
                        }else{
                             echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                        }
                    }
                    if($pagina != $total_paginas){
                    ?>
                    <li><a href="?pagina=<?php echo $pagina+1; ?>">>></a></li>
                    <li><a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
                    <?php } ?> 
                </ul>
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
