<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

include('../is_logged.php'); //verifica que el usuario que intenta acceder a la URL esta logueado

//Valida los campos del form
if (empty($_POST['codigo'])) {
	$errors[] = "Código vacío";
} else if (
	!empty($_POST['codigo'])
) { //si los datos son correctos
	require_once("../../config/db.php"); //configuracion para conectar a la base de datos
	require_once("../../config/conexion.php"); //funcion que conecta a la base de datos
	include("../../funciones.php");

	$codigo = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
	$id_proyecto = mysqli_real_escape_string($con, (strip_tags($_POST["proyecto"], ENT_QUOTES)));

	$sql = "SELECT p.id_producto, p.descripcion_producto, IFNULL(p.stock-sum(s.stock), p.stock) stock FROM productos p
		LEFT join stocks s on s.id_producto = p.id_producto
		where p.codigo_producto = '" . $codigo . "'
		GROUP by p.id_producto";
	$query = mysqli_query($con, $sql); // obtiene los datos de la base
	$row = mysqli_fetch_array($query);

	if ($row != NULL) { // si existe el producto
		var_dump('si existe producto');
		$id_producto = $row['id_producto'];
		$stock = $row['stock'];

		$sql = "SELECT * FROM stocks WHERE id_producto= '" . $id_producto . "' AND id_proyecto= '" . $id_proyecto . "'";
		$query = mysqli_query($con, $sql); // obtiene los datos de la base
		$row = mysqli_fetch_array($query);
		if ($row != NULL) { // si existe el stock 
			$id_stock = $row['id_stock'];
			$stockAnterior = intval($row['stock']);
			$stockNuevo = $stockAnterior + 1;
			$sql = "UPDATE stocks SET stock = '" . $stockNuevo . "' WHERE id_stock ='" . $id_stock . "'";
		} else {
			$date_added = date("Y-m-d H:i:s");
			$stockAnterior = 0;
			$stockNuevo = 1;
			$sql = "INSERT INTO stocks (id_producto, id_proyecto, date_added, stock) VALUES ('$id_producto', '$id_proyecto', '$date_added', '$stockNuevo');";
		}

		if ($stockNuevo <= $stock) {
			$query = mysqli_query($con, $sql);
			if ($query) { //se crea nuevo stock
				if (strstr($sql, 'INSERT')) {
					$messages[] = "Stock se dio de alta satisfactoriamente.";
					$user_id = $_SESSION['user_id'];
					$firstname = $_SESSION['firstname'];
					$nota = "$firstname dio de alta un stock";
					echo guardar_movimiento($id_producto, $id_proyecto, $user_id, $date_added, $nota, $codigo, 'S'); //se crea historico stocks
				} else {
					$date_added = date("Y-m-d H:i:s");
					$messages[] = "Stock aumento su inventario satisfactoriamente";
					$user_id = $_SESSION['user_id'];
					$firstname = $_SESSION['firstname'];
					$nota = "$firstname aumento el stock.";
					echo guardar_movimiento($id_producto, $id_proyecto, $user_id, $date_added, $nota, $codigo, 'S'); //se crea historico stocks
				}
			} else { //si existe error al dar de alta producto
				$errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
			}
		} else {
			$errors[] = "El inventario General no cuenta con suficiente stock";
		}
	} else {
		$errors[] = "El Producto no existe.";
	}
} else {
	$errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Error!</strong>
		<?php
		foreach ($errors as $error) {
			echo $error;
		}
		?>
	</div>
<?php
}
if (isset($messages)) {

?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Bien hecho!</strong>
		<?php
		foreach ($messages as $message) {
			echo $message;
		}
		?>
	</div>
<?php
}

?>