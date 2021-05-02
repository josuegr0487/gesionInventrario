<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) { //si no existe sesion muestra el login
	header("location: login.php");
	exit;
}

require_once("config/db.php"); //configuracion para conectar a la base de datos
require_once("config/conexion.php"); //funcion que conecta a la base de datos

$active_proyecto = "active";
$active_dropdown = "active";
$title = "Gestion de Inventario - Proyectos";
?>

<!DOCTYPE html>
<html lang="en">

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
				<div class="btn-group pull-right">
					<button type='button' class="btn btn-primary" data-toggle="modal" data-target="#nuevoProyecto"><span class="glyphicon glyphicon-plus"></span> Alta Proyecto</button>
				</div>
				<h4><i class='glyphicon glyphicon-search'></i> Proyectos</h4>
			</div>
			<div class="panel-body">

				<?php
				include("modal/proyectos/registro_proyectos.php");
				include("modal/proyectos/editar_proyectos.php");
				?>
				<form class="form-horizontal" role="form" id="datos_proyecto">

					<div class="form-group row">
						<label for="q" class="col-md-2 control-label">Nombre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="q" placeholder="Nombre del proyecto" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/proyectos.js"></script>
</body>

</html>

<?php
