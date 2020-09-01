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
  <link rel="stylesheet" href="css/alertify/alertify.css">
  <link rel="stylesheet" href="css/alertify/themes/default.css">
  <script src="js/jquery-3.3.1.js"></script>
  <script src="js/alertify.js"></script>

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

          <!-- Page Heading -->
          <center><h1>Ingrese datos del paciente</h1></center>
          <form method="POST" action="registro_Secretaria.php" >

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

          <div class="form-group">
            <label for="rut">Rut</label>
            <input type="text" name="rut" class="form-control" id="rut" placeholder="12.345.678-9" required maxlength="12">
          </div>

          <div class="form-group">
            <label for="correo">Correo </label>
            <input type="email" name="correo" class="form-control" id="correo" placeholder="drnovis@gmail.com" required>
          </div>

          <div class="form-group">
            <label for="nacimiento">Fecha Nacimiento </label>
            <input type="date" name="nacimiento" class="form-control" id="nacimiento" placeholder="05/06/1990" required>
          </div>

          <div class="form-group">
            <label for="nombre">Nombre </label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingrese su nombre" required>
          </div>

          <div class="form-group">
            <label for="apellido">Apellido </label>
            <input type="text" name="apellido" class="form-control" id="apellido" placeholder="Ingrese su apellido" required>
          </div>

          <div class="form-group">
            <label for="telefono">Tel&eacute;fono </label>
            <br>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">+569</div>
              </div>
              <input type="tel" name="telefono" id="telefono" placeholder="Ingrese su n&uacute;mero" required minlength="8" maxlength="8" class="form-control"> 
            </div>            
          </div>

          <div class="form-group">
            <label for="password">Contraseña </label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese su contraseña" required>
          </div>

          <div class="form-group">
            <label for="confirmacion">Confirmar Contraseña </label>
            <input type="password" name="confirmacion" class="form-control" id="confirmacion" placeholder="Confirme su contraseña" required>
          </div>
          
          <center>
            <input type="submit" value="Enviar" class="btn btn-success" name="btn1">

          </center>

        </form>

        <?php
          if(isset($_POST['btn1']))
          {
            include("php/conectar.php");
            
            $rut=$_POST['rut'];
            $correo=$_POST['correo'];
            $nacimiento=$_POST['nacimiento'];
            $nombre=$_POST['nombre'];
            $apellido=$_POST['apellido'];
            $telefono=$_POST['telefono'];
            $password=$_POST['password'];
            $confirmacion=$_POST['confirmacion'];
            $query="SELECT SGL_PACIENTE_RUT as rut FROM SGL_PACIENTE";
            $registrado=mysqli_query($conn,$query);

            #validación de rut
            $rut = preg_replace('/[^k0-9]/i', '', $rut);    #cambia los distintos a espacios en blanco 
            $dv  = substr($rut, -1);        #entrega el digito verificador 
            $numero = substr($rut, 0, strlen($rut)-1);  #entrega el rut sin digito verificador
            $i = 2;
            $suma = 0;
            foreach(array_reverse(str_split($numero)) as $v)
            {
                if($i==8)
                    $i = 2;
                $suma += $v * $i;
                ++$i;
            }

            $dvr = 11 - ($suma % 11);

            if($dvr == 11)
                $dvr = 0;
            if($dvr == 10)
                $dvr = 'K';

            if($dvr == strtoupper($dv)){
                $arr1 = str_split($rut);
                $arr1[9]=$arr1[7];
                $arr1[10]="-";
                $arr1[11]=$arr1[8];
                $arr1[8]=$arr1[6];
                $arr1[7]=$arr1[5];
                $arr1[6]=".";
                $arr1[5]=$arr1[4];
                $arr1[4]=$arr1[3];
                $arr1[3]=$arr1[2];
                $arr1[2]=".";
                $rut = implode($arr1);
            }
            else{
                echo "<script type='text/javascript'>
                  alertify.error('Rut invalido');
                </script>";
                exit;
            }

            #Validación numero de teléfono
            $Verif_telefono = preg_replace('/[^0-9]/i', '', $telefono);
            if($telefono <> $Verif_telefono){
              echo "<script type='text/javascript'>
                  alertify.alert('Numero de telefono invalido');
                </script>";  
              exit;
            }

            #Validación nombre y apellido
            $patrones=array();
            $patrones[0]='/[,]/';
            $patrones[1]='/[.]/';
            $patrones[2]='/[-]/';
            $patrones[3]='/[}]/';
            $patrones[4]='/[{]/';
            $patrones[5]='/[(]/';
            $patrones[6]='/[)]/';
            $patrones[7]='/[0]/';
            $patrones[8]='/[1]/';
            $patrones[9]='/[2]/';
            $patrones[10]='/[3]/';
            $patrones[11]='/[4]/';
            $patrones[12]='/[5]/';
            $patrones[13]='/[6]/';
            $patrones[14]='/[7]/';
            $patrones[15]='/[8]/';
            $patrones[16]='/[9]/';
            $patrones[17]='/[*]/';
            $patrones[18]='/[:]/';
            $patrones[19]='/[;]/';
            $patrones[20]='/[_]/';

            $valid_nombre= preg_replace($patrones,'',$nombre);
            $valid_apellido= preg_replace($patrones,'',$apellido);
            if($valid_apellido!=$apellido){
                echo "<script type='text/javascript'>
                  alertify.alert('Apellido invalido');
                </script>";  
                exit;
            }else if($valid_nombre!=$nombre){
               echo "<script type='text/javascript'>
                  alertify.alert('Nombre invalido');
                </script>";  
                exit;
            }
            $estaRegistrado=false;
            while ($fila= mysqli_fetch_array($registrado) ) {
              if($rut==$fila["rut"]){
                $estaRegistrado=true;
              }
            }

            if( !$estaRegistrado){
              if($password == $confirmacion){
               $conn->query("INSERT INTO SGL_PACIENTE (SGL_PACIENTE_RUT,SGL_PACIENTE_CORREO,SGL_PACIENTE_NACIMIENTO,SGL_PACIENTE_NOMBRES,SGL_PACIENTE_APELLIDOS,SGL_PACIENTE_TELEFONO,SGL_PACIENTE_PASSWORD) values ('$rut','$correo','$nacimiento','$nombre','$apellido','$telefono','$password')");

                  echo "<script type='text/javascript'>
                    alertify.success('Paciente registrado correctamente');
                  </script>";
              }
              else{
                echo "<script type='text/javascript'>
                  alertify.alert('Confirmacion contraseña invalido');
                </script>"; 
                exit; 
              }
            }
            else{
               echo "<script type='text/javascript'>
                  alertify.alert('El rut ya se encuentra registrado');
                </script>"; 
                exit; 
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
