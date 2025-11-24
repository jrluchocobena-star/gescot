<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo=$_GET["n_archivo"];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);

?>