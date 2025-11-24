<?php
include ("conexion_teradata.php"); 

include("funciones_fechas.php");

set_time_limit(100000);


$xmes    = date ("Y-m");
#$xmes = "2019-11";
$tiempo_inicial = microtime(true);


for($i = 0; $i < 5; $i++) {
	
	if ($i == 1){
	echo "1.- Inicio de proceso..."."\n";
	}
	
	if ($i == 2){  
	echo "2.- Generando y Copiando reporte de Maestra a Teradata"."\n";
	generar_reporte_maestra_teradata();	
	}
	
	if ($i == 3){     	
	echo "3.- Generando reporte Incidencias"."\n";
	generar_reporte_incidencia_anual();		
	}
	
	if ($i == 4){
	echo "4.- Transfiriendo a TERADATA"."\n";
	copiar_reporte_teradata();	
	}

	if ($i == 5){
	echo "5.- Proceso Terminado";	
	}
	
	
}

	$tiempo_final = microtime(true);
	$tiempo = $tiempo_final - $tiempo_inicial;
	echo "<br>"."El tiempo de ejecución del archivo ha sido de " . $tiempo . " segundos";

function generar_reporte_incidencia_anual(){

$connection_mysql 		= db_conn_mysql();

$paso_1	 ="TRUNCATE TABLE reporte_incidencia_cot_anual";
$res_p1	 = mysql_query($paso_1,$connection_mysql) or die(mysql_error($paso_1));

$paso_2	="INSERT INTO reporte_incidencia_cot_anual(
SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,
tiempo,modo,c_doid,dni,dias,SUBSTR(fec_ini_inc,1,7),'','','',''  
FROM cab_incidencia 
WHERE estado_inc IN('0','1')
ORDER BY fec_reg DESC
)union(SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,trim(motivo_incidencia),fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,trim(tiempo),modo,c_doid,dni,dias,SUBSTR(fec_ini_inc,1,7),'','','',''  
	FROM cab_capacitacion 
	ORDER BY fec_reg DESC)";
//echo "<br>".$paso_2;
	
$res_p2	= mysql_query($paso_2,$connection_mysql) or die(mysql_error($paso_2));

$paso_3	="UPDATE reporte_incidencia_cot_anual SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10;";
$res_p3	= mysql_query($paso_3,$connection_mysql) or die(mysql_error($paso_3));

$paso_4	="UPDATE reporte_incidencia_cot_anual a, tb_usuarios b
SET a.cargo=b.sgrupo
WHERE a.dni=b.dni;";
$res_p4	= mysql_query($paso_4,$connection_mysql) or die(mysql_error($paso_4));

$paso_5	="UPDATE reporte_incidencia_cot_anual a, tb_usuarios b
SET a.estado_rep=b.estado,a.supervisor=b.c_supervisor,a.ncompleto=b.ncompleto
WHERE a.dni=b.dni";
//echo $paso_5;

$res_p5	= mysql_query($paso_5,$connection_mysql) or die(mysql_error($paso_5));

$paso_6	="UPDATE reporte_incidencia_cot_anual a, tb_supervisores b
SET a.supervisor=b.nom_supervisor
WHERE a.supervisor=b.cod_supervisor";
//echo "<br>".$paso_6;

$res_p6	= mysql_query($paso_6,$connection_mysql) or die(mysql_error($paso_6));


$xmes_h    = date ("m/Y");
$paso_10	="UPDATE reporte_incidencia_cot_anual a, horario_cot_anual b
SET a.cod_horario=b.cod_horario
WHERE a.dni=b.dni AND a.xmes=b.xmes and a.cod_horario=''";
//echo $paso_5;
$res_p10	= mysql_query($paso_10,$connection_mysql) or die(mysql_error($paso_10));

$paso_11	="UPDATE reporte_incidencia_cot_anual a,horarios_rrhh b
SET a.horario=b.descripcion_1,a.f1=b.f1,a.f2=b.f2
WHERE a.cod_horario=b.cod_horario";
$res_p11	= mysql_query($paso_11,$connection_mysql) or die(mysql_error($paso_11));

//
$paso_12	="UPDATE reporte_incidencia_cot_anual 
set ejecuto='1', fec_fin_inc=concat(substr(fec_fin_inc,1,11),f2)
where modo='h' and substr(fec_fin_inc,12,5)>f2 and f2<>''";
$res_p12	= mysql_query($paso_12,$connection_mysql) or die(mysql_error($paso_12));



$paso_13	="UPDATE reporte_incidencia_cot_anual a, tb_motivos_incidencia b
SET a.motivo_incidencia=rtrim(b.nom_mot_inc)
WHERE a.motivo_incidencia=b.cod_mot_inc";
$res_p13	= mysql_query($paso_13,$connection_mysql) or die(mysql_error($paso_13));

$paso_14	="UPDATE reporte_incidencia_cot_anual SET ncompleto=REPLACE(ncompleto, ',', ''), supervisor=REPLACE(supervisor, ',', '')";
$res_p14	= mysql_query($paso_14,$connection_mysql) or die(mysql_error($paso_14));

}

function copiar_reporte_teradata(){

		$connection_teradata 	= db_conn_teradata();
		$connection_mysql 		= db_conn_mysql();

		$sql_tdata	="delete from DBI_COT.CC_COT_INCIDENCIAS";		
		
		
		$statement =odbc_exec($connection_teradata, $sql_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}



$paso_15	= "select * from reporte_incidencia_cot_anual";
$rs_paso_15 	= mysql_query($paso_15) or die(mysql_error($paso_15));

	while($rg_paso_15=mysql_fetch_row($rs_paso_15)){			
		
	
		$sql_tdata_1	="INSERT INTO DBI_COT.CC_COT_INCIDENCIAS('$rg_paso_15[0]','$rg_paso_15[1]','$rg_paso_15[2]','$rg_paso_15[3]','$rg_paso_15[4]','$rg_paso_15[5]','$rg_paso_15[6]','$rg_paso_15[7]','$rg_paso_15[8]','$rg_paso_15[10]','$rg_paso_15[11]','$rg_paso_15[14]','$rg_paso_15[16]','$rg_paso_15[17]','$rg_paso_15[18]',
'$rg_paso_15[19]','$rg_paso_15[20]','$rg_paso_15[21]','$rg_paso_15[22]','$rg_paso_15[23]','$rg_paso_15[24]','$rg_paso_15[25]',now(),
'$rg_paso_15[12]','$rg_paso_15[9]')";
		//echo "<p>".$sql_tdata_1;
		
		
		$statement_1 =odbc_exec($connection_teradata, $sql_tdata_1);
		if (!$statement_1){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
		
		
	}
}

function generar_reporte_maestra_teradata(){

		$connection_teradata 	= db_conn_teradata();
		$connection_mysql 		= db_conn_mysql();

		$sql_tdata	="delete from DBI_COT.CC_COT_MAESTRAUSUARIOS";		
		
		
		$statement =odbc_exec($connection_teradata, $sql_tdata);
		if (!$statement){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}



$paso_16	= "select * from tb_usuarios order by ncompleto";
$rs_paso_16 = mysql_query($paso_16) or die(mysql_error($paso_16));

	while($rg_paso_16=mysql_fetch_row($rs_paso_16)){	
	
			$d1 = "select * from tb_locales WHERE cod_local='$rg_paso_16[22]'";
			$res_d1 = mysql_query($d1);	
			$reg_d1=mysql_fetch_row($res_d1);	
			
			$d2 = "select * from tb_supervisores WHERE cod_supervisor='$rg_paso_16[23]'";
			$res_d2 = mysql_query($d2);	
			$reg_d2=mysql_fetch_row($res_d2);	
		
			$fec = substr($rg_paso_16[28],6,4); 
			
			if($reg_maestra[28]==""){
			$edad = 0;
			}else{
			$edad = date("Y") - $fec;
			}
	
		$sql_tdata_1	="INSERT INTO DBI_COT.CC_COT_MAESTRAUSUARIOS
		('','$rg_paso_16[3]','$rg_paso_16[3]','$rg_paso_16[3]','$rg_paso_16[3]','$rg_paso_16[3]','$rg_paso_16[3]',
		'$rg_paso_16[3]','$rg_paso_16[3]','','','','$rg_paso_16[28]','$edad','','','$rg_paso_16[37]','$rg_paso_16[37]',
		'$reg_d1[3]','$reg_d1[1]','$rg_paso_16[18]','$rg_paso_16[39]','$reg_d2[1]',now(),'$rg_paso_16[0]')";
		//echo "<p>".$sql_tdata_1;
		
		
		$statement_1 =odbc_exec($connection_teradata, $sql_tdata_1);
		if (!$statement_1){
			exit("Execution failed - ".odbc_error().":".odbc_errormsg()."\n");
		}
		
		
	}
}

 
?>
