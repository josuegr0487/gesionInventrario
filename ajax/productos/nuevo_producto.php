<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

if (empty($_POST['codigo'])) {
	$errors[] = "Código vacío";
} else if (empty($_POST['nombre'])) {
	$errors[] = "Descripcion del producto vacío";
} else if (empty($_POST['unidad'])) {
	$errors[] = "Unidad del producto vacío";
} else if ( //si los datos son correctos
	!empty($_POST['codigo']) &&
	!empty($_POST['nombre']) &&
	!empty($_POST['unidad'])
) {
	require_once("../../config/db.php"); //configuracion para conectar a la base de datos
	require_once("../../config/conexion.php"); //funcion que conecta a la base de datos
	include("../../funciones.php");

	$codigo = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
	$nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
	$stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
	$id_unidad = intval($_POST['unidad']);
	$marca = mysqli_real_escape_string($con, (strip_tags($_POST["marca"], ENT_QUOTES)));
	$modelo = mysqli_real_escape_string($con, (strip_tags($_POST["modelo"], ENT_QUOTES)));
	$numserie = mysqli_real_escape_string($con, (strip_tags($_POST["numserie"], ENT_QUOTES)));
	$observaciones = mysqli_real_escape_string($con, (strip_tags($_POST["observaciones"], ENT_QUOTES)));
	$date_added = date("Y-m-d H:i:s");
	$nombre_img = $_FILES['imagen']['name'];
	if ($nombre_img == !NULL) {
		$directorio = '../../uploads/';
		// Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
		$resp = move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombre_img);
		if (!$resp) {
			$errors[] = "Error al intentar copiar el archivo, intenta nuevamente.";
		}
	}
	if (empty($errors)) {

		$sql = "INSERT INTO productos (codigo_producto,descripcion_producto,url_image,date_added,stock,id_unidad,marca,modelo,numero_serie,observaciones) VALUES ('$codigo', '$nombre', '$nombre_img', '$date_added', '$stock','$id_unidad', '$marca', '$modelo', '$numserie', '$observaciones');";
		$query_new_insert = mysqli_query($con, $sql);
		if ($query_new_insert) { //se crea nuevo producto
			$messages[] = "Producto se dio de alta satisfactoriamente.";
			$id_producto = get_row('productos', 'id_producto', 'codigo_producto', $codigo);
			$user_id = $_SESSION['user_id'];
			$firstname = $_SESSION['firstname'];
			$nota = "$firstname dio de alta el producto al inventario";
			echo guardar_historial($id_producto, $user_id, $date_added, $nota, $codigo); //se crea historico producto
		} else { //si existe error al dar de alta producto
			$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
		}
		
	}
} else {
	$errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
	</div>
<?php
}
if (isset($messages)) {

?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
	</div>
<?php
}

?>