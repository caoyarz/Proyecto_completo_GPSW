<?php
require __DIR__ . '/../modelos/modelosesion.php';
//----------------Funciones de redirección---------------//
function goLogin()
	{
		echo '<script>alert("Acceso denegado. Por favor, autentifiquese.")</script>';
		//header ("location: http://146.83.198.35:1053/SRC/index.php");
		//enviamos al usuario a la pantalla de login
	}
function goCalendario()
	{
		//headaer("location: http://146.83.198.35:1053/SRC/datefuncionario.php");
	}
function goSolicitud()
	{
		//header("location: http://146.83.198.35:1053/SRC/datecliente.php");
		header("location: datecliente.php");
	}
function goSelector()
	{
		//header("location: datefuncionario.php");
	}
//------------------------Rutina de enrutador-------------//
if (bouncer())
	{
		goLogin();
	}
	
else
	{
		$rut = $_SESSION['user_id'];
		var_dump($rut);
		if (rutEsPaciente())
			{
				goSolicitud();
			}
		if (rutEsTecLab()||rutEsTecnologo())
			{
				goSolicitud();
			}
		if (rutEsSecretaria())
			{
				goCalendario();
			}


			
		//Si llegamos a este punto algo incomodo está sucediendo!
		//handlear con alguna vista de error crítico.
		die("ERROR INESPERADO: Tipo de usuario indefinido");
	}


	
?>