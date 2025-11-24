<?Php
include("conexion_bd.php");


$obs_incidencia = limpiarCaracteres("obs_incidencia");

$cad= "update cab_incidencia set $rr";
$result_1 	= mysql_query($cad) or die(mysql_error());



function clear_cadena($value){
    $new_string = preg_replace("[^'A-Za-z0-9 _]", "", $value);
   	return $new_string;
}

?> 