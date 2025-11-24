<?php

echo "PROCESO INICIANDO....";

set_time_limit(1000000);

include("funciones_carga.php");

$tabla = "tb_contactos_actual";
//$fec = date("dmY");
$fileName = "d:/compartido/data/contactos/BASE_CONTACTOS.txt";


blanquear_tablas_contactos($tabla);

llenar_tablas_contactos($fileName,$tabla);

cruces_tabla_contactos($tabla);

//transpasar_tabla();

echo "<br>PROCESO DE CARGA TERMINADO";	

?>
