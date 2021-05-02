<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

require_once("../../config/db.php"); //configuracion para conectar a la base de datos
require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
	$id_proyecto = intval($_GET['id']);
	$query = mysqli_query($con, "select * from productos where id_proyecto='" . $id_proyecto . "'");  /// verificar si existen productos con ese proyecto
	$count = mysqli_num_rows($query);
	if ($count == 0) {
		if ($delete1 = mysqli_query($con, "DELETE FROM proyectos WHERE id_proyecto='" . $id_proyecto . "'")) {
?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
		<?php
		} else {
		?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
		<?php

		}
	} else {
		?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong> No se pudo eliminar este proyecto. Existen productos vinculados a este proyecto.
		</div>
	<?php
	}
}


if ($action == 'ajax') {
	$isAdmin = (isset($_SESSION['user_name']) && $_SESSION['user_name'] == 'admin') ? true : false; //valida si es admin
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('nombre_proyecto'); //Columnas de busqueda
	$sTable = "proyectos";
	$sWhere = "";
	if ($_GET['q'] != "") //si se escribe informacion en filtro
	{
		$sWhere = "WHERE (";
		for ($i = 0; $i < count($aColumns); $i++) {
			$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}
	$sWhere .= " order by nombre_proyecto";
	include '../pagination.php'; //archivo php de paginacion
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 10; //numero de registros por pagina
	$adjacents  = 4; //espacio entre paginas
	$offset = ($page - 1) * $per_page;
	$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere"); ///total de filas
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './proyectos.php';
	$sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
	$query = mysqli_query($con, $sql); // obtiene los datos de la base
	if ($numrows > 0) { //si existe info

	?>
		<div class="table-responsive">
			<table class="table">
				<tr class="info">
					<th>Nombre</th>
					<th>Fecha de Alta</th>
					<?php
						if ($isAdmin) { 
					?>
						<th class='text-right'>Acciones</th>
					<?php 
						}
					?>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) { //carga filas
					$id_proyecto = $row['id_proyecto'];
					$nombre_proyecto = $row['nombre_proyecto'];
					$date_added = date('d/m/Y', strtotime($row['date_added']));

				?>
					<tr>

						<td><?php echo $nombre_proyecto; ?></td>
						<td><?php echo $date_added; ?></td>
						<?php
							if ($isAdmin) { 
						?>
							<td class='text-right'>
								<a href="#" class='btn btn-default' title='Editar proyecto' data-nombre='<?php echo $nombre_proyecto; ?>' data-id='<?php echo $id_proyecto; ?>' data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
								<a href="#" class='btn btn-default' title='Borrar proyecto' onclick="eliminar('<?php echo $id_proyecto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
							</td>
						<?php 
							}
						?>
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan=4><span class="pull-right">
							<?php
							echo paginate($reload, $page, $total_pages, $adjacents);
							?></span></td>
				</tr>
			</table>
		</div>
<?php
	}
}
?>