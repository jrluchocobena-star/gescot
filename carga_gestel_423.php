<?php

include("conexion_bd.php");
//include("../funciones_fecha.php");
include("conexion_ftp.php");

		
set_time_limit(5000);

$sw=1;

$t_inicio2=date('Y-m-d H:m');

		$dia=date('Y-m-d');
		//$dia='2018-04-24';
		$local_file = "d:/data_cot/Gestel423/glpl494_".$dia.".txt"; //Nombre archivo en nuestro PC		
		$server_file = '/home/geslis/lcobena0/glpl494.txt'; //Nombre archivo en FTP
		
	
		
		// Loguearse con usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		// Descarga el $server_file y lo guarda en $local_file
		if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
		echo "Se descargado el archivo con éxito\n";
		} else {
		echo "Ha ocurrido un error\n";
		}
		
		// Cerrar la conexión
		ftp_close($conn_id);
		
		
		mysql_query("truncate table tb_gestel_423") ;
		//mysql_query("truncate table carga_pedidos_total") ;		
		mysql_query("truncate table tb_gestel_423_prov") ;	
		mysql_query("truncate table ORIGEN_ZONAL") ;	
		
	/*****************************************************************************************/
	$tabla = "tb_gestel_423";
	$ini2=date("Y-m-d H:m");
	$dia=date('Y-m-d');
	
	$row=1;	
	
	$fileName = "d:/data_cot/Gestel423/glpl494_".$dia.".txt";
	//echo $fileName;
	
	
	$fp = fopen($fileName, "r");
	
	while (!feof($fp) ) {
		//$linea = fread($fp,8192);
		$linea  = fgets($fp);	//echo "<br>".$linea;
		
		if($row > 11){ // a partir de la linea 20
		
		//col1
		$ciudad = trim(substr($linea, 3, 7));
		if($ciudad==""){$ciudad='X';}else{$ciudad=$ciudad;}
		
		$pedido = trim(substr($linea, 11, 10));
		if($pedido==""){$pedido='X';}else{$pedido=$pedido;}
		
		$insc = trim(substr($linea, 21, 12));
		
		$dire = limpia_cadena(substr($linea, 35, 94));	
		$distrito = trim(substr($linea, 133, 8));
		if($distrito==""){$distrito='-';}else{$distrito=$distrito;}
		$promocion = trim(substr($linea, 140, 5));
		if($promocion==""){$promocion='-';}else{$promocion=$promocion;}
		$grupo = trim(substr($linea, 146, 16));
		if($grupo==""){$grupo='-';}else{$grupo=$grupo;}
		$nref = trim(substr($linea, 166, 10));
		if($nref==""){$nref='-';}else{$nref=$nref;}	
		$fec_reg = trim(substr($linea, 176, 15));
		if($fec_reg==""){$fec_reg='-';}else{$fec_reg=$fec_reg;}
		$tp_serv = trim(substr($linea, 192, 25));
		if($tp_serv==""){$tp_serv='-';}else{$tp_serv=$tp_serv;}
		$priori = trim(substr($linea, 217, 5));
		if($priori==""){$priori='-';}else{$priori=$priori;}
		$oficom = trim(substr($linea, 226, 5));
		if($oficom==""){$oficom='-';}else{$oficom=$oficom;}
		$peticion = trim(substr($linea, 231, 20));
		if($peticion==""){$peticion='-';}else{$peticion=$peticion;}
		$agrupacion = trim(substr($linea, 255, 5));
		if($agrupacion==""){$agrupacion='-';}else{$agrupacion=$agrupacion;}
		$cliente = trim(substr($linea, 260, 12));
		if($cliente==""){$cliente='-';}else{$cliente=$cliente;}
		$cuenta = trim(substr($linea, 272, 12));
		if($cuenta==""){$cuenta='-';}else{$cuenta=$cuenta;}
		$pc = trim(substr($linea, 284, 12));
		if($pc==""){$pc='-';}else{$pc=$pc;}
		$negocio = trim(substr($linea, 300, 10));
		if($negocio==""){$negocio='-';}else{$negocio=$negocio;}
		$prefijo = trim(substr($linea, 310, 10));
		if($prefijo==""){$prefijo='-';}else{$prefijo=$prefijo;}
		$segmento = trim(substr($linea, 320, 10));
		if($segmento==""){$segmento='-';}else{$segmento=$segmento;}
		$cantidad = trim(substr($linea, 330, 10));
		if($cantidad==""){$cantidad='-';}else{$cantidad=$cantidad;}	
		$subseg = trim(substr($linea, 340, 10));
		if($subseg==""){$subseg='-';}else{$subseg=$subseg;}	
		$iris = trim(substr($linea, 350, 10));
		if($iris==""){$iris='-';}else{$iris=$iris;}	
		$dir_ant = trim(substr($linea, 360, 10));
		if($dir_ant==""){$dir_ant='-';}else{$dir_ant=$dir_ant;}	
		$sector = trim(substr($linea, 415, 10));
		if($sector==""){$sector='-';}else{$sector=$sector;}
		$manz = trim(substr($linea, 425, 5));
		if($manz==""){$manz='-';}else{$manz=$manz;}
		$coorX = trim(substr($linea, 430, 20));
		if($coorX==""){$coorX='-';}else{$coorX=$coorX;}
		$coorY = trim(substr($linea, 450, 20));
		if($coorY==""){$coorY='-';}else{$coorY=$coorY;} 
	
		/*
		echo "<br>".$ciudad."|".$pedido."|".$insc."|".$dire."|".$distrito."|".$promocion."|".$grupo."|".$nref."|".$fec_reg."|".$tp_serv."|".$priori."|".$oficom."|"
		.$peticion."|".$agrupacion."|".$cliente."|".$cuenta."|".$pc."|".$negocio."|".$prefijo."|".$segmento."|".$cantidad."|".$subseg."|".$iris."|".$dir_ant."|".$sector
		."|".$manz."|".$coorX."|".$coorY;	
		
		*/
			
		$sql_1="INSERT INTO $tabla (CIUDAD,PEDIDO,INSCRIPCION,DIRECCION,DISTRITO,PROMOCION,GRUPO,NRO_REF,FECHA_REG,TIPO_SERVICIO,PRIORIDAD,OFIC_COM,PETICION,
			AGRUPACION,CLIENTE,CUENTA,PC,NEGOCIO,PREFIJO,SEGMENTO,CANTIDAD,SUB_SEGMENTO,IRIS,DIRECCION_ANTIGUA,SECTOR,MANZANA,COORD_X,COORD_Y,zon,fec_carga) 
			VALUES ('$ciudad','$pedido','$insc','$dire','$distrito','$promocion','$grupo','$nref','$fec_reg','$tp_serv','$priori','$oficom',
			'$peticion','$agrupacion','$cliente','$cuenta','$pc','$negocio','$prefijo','$segmento','$cantidad','$subseg','$iris','$dir_ant','$sector',
			'$manz','$coorX','$coorY','0',now());";
			
		//echo "<br>".$sql_1;
		$res_1 = mysql_query($sql_1) or die(mysql_error($sql_1));
		
		$sql_2="delete from $tabla where negocio='CEE'";
		$res_2 = mysql_query($sql_2) or die(mysql_error($sql_2));			
		
		$sql_3="delete from $tabla where pedido in ('X','----------','PEDIDO','NICA',':')";		
		//echo "<br>".$sql;	
		$res_3 = mysql_query($sql_3) or die(mysql_error($sql_3));			
		}
		$row++;
		
		if ($ciudad=="X"){
			unset($cont[$row]); 
			
		}
		
					
	}
	
	fclose($fp);	
	
		$sql_4="INSERT INTO tb_gestel_423_prov
		(SELECT *,'ARE' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('50','51','52','53','54','55','56','57','58'))";
		$res_4 = mysql_query($sql_4) or die(mysql_error($sql_4));	
		
		$sql_5="INSERT INTO tb_gestel_423_prov
		(SELECT *,'CHI' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('01','05'))";
		$res_5 = mysql_query($sql_5) or die(mysql_error($sql_5));	
		
		$sql_6="INSERT INTO tb_gestel_423_prov
		(SELECT *,'CTE' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('13','04','09'))";
		$res_6 = mysql_query($sql_6) or die(mysql_error($sql_6));	
		
		$sql_7="INSERT INTO tb_gestel_423_prov
(SELECT *,'HUA' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('10','12','14'))
UNION(SELECT *,'HUA' FROM tb_gestel_423 WHERE CIUDAD IN ('1007','1208','01081','01084','11001','11036','11038','11039'))";
		$res_7 = mysql_query($sql_7) or die(mysql_error($sql_7));	
		
		$sql_8="INSERT INTO tb_gestel_423_prov
(SELECT *,'CUS' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('53','54'))UNION(SELECT *,'HUA' FROM tb_gestel_423 WHERE CIUDAD IN ('57050'))";
		$res_8 = mysql_query($sql_8) or die(mysql_error($sql_8));	

		$sql_9="INSERT INTO tb_gestel_423_prov
(SELECT *,'ICA' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('03'))UNION(SELECT *,'CUS' FROM tb_gestel_423 WHERE CIUDAD IN ('12007','12019','12205','12337','12339','12469'))";
		$res_9 = mysql_query($sql_9) or die(mysql_error($sql_9));	
		
		$sql_10="INSERT INTO tb_gestel_423_prov
(SELECT *,'IQU' FROM tb_gestel_423 WHERE ciudad IN ('11037','01001','01078','01095','01096'))";
		$res_10 = mysql_query($sql_10) or die(mysql_error($sql_10));	
		
		$sql_11="INSERT INTO tb_gestel_423_prov
(SELECT *,'PIU' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('02','07'))";
		$res_11= mysql_query($sql_11) or die(mysql_error($sql_11));	

		$sql_12="INSERT INTO tb_gestel_423_prov
(SELECT *,'TRU' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('15','51','60','08','81'))";
		$res_12 = mysql_query($sql_12) or die(mysql_error($sql_12));
		
		
		/**********************************************/
		$sql_P1="update tb_gestel_423_tot set zon='ARE' 
		WHERE SUBSTR(ciudad,1,2)IN ('50','51','52','53','54','55','56','57','58')";
		$res_P1 = mysql_query($sql_P1) or die(mysql_error($sql_P1));	
		
		$sql_P2="update tb_gestel_423_tot set zon='CHI' WHERE SUBSTR(ciudad,1,2)IN ('01','05')";
		$res_P2 = mysql_query($sql_P2) or die(mysql_error($sql_P2));	
		
		$sql_P3="update tb_gestel_423_tot set zon='CTE'  WHERE SUBSTR(ciudad,1,2)IN ('13','04','09')";
		$res_P3 = mysql_query($sql_P3) or die(mysql_error($sql_P3));	
		
		$sql_P4="update tb_gestel_423_tot set zon='HUA'  WHERE SUBSTR(ciudad,1,2)IN ('10','12','14')";
		$res_P4 = mysql_query($sql_P4) or die(mysql_error($sql_P4));	
		
		$sql_P5="update tb_gestel_423_tot set zon='HUA' WHERE CIUDAD IN ('1007','1208','01081','01084','11001','11036','11038','11039')";
		$res_P5 = mysql_query($sql_P5) or die(mysql_error($sql_P5));	
		
		$sql_P6="update tb_gestel_423_tot set zon='CUS' WHERE SUBSTR(ciudad,1,2)IN ('53','54')";
		$res_P6 = mysql_query($sql_P6) or die(mysql_error($sql_P6));	
		
		$sql_P7="update tb_gestel_423_tot set zon='HUA' WHERE CIUDAD='57050'";
		$res_P7 = mysql_query($sql_P7) or die(mysql_error($sql_P7));	

		$sql_P8="update tb_gestel_423_tot set zon='ICA' WHERE SUBSTR(ciudad,1,2)IN ('03')";
		$res_P8 = mysql_query($sql_P8) or die(mysql_error($sql_P8));	
		
		$sql_P9="update tb_gestel_423_tot set zon='HUA' WHERE CIUDAD IN ('12007','12019','12205','12337','12339','12469')";
		$res_P9 = mysql_query($sql_P9) or die(mysql_error($sql_P9));	
		
		$sql_P10="update tb_gestel_423_tot set zon='IQU' WHERE ciudad IN ('11037','01001','01078','01095','01096')";
		$res_P10 = mysql_query($sql_P10) or die(mysql_error($sql_P10));	
		
		$sql_P11="update tb_gestel_423_tot set zon='PIU' WHERE SUBSTR(ciudad,1,2)IN ('02','07')";
		$res_P11= mysql_query($sql_P11) or die(mysql_error($sql_P11));	

		$sql_P12="update tb_gestel_423_tot set zon='TRU' WHERE SUBSTR(ciudad,1,2)IN ('15','51','60','08','81')";
		$res_P12 = mysql_query($sql_P12) or die(mysql_error($sql_P12));
		
		$sql_P13="update tb_gestel_423_tot set zon='LIM' WHERE zon='0'";
		$res_P13 = mysql_query($sql_P13) or die(mysql_error($sql_P13));

		

		/***********************************************/
		
		$sql_12="INSERT IGNORE INTO tb_gestel_423_dia
		SELECT *,'' FROM tb_gestel_423 group by INSCRIPCION";			
		//echo "<br>".$sql_13;
		$res_12 = mysql_query($sql_12) or die(mysql_error($sql_12));
		
		$sql_12_1="UPDATE tb_gestel_423_dia a, cab_asignaciones_cot b
		SET a.est='TRABAJADO'
		WHERE a.peticion=b.peticion";			
		//echo "<br>".$sql_13;
		$res_12_1 = mysql_query($sql_12_1) or die(mysql_error($sql_12_1));
		
		$sql_13="INSERT IGNORE INTO tb_gestel_423_tot
		SELECT *,'' FROM $tabla group by INSCRIPCION";			
		//echo "<br>".$sql_13;
		$res_13 = mysql_query($sql_13) or die(mysql_error($sql_13));
		
		$sql_13_1="UPDATE tb_gestel_423_tot a, cab_asignaciones_cot b
		SET a.est='TRABAJADO'
		WHERE a.peticion=b.peticion";
		$res_13_1 = mysql_query($sql_13) or die(mysql_error($sql_13_1));	
		
		$sql_14="INSERT ignore into carga_pedidos_total
		(SELECT peticion,pedido,inscripcion,direccion,
		CONCAT('20',SUBSTR(fecha_reg,7,2),'-',SUBSTR(fecha_reg,4,2),'-',SUBSTR(fecha_reg,1,2),
		' ',SUBSTR(fecha_reg,10,5)),'GESTEL-423','0','' FROM $tabla where SUBSTR(fec_carga,1,10)=DATE(NOW()))";
		//echo "<BR>".$sql_14;
		$res_sql_14 = mysql_query($sql_14) or die(mysql_error($sql_14));	
		
		$sql_15="UPDATE carga_pedidos_total a, cab_asignaciones_cot b
		SET a.estado=b.estado_asig 
		WHERE a.peticion=b.peticion";
		//echo "<BR>".$sql_3;
		$res_sql_15 = mysql_query($sql_15) or die(mysql_error($sql_15));	
		
		$sql_16="UPDATE carga_pedidos_total a,  tb_gestel_423_prov b
		SET a.zonal=b.zonal
		WHERE a.peticion=b.peticion and a.origen='GESTEL-423'";
		//echo "<BR>".$sql_3;
		$res_sql_16 = mysql_query($sql_16) or die(mysql_error($sql_16));	
		
		
		
		
		$sql_18="UPDATE carga_pedidos_total SET zonal='LIM' WHERE zonal='' and origen='GESTEL-423'";
		//echo "<BR>".$sql_3;
		$res_sql_18 = mysql_query($sql_18) or die(mysql_error($sql_18));	
		
		
		$sql_19="delete from carga_pedidos_total where peticion in ('',' ','N')";
		//echo "<BR>".$sql_3;
		$res_sql_19 = mysql_query($sql_19) or die(mysql_error($sql_19));	
	
		
		
		
		$junta2="INSERT INTO ORIGEN_ZONAL
		SELECT TRIM(ZONAL),origen,estado,COUNT(*) FROM carga_pedidos_total GROUP BY 1,2,3 ORDER BY 1";
		//echo $junta2;
		$res_sql_junta2= mysql_query($junta2)or die(mysql_error($junta2));	
		
		$sql_="insert into tb_log values('CARGA GESTEL 423','CARGA DE ARCHIVOS GESTEL-OPC.423',now(),'$t_inicio2','USER_WIN','')";		
		$res_sql_ = mysql_query($sql_) or die(mysql_error($sql_));	
		
		
		
		
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