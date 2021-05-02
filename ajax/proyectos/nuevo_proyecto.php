<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

//Valida los campos del form
if (empty($_POST['nombre'])) {
	$errors[] = "Nombre vacío";
} else if (
	!empty($_POST['nombre'])
) { //si los datos son correctos
	require_once("../../config/db.php"); //configuracion para conectar a la base de datos
	require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

	$nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
	$date_added = date("Y-m-d H:i:s");
	$sql = "INSERT INTO proyectos (nombre_proyecto, date_added) VALUES ('$nombre', '$date_added')";
	$query_new_insert = mysqli_query($con, $sql); //se crea nuevo proyecto
	if ($query_new_insert) { //si el proyecto se creo exitosamente
		$messages[] = "Proyecto ha sido actualizado satisfactoriamente.";
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