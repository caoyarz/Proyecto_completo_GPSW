var validationHora = false;
var validationExamen = false;
document.getElementById("agenda").addEventListener("input", function()
	{
		var fecha = document.getElementById("agenda").value;
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function()
		{
		if (this.readyState == 4 && this.status == 200) {
							document.getElementById("hora").innerHTML = this.responseText;
							document.getElementById("hora").selectedIndex = 0;
							validationHora = false;
							activarSubmit();
														}
		}
			xhttp.open("POST", "datepicker/ajax/getHorasDisponibles.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("fecha="+fecha);
		
	});

document.getElementById("submit").addEventListener("click", function()
	{
		var hora = document.getElementById("hora").value;
		var examen = document.getElementById("examen").value;
		var medico = document.getElementById("medico").value;
		document.getElementById("hora").selectedIndex = 0;
		document.getElementById("examen").selectedIndex = 0;
		document.getElementById("agenda").value = new Date();
		document.getElementById("medico").value = '';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function()
		{
		if (this.readyState == 4 && this.status == 200) {

														}
		}
			xhttp.open("POST", "datepicker/ajax/getFormSubmit.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("hora="+hora+"&examen="+examen+"&medico="+medico);
		
	});
	

document.getElementById("hora").addEventListener("input", function()
	{
		var dateinput = document.getElementById("hora").value;
		if (dateinput != "")
			{
				validationHora = true;
			}
		else
			{
				validationHora = false;
			}
		activarSubmit();
	});
	
document.getElementById("examen").addEventListener("input", function()
	{
		var dateinput = document.getElementById("examen").value;
		if (dateinput != "base")
			{
				validationExamen = true;
			}
		else
			{
				validationExamen = false;
			}
		activarSubmit();
	});

function activarSubmit()
	{
		if (validationHora && validationExamen)
			{
				document.getElementById("submit").disabled = false;
			}
		else
			{
				document.getElementById("submit").disabled = true;
			}
	}
