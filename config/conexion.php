<?php
/*-------------------------
Autor: Josue Garcia
Proyecto: Gestion de Inventario
---------------------------*/

$con = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); # coneccion base de datos
if (!$con) {
    die("No se puede conectar a la base de datos: " . mysqli_error($con));
}
if (@mysqli_connect_errno()) {
    die("falló al conectarse a la base : " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}
