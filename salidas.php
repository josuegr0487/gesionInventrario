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

$active_salidas = "active";
$title = "Gestion de Inventario - Salidas";
$isAdmin = (isset($_SESSION['user_name']) && $_SESSION['user_name'] == 'admin') ? true : false; //valida si es admin
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
				<h4><i class='glyphicon glyphicon-search'></i> Salidas</h4>
			</div>
			<div class="panel-body">

				<form class="form-horizontal" role="form" id="datos_salidas">
					<div class="form-group row">

						<label for="proyecto" class="col-md-1 control-label">Proyecto</label>
						<div class='col-md-4'>
							<select class='form-control' name='proyecto' id='proyecto' onchange="load(1)">
								<?php
								$query_proyecto = mysqli_query($con, "select * from proyectos order by nombre_proyecto");
								while ($rw = mysqli_fetch_array($query_proyecto)) {
								?>
									<option value="<?php echo $rw['id_proyecto']; ?>"><?php echo $rw['nombre_proyecto']; ?></option>
								<?php
								}
								?>
							</select>
						</div>

						<label for="q" class="col-md-1 control-label">Código</label>
						<div class='col-md-4'>
							<input type="text" class="form-control" id="q" placeholder="Código del producto">
						</div>
						
						<?php
							if ($isAdmin) { 
						?>
							<div class="col-md-2">
								<button type="button" class="btn btn-default" id="escanear">
									<span class="glyphicon glyphicon-barcode"></span> Escanear
								</button>
							</div>
						<?php 
							}
						?>

						<div class='col-md-12 text-center'>
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
	<script type="text/javascript" src="js/salidas.js"></script>
</body>

</html>

<?php
