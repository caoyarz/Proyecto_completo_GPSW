<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Registrar paciente</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link rel="stylesheet" href="css/alertify/alertify.css">
  <link rel="stylesheet" href="css/alertify/themes/default.css">
  <script src="js/jquery-3.3.1.js"></script>
  <script src="js/alertify.js"></script>

  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div>
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Formulario de Registro</h1>
              </div>
              <hr>

              <div class="container">
                <form method="POST" action="registro.php" >

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
                              alertify.alert('Rut invalido');
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
                    }
                  }
                  else{
                    echo "<script type='text/javascript'>
                              alertify.alert('El rut ya se encuentra registrado');
                            </script>";  
                  }
                }  

              ?>

              <div class="col-md-4"></div>
            </div>

              <div class="text-center">
                <a class="small" href="login.php">¿Ya tienes una cuenta? Ingresa aqui</a>
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
