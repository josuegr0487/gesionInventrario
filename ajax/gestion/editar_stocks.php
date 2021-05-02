<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

//Valida los campos del form 
if (empty($_POST['mod_codigo'])) {
	$errors[] = "Código vacío";
} else if (empty($_POST['mod_nombre'])) {
	$errors[] = "Descripcion del producto vacío";
} else if (empty($_POST['mod_unidad'])) {
	$errors[] = "Unidad del producto vacío";
} else if ( //si los datos son correctos
	!empty($_POST['mod_codigo']) &&
	!empty($_POST['mod_nombre']) &&
	!empty($_POST['mod_unidad'])
) {
	require_once("../../config/db.php"); //configuracion para conectar a la base de datos
	require_once("../../config/conexion.php"); //funcion que conecta a la base de datos
	include("../../funciones.php");
	
	$codigo = mysqli_real_escape_string($con, (strip_tags($_POST["mod_codigo"], ENT_QUOTES)));
	$nombre = mysqli_real_escape_string($con, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
	$stock = isset($_POST['mod_stock']) ? intval($_POST['mod_stock']) : 0;
	$id_unidad = intval($_POST['mod_unidad']);
	$id_ubicacion = intval($_POST['mod_ubicacion']);
	$marca = mysqli_real_escape_string($con, (strip_tags($_POST["mod_marca"], ENT_QUOTES)));
	$modelo = mysqli_real_escape_string($con, (strip_tags($_POST["mod_modelo"], ENT_QUOTES)));
	$numserie = mysqli_real_escape_string($con, (strip_tags($_POST["mod_numserie"], ENT_QUOTES)));
	$observaciones = mysqli_real_escape_string($con, (strip_tags($_POST["mod_observaciones"], ENT_QUOTES)));
	$id_proyecto = intval($_POST['mod_proyecto']);
	$propietario = mysqli_real_escape_string($con, (strip_tags($_POST["mod_propietario"], ENT_QUOTES)));
	$nombre_img = $_FILES['mod_imagen']['name'];
	$id_producto = $_POST['mod_id'];
	$date_mod = date("Y-m-d H:i:s");
	
	if ($nombre_img == !NULL) {
		$directorio = '../../uploads/';
		// Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
		$resp = move_uploaded_file($_FILES['mod_imagen']['tmp_name'], $directorio . $nombre_img);
		$sql = "UPDATE productos SET descripcion_producto = '" . $nombre . "', url_image = '" . $nombre_img . "', stock = '" . $stock . "', id_unidad = '" . $id_unidad . "', id_ubicacion = '" . $id_ubicacion . "', marca = '" . $marca . "', modelo = '" . $modelo . "', numero_serie = '" . $numserie . "', observaciones = '" . $observaciones . "', id_proyecto = '" . $id_proyecto . "', propietario = '" . $propietario . "' WHERE id_producto='" . $id_producto . "'";
		
		if (!$resp) {
			$errors[] = "Error al intentar copiar el archivo, intenta nuevamente.";
		}
	}
	if (empty($errors)) {
		if (empty($sql)){
			$sql = "UPDATE productos SET descripcion_producto = '" . $nombre . "', stock = '" . $stock . "', id_unidad = '" . $id_unidad . "', id_ubicacion = '" . $id_ubicacion . "', marca = '" . $marca . "', modelo = '" . $modelo . "', numero_serie = '" . $numserie . "', observaciones = '" . $observaciones . "', id_proyecto = '" . $id_proyecto . "', propietario = '" . $propietario . "' WHERE id_producto='" . $id_producto . "'";
		}
		$query_update = mysqli_query($con, $sql);
		if ($query_update) {
			$messages[] = "Producto ha sido actualizado satisfactoriamente.";
			$user_id = $_SESSION['user_id'];
			$firstname = $_SESSION['firstname'];
			$nota = "$firstname mofifico el producto.";
			echo guardar_historial($id_producto, $user_id, $date_mod, $nota, $codigo); //se crea historico producto
		} else {
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