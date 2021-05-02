<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

session_start();
if (!isset($_SESSION['user_login_status'])) { //si no existe sesion muestra el login
	header("location: login.php");
	exit;
}

require_once("config/db.php"); //configuracion para conectar a la base de datos
require_once("config/conexion.php"); //funcion que conecta a la base de datos

$active_inventario = "active";
$title = "Gestion de Inventario";
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<?php include("head.php"); ?>
</head>

<body>
	<?php
	include("navbar.php");
	?>

	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h4><i class='glyphicon glyphicon-search'></i> Consultar inventario</h4>
			</div>

			<div class="panel-body">

				<form class="form-horizontal" role="form" id="datos">

					<div class="form-group row">
						<label for="q" class="col-md-2 control-label">Código/Descripción</label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="q" placeholder="Código o descripción del producto" onkeyup='load(1);'>
						</div>
						<div class="col-md-3">
							<button type="button" class="btn btn-default" onclick='load(1);'>
								<span class="glyphicon glyphicon-search"></span> Buscar</button>
							<span id="loader"></span>
						</div>
					</div>
				</form>

				<div id="resultados">
				</div>

				<div class='outer_div'>
				</div>

			</div>
		</div>
	</div>

	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/gestion.js"></script>
</body>

</html>