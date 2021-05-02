<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

//Valida los campos del form  categoria
if (empty($_POST['mod_motivo'])) {
	$errors[] = "Motivo vacío";
} else if ( //si los datos son correctos
	!empty($_POST['mod_motivo'])
) {
	require_once("../../config/db.php"); //configuracion para conectar a la base de datos
	require_once("../../config/conexion.php"); //funcion que conecta a la base de datos
	include("../../funciones.php");

	$codigo = mysqli_real_escape_string($con, (strip_tags($_POST["mod_codigo"], ENT_QUOTES)));
	$motivo = mysqli_real_escape_string($con, (strip_tags($_POST["mod_motivo"], ENT_QUOTES)));
	$date_added = date("Y-m-d H:i:s");
	$id_producto = $_POST['mod_id'];

	$sql = "DELETE FROM productos WHERE id_producto='" . $id_producto . "'";
	$query_update = mysqli_query($con, $sql);
	if ($query_update) {
		$user_id = $_SESSION['user_id'];
		$firstname = $_SESSION['firstname'];
		$nota = "$firstname dio de baja el producto del inventario, motivo: $motivo";
		echo guardar_historial($id_producto, $user_id, $date_added, $nota, $codigo); //se crea historico producto
		$messages[] = "El Producto ha sido dado de baja satisfactoriamente.";
	} else {
		$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
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