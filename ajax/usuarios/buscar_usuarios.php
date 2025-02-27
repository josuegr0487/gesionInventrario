<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

require_once("../../config/db.php"); //configuracion para conectar a la base de datos
require_once("../../config/conexion.php"); //funcion que conecta a la base de datos

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
	$user_id = intval($_GET['id']);
	$query = mysqli_query($con, "select * from usuarios where user_id='" . $user_id . "'");
	$rw_user = mysqli_fetch_array($query);
	$count = $rw_user['user_id'];
	if ($user_id != 1) {
		if ($delete1 = mysqli_query($con, "DELETE FROM usuarios WHERE user_id='" . $user_id . "'")) {
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
			<strong>Error!</strong> No se puede borrar el usuario administrador.
		</div>
	<?php
	}
}
if ($action == 'ajax') {
	$isAdmin = (isset($_SESSION['user_name']) && $_SESSION['user_name'] == 'admin') ? true : false; //valida si es admin
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('firstname', 'lastname'); //Columnas de busqueda
	$sTable = "usuarios";
	$sWhere = "";
	if ($_GET['q'] != "") //si se escribe informacion en el filtro
	{
		$sWhere = "WHERE (";
		for ($i = 0; $i < count($aColumns); $i++) {
			$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
		}
		$sWhere = substr_replace($sWhere, "", -3);
		$sWhere .= ')';
	}
	$sWhere .= " order by user_id";
	include '../pagination.php'; //archivo php de paginacion
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 10; //numero de registros por pagina
	$adjacents  = 4; //espacio entre paginas
	$offset = ($page - 1) * $per_page;
	$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere"); //total de filas
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './usuarios.php';
	$sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
	$query = mysqli_query($con, $sql); // obtiene los datos de la base
	if ($numrows > 0) { //si existe info			
	?>
		<div class="table-responsive">
			<table class="table">
				<tr class="info">
					<th>ID</th>
					<th>Nombres</th>
					<th>Usuario</th>
					<th>Email</th>
					<th>Fecha de Alta</th>
					<?php
						if ($isAdmin) { 
					?>
					<th><span class="pull-right">Acciones</span></th>
					<?php 
						}
					?>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {  //carga filas
					$user_id = $row['user_id'];
					$fullname = $row['firstname'] . " " . $row["lastname"];
					$user_name = $row['user_name'];
					$user_email = $row['user_email'];
					$date_added = date('d/m/Y', strtotime($row['date_added']));

				?>

					<input type="hidden" value="<?php echo $row['firstname']; ?>" id="nombres<?php echo $user_id; ?>">
					<input type="hidden" value="<?php echo $row['lastname']; ?>" id="apellidos<?php echo $user_id; ?>">
					<input type="hidden" value="<?php echo $user_name; ?>" id="usuario<?php echo $user_id; ?>">
					<input type="hidden" value="<?php echo $user_email; ?>" id="email<?php echo $user_id; ?>">

					<tr>
						<td><?php echo $user_id; ?></td>
						<td><?php echo $fullname; ?></td>
						<td><?php echo $user_name; ?></td>
						<td><?php echo $user_email; ?></td>
						<td><?php echo $date_added; ?></td>
						<?php
							if ($isAdmin) { 
						?>
						<td><span class="pull-right">
							
							<a href="#" class='btn btn-default' title='Editar usuario' onclick="obtener_datos('<?php echo $user_id; ?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
							<a href="#" class='btn btn-default' title='Cambiar contraseña' onclick="get_user_id('<?php echo $user_id; ?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-cog"></i></a>
							<a href="#" class='btn btn-default' title='Borrar usuario' onclick="eliminar('<? echo $user_id; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
						</span></td>
						<?php 
							}
						?>
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan=9><span class="pull-right">
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