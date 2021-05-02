/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

$(document).ready(function () {
	load(1);
});

function load(page) {
	var q = $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url: './ajax/unidad_medida/buscar_unidades.php?action=ajax&page=' + page + '&q=' + q,
		beforeSend: function (objeto) {
			$('#loader').html('<img src="./img/25.gif"> Cargando...');
		},
		success: function (data) {
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}

function eliminar(id) {
	var q = $("#q").val();
	if (confirm("Realmente deseas eliminar la unidad de medida")) {
		$.ajax({
			type: "GET",
			url: "./ajax/unidad_medida/buscar_unidades.php",
			data: "id=" + id, "q": q,
			beforeSend: function (objeto) {
				$("#resultados").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				$("#resultados").html(datos);
				load(1);
			}
		});
	}
}


$("#guardar_unidad").submit(function (event) {
	$('#guardar_datos').attr("disabled", true);
	var parametros = $(this).serialize();
	document.getElementById("guardar_unidad").reset();
	$.ajax({
		type: "POST",
		url: "ajax/unidad_medida/nueva_unidad.php",
		data: parametros,
		beforeSend: function (objeto) {
			$("#resultados_ajax").html("Mensaje: Cargando...");
		},
		success: function (datos) {
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		}
	});
	event.preventDefault();
})

$("#editar_unidad").submit(function (event) {
	$('#actualizar_datos').attr("disabled", true);
	var parametros = $(this).serialize();
	// document.getElementById("editar_unidad").reset();
	$.ajax({
		type: "POST",
		url: "ajax/unidad_medida/editar_unidad.php",
		data: parametros,
		beforeSend: function (objeto) {
			$("#resultados_ajax2").html("Mensaje: Cargando...");
		},
		success: function (datos) {
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		}
	});
	event.preventDefault();
})


$('#myModal2').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget) // Button that triggered the modal
	var nombre = button.data('nombre')
	var abreviatura = button.data('abreviatura')
	var id = button.data('id')
	var modal = $(this)
	modal.find('.modal-body #mod_nombre').val(nombre)
	modal.find('.modal-body #mod_abreviatura').val(abreviatura)
	modal.find('.modal-body #mod_id').val(id)
})


