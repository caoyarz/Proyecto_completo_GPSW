<?php

$mail->isSMTP();

/*
Enable SMTP debugging
0 = off (for production use)
1 = client messages
2 = client and server messages
*/


$mail->SMTPDebug = 0;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "proyectogps2020@gmail.com";
$mail->Password = "gps12345";
$mail->setFrom('proyectogps2020@gmail.com', 'Centro Medico Doctor Novis Seltman');
$mail->Subject = 'Solicitud de Insumos';
$mail->CharSet = 'UTF-8'; // Con esto ya funcionan los acentos
$mail->IsHTML(true);


$mail->addAddress($correoDestinatario, $nombreDestinatario);
$mail->Body = $mensaje;
if($mail->send()) $enviados++;
$mail->clearAddresses();


$mensaje = "";
$nombreDestinatario = "";
$correoDestinatario = "";

?>