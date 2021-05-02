<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

//Valida los campos del form
if (empty($_POST['firstname2'])) {
	$errors[] = "Nombres vacíos";
} elseif (empty($_POST['lastname2'])) {
	$errors[] = "Apellidos vacíos";
} elseif (empty($_POST['user_name2'])) {
	$errors[] = "Nombre de usuario vacío";
} elseif (strlen($_POST['user_name2']) > 64 || strlen($_POST['user_name2']) < 2) {
	$errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
} elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name2'])) {
	$errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
} elseif (empty($_POST['user_email2'])) {
	$errors[] = "El correo electrónico no puede estar vacío";
} elseif (strlen($_POST['user_email2']) > 64) {
	$errors[] = "El correo electrónico no puede ser superior a 64 caracteres";
} elseif (!filter_var($_POST['user_email2'], FILTER_VALIDATE_EMAIL)) {
	$errors[] = "Su dirección de correo electrónico no está en un formato de correo electrónico válida";
} elseif ( //si los datos son correctos
	!empty($_POST['user_name2'])
	&& !empty($_POST['firstname2'])
	&& !empty($_POST['lastname2'])
	&& strlen($_POST['user_name2']) <= 64
	&& strlen($_POST['user_name2']) >= 2
	&& preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name2'])
	&& !empty($_POST['user_email2'])
	&& strlen($_POST['user_email2']) <= 64
	&& filter_var($_POST['user_email2'], FILTER_VALIDATE_EMAIL)
) {
	require_once("../../config/db.php"); //configuracion para conectar a la base de datos
	require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

	$firstname = mysqli_real_escape_string($con, (strip_tags($_POST["firstname2"], ENT_QUOTES)));
	$lastname = mysqli_real_escape_string($con, (strip_tags($_POST["lastname2"], ENT_QUOTES)));
	$user_name = mysqli_real_escape_string($con, (strip_tags($_POST["user_name2"], ENT_QUOTES)));
	$user_email = mysqli_real_escape_string($con, (strip_tags($_POST["user_email2"], ENT_QUOTES)));
	$user_id = intval($_POST['mod_id']);
	$sql = "UPDATE usuarios SET firstname='" . $firstname . "', lastname='" . $lastname . "', user_name='" . $user_name . "', user_email='" . $user_email . "'
			WHERE user_id='" . $user_id . "';";
	$query_update = mysqli_query($con, $sql); //actualiza registro

	if ($query_update) { //si el usuario se actualizo exitosamente
		$messages[] = "La cuenta ha sido modificada con éxito.";
	} else {
		$errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
	}
} else {
	$errors[] = "Un error desconocido ocurrió.";
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