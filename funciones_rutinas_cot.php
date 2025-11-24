<? 
include("conexion_bd.php");
include("funciones_fechas.php");

function buscar_archivo(){
	$mes = date("mY");
	$archivo = "Horarios_".$mes.".csv";
	$ruta="\\\\10.226.5.114\\FS-Principal\\Dir_Marketing\\Ger_Consumo_de_Terminales_y_Banda_Ancha\\Jefatura_de_Terminales\\000Cot\\zz_InputsExternos\\HorariosCot\\";
	//echo $ruta."<br>";
	$completo = $ruta.$archivo;
	
	if (!file_exists ($completo)){
		$msn="El archivo $archivo "."NO SE ENCONTRO";
	}else{
		$msn="El archivo $archivo "."SI SE ENCONTRO";
	}
	
	
	
	echo "<tr><td>$msn</td></tr>";
}
	
	

function rutinas_maestra(){
	$xmes = date("Y-m");
	
	$rutina_8	= "UPDATE tb_usuarios SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10";
	$result_8 	= mysql_query($rutina_8) or die(mysql_error($rutina_8));
	
	$rutina_9	= "UPDATE tb_usuarios SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9";
	$result_9 	= mysql_query($rutina_9) or die(mysql_error($rutina_9));
	
	$rutina_1	= "UPDATE movimiento_contactos a, tb_usuarios b 
				   SET a.usu_mov=b.iduser 
				   WHERE SUBSTR(a.pc_sis,1,8)=b.pc AND a.usu_mov in ('undefined','')";
	$result_1 	= mysql_query($rutina_1) or die(mysql_error($rutina_1));
	
	$rutina_2	= "UPDATE movimiento_contactos a, tb_usuarios b 
				   SET a.pc_asig=b.pc 
				   WHERE a.usu_mov=b.iduser AND a.pc_asig=''";
	$result_2 	= mysql_query($rutina_2) or die(mysql_error($rutina_2));
	
	//DESACTIVA LOS QUE ESTAN DE BAJA EN LA MAESTRA
	$rutina_5a	= "UPDATE movimientos_maestra a, tb_usuarios b
	SET a.est=b.estado
	WHERE a.dni=b.dni AND b.estado='DESHABILITADO'";
	$result_5a 	= mysql_query($rutina_5a) or die(mysql_error($rutina_5a));
	
	$rutina_5b	= "UPDATE movimientos_maestra SET est='DESACTIVADO' WHERE est='DESHABILITADO'";
	$result_5b 	= mysql_query($rutina_5b) or die(mysql_error($rutina_5b));
	
	
	$rutina_5c	= "UPDATE movimientos_maestra SET  dato=LTRIM(dato),dato=RTRIM(dato),dato=TRIM(dato)";
	$result_5c 	= mysql_query($rutina_5c) or die(mysql_error($rutina_5c));	
	
	
	$rutina_7	= "UPDATE tb_usuarios SET 
	grupo=TRIM(grupo),sgrupo=TRIM(sgrupo),dni=TRIM(dni),cip=TRIM(cip),ola=TRIM(ola),
	c_supervisor=TRIM(c_supervisor),c_monitor=TRIM(c_monitor),LOCAL=TRIM(LOCAL),
	login=TRIM(login),pass=TRIM(pass)";
	$result_7 	= mysql_query($rutina_7) or die(mysql_error($rutina_7));
	
	
	$rutina_8	= "UPDATE movimientos_maestra SET dni=TRIM(dni),dato=TRIM(dato),aplicativo=TRIM(aplicativo)";
	$result_8 	= mysql_query($rutina_8) or die(mysql_error($rutina_8));
	
	
	$rutina_9	= "UPDATE movimientos_maestra SET dato = REPLACE(dato, '?', '')";
	$result_9 	= mysql_query($rutina_9) or die(mysql_error($rutina_9));
	
	
	$rutina_10	= "UPDATE tb_usuarios SET ncompleto = REPLACE(ncompleto, '?', 'Ñ')";
	$result_10 	= mysql_query($rutina_10) or die(mysql_error($rutina_10));
	
	$rutina_11	= "UPDATE tb_usuarios SET ncompleto = REPLACE(ncompleto, 'Ã\'', 'Ñ')";
	$result_11 	= mysql_query($rutina_11) or die(mysql_error($rutina_11));	
	
	
	$rutina_12	= "TRUNCATE TABLE consultas_gescot";
	$result_12	= mysql_query($rutina_12) or die(mysql_error($rutina_12));

	$rutina_13	= "INSERT INTO consultas_gescot
	(SELECT NOW() as fec_carga,b.dni AS DNI,b.cip AS CIP,b.ncompleto AS GESTOR,'' AS SUPERVISOR, 
	SUBSTR(fec_mov,1,10) AS DIA,COUNT(*) AS cantidad
	FROM movimiento_contactos a, tb_usuarios b
	WHERE a.usu_mov=b.iduser AND SUBSTR(fec_mov,1,7)='$xmes'
	GROUP BY 2,6
	ORDER BY 4,6)";
	$result_13	= mysql_query($rutina_13) or die(mysql_error($rutina_13));
	
	$rutina_14	= "UPDATE consultas_gescot a, tb_usuarios b,tb_supervisores c
	SET a.supervisor=c.nom_supervisor
	WHERE a.dni=b.dni AND b.c_supervisor=c.cod_supervisor";
	$result_14	= mysql_query($rutina_14) or die(mysql_error($rutina_14));
	
	$rutina_15	= "UPDATE movimientos_maestra SET est='CREADO' WHERE est='ACTIVO'";
	$result_15	= mysql_query($rutina_15) or die(mysql_error($rutina_15));
	
	$rutina_16	= "UPDATE movimientos_maestra SET est='NO CREADO' WHERE dato='-'";
	$result_16	= mysql_query($rutina_14) or die(mysql_error($rutina_16));
	
	$rutina_17	= "UPDATE historico_usuarios_maestra SET est='DESACTIVADO'";
	$result_17	= mysql_query($rutina_17) or die(mysql_error($rutina_17));
			
}

function rutinas_incidencias(){

	$xmes = date("Y-m");
	
	$rutina_inc0	= "UPDATE cab_incidencia SET dias=DATEDIFF (fec_fin_inc,fec_ini_inc) + 1 
				  WHERE modo='D' and dias=0";
	$result_inc0	= mysql_query($rutina_inc0) or die(mysql_error($rutina_inc0));
	
	
	$rutina_inc1	= "UPDATE cab_incidencia SET obs_incidencia=TRIM(obs_incidencia),cip=trim(cip),dni=trim(dni)";
	$result_rutina_inc1	= mysql_query($rutina_inc1) or die(mysql_error($rutina_inc1));
	
	
	$rutina_inc2	= " UPDATE cab_incidencia a, tb_usuarios b
	SET a.cip=b.cip
	WHERE a.dni=b.dni AND a.cip=''";
	$result_rutina_inc2	= mysql_query($rutina_inc2) or die(mysql_error($rutina_inc2));
	
	
	$rutina_inc3	= "UPDATE tb_usuarios a, cab_incidencia b
	SET a.m_blanca='MARCHA BLANCA'
	WHERE a.dni=b.dni AND a.estado='HABILITADO' AND a.grupo='COT-TDP' AND b.motivo_incidencia='800' 
	AND '$xmes' BETWEEN SUBSTR(b.fec_ini_inc,1,7) AND SUBSTR(b.fec_fin_inc,1,7)";
	$rutina_rutina_inc3	= mysql_query($rutina_inc3) or die(mysql_error($rutina_inc3));
	
	$rutina_inc4	= "UPDATE cab_incidencia a, tb_usuarios b
	SET estado_inc='4'
	WHERE a.dni=b.dni AND b.estado='DESHABILITADO'";
	$result_rutina_inc4	= mysql_query($rutina_inc4) or die(mysql_error($rutina_inc4));
	
		
	$rutina_inc5	= "UPDATE cab_incidencia SET obs_incidencia=TRIM(obs_incidencia),cip=trim(cip),dni=trim(dni)";
	$result_rutina_inc5	= mysql_query($rutina_inc5) or die(mysql_error($rutina_inc5));
	
	
	$rutina_inc6	= "UPDATE cab_capacitacion 
	SET cod_incidencia=CONCAT('CAP-',TRIM(SUBSTR(cod_incidencia,5,20))) 
	WHERE SUBSTR(cod_incidencia,1,3)='inc'";
	$result_rutina_inc6	= mysql_query($rutina_inc6) or die(mysql_error($rutina_inc6));
	
	
	$rutina_inc7	= "UPDATE cab_incidencia SET 
	obs_incidencia=REPLACE(obs_incidencia, '#', ''),
	obs_incidencia=REPLACE(obs_incidencia, '/', ''),
	obs_incidencia=REPLACE(obs_incidencia, '\\', ''),
	obs_incidencia=REPLACE(obs_incidencia, ',', '')";
	$result_rutina_inc7= mysql_query($rutina_inc7);
	
	$rutina_inc8	= "UPDATE cab_incidencia SET tiempo='06:00:00' WHERE modo='d' AND dias='1' 
	AND SUBSTR(fec_reg,1,7)='$xmes'";
	$result_inc8	= mysql_query($rutina_inc8) or die(mysql_error($rutina_inc8));
}


function rutinas_horarios(){
	
	$xmes = date("mY");
	
	$archivo_horario = 'L:\\\zz_InputsExternos\\\HorariosCot\\\horarios_'.$xmes.".csv";
	
	
	//$archivo_horario = 'L:///zz_InputsExternos///HorariosCot///horarios_'.$xmes.".csv";
	
			
			$sql_H0="truncate table horario_cot_mes ";		
			$res_sql_H0 = mysql_query($sql_H0);
			
			$sql_H1="LOAD DATA LOCAL INFILE '$archivo_horario'
			INTO TABLE horario_cot_mes
			FIELDS TERMINATED BY ','
			LINES TERMINATED BY '\r\n' IGNORE 1 LINES";	
			
			//echo $sql_H1;
			
			$res_sql_H1 = mysql_query($sql_H1) or die(mysql_error());
			
			/***********************/
			$sql_H1a="select * from horario_cot_mes";	
			//echo "<p>".$sql_H1;
			$res_sql_H1a = mysql_query($sql_H1a);
			$nreg_sql_H1a = mysql_num_rows($res_sql_H1a);
			
			//echo $nreg_sql_H1a;
			
			if ($nreg_sql_H1a<1){
				print "  3.1. Error: Problemas en la carga de Horario - 0 registros cargados". "\n";	
				exit;	
			}else{
				print "  3.1. Carga de Horarios COT Ok - Se cargaron $nreg_sql_H1a registros". "\n";
			}
			
			print "  3.2. Procesando Marcas Horarios". "\n";
				
			/***********************/
			
			$sql_H1B="UPDATE horario_cot_mes SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10";	
			//echo "<p>".$sql_H1;
			$res_sql_H1B = mysql_query($sql_H1B);
			
			
			
			$xmes_x=date("Y-m");
			
			$sql_H1C="UPDATE horario_cot_mes SET Mes='$xmes_x', f_carga=now()";	
			//echo "<p>".$sql_H1C;
			$res_sql_H1C = mysql_query($sql_H1C);
			
			
			
			$sql_H1D="UPDATE horario_cot_mes SET cod_horario=CONCAT('0',cod_horario) WHERE LENGTH(cod_horario)=3";	
			//echo "<p>".$sql_H1C;
			$res_sql_H1D = mysql_query($sql_H1D);
			
			
			$sql_H2	= "UPDATE horario_cot_mes a, tb_usuarios b
			SET a.dni=b.dni
			WHERE a.cip=b.cip";
			$result_sql_H2= mysql_query($sql_H2);
			
			
			$sql_H3	= "UPDATE horario_cot_mes SET fecha_inicio=CONCAT('0',fecha_inicio)
			WHERE LENGTH(fecha_inicio)=9";
			$result_sql_H3	= mysql_query($sql_H3);
			
			$sql_H4	= "UPDATE horario_cot_mes SET fecha_fin=CONCAT('0',fecha_fin)
			WHERE LENGTH(fecha_fin)=9";
			$result_sql_H4	= mysql_query($sql_H4);
			
			$sql_H5	= "UPDATE horario_cot_mes SET 
			n_fecha_inicio=CONCAT(SUBSTR(fecha_inicio,7,4),'-',SUBSTR(fecha_inicio,4,2),'-',SUBSTR(fecha_inicio,1,2)),
			n_fecha_fin=CONCAT(SUBSTR(fecha_fin,7,4),'-',SUBSTR(fecha_fin,4,2),'-',SUBSTR(fecha_fin,1,2))";
			$result_sql_H5	= mysql_query($sql_H5);
			
			
			$sql_H7= "UPDATE horario_cot_mes SET ncompleto=trim(ncompleto)";
			$result_sql_H7	= mysql_query($sql_H7);
			
			include("ejecuta_sp.php");
				
			$sql_H11= "truncate table horarios_gestores_cot";
			$result_sql_H11	= mysql_query($sql_H11);
			
			$sql_H12= "INSERT INTO horarios_gestores_cot
			SELECT dni,cip,ncompleto,c_supervisor,sgrupo,'','','','','','',''
			FROM tb_usuarios 
			WHERE estado='HABILITADO'";
			$result_sql_H12	= mysql_query($sql_H12);
			
			
			$sql_H13	= "UPDATE horarios_gestores_cot SET cargo='-' WHERE cargo IS NULL";
			$result_sql_H13 = mysql_query($sql_H13) or die(mysql_error($sql_H13));
			
			$sql_H14	= "UPDATE horarios_gestores_cot a, tb_supervisores b
			SET a.supervisor = b.nom_supervisor
			WHERE a.supervisor=b.cod_supervisor";
			$result_sql_H14 = mysql_query($sql_H14) or die(mysql_error($sql_H14));
				
			$sql_H15	= "UPDATE horarios_gestores_cot a, horario_cot_mes b
			SET a.cod_horario = b.cod_horario
			WHERE a.dni=b.dni and b.est='1'";
			//echo $rutina_inc_4;
			$result_sql_H15	= mysql_query($sql_H15) or die(mysql_error($sql_H15));

			
			$sql_H16 = "UPDATE horarios_gestores_cot a, horarios_personal_apoyo b
			SET a.cod_horario=b.cod_horario
			WHERE a.dni=b.dni AND a.cod_horario=''";
			//echo "\n".$rutina_inc_4a;
			$result_sql_H16	= mysql_query($sql_H16) or die(mysql_error($sql_H16));
			
			$sql_H17	= "UPDATE horarios_gestores_cot a, horarios_cot b
			SET a.cod_horario = b.cod_horario
			WHERE a.dni=b.dni AND a.cod_horario='' and b.est='1'";
			$result_sql_H17	= mysql_query($sql_H17) or die(mysql_error($sql_H17));
			
			$sql_H18	= "UPDATE horarios_gestores_cot a, horarios_rrhh b
			SET a.desc_horario = b.descripcion_1,a.hor_ini=b.f1, a.hor_fin=b.f2
			WHERE a.cod_horario=b.cod_horario";
			$result_sql_H18	= mysql_query($sql_H18) or die(mysql_error($sql_H18));
			
			
			$sql_H19	= "UPDATE horarios_gestores_cot 
			SET dias_horario=TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(desc_horario,'[',1)),'-',-2)),f_carga=now()";
			$result_sql_H19	= mysql_query($sql_H19) or die(mysql_error($sql_H19));
			
			$sql_H20	= "UPDATE horarios_gestores_cot a, cab_incidencia b
			SET a.vacaciones='SI'
			WHERE a.dni=b.dni AND b.motivo_incidencia='50' AND CURDATE() BETWEEN SUBSTR(b.fec_ini_inc,1,10) 
			AND SUBSTR(b.fec_fin_inc,1,10)";
			$result_sql_H20	= mysql_query($sql_H20) or die(mysql_error($sql_H20));
			
			$sql_H21	= "UPDATE horarios_gestores_cot SET cod_horario='S/H',desc_horario='SIN HORARIO ASIGNADO',
			dias_horario='SIN HORARIO ASIGNADO',hor_ini='00:00',hor_fin='00:00' WHERE cod_horario=''";
			$result_sql_H21	= mysql_query($sql_H21) or die(mysql_error($sql_H21));
	
}

function carga_ejepen(){
	
	
	$archivo_ejepen = 'L:\\\zz_InputsExternos\\\EjePen\\\pendientes.CSV';
	
	
	$sql_eje0="truncate table ejepen";		
	$res_sql_eje0 = mysql_query($sql_eje0);
	
	$sql_eje1="LOAD DATA LOCAL INFILE '$archivo_ejepen'
	INTO TABLE ejepen
	fields terminated by ',' 
	OPTIONALLY ENCLOSED BY '\"'
	lines terminated by '\r\n' ignore 1 lines";	
	//echo "<p>".$sql_eje1;
	$res_sql_eje1 = mysql_query($sql_eje1);
	
	/***********************/
	$sql_eje2="select * from ejepen";	
	//echo "<p>".$sql_H1;
	$res_sql_eje2= mysql_query($sql_eje2) or die(mysql_error($sql_eje2));
	$nreg_sql_eje2 = mysql_num_rows($res_sql_eje2);
	
	//echo $nreg_sql_H1a;
	
	if ($nreg_sql_eje2<1){
		print "<tr><td> 4.1. Error: Problemas en la carga de EJEPEN - 0 registros cargados</td></tr>";	
		exit;	
	}else{
		print "<tr><td> 4.1. Carga de EJEPEN Ok - Se cargaron $nreg_sql_eje2 registros</td></tr>";
	}
	
	
	$sql_eje3="update ejepen set mov_total='MT' where rma='X'";		
	$res_sql_eje3 = mysql_query($sql_eje3);
	
	$sql_eje4="update ejepen set mov_total='MASIVO' where rma=''";		
	$res_sql_eje4 = mysql_query($sql_eje4);
	
	
	
	$sql_eje5="truncate table ejepen_resultado";		
	$res_sql_eje5 = mysql_query($sql_eje5);

	
	$sql_eje6="INSERT INTO ejepen_resultado 
	SELECT *,now(),''
	FROM ejepen WHERE mov IN ('ALTAS','RUTINA','TRASLADOS','REINST') 
	and mov_total='MASIVO' and desmotv not in('direccion incorrecta','direccion incorrecta/imprecisa') 
	and marca='trt.2linea_tdp'
	and negocio in ('BASICA','CATV','DTH','SPEEDY','GPON')";		
	$res_sql_eje6 = mysql_query($sql_eje6);
	
	
	$sql_eje7="UPDATE ejepen_resultado SET pet_req=codreq WHERE pet_req='0'";		
	$res_sql_eje7 = mysql_query($sql_eje7);
	

}


function exportar_canceladas_cot(){
	
$n_archivo	="D://COMPARTIDO/DATA/CANCELADAS_ROBOT/ejepen_robot.csv";
$origen	 = "D:/COMPARTIDO/DATA/CANCELADAS_ROBOT/ejepen_robot.csv";

file_put_contents ($origen, "");  // LIMPIA ARCHIVO

	/******************************************************************************************************/	
	
$cabecera="TipoRegistro|gestion|tipo|actividad|contrata|Column1|mov|pet_req|casuistica|observacio|ncontacto|ncontacto2|cliente|contacto|direccion|feci_age|hora_age|gestor|prioridad|actividad1|";	
		
	if (file_exists($n_archivo)){
		$archivo = fopen($n_archivo, "a");
		fwrite($archivo,"$cabecera");
		fclose($archivo);
	}
	else{
		$archivo = fopen($n_archivo, "w");
		fwrite($archivo,"$cabecera");
		fclose($archivo);
	}
	
		
	/******************************************************************************************************/	
	
	$hoy = date("Y/m/d h:m:s");
		
	$lista="select czonal,pet_req,desmotv,detmotv from ejepen_resultado where cruce_1=''";	
	$res_lis = mysql_query($lista);	
		
	while($reg_maestra=mysql_fetch_row($res_lis)){	
	
	
	$valor="CANCELAR";		
				
	$cuerpo="Tecnica|Tecnicas|EJEPEN|||$reg_maestra[0]||$reg_maestra[1]|$reg_maestra[2]|$reg_maestra[3]||||||||||$valor|";

		//echo $cuerpo."<br>";
		
			if (file_exists($n_archivo)){
				$archivo = fopen($n_archivo, "a");
				fwrite($archivo,"\n"."$cuerpo");
				fclose($archivo);
			}
			else{
				$archivo = fopen($n_archivo, "w");
				fwrite($archivo,"\n"."$cuerpo");
				fclose($archivo);
			}		
						
	
		}
/*********************************************************************************/

//$destino="k:/Informes/Maestra/maestra_usuarios_cot.txt";


	$destino="L:/zz_InputsExternos/ejepen/ejepen_robot.csv";
	
	file_put_contents ($destino, "");
	
	if (!copy($origen, $destino)) {
		echo "Error al copiar $fichero...\n";
	}

}


function extraer_archivos_ftp_robot(){
			
		// variables
	$ftp_server = "10.4.40.49";
	$ftp_user_name = "usrftpcot";
	$ftp_user_pass = "usrC0T29$";
	$archivo_d ="Tecnicas_".date("Ymd")."0730.txt";
	$destination_file = 'd://compartido//data//canceladas_robot//'.$archivo_d;
	$source_file = '/canceladas/precarga/'.$archivo_d;

	// echo $destination_file ."|". $source_file."\n";
	// conexión
	$conn_id = ftp_connect($ftp_server,true);// or die("No se puede conectar al servidor $ftp_server\n");
	
	// logeo
	$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
	 
	// conexión
	if ((!$conn_id) || (!$login_result)) { 
		   echo "Conexión al FTP con errores!\n";
		   echo "Intentando conectar a $ftp_server for user $ftp_user_name\n"; 
		   exit; 
	   } else {
		   echo "Conectado a $ftp_server, for user $ftp_user_name\n";
	   }
	 
	// archivo a copiar/subir
	$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_ASCII,0);
	 
	// estado de subida/copiado
	if (!$upload) { 
		   echo "Error al subir el archivo!\n";
	   } else {
		   echo "Archivo $source_file se ha subido exitosamente a $ftp_server en $destination_file\n";
	   }
	 
	// cerramos
	ftp_close($conn_id);
		
}

function carga_canceladas_wa_tecnica(){
	
	$n_archivo ="Tecnicas_".date("Ymd")."0730".".txt";
	$archivo_canceladas_wa_tecnica = 'd://compartido/data/canceladas_robot/'.$n_archivo;
	
	
	$sql_rcan0="truncate table robotcanceladas_wa_tecnicas";		
	$res_sql_rcan0 = mysql_query($sql_rcan0);
	
	$sql_rcan1="LOAD DATA LOCAL INFILE '$archivo_canceladas_wa_tecnica'
	INTO TABLE robotcanceladas_wa_tecnicas
	fields terminated by '\t' 
	OPTIONALLY ENCLOSED BY '\"'
	lines terminated by '\r\n' ignore 1 lines";	
	//echo "<p>".$sql_rcan1;
	$res_sql_rcan1 = mysql_query($sql_rcan1);
	
	/***********************/
	$sql_rcan2="select * from robotcanceladas_wa_tecnicas";	
	//echo "<p>".$sql_H1;
	$res_sql_rcan2= mysql_query($sql_rcan2) or die(mysql_error($sql_rcan2));
	$nreg_sql_rcan2 = mysql_num_rows($res_sql_rcan2);
	
	//echo $nreg_sql_H1a;
	
	if ($nreg_sql_rcan2<1){
		print "  4.0. Error: Problemas en la carga Robot_canceladas(WA Terminadas) - 0 registros cargados". "\n";	
		exit;	
	}else{
		print "  4.0. Carga de Robot_canceladas(WA Terminadas) Ok - Se cargaron $nreg_sql_rcan2 registros". "\n";
	}

}


function cruce_pet_req(){
	
	$sql_1 = "UPDATE ejepen_resultado a, robotcanceladas_robot_tecnicas b
				SET a.cruce_1='SI'
				WHERE a.pet_req=b.pet_req";
	//echo $sql_1;
	$result_1 	= mysql_query($sql_1);
		
	$sql_2 = "UPDATE ejepen_resultado a, robotcanceladas_wa_tecnicas b
				SET a.cruce_1='SI'
				WHERE a.pet_req=b.pet_req AND a.cruce_1=''";
	//echo $sql_2;
	$result_2 	= mysql_query($sql_2);
}


function carga_canceladas_robot_tecnica(){
	
	$n_archivo ="TecnicasInput_".date("Ymd")."0730".".xlsx";
	$archivo_xlsx = 'd://compartido/data/canceladas_robot/'.$n_archivo;

//echo $archivo_xlsx;	
		
		 
	if (file_exists ($archivo_xlsx)){ 
		echo "Si se encontro ".$archivo_xlsx."<br>";
		extract($_POST);
	
			 
			////////////////////////////////////////////////////////
			if (file_exists ($archivo_xlsx)) //validacion para saber si el archivo ya existe previamente
			{
			/*INVOCACION DE CLASES Y CONEXION A BASE DE DATOS*/
			/** Invocacion de Clases necesarias */
			require_once('PHPExcel/Classes/PHPExcel.php');
			require_once('PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');
			//DATOS DE CONEXION A LA BASE DE DATOS
			
			$db_host = 'localhost';
			$db_user = 'root';
			$db_pwd  = '';
			$db_name = 'cot';
		
				
			$cn = mysql_connect($db_host, $db_user, $db_pwd) or die ("ERROR EN LA CONEXION");
			$db = mysql_select_db ($db_name ,$cn) or die ("ERROR AL CONECTAR A LA BD");
			 
			$c1="truncate table robotcanceladas_robot_tecnicas";		
			mysql_query($c1,$cn);
			 
			// Cargando la hoja de calculo
			$objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
			$objPHPExcel = $objReader->load($archivo_xlsx); //carga en objphpExcel por medio de objReader,el nombre del archivo
			$objFecha = new PHPExcel_Shared_Date();
			 
			// Asignar hoja de excel activa
			$objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
			 
			// Llenamos un arreglo con los datos del archivo xlsx
			//$i=1; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
			$param=0;
			$contador=0;
			
			$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
			//$numRows = 300;
			
			//echo $numRows; 
			
			//while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
			
			
			
			for ($i = 2; $i <= $numRows ; $i++) 
			{
			
			$col_1				=$objPHPExcel->getActiveSheet()->getCell('A'.$i);
			$col_2				=$objPHPExcel->getActiveSheet()->getCell('B'.$i);
			$col_3				=$objPHPExcel->getActiveSheet()->getCell('C'.$i);
			$col_4				=$objPHPExcel->getActiveSheet()->getCell('D'.$i);
			$col_5				=$objPHPExcel->getActiveSheet()->getCell('E'.$i);
			$col_6				=$objPHPExcel->getActiveSheet()->getCell('F'.$i);
			$col_7				=$objPHPExcel->getActiveSheet()->getCell('G'.$i);
			$col_8				=$objPHPExcel->getActiveSheet()->getCell('H'.$i);
			$col_9				=$objPHPExcel->getActiveSheet()->getCell('I'.$i);
			
			
			//echo $mes."|".$cip."|".$nombres."|".$fec_fin_horario."|".$cod_horario."|".$fec_ini_horario."<br>";
			
			
			$sql = "INSERT INTO robotcanceladas_robot_tecnicas
					 VALUES ('$col_1','$col_2','$col_3','$col_4','$col_5','$col_6','$col_7','$col_8','$col_9',now())";
			//echo $sql."<p>";
			
			mysql_query($sql,$cn);
			
			}
		
		}else{
		echo "No se encontro ".$archivo_xlsx."<br>";
		}
		
		//unlink($archivo_xlsx); 
	}
}

function copia_mensual_horarios(){
	
	$nro_dias = cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); 
	
	//echo $nro_dias;
		
	if (date("d")==$nro_dias){
		$sql_1 = "INSERT INTO horarios_cot
		SELECT mes,cip,ncompleto,fecha_inicio,cod_horario,fecha_fin,detalle_horario,AREA,lider_directo,
		comentario,dni,n_fecha_inicio,n_fecha_fin,est FROM horario_cot_mes WHERE est='1'";
		//echo $sql_1;
		$result_1 	= mysql_query($sql_1);		
		print "<tr><td>3.- Proceso Copiado mensual de horarios OK</td></tr>";
	}else{
		print "<tr><td>3.- Aun no es la fecha de copiado mensual</td></tr>";
	}
}


/***************************/

function carga_maestracot(){

$xmes = date("mY");
	
$archivo = "\\\\10.226.5.114\\FS-Principal\\Dir_Marketing\\Ger_Consumo_de_Terminales_y_Banda_Ancha\\Jefatura_de_Terminales\\000Cot\\zz_InputsExternos\\WebGescot\\Input_Maestra\\maestra_cot_102020.csv";
	
	
	//$archivo_horario = 'L:///zz_InputsExternos///HorariosCot///horarios_'.$xmes.".csv";
	
			
			$sql_H0="truncate table maestra_cot_temporal";		
			$res_sql_H0 = mysql_query($sql_H0);
			
			$sql_H1="LOAD DATA LOCAL INFILE '$archivo'
			INTO TABLE maestra_cot_temporal
			FIELDS TERMINATED BY ','
			LINES TERMINATED BY '\r\n' IGNORE 1 LINES";	
			
			//echo $sql_H1;
			
			$res_sql_H1 = mysql_query($sql_H1) or die(mysql_error());
			
}
?>