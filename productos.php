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

$active_dropdown  = "active";
$active_productos = "active";
$title = "Gestion de Inventario - Productos";
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
				<div class="btn-group pull-right">
					<button type='button' class="btn btn-primary" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus"></span> Dar de Alta</button>
				</div>
				<h4><i class='glyphicon glyphicon-search'></i> Consultar inventario</h4>
			</div>

			<div class="panel-body">
				<?php
				include("modal/productos/registro_productos.php");
				include("modal/productos/editar_productos.php");
				include("modal/productos/consultar_productos.php");
				include("modal/productos/baja_productos.php");
				?>

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
	<script type="text/javascript" src="js/productos.js"></script>
</body>

</html>