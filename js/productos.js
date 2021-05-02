/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

$(document).ready(function () {
	var src = $('#blah').attr('src');
	if (src === "#") {
		$('#blah').css('display', 'none');
	}
	load(1);
});

$("#imagen").change(function (event) {
	var fileInput = event.target
	var pattern = /image-*/;

	if (fileInput.files && fileInput.files[0]) {
		const file = fileInput.files[0]
		if (!file.type.match(pattern)) {
			alert('Invalid format');
			return;
		}
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#blah')
				.attr('src', e.target.result)
				.css('display', 'block');
		};

		reader.readAsDataURL(file);
	}
})

$("#guardar_producto").submit(function (event) {
	event.preventDefault();
	$('#guardar_datos').attr("disabled", true);
	var parametros = new FormData(this)
	document.getElementById("guardar_producto").reset();
	$.ajax({
		type: "POST",
		url: "ajax/productos/nuevo_producto.php",
		data: parametros,
		beforeSend: function (objeto) {
			$("#resultados_ajax_productos").html("Mensaje: Cargando...");
		},
		success: function (datos) {
			$("#resultados_ajax_productos").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		},
		cache: false,
		contentType: false,
		processData: false
	});
});

function load(page) {
	var q = $("#q").val();
	var parametros = { 'action': 'ajax', 'page': page, 'q': q };
	$("#loader").fadeIn('slow');
	$.ajax({
		data: parametros,
		url: './ajax/productos/buscar_productos.php',
		beforeSend: function (objeto) {
			$('#loader').html('<img src="./img/25.gif"> Cargando...');
		},
		success: function (data) {
			$(".outer_div").html(data).fadeIn('slow');
			$('#loader').html('');
		}
	})
}

$("#editar_producto").submit(function (event) {
	event.preventDefault();
	$('#actualizar_datos').attr("disabled", true);
	var parametros = new FormData(this)
	$.ajax({
		type: "POST",
		url: "ajax/productos/editar_producto.php",
		data: parametros,
		beforeSend: function (objeto) {
			$("#resultados_ajax2").html("Mensaje: Cargando...");
		},
		success: function (datos) {
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		},
		cache: false,
		contentType: false,
		processData: false
	});
})

$('#myModal2').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var codigo = button.data('row')['codigo_producto'];
	var nombre = button.data('row')['descripcion_producto'];
	var stock = button.data('row')['stock'];
	var unidad = button.data('row')['id_unidad'];
	var marca = button.data('row')['marca'];
	var modelo = button.data('row')['modelo'];
	var numserie = button.data('row')['numero_serie'];
	var observaciones = button.data('row')['observaciones'];
	var imagen = button.data('row')['url_image'];
	var id = button.data('row')['id_producto'];
	var modal = $(this)
	modal.find('.modal-body #mod_codigo').val(codigo)
	modal.find('.modal-body #mod_nombre').val(nombre)
	modal.find('.modal-body #mod_stock').val(stock)
	modal.find('.modal-body #mod_unidad').val(unidad)
	modal.find('.modal-body #mod_marca').val(marca)
	modal.find('.modal-body #mod_modelo').val(modelo)
	modal.find('.modal-body #mod_numserie').val(numserie)
	modal.find('.modal-body #mod_observaciones').val(observaciones)
	modal.find('.modal-body #blah').css('display', 'none');
	if (imagen) {
		modal.find('.modal-body #blah')
			.attr('src', './uploads/' + imagen)
			.css('display', 'block');
	}
	modal.find('.modal-body #mod_id').val(id);

	$("#mod_imagen").change(function (event) {
		var fileInput = event.target
		var pattern = /image-*/;

		if (fileInput.files && fileInput.files[0]) {
			const file = fileInput.files[0]
			if (!file.type.match(pattern)) {
				alert('Invalid format');
				return;
			}
			var reader = new FileReader();
			reader.onload = function (e) {
				modal.find('.modal-body #blah')
					.attr('src', e.target.result)
					.css('display', 'block');
			};

			reader.readAsDataURL(file);
		}
	})
})

$('#myModal1').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var codigo = button.data('row')['codigo_producto'];
	var nombre = button.data('row')['descripcion_producto'];
	var unidad = button.data('row')['id_unidad'];
	var stock = button.data('row')['stock'];
	var marca = button.data('row')['marca'];
	var modelo = button.data('row')['modelo'];
	var numserie = button.data('row')['numero_serie'];
	var observaciones = button.data('row')['observaciones'];
	var imagen = button.data('row')['url_image'];
	var id = button.data('row')['id_producto'];
	var modal = $(this)
	modal.find('.modal-body #mod_codigo').val(codigo)
	modal.find('.modal-body #mod_nombre').val(nombre)
	modal.find('.modal-body #mod_stock').val(stock)
	modal.find('.modal-body #mod_unidad').val(unidad)
	modal.find('.modal-body #mod_marca').val(marca)
	modal.find('.modal-body #mod_modelo').val(modelo)
	modal.find('.modal-body #mod_numserie').val(numserie)
	modal.find('.modal-body #mod_observaciones').val(observaciones)
	modal.find('.modal-body #blah').css('display', 'none');
	if (imagen) {
		modal.find('.modal-body #blah')
			.attr('src', './uploads/' + imagen)
			.css('display', 'block');
	}
	modal.find('.modal-body #mod_id').val(id);
})

$("#bajar_producto").submit(function (event) {
	$('#actualizar_datos').attr("disabled", true);
	var parametros = $(this).serialize();
	$.ajax({
		type: "POST",
		url: "ajax/productos/baja_producto.php",
		data: parametros,
		beforeSend: function (objeto) {
			$("#resultados_ajax3").html("Mensaje: Cargando...");
		},
		success: function (datos) {
			$("#resultados_ajax3").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		}
	});
	event.preventDefault();
})

$('#myModal3').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget)
	var codigo = button.data('row')['codigo_producto'];
	var nombre = button.data('row')['descripcion_producto'];
	var stock = button.data('row')['stock'];
	var unidad = button.data('row')['id_unidad'];
	var marca = button.data('row')['marca'];
	var modelo = button.data('row')['modelo'];
	var numserie = button.data('row')['numero_serie'];
	var observaciones = button.data('row')['observaciones'];
	var imagen = button.data('row')['url_image'];
	var id = button.data('row')['id_producto'];
	var modal = $(this)
	modal.find('.modal-body #mod_codigo').val(codigo)
	modal.find('.modal-body #mod_nombre').val(nombre)
	modal.find('.modal-body #mod_stock').val(stock)
	modal.find('.modal-body #mod_unidad').val(unidad)
	modal.find('.modal-body #mod_marca').val(marca)
	modal.find('.modal-body #mod_modelo').val(modelo)
	modal.find('.modal-body #mod_numserie').val(numserie)
	modal.find('.modal-body #mod_observaciones').val(observaciones)
	modal.find('.modal-body #blah').css('display', 'none');
	if (imagen) {
		modal.find('.modal-body #blah')
			.attr('src', './uploads/' + imagen)
			.css('display', 'block');
	}
	modal.find('.modal-body #mod_id').val(id);
})