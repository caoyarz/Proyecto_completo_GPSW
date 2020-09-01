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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript">
    function cambiarcont(pagina) {
                $("#contenido").load(pagina);
    }
  </script>

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

             <h1> Registrar Llegada de Pacientes </h1>
            <br>
            <br>
            <form method="POST" action="RegistrarLlegada.php" >
                
                <div class="form-group">
                    <label for="rut">Rut</label>
                    <input type="text" name="rut"  id="rut" placeholder="12.345.678-9"  maxlength="12" class="form-control">
                    <input type="submit" value="Buscar"  name="btn1" class="btn btn-primary">
                    <p>    incluir "." y "-"</p>
                </div>


                <div>
                        <?php 
                            include ("CONEXION_Chicallo.php");
                            $db=new Conect_MySql();
                        ?>
                        <br>
                        
                        <input id="myInput" name = "myInput" type = "hidden" >
                        
                            <?php
                                //  Al presionar el boton de buscar se realizaran las siguientes acciones
                                if(isset($_POST['btn1']))
                                { 

                                    $sql5= "SELECT SGL_PACIENTE_RUT from SGL_PACIENTE  ;";
                                    $query5 = $db->execute($sql5);
                                    $rut5 = $_POST['rut'];
                                    $rut_existe = 0;
                                    // Se verifica si es que el rut fue ingresado correctamente
                                    while($dato5=$db->fetch_row($query5)){
                                        if ($rut5 == $dato5['SGL_PACIENTE_RUT'])
                                        $rut_existe = 1;
                                    }
                                    // Se creara una tabla con la informacion de los examenes del paciente solicitado y en caso de que este mal ingresado se mostrara una alerta
                                    if($rut_existe == 1)
                                    {
                                            ?> 
                                            <tr><i><b>Citas  </b></i> </tr>
                                            <br>
                                            <?php
                                            $rut = $_POST['rut'];
                                            $sql= "SELECT c.SGL_CITA_IDENTIFICADOR from SGL_CITA c where c.SGL_PACIENTE_RUT = '".$rut."'and c.SGL_CITA_ESTADO = 'Reservada';";
                                            $query = $db->execute($sql); ?>
                                                
                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                            <script>
                                                $(function(){
                                                $(document).on('change','#citas',function(){ //detectamos el evento change
                                                    var value = $(this).val();//sacamos el valor del select
                                                $('#myInput').val(value);//le agregamos el valor al input (notese que el input debe tener un ID para que le caiga el valor)
                                                });
                
                                                });  
                                            </script>
                                            <!-- aqui se crea un combobox con las citas del paciente -->
                                            <select id="citas" name="citas" class="form-control">
                                                <option value ="Seleccione una cita" ><?php echo "Seleccione una cita" ?></option>
                                                <?php
                                                    while($dato=$db->fetch_row($query)){
                                                ?>
                                                <option value="<?php echo $dato['SGL_CITA_IDENTIFICADOR'] ?>"><?php echo $dato['SGL_CITA_IDENTIFICADOR'] ?> </option>
                                                <?php } ?>
                                            </select>      
                                            
                                            <!-- aqui se crean las opciones de confirmar o rechazar citas -->      
                                            <input type="submit" value="Confirmar"  name="btn2" class="btn btn-success">
                                            <input type="submit" value="Rechazar"  name="btn3" class="btn btn-danger"> 
                                            
                                            <div>
                                                <br>
                                                
                                                <table class="table table-bordered dataTable">
                                                    <tr>
                                                        <td>ID Cita </td>
                                                        <td>Medico </td>
                                                        <td>Fecha/Hora </td>
                                                    </tr>
                                                    <?php
                                                        $id_cida = $_POST['myInput'];
                                                        $sql2 = "SELECT  c.SGL_CITA_IDENTIFICADOR, c.SGL_CITA_MEDICO_SOLICITANTE, c.SGL_CITA_HORA
                                                        FROM  SGL_CITA c
                                                        WHERE c.SGL_PACIENTE_RUT = '".$rut."'  and c.SGL_CITA_ESTADO = 'Reservada'
                                                        ORDER BY (c.SGL_CITA_IDENTIFICADOR) ASC;" ;
                                                        $query2 = $db->execute($sql2);
                                                        while($dato2=$db->fetch_row($query2)){  ?>
                                                            <tr>
                                                                <td> <?php echo $dato2['SGL_CITA_IDENTIFICADOR']; ?>    </td>
                                                                <td> <?php echo $dato2['SGL_CITA_MEDICO_SOLICITANTE']; ?>    </td>
                                                                <td> <?php echo $dato2['SGL_CITA_HORA']; ?>    </td>
                                                            </tr>
                                                            <?php } ?>
                                                </table>
                                                <br>
                        <?php       }else{
                                        //alerta
                                        echo '<script language="javascript">';
                                        echo 'alert("Rut no valido")';
                                        echo '</script>';
                                        exit;
                                    }  
                            } ?> 

                        <?php 
                            //  Al presionar el boton de Confirmar se realizaran las siguientes acciones
                            if(isset($_POST['btn2'])){
                                // Se ingresara la opcion a la base de datos y en caso de que no seleccione una opcion mostrara una alerta
                                if($_POST['myInput'] != "Seleccione una cita" && $_POST['myInput'] != NULL)
                                {
                                    $cita_select = $_POST['myInput'];
                                    $sql3= "UPDATE SGL_CITA SET SGL_CITA.SGL_CITA_ESTADO = 'Confirmada' WHERE SGL_CITA.SGL_CITA_IDENTIFICADOR = ".$cita_select.";";
                                    $db->execute($sql3);
                                }else{
                                    //alerta
                                    echo '<script language="javascript">';
                                    echo 'alert("No selecciono una cita, vuelva a buscar al paciente")';
                                    echo '</script>';
                                
                                }
                            }
                        ?>
                        <?php 
                            //  Al presionar el boton de Rechazar se realizaran las siguientes acciones
                            if(isset($_POST['btn3'])){
                                // Se ingresara la opcion a la base de datos y en caso de que no seleccione una opcion mostrara una alerta
                                if($_POST['myInput'] != "Seleccione una cita" && $_POST['myInput'] != NULL)
                                {
                                    $cita_select = $_POST['myInput'];
                                    $sql3= "UPDATE SGL_CITA SET SGL_CITA.SGL_CITA_ESTADO = 'Rechazada' WHERE SGL_CITA.SGL_CITA_IDENTIFICADOR = ".$cita_select.";";
                                    $db->execute($sql3);
                                }else{
                                    //alerta
                                    echo '<script language="javascript">';
                                    echo 'alert("No selecciono una cita, vuelva a buscar al paciente")';
                                    echo '</script>';
                                
                                }
                            }
                        ?>
                </div>
                <br>

            </form>

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
