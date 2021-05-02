<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado
//verifica datos del form
if (empty($_POST['user_id_mod'])) {
	$errors[] = "ID vacío";
} elseif (empty($_POST['user_password_new3']) || empty($_POST['user_password_repeat3'])) {
	$errors[] = "Contraseña vacía";
} elseif ($_POST['user_password_new3'] !== $_POST['user_password_repeat3']) {
	$errors[] = "la contraseña y la repetición de la contraseña no son lo mismo";
} elseif ( //si los datos son correctos
	!empty($_POST['user_id_mod'])
	&& !empty($_POST['user_password_new3'])
	&& !empty($_POST['user_password_repeat3'])
	&& ($_POST['user_password_new3'] === $_POST['user_password_repeat3'])
) {
	require_once("../../config/db.php"); //configuracion para conectar a la base de datos
	require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

	$user_id = intval($_POST['user_id_mod']);
	$user_password = $_POST['user_password_new3'];
	$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT); //encripta la contraseña del usuario con la función password_hash ()
	$sql = "UPDATE usuarios SET user_password_hash='" . $user_password_hash . "' WHERE user_id='" . $user_id . "'";
	$query = mysqli_query($con, $sql); //actualiza registro

	if ($query) { //si el usuario se actualizo exitosamente
		$messages[] = "contraseña ha sido modificada con éxito.";
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