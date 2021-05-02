<?php
function get_row($table, $row, $id, $equal)
{
	global $con;
	$query = mysqli_query($con, "select $row from $table where $id='$equal'");
	$rw = mysqli_fetch_array($query);
	$value = $rw[$row];
	return $value;
}

function guardar_historial($id_producto, $user_id, $fecha, $nota, $reference)
{
	global $con;
	$sql = "INSERT INTO historial (id_historial, id_producto, user_id, fecha, log, referencia)
	VALUES (NULL, '$id_producto', '$user_id', '$fecha', '$nota', '$reference');";
	$query = mysqli_query($con, $sql);
}

function guardar_movimiento($id_producto, $id_proyecto, $user_id, $fecha, $nota, $reference, $status)
{
	global $con;
	$sql = "INSERT INTO movimientos (id_producto, id_proyecto, user_id, fecha, referencia, status, log)
	VALUES ('$id_producto', '$id_proyecto', '$user_id', '$fecha', '$reference', '$status', '$nota' );";
	$query = mysqli_query($con, $sql);
}
