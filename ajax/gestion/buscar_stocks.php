<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

require_once("../../config/db.php"); //configuracion para conectar a la base de datos
require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

include("../../funciones.php");
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('codigo_producto', 'descripcion_producto'); //Columnas de busqueda
	$sTable = "productos";
	$lJTable = "stocks";
	$iJTable = "unidad_medida";
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
	$sWhere .= " group by $sTable.id_producto";
	$sWhere .= " order by descripcion_producto asc";
	$leftJoin = "LEFT JOIN $lJTable ON $lJTable.id_producto = $sTable.id_producto";
	$innerJoin = "INNER JOIN $iJTable ON $iJTable.id_unidad = $sTable.id_unidad";
	include '../pagination.php';  //archivo php de paginacion
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 18; //numero de registros por pagina
	$adjacents  = 4; //espacio entre paginas
	$offset = ($page - 1) * $per_page;
	$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere"); ///total de filas
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './gestion.php';
	$sql = "SELECT $sTable.id_producto, $sTable.codigo_producto, $sTable.descripcion_producto, $sTable.stock, IFNULL($sTable.stock-sum($lJTable.stock), $sTable.stock) stockD, $iJTable.abreviacion  
	FROM  $sTable $leftJoin $innerJoin $sWhere LIMIT $offset,$per_page";
	$query = mysqli_query($con, $sql); // obtiene los datos de la base
	if ($numrows > 0 ) { //si existe info

?>
		<div class="table-responsive">
			<table class="table">
				<tr class="info">
					<th>Código</th>
					<th>Descripción Producto</th>
					<th>Stock</th>
					<th>Disponible</th>
					<th>Unidad</th>
					<!-- <th><span class="pull-right">Acciones</span></th> -->
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) { //carga filas
					$id_producto = $row['id_producto'];
					$codigo_producto = $row['codigo_producto'];
					$descripcion_producto = $row['descripcion_producto'];
					$stock = $row['stock'];
					$stockD = $row['stockD'];
					$abreviacion = $row['abreviacion'];
					$row_data = json_encode($row);
				?>
					<tr>
						<td><?php echo $codigo_producto; ?></td>
						<td><?php echo $descripcion_producto; ?></td>
						<td><?php echo $stock; ?></td>
						<td><?php echo $stockD; ?></td>
						<td><?php echo $abreviacion; ?></td>

						<!-- <td class='text-right'>
							<a href="#" class='btn btn-default' title='Consultar producto' data-row='<?php echo $row_data; ?>' data-toggle="modal" data-target="#myModal1"><i class="glyphicon glyphicon-search"></i></a>
							<a href="#" class='btn btn-default' title='Editar producto' data-row='<?php echo $row_data; ?>' data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
							<a href="#" class='btn btn-default' title='Baja de Producto' data-row='<?php echo $row_data; ?>' data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						</td> -->

					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right">
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