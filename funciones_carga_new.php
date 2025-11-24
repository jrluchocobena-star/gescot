<? 
include("conexion_bd.php");


/********************************************************************************************************/	

/*
function leer_clave_gestel($ftp_user_pass){
$file = fopen("d:/macros/acceso/gestel.ini", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached

$fila = 0;
while(!feof($file))
{
	$linea  = fgets($file);	//echo "<br>".$linea;		
		if ($fila==3){
		$ftp_user_pass = trim(substr($linea, 10, 15));		
		echo $ftp_user_pass. "<br />";
		return $ftp_user_pass;
		}
	$fila=$fila + 1;
}
fclose($file);

}	
*/
function copiar_archivo(){
	
		$file = fopen("d:/macros/acceso/gestel.ini", "r") or exit("Unable to open file!");
		//Output a line of the file until the end is reached
		
		$fila = 0;
		while(!feof($file))
		{
			$linea  = fgets($file);	//echo "<br>".$linea;		
				if ($fila==2){
				$ftp_user_pass = trim(substr($linea, 9, 15));						
				}
			$fila=$fila + 1;
		}
		fclose($file);

		//echo $ftp_user_pass;
		
		$server_file 	= '/home/geslis/lcobena0/glpl494.txt'; //Nombre archivo en FTP
		$local_file 	= "d:/data_cot/Gestel423/glpl494_".date('Y-m-d').".txt"; //Nombre archivo en nuestro PC		
		$ftp_server		= '10.4.3.220';
		$ftp_user_name	= 'lcobena0';				
		$conn_id 		= ftp_connect($ftp_server);

		// Loguearse con usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		// Descarga el $server_file y lo guarda en $local_file
		if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
		//echo "Se descargado el archivo $server_file con éxito\n";
		} else {
		echo "Ha ocurrido un error\n";
		}
		
		// Cerrar la conexión
		ftp_close($conn_id);
		
		echo "<br>"."Proceso Copiar archivo G423 OK";
	
}

	
function blanquear_tablas_423(){		
		mysql_query("truncate table tb_gestel_423") ;
		//mysql_query("truncate table carga_pedidos_total") ;		
		mysql_query("truncate table tb_gestel_423_prov") ;	
		mysql_query("truncate table ORIGEN_ZONAL") ;	
		
		echo "<br>"."Proceso Blanquear Tablas 423 OK";
}	
	
function carga_423(){
	
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
		if (is_numeric($ciudad)){$ciudad=$ciudad;}else{$ciudad=0;} 	
		//if($ciudad==""){$ciudad='X';}else{$ciudad=$ciudad;}			
		
		$pedido = trim(substr($linea, 11, 10));
		if (is_numeric($pedido)){$pedido=$pedido;}else{$pedido=0;} 
		/*
		if($pedido==""){$pedido='X';}else{$pedido=$pedido;}
		if($pedido=="-"){$pedido='X';}else{$pedido=$pedido;}
		*/
		$insc = trim(substr($linea, 21, 12));
		if (is_numeric($insc)){$insc=$insc;}else{$insc=0;} 
		
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
	
		
		$sql_1="INSERT INTO tb_gestel_423(CIUDAD,PEDIDO,INSCRIPCION,DIRECCION,DISTRITO,PROMOCION,GRUPO,NRO_REF,
		FECHA_REG,TIPO_SERVICIO,PRIORIDAD,OFIC_COM,PETICION,AGRUPACION,CLIENTE,CUENTA,PC,NEGOCIO,PREFIJO,
		SEGMENTO,CANTIDAD,SUB_SEGMENTO,IRIS,DIRECCION_ANTIGUA,SECTOR,MANZANA,COORD_X,COORD_Y,zon,fec_carga) 
		VALUES('$ciudad','$pedido','$insc','$dire','$distrito','$promocion','$grupo','$nref',
		'$fec_reg','$tp_serv','$priori','$oficom','$peticion','$agrupacion','$cliente','$cuenta','$pc',
		'$negocio','$prefijo','$segmento','$cantidad','$subseg','$iris','$dir_ant','$sector',
		'$manz','$coorX','$coorY','0',now());";
			
		//echo "<br>|".$sql_1."|";
		$res_1 = mysql_query($sql_1);
		
			
		}
		$row++;
		
		if ($ciudad=="X"){
			unset($cont[$row]); 
			
		}
		
					
	}
	
		fclose($fp);	

	$sql_2	=	"delete from tb_gestel_423 where negocio='CEE'";
	//echo "<br>".$sql_2;
	$res_2 	= 	mysql_query($sql_2) or die(mysql_error($sql_2));			
			
	$sql_3	=	"delete from tb_gestel_423 where segmento in ('1','2','3','4')";		
	//echo "<br>".$sql_3;	
	$res_3  = 	mysql_query($sql_3) or die(mysql_error($sql_3));		
	
	$sql_3_a="DELETE FROM tb_gestel_423 WHERE pedido='0'";		
		//echo "<br>".$sql_11x;	
	$res_3_a= mysql_query($sql_3_a) or die(mysql_error($sql_3_a));
	

	echo "<br>"."Proceso Carga423 OK";
}


function exclusiones_423(){		
		
		
		/* ZONIFICACION PROVINCIA */
	
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
		(SELECT *,'HUA' FROM tb_gestel_423 WHERE 
		SUBSTR(ciudad,1,2)IN ('10','12','14'))
		UNION(SELECT *,'HUA' FROM tb_gestel_423 WHERE 
		CIUDAD IN ('1007','1208','01081','01084','11001','11036','11038','11039'))";
		$res_7 = mysql_query($sql_7) or die(mysql_error($sql_7));	
		
		$sql_8="INSERT INTO tb_gestel_423_prov
		(SELECT *,'CUS' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('53','54'))
		UNION(SELECT *,'HUA' FROM tb_gestel_423 WHERE CIUDAD IN ('57050'))";
		$res_8 = mysql_query($sql_8) or die(mysql_error($sql_8));	

		$sql_9="INSERT INTO tb_gestel_423_prov
		(SELECT *,'ICA' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('03'))UNION(SELECT *,'CUS' 
		FROM tb_gestel_423 WHERE CIUDAD IN ('12007','12019','12205','12337','12339','12469'))";
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
		
		$sql_P5="update tb_gestel_423_tot set zon='HUA' WHERE 
		CIUDAD IN ('1007','1208','01081','01084','11001','11036','11038','11039')";
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
		SELECT *,'' FROM tb_gestel_423 group by INSCRIPCION";			
		//echo "<br>".$sql_13;
		$res_13 = mysql_query($sql_13) or die(mysql_error($sql_13));
		
		$sql_13_1="UPDATE tb_gestel_423_tot a, cab_asignaciones_cot b
		SET a.est='TRABAJADO'
		WHERE a.peticion=b.peticion";
		$res_13_1 = mysql_query($sql_13) or die(mysql_error($sql_13_1));	
		
		/*
		$sql_13_2="delete from carga_pedidos_total where origen='GESTEL-423'";
		//echo "<BR>".$sql_14;
		$res_sql_13_2 = mysql_query($sql_13_2) or die(mysql_error($sql_13_2));	
		*/
		
		$sql_14="INSERT ignore into carga_pedidos_total
		(SELECT peticion,pedido,inscripcion,direccion,
		CONCAT('20',SUBSTR(fecha_reg,7,2),'-',SUBSTR(fecha_reg,4,2),'-',SUBSTR(fecha_reg,1,2),
		' ',SUBSTR(fecha_reg,10,5)),'GESTEL-423','0','' FROM tb_gestel_423 where SUBSTR(fec_carga,1,10)=DATE(NOW()))";
		//echo "<BR>".$sql_14;
		$res_sql_14 = mysql_query($sql_14);	
		
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
	
		
		$sql_3_b="DELETE FROM tb_gestel_423 WHERE ciudad=0";
		//echo "<br>".$sql_11x;	
		$res_3_b = mysql_query($sql_3_b) or die(mysql_error($sql_3_b));	
		
		$junta2="INSERT INTO ORIGEN_ZONAL
		SELECT TRIM(ZONAL),origen,estado,COUNT(*) FROM carga_pedidos_total GROUP BY 1,2,3 ORDER BY 1";
		//echo $junta2;
		$res_sql_junta2= mysql_query($junta2)or die(mysql_error($junta2));	
		
		$sql_="insert into tb_log values('CARGA GESTEL 423','CARGA DE ARCHIVOS GESTEL-OPC.423',now(),'$t_inicio2','USER_WIN','')";		
		$res_sql_ = mysql_query($sql_) or die(mysql_error($sql_));	
		
		echo "<br>"."Proceso Excluciones423 OK";
	
}

function carga_beoliquidaciones(){
	
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
	
	}
	
function blanquear_tablas_cms(){
	//mysql_query("truncate table tb_cms_tmp") ; 	
	mysql_query("truncate table tb_cms") ; 	
}

function carga_cms($cms){
	echo $cms;
	$row = 1 ;	
	$fp = fopen($cms, "r");
	
	while (!feof($fp) ) {
		//$linea = fread($fp,8192);
		
		$linea  = fgets($fp);	
		
		//echo "<br>".$row;
		
		if($row > 1){ // a partir de la linea 20
		
		$linea = explode(",", $linea);

		$col					=$linea[0];
		$n_requer				=$linea[1];
		$Area_Ant				=$linea[2];
		$AREA					=$linea[3];
		$Cliente				=$linea[4];
		$VIP					=$linea[5];
		$CORP					=$linea[6];
		$Agendado				=$linea[7];
		$En_Gaudi				=$linea[8];
		$Seg_Gaudi				=$linea[9];
		$PAI					=$linea[10];
		$Nivel_Ubic				=$linea[11];
		$Peticion				=$linea[12];
		$MultiServicio			=$linea[13];
		$Tipo_Deco				=$linea[14];
		$T_Rq					=$linea[15];
		$Motv					=$linea[16];
		$Descripcion_Motivo		=$linea[17];
		$Cod_Cmts				=$linea[18];
		$Descrip_Cmts			=$linea[19];
		$Nodo					=$linea[20];
		$Plano					=$linea[21];
		$Troncal				=$linea[22];
		$Sector					=$linea[23];
		$Line_Ext				=$linea[24];
		$Tap					=$linea[25];
		$Borne					=$linea[26];
		$Numcoo_X				=$linea[27];
		$Numcoo_Y				=$linea[28];
		$Dist					=$linea[29];
		$Via					=$linea[30];
		$Direccion				=quitar_tildes($linea[31]);
		$Numero					=$linea[32];
		$INT					=$linea[33];
		$Piso					=$linea[34];
		$Mzn					=$linea[35];
		$Lote					=$linea[36];
		$Urb					=$linea[37];
		$Nombre_Urb				=quitar_tildes($linea[38]);
		$Referencia				=quitar_tildes($linea[39]);
		$Clase_Srv				=quitar_tildes($linea[40]);
		$Señal_de_la_Troba		=$linea[41];
		$_Cr					=$linea[42];
		$Premium				=$linea[43];
		$N_Cross				=$linea[44];
		$Categoria_Srv			=$linea[45];
		$Tlf					=$linea[46];
		
		if ($linea[46]!=""){
			$Fecha_Llegada=$linea[48];
			$Sit="";
		}else{
			$Fecha_Llegada=$linea[47];
			$Sit=$linea[48];
		}		
				
		$Edo					=$linea[49];
		$Motv_					=$linea[50];
		$Ofc_Adm				=trim($linea[51]);
		$F_Prg_MM				=$linea[52];
		$Prior					=$linea[53];
		$Observaciones			=$linea[54];
		$Autorizacion			=$linea[55];
		$Cod_Autorizacion		=$linea[56];
		$Contacto_Clte			=$linea[57];
		$Cliente_Conforme		=$linea[58];
		$Tel_Contacto_CCT		=$linea[59];
		$Tel_Contacto_REF_CCT	=$linea[60];
		$Mot_Autorizacion		=$linea[61];
		$DescMot_Autorizcion	=$linea[62];
		$Escenario_Autorizacion	=$linea[63];
		$Tecnico				=$linea[64];
		$Nombre_Tecnico			=$linea[65];
		$Fec_Autorizacion		=$linea[66];
		$Usu_Autorizacion		=$linea[67];
		$Encuesta				=$linea[68];
		$Contacto_Enc			=$linea[69];
		$Parentesco_Enc			=$linea[70];
		$Telefono_Enc			=$linea[71];
		$Incidencia				=$linea[72];
		$Ticket_Incidencia		=$linea[73];
		$Seg_Incidencia			=$linea[74];
		$Resegmentacion			=$linea[75];
		$Tipo_Paquete			=$linea[76];
		$N_OS					=$linea[77];
		$Estado_OS				=$linea[78];
		$Tipo_Linea				=$linea[79];
		$NroTlfVOIP				=$linea[80];
		$PromLinea				=$linea[81];
		$Descripcion_Prom_Linea	=$linea[82];
		$Tipo_Tecnologia		=$linea[83];
		$zon					=$linea[84];
		$zon1					=$linea[85];
		$est					=$linea[86];
		
		
	/*	
	echo "<br>".$col."|".$n_requer."|".$Area_Ant."|".$AREA."|".$Cliente."|".$VIP."|".$CORP."|".$Agendado."|".$En_Gaudi."|".$En_Gaudi."|".$PAI."|".$Nivel_Ubic."|".$Peticion."|".$MultiServicio."|".$Tipo_Deco."|".$T_Rq."|".$Motv."|".$Descripcion_Motivo."|".$Cod_Cmts."|".$Descrip_Cmts."|".$Nodo."|".$Plano."|".$Troncal."|".$Sector."|".$Line_Ext."|".$Tap."|".$Borne."|".$Numcoo_X."|".$Numcoo_Y."|dist".$Dist."|via".$Via."|dire".$Direccion."|".$Numero."|".$INT."|".$Piso."|".$Mzn."|".$Lote."|".$Urb."|".$Nombre_Urb."|".$Referencia."|".$Clase_Srv."|".$Señal_de_la_Troba."|".$_Cr."|".$Premium."|".$N_Cross."|".$Categoria_Srv."|".$Tlf."|".$Fecha_Llegada."|".$Sit."|".$Edo."|".$Motv_."|".$Ofc_Adm."|".$F_Prg_MM."|".$Prior."|".$Observaciones."|".$Autorizacion."|".$Cod_Autorizacion."|".$Contacto_Clte."|".$Cliente_Conforme."|".$Tel_Contacto_CCT."|".$Tel_Contacto_REF_CCT."|".$Mot_Autorizacion."|".$DescMot_Autorizcion."|".$Escenario_Autorizacion."|".$Tecnico."|".$Nombre_Tecnico."|".$Fec_Autorizacion."|".$Usu_Autorizacion."|".$Encuesta."|".$Contacto_Enc."|".$Parentesco_Enc."|".$Telefono_Enc."|".$Incidencia."|".$Ticket_Incidencia."|".$Seg_Incidencia."|".$Resegmentacion."|".$Tipo_Paquete."|".$N_OS."|".$Estado_OS."|".$Tipo_Linea."|".$NroTlfVOIP."|".$PromLinea."|".$Descripcion_Prom_Linea."|".$Tipo_Tecnologia."|".$zon."|".$zon1."|".$est."<br>";	
	
	*/
	
	
	$sql_0="INSERT INTO tb_cms(col,n_requer,Area_Ant,AREA_,Cliente,VIP,CORP,Agendado,En_Gaudi,Seg_Gaudi,PAI,
Nivel_Ubic,Peticion,MultiServicio,Tipo_Deco,T_Rq,Motv,Descripcion_Motivo,Cod_Cmts,Descrip_Cmts,Nodo,
Plano,Troncal,Sector,Line_Ext,Tap,Borne,Numcoo_X,Numcoo_Y,Dist,Via,Direccion,Numero,INT_,
Piso,Mzn,Lote,Urb,Nombre_Urb,Referencia,Clase_Srv,Senal_de_la_Troba,_Cr,Premium,N_Cross,Categoria_Srv,
Tlf,Fecha_Llegada,Sit,Edo,Motv_,Ofc_Adm,F_Prg_MM,Prior,Observaciones,Autorizacion,Cod_Autorizacion,Contacto_Clte,
Cliente_Conforme,Tel_Contacto_CCT,Tel_Contacto_REF_CCT,Mot_Autorizacion,DescMot_Autorizcion,Escenario_Autorizacion,
Tecnico, Nombre_Tecnico,Fec_Autorizacion,Usu_Autorizacion,Encuesta,Contacto_Enc,Parentesco_Enc,Telefono_Enc,Incidencia,
Ticket_Incidencia,Seg_Incidencia,Resegmentacion,Tipo_Paquete,N_OS,Estado_OS,Tipo_Linea,NroTlfVOIP,PromLinea,
Descripcion_Prom_Linea,Tipo_Tecnologia,zon,zon1,est,fec_carga) 
VALUES ('$col','$n_requer','$Area_Ant','$AREA','$Cliente','$VIP','$CORP','$Agendado','$En_Gaudi','$Seg_Gaudi','$PAI','$Nivel_Ubic','$Peticion','$MultiServicio','$Tipo_Deco','$T_Rq','$Motv','$Descripcion_Motivo','$Cod_Cmts','$Descrip_Cmts','$Nodo','$Plano','$Troncal','$Sector','$Line_Ext','$Tap','$Borne','$Numcoo_X','$Numcoo_Y','$Dist','$Via','$Direccion','$Numero','$INT','$Piso','$Mzn','$Lote','$Urb','$Nombre_Urb','$Referencia','$Clase_Srv','$Senal_de_la_Troba','$_Cr','$Premium','$N_Cross','$Categoria_Srv','$Tlf','$Fecha_Llegada','$Sit','$Edo','$Motv_','$Ofc_Adm','$F_Prg_MM','$Prior','$Observaciones','$Autorizacion','$Cod_Autorizacion','$Contacto_Clte','$Cliente_Conforme','$Tel_Contacto_CCT','$Tel_Contacto_REF_CCT','$Mot_Autorizacion','$DescMot_Autorizcion','$Escenario_Autorizacion','$Tecnico','$Nombre_Tecnico','$Fec_Autorizacion','$Usu_Autorizacion','$Encuesta','$Contacto_Enc','$Parentesco_Enc','$Telefono_Enc','$Incidencia','$Ticket_Incidencia','$Seg_Incidencia','$Resegmentacion','$Tipo_Paquete','$N_OS','$Estado_OS','$Tipo_Linea','$NroTlfVOIP','$PromLinea','$Descripcion_Prom_Linea','$Tipo_Tecnologia','$zon','$zon1','$est',now());";
		
		
			
		//echo "<br>".$sql_0."<br>";
		$res_0 = mysql_query($sql_0);
		
		}
		$row++;
	}
	fclose($fp);	

	
	
	$sql_1="DELETE FROM tb_cms WHERE n_requer in('','N',' ')";			
		//echo "<br>".$sql;
	$res_1 = mysql_query($sql_1) or die(mysql_error($sql_1));	
	
	/*
	$sql_2="UPDATE tb_cms_tmp a,  cab_asignaciones_cot b
	SET a.est=b.estado_asig 
	WHERE a.peticion=b.peticion";			
		//echo "<br>".$sql;
	$res_2 = mysql_query($sql_2) or die(mysql_error());	
	*/
	
	$sql_3="UPDATE tb_cms SET Ofc_Adm=trim(F_Prg_MM),Ofc_Adm=trim(Autorizacion)
			WHERE TRIM(Ofc_adm) NOT IN ('AMA','APU','ARE','AYA','CAJ','CHI','CTE','CUS','HCV',
			'HNC','HUA','ICA','LIM','LOR','MDD','MOQ','PAS','PIU','PUN',
			'PUN','SMT','TAC','TRU','TUM','UCA')";
		//echo "<BR>".$sql_3;
	$res_3 = mysql_query($sql_3) or die(mysql_error($sql_3));
	
	
	$sql_4="UPDATE tb_cms SET zon=ofc_adm";
	$res_sql_4= mysql_query($sql_4) or die(mysql_error($sql_4));
	
	$sql_5="UPDATE tb_cms SET zon=zon1 WHERE zon1<>''";
	$res_sql_5= mysql_query($sql_5) or die(mysql_error($sql_5));	
		
	$sql_6="INSERT IGNORE INTO tb_cms_total
	SELECT * FROM tb_cms";			
	//echo "<br>".$sql;
	$res_6 = mysql_query($sql_6) or die(mysql_error($sql_6));
	
	$sql_6a ="delete from carga_pedidos_total where origen='cms'";
		//echo "<BR>".$sql_14;
	$res_sql_6a = mysql_query($sql_6a) or die(mysql_error($sql_6a));
	
	$sql_7="INSERT ignore into carga_pedidos_total
		(SELECT n_requer,peticion,cliente,CONCAT(via,',',TRIM(direccion),urb,',',nombre_urb,'-',referencia)
		 AS  direccion,CONCAT(SUBSTR(fecha_llegada,7,4),'-',
		 SUBSTR(fecha_llegada,4,2),'-',SUBSTR(fecha_llegada,1,2),' ',
		 SUBSTR(fecha_llegada,12,5)) AS fec,'CMS','0',trim(zon)
		FROM tb_cms order by 4)";
		//echo "<BR>".$sql_14;
	$res_sql_7 = mysql_query($sql_7) or die(mysql_error($sql_7));
	
	$sql_8="UPDATE carga_pedidos_total a, cab_asignaciones_cot b
		SET a.estado=b.estado_asig 
		WHERE a.peticion=b.peticion";
		//echo "<BR>".$sql_3;
	$res_sql_8 = mysql_query($sql_8) or die(mysql_error($sql_8));
	
	
	}

function borrar_enprocesos(){
	$hoy = date("Y-m-d");
	
	$sql_1="delete FROM cab_asignaciones_cot WHERE SUBSTR(fec_reg_web,1,10)!='$hoy' AND estado_asig='1'";
		//echo "<BR>".$sql_3;
	$res_sql_1 = mysql_query($sql_1) or die(mysql_error($sql_1));
	
	$paso_2		= "DELETE FROM cab_asignaciones_cot WHERE estado_asig='1' 
	AND SEC_TO_TIME((TIMESTAMPDIFF(HOUR ,fec_reg_web,NOW()))*60)='00:02:00'";
	//echo  "<p>".$ssx1;
	$res_paso_2	= mysql_query($paso_2);
	
	}


function carga_tabla_GESTEL_47D($fileName,$zon){	
		
	$gestel_47D = fopen($fileName, "r");		
		
	while (!feof($gestel_47D) ) {
				//$linea = fread($gestel_47D,8192);
				$linea  = fgets($gestel_47D);	
						
				$row=$row+1;		
				//echo $linea;
				if ($zon=="LIM"){
					$lin=13;	
				}else{
					$lin=14;
				}
				
				if ($row > $lin){
				$fecha = trim(substr($linea, 2, 18));
				if($fecha==""){$fecha='X';}else{$fecha=$fecha;}
				
				$Comprob = trim(substr($linea, 20, 10));
				if($Comprob==""){$Comprob='X';}else{$Comprob=$Comprob;}
				
				$Inscripcion = trim(substr($linea, 30, 10));
				if($Inscripcion==""){$Inscripcion='X';}else{$Inscripcion=$Inscripcion;}
				
				$Solicitud = trim(substr($linea, 40, 10));
				if($Solicitud==""){$Solicitud='X';}else{$Solicitud=$Solicitud;}
				
				$Usuario = trim(substr($linea, 50, 10));
				if($Usuario==""){$Usuario='X';}else{$Usuario=$Usuario;}
				
				$CodSol = trim(substr($linea, 60, 8));
				if($CodSol==""){$CodSol='X';}else{$CodSol=$CodSol;}
				
				$Motivo = trim(substr($linea, 69, 30));
				if($Motivo==""){$Motivo='X';}else{$Motivo=$Motivo;}
				
				$Pedido = trim(substr($linea, 88, 10));
				if($Pedido==""){$Pedido='X';}else{$Pedido=$Pedido;}
				
				$Red = trim(substr($linea, 98, 15));
				if($Red==""){$Red='X';}else{$Red=$Red;}
				
				$MDFo = trim(substr($linea, 114, 5));
				if($MDFo==""){$MDFo='X';}else{$MDFo=$MDFo;}
				
				$Cabl = trim(substr($linea, 120, 5));
				if($Cabl==""){$Cabl='X';}else{$Cabl=$Cabl;}
				
				$PAli = trim(substr($linea, 126, 5));
				if($PAli==""){$PAli='X';}else{$PAli=$PAli;}
				
				$Armar = trim(substr($linea, 131, 5));
				if($Armar==""){$Armar='X';}else{$Armar=$Armar;}
				
				$Bloq = trim(substr($linea, 136, 5));
				if($Bloq==""){$Bloq='X';}else{$Bloq=$Bloq;}
				
				$PDis = trim(substr($linea, 141, 5));
				if($PDis==""){$PDis='X';}else{$PDis=$PDis;}
				
				$Caja = trim(substr($linea, 146, 5));
				if($Caja==""){$Caja='X';}else{$Caja=$Caja;}
				
				$Born = trim(substr($linea, 151, 5));
				if($Born==""){$Born='X';}else{$Born=$Born;}
				
				$MDFd = trim(substr($linea, 156, 5));
				if($MDFd==""){$MDFd='X';}else{$MDFd=$MDFd;}
				
				$Cabld = trim(substr($linea, 161, 8));
				if($Cabld==""){$Cabld='X';}else{$Cabld=$Cabld;}
				
				$PAlid = trim(substr($linea, 169, 5));
				if($PAlid==""){$PAlid='X';}else{$PAlid=$PAlid;}
				
				$Armard = trim(substr($linea, 173, 5));
				if($Armard==""){$Armard='X';}else{$Armard=$Armard;}
				
				$Bloqd = trim(substr($linea, 178, 6));
				if($Bloqd==""){$Bloqd='X';}else{$Bloqd=$Bloqd;}
				
				$PDisd = trim(substr($linea, 184, 5));
				if($PDisd==""){$PDisd='X';}else{$PDisd=$PDisd;}
				
				$Cajad = trim(substr($linea, 189, 5));
				if($Cajad==""){$Cajad='X';}else{$Cajad=$Cajad;}
				
				$Bornd = trim(substr($linea, 195, 5));
				if($Bornd==""){$Bornd='X';}else{$Bornd=$Bornd;}
				
				$Telefono = trim(substr($linea, 200, 8));
				if($Telefono==""){$Telefono='X';}else{$Telefono=$Telefono;}
				
				$Sect = trim(substr($linea, 208, 6));
				if($Sect==""){$Sect='X';}else{$Sect=$Sect;}
				
				$Manz = trim(substr($linea, 214, 6));
				if($Manz==""){$Manz='X';}else{$Manz=$Manz;}
				
				$Peticion = trim(substr($linea, 220, 10));
				if($Peticion==""){$Peticion='X';}else{$Peticion=$Peticion;}
				
				$Agrupacion = trim(substr($linea, 240, 2));
				if($Agrupacion==""){$Agrupacion='X';}else{$Agrupacion=$Agrupacion;}
				
				$Cliente = trim(substr($linea, 243, 12));
				if($Cliente==""){$Cliente='X';}else{$Cliente=$Cliente;}
				
				$Cuenta = trim(substr($linea, 257, 10));
				if($Cuenta==""){$Cuenta='X';}else{$Cuenta=$Cuenta;}
				
				$PC = trim(substr($linea, 270, 10));
				if($PC==""){$PC='X';}else{$PC=$PC;}
				
				/*
				echo "<P>".$row."|".$fecha."|".$Comprob."|".$Inscripcion."|".$Solicitud."|".$Usuario."|".$CodSol."|".$Motivo."|".$Pedido."|".$Red."|".$MDFo."|".$Cabl."|".$PAli."|"
				.$Armar."|".$Bloq."|".$PDis."|".$Caja."|".$Born."|".$MDFd."|".$Cabld."|".$PAlid."|".$Armard."|".$Bloqd."|".$PDisd."|".$Cajad."|".$Bornd
				."|".$Telefono."|".$Sect."|".$Manz."|".$Peticion."|".$Agrupacion."|".$Cliente."|".$Cuenta."|".$PC."|".$v."|".$v;
				
				*/
				
				
				
				
				$sql_1="INSERT ignore INTO gestel_47d 
				(Fecha,Comprob_,Inscripcion,Solicitud,Usuario,Cod_Sol,Motivo,Pedido,Red,MDF,Cabl ,PAli ,Armar ,Bloq ,PDis ,Caja ,Born ,MDFd,Cabld ,PAlid ,Armard 
				,Bloqd ,PDisd ,Cajad ,Bornd ,Telefono ,Sect ,Manz,Peticion ,Agrupacion ,Cliente,Cuenta,PC,Tipo_Circuito1,N_Circuito1,Tipo_Circuito2,N_Circuito2,
				Segmento,origen,fec_carga,n_area) 
					VALUES ('$fecha','$Comprob','$Inscripcion','$Solicitud','$Usuario','$CodSol','$Motivo','$Pedido','$Red','$MDFo','$Cabl',
					'$PAli','$Armar','$Bloq','$PDis','$Caja','$Born','$MDFd','$Cabld','$PAlid','$Armard','$Bloqd','$PDisd','$Cajad','$Bornd',
					'$Telefono','$Sect','$Manz','$Peticion','$Agrupacion','$Cliente','$Cuenta','','','','','','','$zon',now(),'')";
					
				//echo "<P>".$sql_1;
				$res_1 = mysql_query($sql_1) or die(mysql_error());
				}
				
				if ($ciudad=="X"){
					unset($cont[$row]); 
					
				}
		}
	
	fclose($gestel_47D);				
		
	$sql_2="DELETE FROM gestel_47d WHERE SUBSTR(fecha,1,1) IN ('','-','f','t','x','s')";		
		//echo "<P>".$sql;
	$res_2 = mysql_query($sql_2) or die(mysql_error());	
		
	/*$
	sql_3="DELETE FROM gestel_47d WHERE SUBSTR(fecha,1,4)!='2018'";		
		//echo "<P>".$sql;
	$res_3 = mysql_query($sql_3) or die(mysql_error());	
	*/
	$sql_4="INSERT ignore INTO gestel_47d_total
			SELECT * FROM gestel_47d GROUP BY Comprob_";		
		//echo "<P>".$sql;
	$res_4 = mysql_query($sql_4) or die(mysql_error());	
	
	
	
}


/**************************************************/

function blanquear_tablas_contactos($tabla){
	echo "<br>1.- PROCESO BLANQUEADO DE TABLAS EJECUTANDOSE";
	mysql_query("truncate table $tabla") ;	
}

function llenar_tablas_contactos($fileName,$tabla){
	
		//echo $fileName.",".$tabla;
	
		$link = mysql_connect("localhost", "root", "") ;
		$db = mysql_select_db("cot", $link) ; 
		
		$row=1;		
		echo "<br>1.- PROCESO LLENADO DE TABLAS EJECUTANDOSE INICIADO ";
		//$fileName = "d:/Macros/Gestel423/base_contact_dic2017.csv";
		
		$fec=date("mY");		
		
		$fp = fopen($fileName, "r");
		
		while (!feof($fp) ) 
		{	//$linea = fread($fp,8192);
			
			$linea  = fgets($fp);	
			//echo "<br>".$linea;
			
			$col= explode("|",$linea);
			
			
			if ($col[1]=="En"){
				$cliente ="";
			}else{
				$cliente = $col[4]." ".$col[5]." ".$col[6];
			}
			
			$ob			= "BASE DE DATOS CMR(B.I) CARGADA";
			$hoy 		= date("Y-m-d");			
			
			
			
			$sql_1		= "INSERT INTO $tabla 			
			(pedido,campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10,campo11) 
			VALUES
			('$col[0]','$col[1]','$col[2]','$col[3]','$col[4]','$col[5]','$col[6]','$cliente',
			'$col[8]','$ob','$hoy','REGISTRADO');";
				
			//echo "<br>".$sql_1;
			$res_1 = mysql_query($sql_1, $link) or die(mysql_error());	
		
		}	
		fclose($fp);	
		echo "<br>2.- PROCESO LLENADO DE TABLAS EJECUTANDOSE TERMINADO";
}

function cruces_tabla_contactos($tabla){
	
	echo "<br>3.- PROCESO DE CARGA DE CRUCES EJECUTANDOSE";		
	
	$link = mysql_connect("localhost", "root", "") ;
	$db = mysql_select_db("cot", $link) ; 	
	
	
	$sql_2		= "INSERT INTO bitacora_cargas_contactos
				SELECT '',curdate(),COUNT(*),'156' FROM tb_contactos_actual LIMIT 1";		
	//echo "<br>".$sql;
	$res_2 = mysql_query($sql_2, $link) or die(mysql_error($sql_2));
	
	$sql_3		= "UPDATE $tabla
				SET campo2=LPAD(campo2,8,'0')
				WHERE LENGTH(campo2)<9";		
	//echo "<br>".$sql;
	$res_3 = mysql_query($sql_3, $link) or die(mysql_error($sql_3));
	
	$sql_4		= "delete from $tabla where campo2=''";		
	//echo "<br>".$sql;
	$res_4 = mysql_query($sql_4, $link) or die(mysql_error($sql_4));
	
	$sql_5		= "UPDATE $tabla SET campo6='' WHERE campo6 REGEXP '[0-9]+$'";		
	//echo "<br>".$sql;
	$res_5 = mysql_query($sql_5, $link) or die(mysql_error($sql_5));
		
	$sql_6		= "UPDATE $tabla SET campo4='S/I', campo5='S/I', campo6='S/I', campo7='S/I' WHERE campo7=' ,'";		
	//echo "<br>".$sql;
	$res_6 = mysql_query($sql_6, $link) or die(mysql_error($sql_6));
		
	
	/*
	$sql_6		= "UPDATE tb_contactos_prueba a, tb_contactos_actual b
				SET a.campo11=b.campo11
				WHERE a.campo2=b.campo2 AND a.campo3=b.campo3";		
	//echo "<br>".$sql;
	$res_6 = mysql_query($sql_6, $link) or die(mysql_error($sql_6));
		*/
}

function transpasar_tabla(){
	$link = mysql_connect("localhost", "root", "") ;
	$db = mysql_select_db("cot", $link) ; 	
	
	$sql_1		= "CREATE TABLE tb_contactos_actual_0619
	(SELECT '' AS item,'' AS pedido,campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10,campo11
	FROM tb_contactos_actual GROUP BY campo2,campo3)";		
	//echo "<br>".$sql_1;
	$res_1 = mysql_query($sql_1, $link) or die(mysql_error($sql_1));
	
}

function llenar_tablas_contactos_txt($fileName,$tabla){
	echo "<br>"."Llenando tablas";
	
	$link = mysql_connect("localhost", "root", "") ;
	$db = mysql_select_db("cot", $link) ; 
	
	mysql_query("truncate table $tabla") ;	
	
	$qry = "LOAD DATA INFILE '$fileName'
	INTO TABLE $tabla
	FIELDS TERMINATED BY '|'
	LINES TERMINATED BY '\n' 
	IGNORE 1 LINES 
	(pedido,campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10,campo11)"; 	
	//echo "<br>".$qry;
	
	$res = mysql_query($qry, $link) or die(mysql_error());
	
	}
?>