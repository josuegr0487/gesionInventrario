/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

$(document).ready(function () {
	load(1);
});

function load(page) {
	var q = $("#q").val();
	var parametros = { 'action': 'ajax', 'page': page, 'q': q };
	$("#loader").fadeIn('slow');
	$.ajax({
		data: parametros,
		url: './ajax/gestion/buscar_stocks.php',
		beforeSend: function (objeto) {
			$('#loader').html('<img src="./img/25.gif"> Cargando...');
		},
		success: function (data) {
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}