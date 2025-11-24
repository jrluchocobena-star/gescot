<?php

include("conexion_bd.php");
//include("../funciones_fecha.php");
include("conexion_ftp.php");

		
	
	/*************************************************************************************/
	// CARGA BEOLIQUIDACION
	
		$ftp_server='10.226.44.223';
		$ftp_user_name='atento_cot';
		$ftp_user_pass='4t3nt0c0t';
		$conn_id = ftp_connect($ftp_server);
		
		$ruta_server ="/GCOT/R414/";		
		
		
		$archivo_server_1="VERDE_20180720_10.csv";						
		$local_file_1 = 'D:/DATA_COT/BEOLIQUIDACION/'.$archivo_server_1; //Nombre archivo en nuestro PC
		$server_file_1 = $ruta_server.$archivo_server_1; //Nombre archivo en FTP
		
			
		// Loguearse con usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		// Descarga el $server_file y lo guarda en $local_file
		if (ftp_get($conn_id, $local_file_1, $server_file_1, FTP_BINARY)) {
		echo "Se descargado el archivo con éxito\n";	
		
		
		} else {
		echo "Ha ocurrido un error\n";
		}
		
		/****************/
		
		$archivo_server_2	="MC_20180720_10.csv";						
		$local_file_2		= 'D:/DATA_COT/BEOLIQUIDACION/'.$archivo_server_2; //Nombre archivo en nuestro PC
		$server_file_2		= $ruta_server.$archivo_server_2; //Nombre archivo en FTP
		
			
		// Loguearse con usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		// Descarga el $server_file y lo guarda en $local_file
		if (ftp_get($conn_id, $local_file_2, $server_file_2, FTP_BINARY)) {
		echo "Se descargado el archivo con éxito\n";	
		
		
		} else {
		echo "Ha ocurrido un error\n";
		}
		
		
		

		// Cerrar la conexión
	ftp_close($conn_id);		
	
	mysql_query("truncate table tb_beoliquidacion") ;	
	mysql_query("truncate table tb_beoliquidacion_tmp") ;
	mysql_query("truncate table mc_prueba") ;
	
	$file_beo_1 = 'D:/DATA_COT/BEOLIQUIDACION/'.$archivo_server_1;
	
	$sql_beo1="LOAD DATA LOCAL INFILE '$file_beo_1'
	INTO TABLE tb_beoliquidacion_tmp
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
//	echo "<p>".$sql;
	$res_sql_beo1 = mysql_query($sql_beo1);
	
	$sql_beo2="INSERT IGNORE INTO tb_beoliquidacion 
	SELECT *,'0',NOW() FROM tb_beoliquidacion_tmp";			
	//echo "<br>".$sql_beo2;
	$res_sql_beo2 = mysql_query($sql_beo2) or die(mysql_error($sql_beo2));
	
	$sql_beo3="UPDATE tb_beoliquidacion a, cab_beoliquidaciones_cot b
	SET a.estado=b.estado
	WHERE a.CODMULTIGESTION=b.CODMULTIGESTION";
		//echo "<BR>".$sql_3;
	$res_sql_beo3 = mysql_query($sql_beo3) or die(mysql_error($sql_beo3));	
	
	$file_beo_2 = 'D:/DATA_COT/BEOLIQUIDACION/'.$archivo_server_2;
	
	$sql_beo4="LOAD DATA LOCAL INFILE '$file_beo_2'
	INTO TABLE mc_prueba
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
//	echo "<p>".$sql;
	$res_sql_beo4 = mysql_query($sql_beo4);
	
	$sql_beo5="UPDATE tb_beoliquidacion_tmp a, mc_prueba b
	SET a.status_='VERDE' 
	WHERE a.CODCLI=b.IDCLIENTECRM AND b.STATUS='ok'";	
//	echo "<p>".$sql;
	$res_sql_beo5 = mysql_query($sql_beo5);
	
	$sql_beo6="UPDATE tb_beoliquidacion_tmp a, mc_prueba b
	SET a.status_='NO APLICA' 
	WHERE a.CODCLI=b.IDCLIENTECRM AND b.STATUS='No es HFC'";	
//	echo "<p>".$sql;
	$res_sql_beo6 = mysql_query($sql_beo6);
	
	$sql_beo7="UPDATE tb_beoliquidacion_tmp a, mc_prueba b
	SET a.status_='ROJO ' 
	WHERE a.CODCLI=b.IDCLIENTECRM AND a.STATUS_ IS NULL";	
//	echo "<p>".$sql;
	$res_sql_beo7 = mysql_query($sql_beo7);
	
	$sql_beo8="UPDATE tb_beoliquidacion_tmp a, mc_prueba b
	SET a.llamador=b.CODREQ
	WHERE a.CODCLI=b.IDCLIENTECRM";	
//	echo "<p>".$sql;
	$res_sql_beo8 = mysql_query($sql_beo8);
	
		 
?>