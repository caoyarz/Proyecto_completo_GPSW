<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/OAuth.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();

$mail->isSMTP();
/*
Enable SMTP debugging
0 = off (for production use)
1 = client messages
2 = client and server messages
*/
$correoDestinatario = $_POST['correo'];
$nombreDestinatario = $_POST['nombreProveedor'];
$mensaje = $_POST['mensaje'];
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "proyectogps2020@gmail.com";
$mail->Password = "gps12345";
$mail->setFrom('proyectogps2020@gmail.com', 'Centro Medico Doctor Eric Seltman');
$mail->addAddress($correoDestinatario, $nombreDestinatario);
$mail->Subject = 'Solicitud de Insumos';
$mail->Body = $mensaje;
$mail->CharSet = 'UTF-8'; // Con esto ya funcionan los acentos
$mail->IsHTML(true);
if($mail->send()) $respuesta = "ok";
else $respuesta="Error";
echo json_encode(array("respuesta" => $respuesta));
?>