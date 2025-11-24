<?php

include("funciones_carga.php");
		
//set_time_limit(5000);

/********************************************************************************************************/	

copiar_archivo(); 

$dia=date('Y-m-d');
$local_file = "d:/data_cot/Gestel423/glpl494_".$dia.".txt"; //Nombre archivo en nuestro PC		


if (file_exists($local_file)) { 		 
	blanquear_tablas_423();
	borrar_enprocesos();
	carga_423();	
	exclusiones_423();	
	carga_formatopsi();
} else {
		echo "El fichero $local_file no fue cargado";
		return;
}	

$sql_3_a="DELETE FROM tb_gestel_423 WHERE pedido='0'";		
	//echo "<br>".$sql_11x;	
$res_3_a= mysql_query($sql_3_a) or die(mysql_error($sql_3_a));		 

?>