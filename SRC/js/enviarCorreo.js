function Enviar(){
	var correo =$("#correo").val();
	var mensaje =$("#mensaje").val();
	var nombreProveedor =$("#nombreProveedor").val();
	mensaje = mensaje.replace(/\n/g, "<br>");
	$.ajax({
		type: "POST",
		url: "enviarCorreo.php",
		data: {
			correo: correo,
			mensaje: mensaje,
			nombreProveedor: nombreProveedor
		},
		success: function(response){
			var datos = JSON.parse(response);
			if(datos.respuesta !="ok"){
				alertify.error("Error al enviar correo, intente más tarde");
			}
			else{
				alertify.success("Correo enviado correctamente");
			}
		}
	});
}