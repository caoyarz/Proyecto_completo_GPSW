<?php
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
require 'OAuth.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();

$mail->isSMTP();
/*
Enable SMTP debugging
0 = off (for production use)
1 = client messages
2 = client and server messages
*/
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = "proyectogps2020@gmail.com";
$mail->Password = "gps12345";
$mail->setFrom('proyectogps2020@gmail.com', 'Centro Medico Doctor Eric Seltman');
$mail->addAddress('e.arenas.gomez@gmail.com', 'Receptor');
$mail->Subject = 'Prueba Correo';
$mail->Body = "Cuerpo del Correo <br> Otra linea <br>".$mail->Username;
$mail->CharSet = 'UTF-8'; // Con esto ya funcionan los acentos
$mail->IsHTML(true);
if (!$mail->send())
{ 
	echo "Error al enviar el E-Mail: ".$mail->ErrorInfo;
}
else
{
	echo "E-Mail enviado";
}
?>