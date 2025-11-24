<?php
include_once("../conexion_w101.php");


$connection_w101	= db_conn_w101();

$iduser=$_GET["iduser"];
$arch=$_GET["arch"];
	

	$archivo="d://formato_101.csv";
	
	
	mysql_query("delete from asignaciones.wt_solicitudes_historicos") ;	

	$sql_0="LOAD DATA LOCAL INFILE '$archivo' INTO TABLE asignaciones.wt_solicitudes_historicos 
	FIELDS TERMINATED BY ';'
	LINES TERMINATED BY '\n' IGNORE 1 LINES";			
	echo "<br>".$sql_0."\n";			
	$res_0 = mysql_query($sql_0,$connection_w101) or die (mysql_error());
		
	$sql_1="UPDATE wt_solicitudes_historicos SET fecha_solicitud=NOW(),est='NUEVO'";	
	//echo "<p>".$sql;
	$res_1 = mysql_query($sql_1,$connection_w101) or die ($sql_1);
	
	/*
	$sql_2="DELETE FROM wt_maestra_consultas";	
	//echo "<p>".$sql;
	$res_2 = mysql_query($sql_2,$connection_w101) or die (mysql_error());
	
	$sql_3="INSERT INTO wt_maestra_consultas
	SELECT solicitado_por,celular,xcarnet,xdni,'','','','','','','','','','','','','','','','' FROM wt_solicitudes_historicos
	WHERE est='NUEVO'";	
	//echo "<p>".$sql_3;
	$res_3 = mysql_query($sql_3,$connection_w101) or die (mysql_error());
	
	$sql_4="DELETE FROM wt_maestra_consultas WHERE CELULAR=''";	
		//echo "<p>".$sql;
	$res_4 = mysql_query($sql_4,$connection_w101) or die (mysql_error());
	
	$sql_5="UPDATE wt_maestra_consultas SET xcarnet=TRIM(xcarnet),xdni=TRIM(xdni),celular=TRIM(celular)";	
	//echo "<p>".$sql;
	$res_5 = mysql_query($sql_5,$connection_w101) or die (mysql_error());
	
	$sql_6="UPDATE wt_maestra_consultas a, wt_maestra_tecnicos b
SET a.cod_tecnico=b.cod_tecnico,a.nom_tecnico=b.nom_tecnico,a.nro_doc=b.nro_doc,a.eecc=b.eecc,a.nro_cel=b.celular,
a.estado_toa=b.estado_toa,a.estado_celular=b.estado_celular,a.encontro_cel='SI',a.encontro_carnet='SI',a.encontro_dni='SI'
WHERE a.xdni=b.nro_doc AND a.xcarnet=b.cod_tecnico AND a.celular=b.celular";	
	//echo "<p>".$sql;
	$res_6 = mysql_query($sql_6,$connection_w101) or die (mysql_error());
	
	$sql_7="UPDATE wt_maestra_consultas a, wt_maestra_tecnicos b
SET a.cod_tecnico=b.cod_tecnico,a.nom_tecnico=b.nom_tecnico,a.nro_doc=b.nro_doc,a.eecc=b.eecc,a.nro_cel=b.celular,
a.estado_toa=b.estado_toa,a.estado_celular=b.estado_celular,a.encontro_dni='SI'
WHERE a.xdni=b.nro_doc AND a.nom_tecnico=''";	
	//echo "<p>".$sql;
	$res_7 = mysql_query($sql_7,$connection_w101) or die (mysql_error());
	
	$sql_8="UPDATE wt_maestra_consultas a, wt_maestra_tecnicos b
SET a.cod_tecnico=b.cod_tecnico,a.nom_tecnico=b.nom_tecnico,a.nro_doc=b.nro_doc,a.eecc=b.eecc,a.nro_cel=b.celular,
a.estado_toa=b.estado_toa,a.estado_celular=b.estado_celular,a.encontro_carnet='SI'
WHERE a.xcarnet=b.cod_tecnico AND a.nom_tecnico=''";	
	//echo "<p>".$sql;
	$res_8 = mysql_query($sql_8,$connection_w101) or die (mysql_error());
	
	$sql_9="UPDATE wt_maestra_consultas a, wt_maestra_tecnicos b
SET a.cod_tecnico=b.cod_tecnico,a.nom_tecnico=b.nom_tecnico,a.nro_doc=b.nro_doc,a.eecc=b.eecc,a.nro_cel=b.celular,
a.estado_toa=b.estado_toa,a.estado_celular=b.estado_celular,a.encontro_cel='SI'
WHERE a.celular=b.celular AND a.nom_tecnico=''";	
	//echo "<p>".$sql;
	$res_9 = mysql_query($sql_9,$connection_w101) or die (mysql_error());
	
	$sql_10="UPDATE wt_maestra_consultas a, ws_usuarios b
SET a.celular_101=b.nrocel,a.carnet_101=b.carnet,a.dni_101=b.dni,a.estado_101=b.estado,a.encontro_w101='SI'
WHERE a.xdni=b.dni AND a.xcarnet=b.carnet AND a.celular=b.nrocel";	
	//echo "<p>".$sql;
	$res_10 = mysql_query($sql_10,$connection_w101) or die (mysql_error());
	
	$sql_11="UPDATE wt_maestra_consultas SET encontro_cel='NO' WHERE encontro_cel=''";	
	//echo "<p>".$sql;
	$res_11 = mysql_query($sql_11,$connection_w101) or die (mysql_error());
	
	$sql_12="UPDATE wt_maestra_consultas SET encontro_carnet='NO' WHERE encontro_carnet=''";	
	//echo "<p>".$sql;
	$res_12 = mysql_query($sql_12,$connection_w101) or die (mysql_error());
	
	$sql_13="UPDATE wt_maestra_consultas SET encontro_dni='NO' WHERE encontro_dni=''";	
	//echo "<p>".$sql;
	$res_13 = mysql_query($sql_13,$connection_w101) or die (mysql_error());
	
	$sql_14="UPDATE wt_maestra_consultas SET encontro_w101='NO' WHERE encontro_w101=''";	
	//echo "<p>".$sql;
	$res_14 = mysql_query($sql_14,$connection_w101) or die (mysql_error());
	
	$sql_15="UPDATE wt_maestra_consultas SET resultado=''";	
	//echo "<p>".$sql;
	$res_15 = mysql_query($sql_15,$connection_w101) or die (mysql_error());
	
	$sql_16="UPDATE wt_maestra_consultas SET resultado='ACEPTADO: SE ENCUENTRA REGISTRADO' WHERE encontro_dni='SI' 
	AND encontro_carnet='SI' AND encontro_cel='SI'";	
	//echo "<p>".$sql;
	$res_16 = mysql_query($sql_16,$connection_w101) or die (mysql_error());
	
	$sql_17="UPDATE wt_maestra_consultas SET resultado='RECHAZADO: NO SE ENCUENTRA EN MAESTRA TECNICOS' WHERE cod_tecnico=''";	
	//echo "<p>".$sql;
	$res_17 = mysql_query($sql_17,$connection_w101) or die (mysql_error());
	
	$sql_18="UPDATE wt_maestra_consultas SET resultado='RECHAZADO: DNI NO COINCIDEN' WHERE encontro_dni='NO' 
	AND encontro_carnet='SI' AND encontro_cel='SI'";	
	//echo "<p>".$sql;
	$res_18 = mysql_query($sql_18,$connection_w101) or die (mysql_error());
	
	$sql_19="UPDATE wt_maestra_consultas SET resultado='RECHAZADO: CELULAR NO COINCIDEN' WHERE encontro_dni='SI' 
	AND encontro_carnet='SI' AND encontro_cel='NO'";	
	//echo "<p>".$sql;
	$res_19 = mysql_query($sql_19,$connection_w101) or die (mysql_error());
	
	$sql_20="UPDATE wt_maestra_consultas SET resultado='RECHAZADO: CARNET NO COINCIDEN' WHERE encontro_dni='SI' 
	AND encontro_carnet='NO' AND encontro_cel='SI'";	
	//echo "<p>".$sql;
	$res_20 = mysql_query($sql_20,$connection_w101) or die (mysql_error());
	
	$sql_21="UPDATE wt_maestra_consultas SET resultado='RECHAZADO: DNI Y CELULAR NO COINCIDEN' WHERE encontro_dni='NO' 
	AND encontro_carnet='SI' AND encontro_cel='NO'";	
	//echo "<p>".$sql;
	$res_21 = mysql_query($sql_21,$connection_w101) or die (mysql_error());
	
	$sql_22="UPDATE wt_maestra_consultas SET resultado='RECHAZADO: CELULAR Y CARNET NO COINCIDEN' WHERE encontro_dni='SI' 
	AND encontro_carnet='NO' AND encontro_cel='NO'";	
	//echo "<p>".$sql;
	$res_22 = mysql_query($sql_22,$connection_w101) or die (mysql_error());
	
	$sql_23="UPDATE wt_maestra_consultas SET resultado='RECHAZADO: DNI Y CELULAR NO COINCIDEN' WHERE encontro_dni='NO' 
	AND encontro_carnet='SI' AND encontro_cel='NO'";	
	//echo "<p>".$sql;
	$res_23 = mysql_query($sql_23,$connection_w101) or die (mysql_error());
	
	$sql_24="UPDATE wt_solicitudes_historicos SET est='OK' WHERE est='NUEVO';";	
	//echo "<p>".$sql;
	$res_24 = mysql_query($sql_24,$connection_w101) or die (mysql_error());
	
	$sql_25="INSERT INTO wt_maestra_consultas_historico
	SELECT *,NOW()AS f_ejecusion FROM wt_maestra_consultas";	
	//echo "<p>".$sql_25;
	$res_25 = mysql_query($sql_25,$connection_w101) or die (mysql_error());
	*/
	echo "Proceso de Carga Terminado";
	
?>