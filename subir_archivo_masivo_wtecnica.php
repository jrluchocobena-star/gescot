<?
include_once("conexion_w101.php");
$connection_w101	= db_conn_w101();

$iduser=$_GET["iduser"];


	$archivo="D:/COMPARTIDO/DATA/101/wtecnica_ussd.CSV";

	
	mysql_query("truncate table ws_movimiento_usuarios_tmp") ;	

	$sql_0="LOAD DATA LOCAL INFILE '$archivo' INTO TABLE ws_movimiento_usuarios_tmp 
	FIELDS TERMINATED BY ',' ENCLOSED BY '\"'
	LINES TERMINATED BY '\n' IGNORE 1 LINES";

			
	//echo "<br>".$sql_0."\n";		
	$res_0 = mysql_query($sql_0,$connection_w101);
	
	$sql_1    = "select * from ws_movimiento_usuarios_tmp";
	//echo $sql_1;
	$res_sql1 = mysql_query($sql_1,$connection_w101);	
	
	$i=0;
	while($reg_sql1 = mysql_fetch_row($res_sql1)){			
	
		//$i = $i+1;
		if (substr($reg_sql1[1],0,2)=="51"){
			$nuevo_cel = '+'.$reg_sql1[1];
			$sql_3a="update ws_movimiento_usuarios_tmp set NroCel ='$nuevo_cel'  where NroCel='$reg_sql1[1]'";
	//		echo $sql_3;
			$res_sql3a = mysql_query($sql_3a,$connection_w101);	
		}else{
			if (substr($reg_sql1[1],0,1)=="9"){	
			$nuevo_cel='+51'.$reg_sql1[1];
			$sql_3b="update ws_movimiento_usuarios_tmp set NroCel = '$nuevo_cel'  where NroCel='$reg_sql1[1]'";
	//		echo $sql_3;
			$res_sql3b = mysql_query($sql_3b,$connection_w101);
			}
		}
		
		
		/************************************************************************************/
		
		if ($reg_sql1[13]=="" and $reg_sql1[14]=="" and $reg_sql1[15]=="" and $reg_sql1[16]=="" and $reg_sql1[17]=="" and $reg_sql1[18]=="" and $reg_sql1[19]=="" 
		and $reg_sql1[20]=="" and $reg_sql1[21]=="" and $reg_sql1[22]=="" and $reg_sql1[23]=="" and $reg_sql1[24]=="" and $reg_sql1[25]=="" and $reg_sql1[26]=="" 
		and $reg_sql1[27]=="" and $reg_sql1[28]=="" and $reg_sql1[29]=="" and $reg_sql1[30]=="" and $reg_sql1[31]=="" and $reg_sql1[32]=="" and $reg_sql1[33]=="")
		{ 
		$marca="ERROR";
		$error="DEL CAMPO ESTADO HASTA CAMPO PCGAVERIA ESTAN VACIOS";
		}
		
		if (empty($reg_sql1[3])){
		$marca="ERROR";
		$error="\n"."CARNET VACIO";
		}
			
		if (empty($reg_sql1[4])){
		$marca="ERROR";
		$error="\n"."DNI VACIO";		
		}	
		
		if (empty($reg_sql1[10])){
		$marca="ERROR";
		$error="\n"."CAMPO AREA DE GESTION ESTAN VACIOS";		
		}
		
		if (empty($reg_sql1[2])){
		$marca="ERROR";
		$error="\n"."CAMPO NOMBRES ESTAN VACIOS";		
		}
		
		$error_ = $error_.$error;
		
		$sql_7="update ws_movimiento_usuarios_tmp set marca_1='$marca',error='$error_' where NroCel='$nuevo_cel'";
		//echo $sql_7;
		$res_sql7 = mysql_query($sql_7,$connection_w101);			
		
		
		$sql_8="UPDATE ws_movimiento_usuarios_tmp a, ws_movimiento_usuarios b
		SET a.marca_1='YA EXISTE'
		WHERE a.NroCel=b.NroCel ";
		$res_sql8 = mysql_query($sql_8,$connection_w101);		
	}
	
	
	
	$sql_9="INSERT INTO ws_movimiento_usuarios(
	SELECT idDSL,NroCel,Nombre,Carnet,DNI,Region,Zonal,Zona,EECC,Jefatura,AreaGestion,Responsable,Celular,Estado,pConsulta,pReset,pReconfig,
	pCambioParADSL,pCambioVoz,pRecomenLinea,pConsultaPedido,pReporte,pReasignacion,pRegistrarCaja,flagConformidad,pReasigMDF,pObservadas,
	pReporteNODEID,	pConsultaCajas,pTratTecnico,pTratConsultTelf,pCierreAten,pGamming,pCGAveria,'',now(),obs,SolicitadoPor,TOA,'$iduser',
	'CARGA MASIVA','','','',CURDATE()
	FROM ws_movimiento_usuarios_tmp where marca_1='')";
	//echo $sql_9;
	$res_sql9 = mysql_query($sql_9,$connection_w101);	
	
	
	$hoy=date("Y-m-d");
	$sql_10="select * from ws_movimiento_usuarios where fec_carga='$hoy'";
	$resp_10 = mysql_query($sql_10,$connection_w101);	
	
	if ($iduser=="156"){ $iduser="lcobenat";}
	
	while($reg_10 = mysql_fetch_row($resp_10)){		
		/*		
		$sql_11 ="INSERT INTO ws_usuarios VALUES 	
		(NULL,'$reg_10[0]','$reg_10[1]','$reg_10[2]','$reg_10[3]','$reg_10[4]','$reg_10[5]','$reg_10[6]','$reg_10[7]','$reg_10[8]','$reg_10[9]',
		'$reg_10[10]','$reg_10[11]','$reg_10[12]','$reg_10[13]','$reg_10[14]','$reg_10[15]','$reg_10[16]','$reg_10[17]','$reg_10[18]','$reg_10[19]','$reg_10[20]',	
		'$reg_10[21]','$reg_10[22]','$reg_10[23]','$reg_10[24]','$reg_10[25]','$reg_10[26]','$reg_10[27]','$reg_10[28]','$reg_10[29]',
	    '$reg_10[30]','$reg_10[31]','$reg_10[32]','$reg_10[33]',now(),now(),'$reg_10[36]','$reg_10[37]','$reg_10[38]','$reg_10[39]','$iduser') 
		ON DUPLICATE KEY UPDATE Nombre='$reg_10[2]',Carnet='$reg_10[3]',DNI='$reg_10[4]',Region='$reg_10[5]',
		Zonal='$reg_10[6]',Zona='$reg_10[7]',EECC='$reg_10[8]',Jefatura='$reg_10[9]',AreaGestion='$reg_10[10]',Responsable='$reg_10[11]',celular='$reg_10[12]',
		Estado='$reg_10[13]',pConsulta='$reg_10[14]',pReset='$reg_10[15]',pReconfig='$reg_10[16]',pCambioParADSL='$reg_10[17]',pCambioVoz='$reg_10[18]',
		pRecomenLinea='$reg_10[19]', pConsultaPedido='$reg_10[20]',pReporte='$reg_10[21]',pReasignacion='$reg_10[22]',pRegistrarCaja='$reg_10[23]',
		flagConformidad='$reg_10[24]',pReasigMDF='$reg_10[25]',pObservadas='$reg_10[26]',pReporteNODEID='$reg_10[27]',pConsultaCajas='$reg_10[28]',pTratTecnico='$reg_10[29]',
		pTratConsultTelf='$reg_10[30]',pCierreAten='$reg_10[31]',pGamming='$reg_10[32]',pCGAveria='$reg_10[33]',
		FechaModifi=IF($reg_10[35]<>'0000-00-00 00:00:00',NOW(),$reg_10[35]),SolicitadoPor='$reg_10[37]', 
		FechaCreacion=IF($reg_10[34]<>'0000-00-00 00:00:00',NOW(),$reg_10[34]),TOA='$reg_10[38]',AtendidoPor='$iduser'";	
		echo "<br>".$sql_1;
		*/
		$sql_11 ="INSERT INTO ws_usuarios VALUES 	
		('','$reg_10[1]','$reg_10[2]','$reg_10[3]','$reg_10[4]','$reg_10[5]','$reg_10[6]','$reg_10[7]','$reg_10[8]','$reg_10[9]',
		'$reg_10[10]','$reg_10[11]','$reg_10[12]','$reg_10[13]','$reg_10[14]','$reg_10[15]','$reg_10[16]','$reg_10[17]','$reg_10[18]','$reg_10[19]','$reg_10[20]',	
		'$reg_10[21]','$reg_10[22]','$reg_10[23]','$reg_10[24]','$reg_10[25]','$reg_10[26]','$reg_10[27]','$reg_10[28]','$reg_10[29]',
	    '$reg_10[30]','$reg_10[31]','$reg_10[32]','$reg_10[33]',now(),now(),'$reg_10[36]','$reg_10[37]','$reg_10[38]','$iduser') 
		ON DUPLICATE KEY UPDATE Nombre='$reg_10[2]',Carnet='$reg_10[3]',DNI='$reg_10[4]',Region='$reg_10[5]',
		Zonal='$reg_10[6]',Zona='$reg_10[7]',EECC='$reg_10[8]',Jefatura='$reg_10[9]',AreaGestion='$reg_10[10]',Responsable='$reg_10[11]',celular='$reg_10[12]',
		Estado='$reg_10[13]',pConsulta='$reg_10[14]',pReset='$reg_10[15]',pReconfig='$reg_10[16]',pCambioParADSL='$reg_10[17]',pCambioVoz='$reg_10[18]',
		pRecomenLinea='$reg_10[19]', pConsultaPedido='$reg_10[20]',pReporte='$reg_10[21]',pReasignacion='$reg_10[22]',pRegistrarCaja='$reg_10[23]',
		flagConformidad='$reg_10[24]',pReasigMDF='$reg_10[25]',pObservadas='$reg_10[26]',pReporteNODEID='$reg_10[27]',pConsultaCajas='$reg_10[28]',pTratTecnico='$reg_10[29]',
		pTratConsultTelf='$reg_10[30]',pCierreAten='$reg_10[31]',pGamming='$reg_10[32]',pCGAveria='$reg_10[33]',
		FechaModifi=now(),FechaCreacion=IF(FechaCreacion<>'0000-00-00 00:00:00',NOW(),'$reg_10[34]'),TOA='$reg_10[38]',AtendidoPor='$iduser'";	
		//echo "<br>".$sql_11;

		$resp_11 = mysql_query($sql_11,$connection_w101);		
	}
	
?>
