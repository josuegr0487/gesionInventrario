/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

$(document).ready(function () {
    load(1);
    var input = document.getElementById('q');
    input.focus();
});

function load(page) {
	$("#loader").fadeIn('slow');
	var select = document.getElementById('proyecto');
	var data = {
		proyecto: select.value
	}
	$.ajax({
		data,
		url: './ajax/entradas/buscar_entradas.php?action=ajax&page=' + page,
		beforeSend: function (objeto) {
			$('#loader').html('<img src="./img/25.gif"> Cargando...');
		},
		success: function (data) {
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}

$('#q').keypress(function(e){
    if(e.which == 13){
        e.preventDefault();
        document.getElementById("escanear").click();
    }
});

$('#escanear').click(function() {
    $(this).attr("disabled", true);
	var input = document.getElementById('q');
	var select = document.getElementById('proyecto');
	var data = {
		codigo: input.value,
		proyecto: select.value
	}

    $.ajax({
		type: "POST",
		url: "ajax/entradas/nueva_entrada.php",
		data,
		beforeSend: function (objeto) {
			$("#resultados").html("Mensaje: Cargando...");
		},
		success: function (datos) {
            $("#resultados").html(datos);
			$('#escanear').attr("disabled", false);
            load(1);
            input.value = '';
            input.focus();
		}
	});
})