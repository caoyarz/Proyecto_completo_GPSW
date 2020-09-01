var validationTecnologo = false;

document.querySelectorAll(".btn-confirma").forEach(function (elem)
{
	elem.addEventListener("click", function()
	{
		var idrequest = this.dataset.id;
		var tecid = document.getElementById("tecnologo-drop").value;
		console.log(tecid);
		console.log(idrequest);
		
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function()
		{
		if (this.readyState == 4 && this.status == 200) {
							document.getElementById("tr-"+idrequest).style.display = "none"
							document.getElementById("tecnologo-drop").selectedIndex = 0;
							validationTecnologo = false;
							activarSubmit();											
		}
	}
			xhttp.open("POST","datepicker/ajax/updateCita.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("id="+idrequest+"&tecid="+tecid);
})
});


document.querySelectorAll(".btn-rechaza").forEach(function (elem)
{
		elem.addEventListener("click", function()
		{
		var idrequest = this.dataset.id;
		console.log(idrequest);
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function()
		{
		if (this.readyState == 4 && this.status == 200) {
													document.getElementById("tr-"+idrequest).style.display = "none"
													document.getElementById("tecnologo-drop").selectedIndex = 0;
													validationTecnologo = false;
													activarSubmit();	
													
													}
		}
		let check = confirm("Confirma rechazar esta hora?");
        if (check == true) {
            xhttp.open("POST", "datepicker/ajax/deleteCita.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("id='"+idrequest+"'");
        }
			
	})
});
	

document.getElementById("tecnologo-drop").addEventListener("input", function()
	{
		var input = this.value;
		if (input != "base")
			{
				validationTecnologo = true;
			}
		else
			{
				validationTecnologo = false;
			}
		activarSubmit();
	});

function activarSubmit()
	{
		if (validationTecnologo)
			{
				document.querySelectorAll(".btn-confirma").forEach(function(elem)
				{
					elem.disabled = false;
				});
			}
		else
			{
				document.querySelectorAll(".btn-confirma").forEach(function(elem)
				{
					elem.disabled = true;
				});
			}
	}
