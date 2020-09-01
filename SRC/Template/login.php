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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/alertify/alertify.css">
  <link rel="stylesheet" href="css/alertify/themes/default.css">
  <script src="js/jquery-3.3.1.js"></script>
  <script src="js/alertify.js"></script>


</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bienvenido</h1>
                  </div>
                  <form class="user" action="login.php" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="InputRut" name="rut" aria-describedby="emailHelp" placeholder="Ingrese su Rut">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="InputPassword" name="password" placeholder="Contraseña">
                    </div>
                    <button type="submit" class="btn btn-success">Ingresar</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="registro.php">Regístrate</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
session_start();

require 'php/conectar.php';
if (isset($_SESSION['user_id'])) {
  if ($_SESSION['tipo_usuario'] == 'Tecnico')
    header('Location: /SRC/Template/Tecnico Laboratorista.php');
  if ($_SESSION['tipo_usuario'] == 'Tecnologo')
    header('Location: /SRC/Template/Tecnologo Medico.php');
  if($_SESSION['tipo_usuario'] == 'Secretaria')
    header('Location: /SRC/Template/Secretaria.php');
  if($_SESSION['tipo_usuario'] == 'Paciente')
    header('Location: /SRC/Template/Paciente.php');
}

if (!empty($_POST['rut']) && !empty($_POST['password'])) {
  $rut=$_POST['rut'];
  $password= $_POST['password'];
  $query = "SELECT SGL_SECRETARIA_RUT, SGL_SECRETARIA_PASSWORD FROM SGL_SECRETARIA WHERE SGL_SECRETARIA_RUT ='" . $rut . "' and SGL_SECRETARIA_PASSWORD='" . $password . "'";
  if ( mysqli_num_rows($results = mysqli_query( $conn, $query))==1 ) {
    $_SESSION['user_id']      = $rut;
    $_SESSION['tipo_usuario'] = 'Secretaria';
    header('Location: /SRC/Template/Secretaria.php');
  } else {
    $query = "SELECT SGL_TECNOLOGO_RUT, SGL_TECNOLOGO_PASSWORD FROM SGL_TECNOLOGO WHERE SGL_TECNOLOGO_RUT ='" . $rut . "' and SGL_TECNOLOGO_PASSWORD='" . $password . "'";
    if ( mysqli_num_rows($results = mysqli_query( $conn, $query))==1 ) {
      $_SESSION['user_id']      = $rut;
      $_SESSION['tipo_usuario'] = 'Tecnologo';
      header('Location: /SRC/Template/Tecnologo Medico.php');
    } else{
      $query= "SELECT `SGL_TECNICO_LABORATORIO_RUT`, `SGL_TECNICO_LABORATORIO_PASSWORD` FROM `SGL_TECNICO_LABORATORIO` WHERE `SGL_TECNICO_LABORATORIO_RUT`='".$rut."' AND `SGL_TECNICO_LABORATORIO_PASSWORD`='".$password."'";
      if ( mysqli_num_rows($results = mysqli_query( $conn, $query))==1 ) {
        $_SESSION['user_id']      = $rut;
        $_SESSION['tipo_usuario'] = 'Tecnico';
        header('Location: /SRC/Template/Tecnico Laboratorista.php');
      }
      else {
        $query= "SELECT `SGL_PACIENTE_RUT`, `SGL_PACIENTE_PASSWORD` FROM `SGL_PACIENTE` WHERE `SGL_PACIENTE_RUT`='".$rut."' AND `SGL_PACIENTE_PASSWORD`='".$password."'";
      if ( mysqli_num_rows($results = mysqli_query( $conn, $query))==1 ) {
        $_SESSION['user_id']      = $rut;
        $_SESSION['tipo_usuario'] = 'Paciente';
        header('Location: /SRC/Template/Paciente.php ');
      }
      else{
        echo "<script type='text/javascript'>
        		alertify.error('El rut o la contraseña es incorrecta');
              </script>";
      }
    }
    }
    }

}
?>