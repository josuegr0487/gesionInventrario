<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

require_once("../../config/db.php"); //configuracion para conectar a la base de datos
require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$id_proyecto = mysqli_real_escape_string($con, (strip_tags($_GET["proyecto"], ENT_QUOTES)));

if ($action == 'ajax') {
	$sTable = "movimientos";
	$iJTable = "productos";
	$sWhere = "WHERE status = 'S' AND $sTable.id_proyecto = $id_proyecto";
	$sWhere .= " order by id_movimiento desc";
	$innerJoin = "INNER JOIN $iJTable ON $iJTable.id_producto = $sTable.id_producto";
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
	$reload = './salidas.php';
	$sql = "SELECT * FROM  $sTable $innerJoin $sWhere LIMIT $offset,$per_page";
	$query = mysqli_query($con, $sql); // obtiene los datos de la base
	if ($numrows > 0) { //si existe info

?>
		<div class="table-responsive">
			<table class="table">
				<tr class="info">
					<th>Fecha de Salida</th>
					<th>Código</th>
					<th>Descripción Producto</th>
					<th>Log</th>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) { //carga filas
					$id_historial = $row['id_movimiento'];
					$codigo_producto = $row['codigo_producto'];
					$descripcion_producto = $row['descripcion_producto'];
					$date_added = date('d/m/Y H:i:s ', strtotime($row['fecha']));
					$log = $row['log'];
				?>
					<tr>
						<td><?php echo $date_added; ?></td>
						<td><?php echo $codigo_producto; ?></td>
						<td><?php echo $descripcion_producto; ?></td>
						<td><?php echo $log; ?></td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right">
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