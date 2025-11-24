<? 
include("conexion_bd.php");

$p1	= "UPDATE cab_incidencia SET tiempo=SEC_TO_TIME(dias*86400) WHERE modo ='d'";
$result_1 	= mysql_query($rutina_1) or die(mysql_error());


?>