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
		url: './ajax/usuarios/buscar_usuarios.php?action=ajax&page=' + page + '&q=' + q,
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
	if (confirm("Realmente deseas eliminar el usuario")) {
		$.ajax({
			type: "GET",
			url: "./ajax/usuarios/buscar_usuarios.php",
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

$("#guardar_usuario").submit(function (event) {
	$('#guardar_datos').attr("disabled", true);

	var parametros = $(this).serialize();
	$.ajax({
		type: "POST",
		url: "ajax/usuarios/nuevo_usuario.php",
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

$("#editar_usuario").submit(function (event) {
	$('#actualizar_datos2').attr("disabled", true);

	var parametros = $(this).serialize();
	$.ajax({
		type: "POST",
		url: "ajax/usuarios/editar_usuario.php",
		data: parametros,
		beforeSend: function (objeto) {
			$("#resultados_ajax2").html("Mensaje: Cargando...");
		},
		success: function (datos) {
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		}
	});
	event.preventDefault();
})


$("#editar_password").submit(function (event) {
	$('#actualizar_datos3').attr("disabled", true);

	var parametros = $(this).serialize();
	$.ajax({
		type: "POST",
		url: "ajax/usuarios/editar_password.php",
		data: parametros,
		beforeSend: function (objeto) {
			$("#resultados_ajax3").html("Mensaje: Cargando...");
		},
		success: function (datos) {
			$("#resultados_ajax3").html(datos);
			$('#actualizar_datos3').attr("disabled", false);
			load(1);
		}
	});
	event.preventDefault();
})


function get_user_id(id) {
	$("#user_id_mod").val(id);
}

function obtener_datos(id) {
	var nombres = $("#nombres" + id).val();
	var apellidos = $("#apellidos" + id).val();
	var usuario = $("#usuario" + id).val();
	var email = $("#email" + id).val();

	$("#mod_id").val(id);
	$("#firstname2").val(nombres);
	$("#lastname2").val(apellidos);
	$("#user_name2").val(usuario);
	$("#user_email2").val(email);
}




