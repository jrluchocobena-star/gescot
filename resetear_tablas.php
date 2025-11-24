<?php

		include("conexion_bd.php");
		mysql_query("truncate table tb_cms") ; 
		mysql_query("truncate table tb_cms_tmp") ; 
		mysql_query("truncate table tb_gestel_423") ;
		mysql_query("truncate table carga_pedidos_total") ;		
		mysql_query("truncate table tb_gestel_423_prov") ;	

?>