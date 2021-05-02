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

$active_medida = "active";
$active_dropdown = "active";
$title = "Gestion de Inventario - Unidad de Medidas";
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
					<button type='button' class="btn btn-primary" data-toggle="modal" data-target="#nuevaUnidad"><span class="glyphicon glyphicon-plus"></span> Alta Unidad de Medida</button>
				</div>
				<h4><i class='glyphicon glyphicon-search'></i> Unidad de Medidas</h4>
			</div>
			<div class="panel-body">

				<?php
				include("modal/unidad_medida/registro_unidades.php");
				include("modal/unidad_medida/editar_unidades.php");
				?>
				<form class="form-horizontal" role="form" id="datos_unidad">

					<div class="form-group row">
						<label for="q" class="col-md-2 control-label">Nombre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" id="q" placeholder="Nombre de la unidad de medida" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/unidad_medida.js"></script>
</body>

</html>

<?php
