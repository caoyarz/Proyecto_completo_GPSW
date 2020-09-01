<?php
session_start();
require 'php/conectar.php';
require('writeHTML.php');
if(!file_exists('examenes/')){
	mkdir('examenes/',0777);
}
if($_POST['examen']=='orina_completa'){
	require "orina_completa.php";
	$_SESSION['exa']='Examen de orina';
	$paciemte_rut=mysqli_fetch_array(mysqli_query($conn,"SELECT `SGL_PACIENTE_RUT` FROM `SGL_EXAMEN_REALIZADO` where `SGL_EXAMEN_REALIZADO_IDENTIFICADOR`='".$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR']."'"))['SGL_PACIENTE_RUT'];
	$ruta=to_pdf(orina_tohtml($_POST['aspecto'],$_POST['glucosuria'],$_POST['proteina'],$_POST['hemoglobina'],$_POST['ph'],$_POST['densidad'],$_POST['cetonicos'],$_POST['bilirrubina'],$_POST['urobili'],$_POST['nitri'],$_POST['comentarios'],$_POST['conclusiones']),
		$_SESSION['row']['SGL_PACIENTE_NOMBRES'].'_'.$_SESSION['row']['SGL_PACIENTE_APELLIDOS'].'_'.$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR']);
	$maxi=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX( SGL_RESULTADO_EXAMEN_IDENTIFICADOR ) as maxi FROM `SGL_RESULTADO_EXAMEN`"))['maxi'];
	$maxi++;
	$uwu=$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR'];
	$ewe=$_SESSION['user_id'];
	$sql="INSERT INTO `SGL_RESULTADO_EXAMEN` (`SGL_RESULTADO_EXAMEN_IDENTIFICADOR`, `SGL_TECNOLOGO_RUT`, `SGL_PACIENTE_RUT`, `SGL_EXAMEN_REALIZADO_IDENTIFICADOR`, `SGL_RESULTADO_EXAMEN_DOCUMENTO`) VALUES ($maxi,'$ewe','$paciemte_rut','$uwu','$ruta')";
	mysqli_real_query($conn,$sql);
}
elseif ($_POST['examen']=='Proteinas_Totales_Sericas'){
	require "Proteinas_Totales_Sericas.php";
	$_SESSION['exa']='Proteinas_Totales_Sericas';
	$paciemte_rut=mysqli_fetch_array(mysqli_query($conn,"SELECT `SGL_PACIENTE_RUT` FROM `SGL_EXAMEN_REALIZADO` where `SGL_EXAMEN_REALIZADO_IDENTIFICADOR`='".$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR']."'"))['SGL_PACIENTE_RUT'];
	$ruta=to_pdf(proteina_tohtml($_POST['protes'],$_POST['comentarios'],$_POST['conclusiones']),$_SESSION['row']['SGL_PACIENTE_NOMBRES'].'_'.$_SESSION['row']['SGL_PACIENTE_APELLIDOS'].'_'.$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR']);
	$maxi=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX( SGL_RESULTADO_EXAMEN_IDENTIFICADOR ) as maxi FROM `SGL_RESULTADO_EXAMEN`"))['maxi'];
	$maxi++;
	$uwu=$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR'];
	$ewe=$_SESSION['user_id'];
	$sql="INSERT INTO `SGL_RESULTADO_EXAMEN` (`SGL_RESULTADO_EXAMEN_IDENTIFICADOR`, `SGL_TECNOLOGO_RUT`, `SGL_PACIENTE_RUT`, `SGL_EXAMEN_REALIZADO_IDENTIFICADOR`, `SGL_RESULTADO_EXAMEN_DOCUMENTO`) VALUES ($maxi,'$ewe','$paciemte_rut','$uwu','$ruta')";
	mysqli_real_query($conn,$sql);

}
elseif ($_POST['examen']=='Proteinuria_Aislada'){
	require "Proteinuria_Aislada.php";
	$_SESSION['exa']='Proteinuria_Aislada';
	$paciemte_rut=mysqli_fetch_array(mysqli_query($conn,"SELECT `SGL_PACIENTE_RUT` FROM `SGL_EXAMEN_REALIZADO` where `SGL_EXAMEN_REALIZADO_IDENTIFICADOR`='".$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR']."'"))['SGL_PACIENTE_RUT'];
	$ruta=to_pdf(proteinuria_tohtml($_POST['protes'],$_POST['comentarios'],$_POST['conclusiones']),$_SESSION['row']['SGL_PACIENTE_NOMBRES'].'_'.$_SESSION['row']['SGL_PACIENTE_APELLIDOS'].'_'.$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR']);
	$maxi=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX( SGL_RESULTADO_EXAMEN_IDENTIFICADOR ) as maxi FROM `SGL_RESULTADO_EXAMEN`"))['maxi'];
	$maxi++;
	$uwu=$_SESSION['row']['SGL_EXAMEN_REALIZADO_IDENTIFICADOR'];
	$ewe=$_SESSION['user_id'];
	$sql="INSERT INTO `SGL_RESULTADO_EXAMEN` (`SGL_RESULTADO_EXAMEN_IDENTIFICADOR`, `SGL_TECNOLOGO_RUT`, `SGL_PACIENTE_RUT`, `SGL_EXAMEN_REALIZADO_IDENTIFICADOR`, `SGL_RESULTADO_EXAMEN_DOCUMENTO`) VALUES ($maxi,'$ewe','$paciemte_rut','$uwu','$ruta')";
	mysqli_real_query($conn,$sql);

}
header('Location: /SRC/Template/revisar_examenes.php');

function to_pdf($html,$name){
	$host="mysqltrans.face.ubiobio.cl";
	$user="G1gestions2res";
	$password="G1s2gestion20-1";
	$bd="G1s2gestionres_bd";
	$conn=mysqli_connect($host,$user,$password,$bd);
	$Rut_tec=$_SESSION['user_id'];
	$sql  = "SELECT `SGL_TECNOLOGO_NOMBRES`,`SGL_TECNOLOGO_APELLIDOS` FROM `SGL_TECNOLOGO` where `SGL_TECNOLOGO_RUT`='".$Rut_tec."'";
	$resultado = mysqli_query($conn,$sql);
	$row=mysqli_fetch_array($resultado);
	$Nombre_Tec=$row['SGL_TECNOLOGO_NOMBRES'].' '.$row['SGL_TECNOLOGO_APELLIDOS'];
	$pdf=new PDF_HTML();
	$pdf->AddPage();
	$paciente=$_SESSION['row']['SGL_PACIENTE_NOMBRES'].' '.$_SESSION['row']['SGL_PACIENTE_APELLIDOS'];
	$html1='<header >
<table border="1" align="center" bordercolor="#000000" class="egt" >
	
	<tr>
		<td>Analizado por: '.$Nombre_Tec.'</td>
		<td>RUN: '.$Rut_tec.'</td>
	</tr>
	<br> 
	<tr>
		<td>Examen:</td>
		<td>'.$_SESSION['exa'].'</td>
		<td>Paciente: </td>
		<td>'.$paciente.'</td>
	</tr>
	
</table></header>';
	$pdf->SetFont('Arial');
	$pdf->WriteHTML($html1.$html);
	$pdf->Close();

	$pdf->Output('F','examenes/'.$name.'.pdf');
	return 'examenes/'.$name.'.pdf';
}



function close_window(){
echo '<script language="javascript" type="text/javascript">
    function cerrar() {
        window.open(\'\',\'_parent\',\'\');
        window.close();
    }
</script>
<script type="text/javascript">
    window.onload= cerrar();
</script>';
}
