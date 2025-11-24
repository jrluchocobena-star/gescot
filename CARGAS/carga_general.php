<?

include("//conexion_bd.php");
//include("../funciones_fecha.php");

set_time_limit(5000);

$sw=1;

		//exec("D:\MACROS\Gestel423\Descarga423Gestel.EBX", $resultado); // Ejecutar el archivo EBC (GESTEL).
		
		
		//$local_file = 'd:/data_cot/Gestel423/glpl494.txt'; //Nombre archivo en nuestro PC
		$dia=date('Y-m-d');
		$local_file = "d:/data_cot/Gestel423/glpl494_".$dia.".txt"; //Nombre archivo en nuestro PC		
		$server_file = '/home/geslis/lcobena0/glpl494.txt'; //Nombre archivo en FTP
		
		// Establecer la conexión
		$ftp_server='10.4.3.220';
		$ftp_user_name='lcobena0';
		$ftp_user_pass='gestel032018';
		$conn_id = ftp_connect($ftp_server);
		
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
		
		$ini=date("Y-m-d H:m");
		archivo_log($ini,'USER_WIN','CARGA GESTEL 423','0.PROCESO DEL FTP....OK');
		
		
	mysql_query("truncate table tb_cms") ; 
	mysql_query("truncate table tb_gestel_423") ;
	mysql_query("truncate table carga_pedidos_total") ;		
	mysql_query("truncate table tb_gestel_423_prov") ;	
		
	/*****************************************************************************************************/
	
		
	$tabla = "tb_gestel_423";
	$ini2=date("Y-m-d H:m");
	$dia=date('Y-m-d');
	
	$row=1;
	
	$fileName = "d:/data_cot/Gestel423/glpl494_".$dia.".txt";
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
			AGRUPACION,CLIENTE,CUENTA,PC,NEGOCIO,PREFIJO,SEGMENTO,CANTIDAD,SUB_SEGMENTO,IRIS,DIRECCION_ANTIGUA,SECTOR,MANZANA,COORD_X,COORD_Y,opc,fec_carga) 
			VALUES ('$ciudad','$pedido','$insc','$dire','$distrito','$promocion','$grupo','$nref','$fec_reg','$tp_serv','$priori','$oficom',
			'$peticion','$agrupacion','$cliente','$cuenta','$pc','$negocio','$prefijo','$segmento','$cantidad','$subseg','$iris','$dir_ant','$sector',
			'$manz','$coorX','$coorY','0',now());";
			
		//echo "<br>".$sql;
		$res_1 = mysql_query($sql_1) or die(mysql_error());
		
		$sql_2="delete from $tabla where negocio='CEE'";
		$res_2 = mysql_query($sql_2) or die(mysql_error());			
		
		$sql_3="delete from $tabla where pedido in ('X','----------','PEDIDO','NICA')";		
		//echo "<br>".$sql;	
		$res_3 = mysql_query($sql_3) or die(mysql_error());			
		}
		$row++;
		
		if ($ciudad=="X"){
			unset($cont[$row]); 
			
		}
		
					
	}
	
	fclose($fp);	
	
		$sql_4="INSERT INTO tb_gestel_423_prov
		(SELECT *,'ARE' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('50','51','52','53','54','55','56','57','58'))";
		$res_4 = mysql_query($sql_4) or die(mysql_error());	
		
		$sql_5="INSERT INTO tb_gestel_423_prov
		(SELECT *,'CHY' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('01','05'))";
		$res_5 = mysql_query($sql_5) or die(mysql_error());	
		
		$sql_6="INSERT INTO tb_gestel_423_prov
		(SELECT *,'CHB' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('13','04','09'))";
		$res_6 = mysql_query($sql_6) or die(mysql_error());	
		
		$sql_7="INSERT INTO tb_gestel_423_prov
(SELECT *,'HYO' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('10','12','14'))
UNION(SELECT *,'HYO' FROM tb_gestel_423 WHERE CIUDAD IN ('1007','1208','01081','01084','11001','11036','11038','11039'))";
		$res_7 = mysql_query($sql_7) or die(mysql_error());	
		
		$sql_8="INSERT INTO tb_gestel_423_prov
(SELECT *,'CUZ' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('53','54'))UNION(SELECT *,'HYO' FROM tb_gestel_423 WHERE CIUDAD IN ('57050'))";
		$res_8 = mysql_query($sql_8) or die(mysql_error());	

		$sql_9="INSERT INTO tb_gestel_423_prov
(SELECT *,'ICA' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('03'))UNION(SELECT *,'HYO' FROM tb_gestel_423 WHERE CIUDAD IN ('12007','12019','12205','12337','12339','12469'))";
		$res_9 = mysql_query($sql_9) or die(mysql_error());	
		
		$sql_10="INSERT INTO tb_gestel_423_prov
(SELECT *,'IQU' FROM tb_gestel_423 WHERE ciudad IN ('11037','01001','01078','01095','01096'))";
		$res_10 = mysql_query($sql_10) or die(mysql_error());	
		
		$sql_11="INSERT INTO tb_gestel_423_prov
(SELECT *,'PIU' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('02','07'))";
		$res_11= mysql_query($sql_11) or die(mysql_error());	

		$sql_12="INSERT INTO tb_gestel_423_prov
(SELECT *,'TRU' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('15','51','60','80','81'))";
		$res_12 = mysql_query($sql_12) or die(mysql_error());
		
		
		/**********************************************/
		/*
		$sql_4="update tb_gestel_423_total set zonal='ARE' WHERE SUBSTR(ciudad,1,2)IN ('50','51','52','53','54','55','56','57','58'))";
		$res_4 = mysql_query($sql_4) or die(mysql_error());	
		
		$sql_5="update tb_gestel_423_total set zonal='CHY'  WHERE SUBSTR(ciudad,1,2)IN ('01','05'))";
		$res_5 = mysql_query($sql_5) or die(mysql_error());	
		
		$sql_6="update tb_gestel_423_total set zonal='CHB'  WHERE SUBSTR(ciudad,1,2)IN ('13','04','09'))";
		$res_6 = mysql_query($sql_6) or die(mysql_error());	
		
		$sql_7="INSERT INTO tb_gestel_423_total
(SELECT *,'HYO' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('10','12','14'))
UNION(SELECT *,'HYO' FROM tb_gestel_423 WHERE CIUDAD IN ('1007','1208','01081','01084','11001','11036','11038','11039'))";
		$res_7 = mysql_query($sql_7) or die(mysql_error());	
		
		$sql_8="INSERT INTO tb_gestel_423_total
(SELECT *,'CUZ' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('53','54'))UNION(SELECT *,'HYO' FROM tb_gestel_423 WHERE CIUDAD IN ('57050'))";
		$res_8 = mysql_query($sql_8) or die(mysql_error());	

		$sql_9="INSERT INTO tb_gestel_423_total
(SELECT *,'ICA' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('03'))UNION(SELECT *,'HYO' FROM tb_gestel_423 WHERE CIUDAD IN ('12007','12019','12205','12337','12339','12469'))";
		$res_9 = mysql_query($sql_9) or die(mysql_error());	
		
		$sql_10="INSERT INTO tb_gestel_423_total
(SELECT *,'IQU' FROM tb_gestel_423 WHERE ciudad IN ('11037','01001','01078','01095','01096'))";
		$res_10 = mysql_query($sql_10) or die(mysql_error());	
		
		$sql_11="INSERT INTO tb_gestel_423_prov
(SELECT *,'PIU' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('02','07'))";
		$res_11= mysql_query($sql_11) or die(mysql_error());	

		$sql_12="INSERT INTO tb_gestel_423_prov
(SELECT *,'TRU' FROM tb_gestel_423 WHERE SUBSTR(ciudad,1,2)IN ('15','51','60','80','81'))";
		$res_12 = mysql_query($sql_12) or die(mysql_error());
		
		*/
		/***********************************************/
		
		
		
		$sql_13="INSERT INTO tb_gestel_423_total
		SELECT * FROM $tabla";			
		//echo "<br>".$sql;
		$res_13 = mysql_query($sql_13) or die(mysql_error());
		
		archivo_log($ini2,'USER_WIN','CARGA GESTEL 423','2.CARGA DATA DE ARCHIVOS TXT A SERVIDOR.....OK');		
		
		
		$sql_14="INSERT INTO carga_pedidos_total
		(SELECT peticion,pedido,inscripcion,direccion,CONCAT('20',SUBSTR(fecha_reg,7,2),'-',SUBSTR(fecha_reg,4,2),'-',SUBSTR(fecha_reg,1,2),' ',SUBSTR(fecha_reg,10,5)),'GESTEL-423','0','' FROM $tabla where SUBSTR(fec_carga,1,10)=DATE(NOW()))
		UNION(
		SELECT n_requer,peticion,cliente,CONCAT(via,',',TRIM(direccion),urb,',',nombre_urb,'-',referencia) AS direccion,CONCAT(SUBSTR(fecha_llegada,7,4),'-',SUBSTR(fecha_llegada,4,2),'-',SUBSTR(fecha_llegada,1,2),' ',SUBSTR(fecha_llegada,12,5)) AS fec,'CMS','0','' 
		FROM tb_cms)";
		//echo "<BR>".$sql_14;
		$res_sql_14 = mysql_query($sql_14) or die(mysql_error());	
		
		$sql_15="UPDATE carga_pedidos_total a, cab_asignaciones_cot b
		SET estado='3' 
		WHERE a.pedido=b.pedido";
		//echo "<BR>".$sql_3;
		$res_sql_15 = mysql_query($sql_15) or die(mysql_error());	
		
		$sql_16="UPDATE carga_pedidos_total a,  tb_gestel_423_prov b
		SET a.zonal=b.zonal
		WHERE a.pedido=b.pedido";
		//echo "<BR>".$sql_3;
		$res_sql_16 = mysql_query($sql_16) or die(mysql_error());	
		
		
		$sql_17="UPDATE carga_pedidos_total SET zonal='LIM' WHERE zonal=''";
		//echo "<BR>".$sql_3;
		$res_sql_17 = mysql_query($sql_17) or die(mysql_error());	
		
		archivo_log($ini3,'USER_WIN','CARGA GESTEL 423','3.CONSOLIDADO DE TABLAS....OK');

?>