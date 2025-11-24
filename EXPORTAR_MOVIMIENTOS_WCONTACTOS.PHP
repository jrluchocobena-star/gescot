<?php 

include("conexion_bd.php");
//include("funciones_fecha.php");

set_time_limit(5000);

$ruta="D:/COMPARTIDO/DATA/CONTACTOS/";
$archivo="MOVIMIENTOS_WEB_CONTACTOS.txt"; 
$c_archivo=$ruta.$archivo;

$qry_0 = "SELECT * FROM tb_contactos_032019 WHERE campo11 IN('REGISTRADO','ELIMINAR','ACTUALIZAR')
INTO OUTFILE '$c_archivo' 
FIELDS TERMINATED BY '|' 
"; 	
//echo "<br>".$qry_0;		
$res_0 = mysql_query($qry_0);

?>