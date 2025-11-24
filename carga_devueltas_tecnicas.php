<?php

echo "Proceso Iniciado....!!!";

include("conexion_bd.php");
ini_set("display_errors", "On");
error_reporting(E_ALL ^ E_NOTICE);
set_time_limit(12000);

$ruta ="D:/COMPARTIDO/DATA/DEVUELTAS/input/";

	mysql_query("truncate table tabla_ONLINE_tmp") ;
	mysql_query("truncate table tabla_zuta") ;	
	mysql_query("truncate table tabla_tec_ONLINE") ;
	mysql_query("truncate table tabla_tec_PAI") ;
	mysql_query("truncate table tabla_cmr") ;
	mysql_query("truncate table tabla_cmr_online") ;
	mysql_query("truncate table tabla_devueltas") ;
	
	/*
	$file_1 = $ruta."TABLA_ONLINE.csv";
	
	$sql_beo1="LOAD DATA LOCAL INFILE '$file_1'
	INTO TABLE tabla_tec_ONLINE
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_beo1;
	$res_sql_beo1 = mysql_query($sql_beo1);
	*/
	
	/******************************************************************/
	$tabla = "tabla_tec_ONLINE";
	$ini2=date("Y-m-d H:m");
	$dia=date('Y-m-d');
	
	$row=1;	
	
	$file_1 = $ruta."TABLA_TEC_ONLINE.csv";
	//echo $fileName;
	
	
	$fp = fopen($file_1, "r");
	
	while (!feof($fp) ) {
		//$linea = fread($fp,8192);
		$linea  = fgets($fp);	//echo "<br>".$linea;
		
		if($row > 1){ // a partir de la linea 20
		
		$linea = explode(",", $linea);
		
		$Nro_Peticion		=$linea[0];
		$id					=$linea[1];
		$Movimiento_id		=$linea[2];
		$cod_Motivo			=$linea[3];
		$Motivo				=$linea[4];
		$Sub_Motivo			=eliminar_simbolos($linea[5]);
		$Descripcion		=eliminar_simbolos($linea[6]);
		$Nombre_Tecnico		=$linea[7];
		$Nro_Celular		=$linea[8];
		$Carnet				=$linea[9];
		$Area				=$linea[10];
		$EECC				=$linea[11];
		$Tematico_1			=$linea[12];
		$Tematico_2			=eliminar_simbolos($linea[13]);
		$Tematico_3			=eliminar_simbolos($linea[14]);
		$Comentario			=eliminar_simbolos($linea[15]);
		$Fecha_Ingreso		=$linea[16];
		$Fecha_Liquidacion	=$linea[17];
		$Fecha_Proceso		=$linea[18];
		$Estado				=$linea[19];
		$Usuario			=$linea[20];
		$Supervision		=$linea[21];
		$Perfil				=$linea[22];
		$Zonal				=$linea[23];
		$Jefatura			=$linea[24];
		$mov				=$linea[25];
		$cmdf_nodo			=$linea[26];
		$telf1				=$linea[27];
		$telf2				=$linea[28];
		$win_telf1			=$linea[29];
		$win_telf2			=$linea[30];
		$win_telf3			=$linea[31];
		$contra				=$linea[32];
		$Negocio			=$linea[33];
		$datofiltro			=$linea[34];
		$winback			=$linea[35];
		$up_front			=$linea[36];
		$Region				=$linea[37];
		$CODTRTRN			=$linea[38];
		$CODLEX				=$linea[39];
		$CODTAP				=$linea[40];
		$CODBOR				=$linea[41];
		$TOA				=$linea[42];

		
		$sql_1="INSERT INTO $tabla(
		Nro_Peticion,id,Movimiento_id,cod_Motivo,Motivo,Sub_Motivo,Descripcion,Nombre_Tecnico,
		Nro_Celular,Carnet,Area,EECC,Tematico_1,Tematico_2,Tematico_3,Comentario,Fecha_Ingreso,
		Fecha_Liquidacion,Fecha_Proceso,Estado,Usuario,Supervision,Perfil,Zonal,Jefatura,mov,
		cmdf_nodo,telf1,telf2,win_telf1,win_telf2,win_telf3,contra,Negocio,datofiltro,winback,up_front,
		Region,CODTRTRN,CODLEX,CODTAP,CODBOR,TOA
		)VALUES(
		'$Nro_Peticion','$id','$Movimiento_id','$cod_Motivo','$Motivo','$Sub_Motivo','$Descripcion',
		'$Nombre_Tecnico','$Nro_Celular','$Carnet','$Area','$EECC','$Tematico_1',
		'$Tematico_2','$Tematico_3','$Comentario','$Fecha_Ingreso','$Fecha_Liquidacion','$Fecha_Proceso','$Estado',
		'$Usuario','$Supervision','$Perfil','$Zonal','$Jefatura','$mov','$cmdf_nodo','$telf1','$telf2','$win_telf1',
		'$win_telf2','$win_telf3','$contra','$Negocio','$datofiltro','$winback','$up_front','$Region',
		'$CODTRTRN','$CODLEX','$CODTAP','$CODBOR','$TOA'
		);";
			
		//echo "<br>".$sql_1;
		$res_1 = mysql_query($sql_1) or die(mysql_error($sql_1));
		
			
		}
		$row++;
		
		if ($ciudad=="X"){
			unset($cont[$row]); 
			
		}
				
	}
	
		fclose($fp);	
	
	/******************************************/
		
	$file_2 = $ruta."TABLA_TEC_PAI.csv";
	
	$sql_beo2="LOAD DATA LOCAL INFILE '$file_2'
	INTO TABLE tabla_tec_PAI
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_beo2;
	$res_sql_beo2 = mysql_query($sql_beo2);
	
	
	/**********************************************************************************************************************/
		
	
	$file_4 = $ruta."TABLA_CMR.csv";
	
	$sql_beo4="LOAD DATA LOCAL INFILE '$file_4'
	INTO TABLE tabla_cmr
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_beo2;
	$res_sql_beo4 = mysql_query($sql_beo4);
	
	
	/******************************************/
	
	$file_5 = $ruta."TABLA_CMR_ONLINE.csv";
	
	$sql_beo5="LOAD DATA LOCAL INFILE '$file_5'
	INTO TABLE tabla_cmr_online
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_beo2;
	$res_sql_beo5 = mysql_query($sql_beo5);
	
	
	/**********************************************************************************************************************/
	
	$sql_beo3="INSERT INTO tabla_zuta
	(
	SELECT 'TECNICA','TEC_PAI',gestion,zonal,'',pet_req,'','',casuistica,contrata,'',actividad,observacion,
	'','','','','',tematico1,tematico2,tematico3,tematico4,obs_gestio,f_carga,'',f_gestion,f_bloqueo,situacion,usu_gestion,
	'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''	
	FROM tabla_tec_pai
	)UNION(
	SELECT 'TECNICA','TEC_ONLINE',cod_Motivo,Zonal,Jefatura,Nro_Peticion,mov,'',Motivo,EECC,Sub_Motivo,'','',
	Descripcion,Nombre_Tecnico,Carnet,AREA,'',Tematico_1,Tematico_2,Tematico_3,Comentario,'',Fecha_Ingreso,'',
	Fecha_Liquidacion,Fecha_Proceso,Estado,Usuario,
	'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''				
	FROM tabla_tec_online	
	)UNION(
	SELECT 'COMERCIAL','COM_PAI','COMERCIAL',czonal,jefatura,pet_req,mov,motivo_pt,desmotv,contra,detmotv,actividad,
	'','','','','','',tematico1,tematico2,tematico3,tematico4,obs_gestio,f_carga,'',f_gestion,f_bloqueo,situacion,usu_gestion,
	'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''				
	FROM tabla_cmr
	)UNION(
	SELECT 'COMERCIAL','COM_ONLINE','ONLINE',czonal,jefatura,pet_req,mov,'',des_mot,contra,det_mot,actividad,
	'','',nombre_tco,cip_tecnico,AREA,eecc,tematico1,tematico2,tematico3,tematico4,obs_gestio,f_carga,f_sms,
	f_gestion,f_bloqueo,situacion,usu_gestion,
	'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''				
	FROM tabla_cmr_online
	)";	
	//echo "<p>".$sql_beo3;
	$res_sql_beo3 = mysql_query($sql_beo3);
	
	$cri1="UPDATE tabla_zuta SET criterio='fecha carga vacia' WHERE f_carga=''";			
	//echo "<p>".$sql_beo3;
	$res_cri1 = mysql_query($cri1);
	
	$cri2="UPDATE tabla_zuta SET criterio='fecha gestion vacia' WHERE f_gestion=''";	
	//echo "<p>".$sql_beo3;
	$res_cri2 = mysql_query($cri2);
	
	$cri3="UPDATE tabla_zuta SET criterio='fecha bloqueo vacia' WHERE f_bloqueo=''";	
	//echo "<p>".$sql_beo3;
	$res_cri3 = mysql_query($cri3);
	
	$cri4="UPDATE tabla_zuta SET criterio='fecha sms vacia' WHERE f_sms=''";	
	//echo "<p>".$sql_beo3;
	$res_cri4 = mysql_query($cri4);
	
	$cri5="UPDATE tabla_zuta SET criterio='codigo req. vacio' WHERE petreq=''";	
	//echo "<p>".$sql_beo3;
	$res_cri5 = mysql_query($cri5);
	
	$cri6="UPDATE tabla_zuta 
	SET anio_carga=SUBSTR(f_carga,7,4),mes_carga=SUBSTR(f_carga,4,2),dia_carga=SUBSTR(f_carga,1,2),
	hora_minuto_carga=SUBSTR(f_carga,12,2), hora_carga=SUBSTR(f_carga,15,2),
	anio_bloqueo=SUBSTR(f_bloqueo,7,4),mes_bloqueo=SUBSTR(f_bloqueo,4,2),dia_bloqueo=SUBSTR(f_bloqueo,1,2),
	hora_minuto_bloqueo=SUBSTR(f_bloqueo,12,2), hora_bloqueo=SUBSTR(f_bloqueo,15,2),
	anio_gestion=SUBSTR(f_gestion,7,4),mes_gestion=SUBSTR(f_gestion,4,2),dia_gestion=SUBSTR(f_gestion,1,2),
	hora_minuto_gestion=SUBSTR(f_gestion,12,2), hora_gestion=SUBSTR(f_gestion,15,2) where base in ('TEC_ONLINE','TEC_PAI')";	
	//echo "<p>".$sql_beo3;
	$res_cri6 = mysql_query($cri6);
	
	
	$cri7="INSERT INTO tabla_devueltas
	SELECT Fuente,base,gestion,zona,jef,petreq,mov,motivopt,desmotv,contra,detmotv,actividad,des_mot,det_mot,nomb_tco,cipte,AREA,eecc,
	tematico1,tematico2,tematico3,tematico4,obsgest,f_carga,f_sms,f_gestion,f_bloqueo,situa,us,Situacion_z,ANIO_CARGA,
	MES_CARGA,DIA_CARGA,HORA_MINUTO_CARGA,HORA_CARGA,ANIO_BLOQUEO,MES_BLOQUEO,DIA_BLOQUEO,HORA_MINUTO_BLOQUEO,HORA_BLOQUEO,
	ANIO_GESTION,MES_GESTION,DIA_GESTION,HORA_MINUTO_GESTION,HORA_GESTION,OBSERVACION,MINUTOS_FC_FG,
	CASE DAYOFWEEK(CONCAT(anio_carga,'/',mes_carga,'/',dia_carga))
	 WHEN 1 THEN 'Domingo'
	 WHEN 2 THEN 'Lunes'
	 WHEN 3 THEN 'Martes'
	 WHEN 4 THEN 'Miércoles'
	 WHEN 5 THEN 'Jueves'
	 WHEN 6 THEN 'Viernes'
	 WHEN 7 THEN 'Sabado'
	 END nombre_dia,	
	CASE DAYOFWEEK(CONCAT(ANIO_GESTION,'/',MES_GESTION,'/',DIA_GESTION))
	 WHEN 1 THEN 'Domingo'
	 WHEN 2 THEN 'Lunes'
	 WHEN 3 THEN 'Martes'
	 WHEN 4 THEN 'Miércoles'
	 WHEN 5 THEN 'Jueves'
	 WHEN 6 THEN 'Viernes'
	 WHEN 7 THEN 'Sabado'
	 END nombre_dia,
	TIEMPO_ATENCION_ONLINE_FC_FG,MOTIVO,EECC_OK,SEMANA_CALC_FC,MES_CALC_FC,SEMANA_CALC_FG,
	MES_CALC_FG,Mov_Total,responsable,resultado,casuistica,FECREG
	FROM tabla_zuta WHERE criterio='' GROUP BY petreq";	
	//echo "<p>".$sql_beo3;
	$res_cri7 = mysql_query($cri7);
	
	echo "Proceso Terminado....!!!";
	
	
	/**********************************************************************************************************************/

?>