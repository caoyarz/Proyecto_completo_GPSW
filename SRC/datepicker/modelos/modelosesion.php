<?php
require __DIR__ . '/../config/database.php';
session_start();

//Llamar a esta funcion para paginas que requieran login.
function bouncer()
	{
		if (!isset($_SESSION['user_id']))
			{
				return TRUE;
			}
		return FALSE;
	}
//Llamar a estas funciones para restringir el acceso a cierto tipo de sesiones.
function strictSecretaria()
	{
		if (!rutEsSecretaria()) forceLogout();
	}

function strictTecnologo()
	{
		if (!rutEsTecnologo()) forceLogout();
	}
	
function strictTecLab()
	{
		if (!rutEsTecLab()) forceLogout();
	}
	
function strictFuncionario()
	{
		if(!rutEsSecretaria()&&!rutEsTecLab()&&!rutEsTecnologo()) forceLogout();
	}
	
	
//
function forceLogout()
	{
		session_destroy();
		header( 'Location: /SRC/index.php');

	}
	
function rutEsPaciente()
	{
		if ($_SESSION['tipo_usuario'] == 'Paciente')
			{
				return true;
			}
		else return false;
	}


function rutEsTecLab()
	{
		if ($_SESSION['tipo_usuario'] == 'Tecnico')
			{
				return true;
			}
		else return false;
	}


function rutEsTecnologo()
	{
		if ($_SESSION['tipo_usuario'] == 'Tecnologo')
			{
				return true;
			}
		else return false;
	}



function rutEsSecretaria()
	{
		if ($_SESSION['tipo_usuario'] == 'Secretaria')
			{
				return true;
			}
		else return false;
	}



?>