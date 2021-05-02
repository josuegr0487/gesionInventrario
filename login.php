<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

require_once("config/db.php"); //configuracion para conectar a la base de datos
require_once("classes/Login.php"); //carga la clase login

$login = new Login();

if ($login->isUserLoggedIn() == true) {
	header("location: gestion.php");
} else {
?>
	<!DOCTYPE html>
	<html lang="es">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
		<title>Gestion de Inventario - Acceso</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<!-- CSS  -->
		<link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection" />
	</head>

	<body>
		<div class="container">
			<div class="card card-container">
				<img id="profile-img" class="profile-img-card" src="img/usr_login.png" />
				<p id="profile-name" class="profile-name-card"> Gestion de Inventario </p>
				<form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="form-signin">
					<?php
					if (isset($login)) { //muestra los mensajes de la clase login
						if ($login->errors) {
					?>
							<div class="alert alert-danger alert-dismissible" role="alert">
								<strong>Error!</strong>

								<?php
								foreach ($login->errors as $error) {
									echo $error;
								}
								?>
							</div>
						<?php
						}
						if ($login->messages) {
						?>
							<div class="alert alert-success alert-dismissible" role="alert">
								<strong>Aviso!</strong>
								<?php
								foreach ($login->messages as $message) {
									echo $message;
								}
								?>
							</div>
					<?php
						}
					}
					?>
					<span id="reauth-email" class="reauth-email"></span>
					<input class="form-control" placeholder="Usuario" name="user_name" type="text" value="" autofocus="">
					<input class="form-control" placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off">
					<button type="submit" class="btn btn-lg btn-primary btn-block btn-signin" name="login" id="submit">Iniciar Sesión</button>
				</form><!-- /form -->

			</div><!-- /card-container -->
		</div><!-- /container -->
	</body>

	</html>

<?php
}
