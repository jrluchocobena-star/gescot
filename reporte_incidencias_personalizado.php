<?php
include("conexion_bd.php");
include("funciones_fechas.php");


$xmes_ = "022020";
$xmes =  "2020-02";
	
	$archivo_horario = 'L:\\\zz_InputsExternos\\\HorariosCot\\\horarios_'.$xmes_."_PER.csv";
	
	
	$sql_H0="truncate table horario_cot_mes_per";		
	$res_sql_H0 = mysql_query($sql_H0);
	
	$sql_H1="LOAD DATA LOCAL INFILE '$archivo_horario'
	INTO TABLE horario_cot_mes_per
	FIELDS TERMINATED BY ','
	LINES TERMINATED BY '\n' IGNORE 1 LINES";	
	//echo "<p>".$sql_H1;
	$res_sql_H1 = mysql_query($sql_H1);

	$sql_H1B="UPDATE horario_cot_mes_per SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10";	
	//echo "<p>".$sql_H1;
	$res_sql_H1B = mysql_query($sql_H1B) or die(mysql_error());
	$nreg_sql_H1B = mysql_num_rows($res_sql_H1B);
	
		
	$sql_H1C="UPDATE horario_cot_mes_per SET Mes='$xmes'";	
	//echo "<p>".$sql_H1C;
	$res_sql_H1C = mysql_query($sql_H1C) or die(mysql_error());
	$nreg_sql_H1C = mysql_num_rows($res_sql_H1C);
	
	$sql_H1D="UPDATE horario_cot_mes_per SET cod_horario=CONCAT('0',cod_horario) WHERE LENGTH(cod_horario)=3";	
	//echo "<p>".$sql_H1C;
	$res_sql_H1D = mysql_query($sql_H1D) or die(mysql_error());
	$nreg_sql_H1D = mysql_num_rows($res_sql_H1D);	
	
	$sql_H2	= "UPDATE horario_cot_mes_per a, tb_usuarios b
	SET a.dni=b.dni
	WHERE a.cip=b.cip";
	$result_sql_H2= mysql_query($sql_H2) or die(mysql_error($sql_H2));
	
	
	$sql_H3	= "UPDATE horario_cot_mes_per SET fecha_inicio=CONCAT('0',fecha_inicio)
	WHERE LENGTH(fecha_inicio)=9";
	$result_sql_H3	= mysql_query($sql_H3) or die(mysql_error($sql_H3));
	
	$sql_H4	= "UPDATE horario_cot_mes_per SET fecha_fin=CONCAT('0',fecha_fin)
	WHERE LENGTH(fecha_fin)=9";
	$result_sql_H4	= mysql_query($sql_H4) or die(mysql_error($sql_H4));
	
	$sql_H5	= "UPDATE horario_cot_mes_per SET 
	n_fecha_inicio=CONCAT(SUBSTR(fecha_inicio,7,4),'-',SUBSTR(fecha_inicio,4,2),'-',SUBSTR(fecha_inicio,1,2)),
	n_fecha_fin=CONCAT(SUBSTR(fecha_fin,7,4),'-',SUBSTR(fecha_fin,4,2),'-',SUBSTR(fecha_fin,1,2))";
	$result_sql_H5	= mysql_query($sql_H5) or die(mysql_error($sql_H5));
	
	
	/**************/
	
	$sql_H11	= "truncate table horarios_gestores_cot_per";
	$result_sql_H11	= mysql_query($sql_H11) or die(mysql_error($sql_H11));
	
	$sql_H12	= "INSERT INTO horarios_gestores_cot_per
	SELECT dni,cip,ncompleto,c_supervisor,sgrupo,'','','','','',''
	FROM tb_usuarios 
	WHERE estado='HABILITADO' AND grupo='COT-TDP'";
	$result_sql_H12	= mysql_query($sql_H12) or die(mysql_error($sql_H12));
	
	
	$sql_H13	= "UPDATE horarios_gestores_cot_per SET cargo='-' WHERE cargo IS NULL";
	$result_sql_H13 = mysql_query($sql_H13) or die(mysql_error($sql_H13));
	
	$sql_H14	= "UPDATE horarios_gestores_cot_per a, tb_supervisores b
	SET a.supervisor = b.nom_supervisor
	WHERE a.supervisor=b.cod_supervisor";
	$result_sql_H14 = mysql_query($sql_H14) or die(mysql_error($sql_H14));
	
	include("ejecuta_sp_per.php");
	
	$sql_H16 = "UPDATE horarios_gestores_cot_per a, horarios_personal_apoyo b
	SET a.cod_horario=b.cod_horario
	WHERE a.dni=b.dni AND a.cod_horario=''";
	//echo "\n".$rutina_inc_4a;
	$result_sql_H16	= mysql_query($sql_H16) or die(mysql_error($sql_H16));
	
	$sql_H15	= "UPDATE horarios_gestores_cot_per a, horario_cot_mes_per b
	SET a.cod_horario = b.cod_horario
	WHERE a.dni=b.dni and b.est='1'";
	//echo $rutina_inc_4;
	$result_sql_H15	= mysql_query($sql_H15) or die(mysql_error($sql_H15));
	
	
	
	$sql_H17	= "UPDATE horarios_gestores_cot_per a, horarios_cot b
	SET a.cod_horario = b.cod_horario
	WHERE a.dni=b.dni AND a.cod_horario='' and b.est='1'";
	$result_sql_H17	= mysql_query($sql_H17) or die(mysql_error($sql_H17));
	
	$sql_H18	= "UPDATE horarios_gestores_cot_per a, horarios_rrhh b
	SET a.desc_horario = b.descripcion_1,a.hor_ini=b.f1, a.hor_fin=b.f2
	WHERE a.cod_horario=b.cod_horario";
	$result_sql_H18	= mysql_query($sql_H18) or die(mysql_error($sql_H18));
	
	
	$sql_H19	= "UPDATE horarios_gestores_cot_per 
	SET dias_horario=TRIM(SUBSTRING_INDEX(TRIM(SUBSTRING_INDEX(desc_horario,'[',1)),'-',-2))";
	$result_sql_H19	= mysql_query($sql_H19) or die(mysql_error($sql_H19));
	
	$sql_H20	= "UPDATE horarios_gestores_cot_per a, cab_incidencia b
	SET a.vacaciones='SI'
	WHERE a.dni=b.dni AND b.motivo_incidencia='50' AND CURDATE() BETWEEN SUBSTR(b.fec_ini_inc,1,10) 
	AND SUBSTR(b.fec_fin_inc,1,10)";
	$result_sql_H20	= mysql_query($sql_H20) or die(mysql_error($sql_H20));
	
	$sql_H21	= "UPDATE horarios_gestores_cot_per SET cod_horario='S/H',desc_horario='SIN HORARIO ASIGNADO',
	dias_horario='SIN HORARIO ASIGNADO',hor_ini='00:00',hor_fin='00:00' WHERE cod_horario=''";
	$result_sql_H21	= mysql_query($sql_H21) or die(mysql_error($sql_H21));
	
	$sql_H22	= "UPDATE horario_cot_mes_per SET FECHA_INICIO=REPLACE(FECHA_INICIO, '/', '-'), 
	FECHA_FIN=REPLACE(FECHA_FIN, '/', '-')";
	$result_sql_H22	= mysql_query($sql_H22) or die(mysql_error($sql_H22));
	
	
//$xmes    = date ("Y-m");

$archivo = "d://compartido/data/incidencias/Reporte_Incidencias_cot_per_".$xmes.".csv";
$origen	 = "D:/compartido/data/incidencias/Reporte_Incidencias_cot_per_".$xmes.".csv";

unlink($origen);

$paso_1	 ="TRUNCATE TABLE reporte_incidencia_cot_per";
$res_p1	 = mysql_query($paso_1) or die(mysql_error($paso_1));

$paso_2	="INSERT INTO reporte_incidencia_cot_per(
SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,
tiempo,modo,c_doid,dni,dias
,SUBSTR(fec_ini_inc,1,7),'','','',''  
	FROM cab_incidencia 
	WHERE estado_inc IN('0','1') and SUBSTR(fec_ini_inc,1,7)='$xmes'
	ORDER BY fec_reg DESC
)union(SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,
tiempo,modo,c_doid,dni,dias
,SUBSTR(fec_ini_inc,1,7),'','','',''  
	FROM cab_capacitacion 
	WHERE SUBSTR(fec_ini_inc,1,7)='$xmes'	
	ORDER BY fec_reg DESC)";
//echo "<br>".$paso_2;
	
$res_p2	= mysql_query($paso_2) or die(mysql_error($paso_2));

$paso_3	="UPDATE reporte_incidencia_cot_per SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10;";
$res_p3	= mysql_query($paso_3) or die(mysql_error($paso_3));

$paso_4	="UPDATE reporte_incidencia_cot_per a, tb_usuarios b
SET a.cargo=b.sgrupo
WHERE a.dni=b.dni;";
$res_p4	= mysql_query($paso_4) or die(mysql_error($paso_4));

$paso_5	="UPDATE reporte_incidencia_cot_per a, tb_usuarios b
SET a.estado_rep=b.estado,a.supervisor=b.c_supervisor,a.ncompleto=b.ncompleto
WHERE a.dni=b.dni";
//echo $paso_5;

$res_p5	= mysql_query($paso_5) or die(mysql_error($paso_5));

$paso_6	="UPDATE reporte_incidencia_cot_per a, tb_supervisores b
SET a.supervisor=b.nom_supervisor
WHERE a.supervisor=b.cod_supervisor";
//echo "<br>".$paso_6;

$res_p6	= mysql_query($paso_6) or die(mysql_error($paso_6));


//$xmes_h    = date ("m/Y");
$paso_10	="UPDATE reporte_incidencia_cot_per a, horarios_gestores_cot_per b
SET a.cod_horario=b.cod_horario
WHERE a.dni=b.dni";
//echo $paso_5;
$res_p10	= mysql_query($paso_10) or die(mysql_error($paso_10));

$paso_11	="UPDATE reporte_incidencia_cot_per a,horarios_rrhh b
SET a.horario=b.descripcion_1,a.f1=b.f1,a.f2=b.f2
WHERE a.cod_horario=b.cod_horario";
$res_p11	= mysql_query($paso_11) or die(mysql_error($paso_11));

//
$paso_12	="UPDATE reporte_incidencia_cot_per 
set ejecuto='1', fec_fin_inc=concat(substr(fec_fin_inc,1,11),f2)
where modo='h' and substr(fec_fin_inc,12,5)>f2 and f2<>''";
$res_p12	= mysql_query($paso_12) or die(mysql_error($paso_12));


$paso_13	="UPDATE reporte_incidencia_cot_per a, tb_motivos_incidencia b
SET a.motivo_incidencia=b.nom_mot_inc
WHERE a.motivo_incidencia=b.cod_mot_inc";
$res_p13	= mysql_query($paso_13) or die(mysql_error($paso_13));

$paso_14	="UPDATE reporte_incidencia_cot_per SET ncompleto=REPLACE(ncompleto, ',', ''), supervisor=REPLACE(supervisor, ',', '')";
$res_p14	= mysql_query($paso_14) or die(mysql_error($paso_14));

/*****************************************************************************/


$lista="
(select 'ITEM','CIP','COD_HORARIO','HORARIO','H_INGRESO','H_SALIDA','FEC_REG','USU_REG','TP_INCIDENCIA','MOTIVO_INCIDENCIA','FEC_INI_INC','FEC_FIN_INC','NRO_PARTICIPANTES','COD_INCIDENCIA','EJECUTO','TIEMPO','MODO','C_DOID','DNI','DIAS','XMES','AREA','ESTADO','SUPERVISOR','NOMBRES COMPLETOS','FEC.CARGA','OBS INCIDENCIA'
)union(
SELECT id,cip,cod_horario,horario,f1,f2,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,nro_participantes,
cod_incidencia,ejecuto,tiempo,modo,c_doid,dni,dias,SUBSTR(fec_ini_inc,1,7),cargo,estado_rep,supervisor,ncompleto,now(),obs_incidencia  
FROM reporte_incidencia_cot_per 
WHERE estado_rep='HABILITADO' and cargo='BACK'
ORDER BY fec_ini_inc DESC
INTO OUTFILE '$archivo' FIELDS TERMINATED BY '|')";
//echo $lista;
$res_lista = mysql_query($lista);


/*****************************************************************************/


//$destino_1 = "k:/Incidencias_COT/Reporte_Incidencias_cot_".$xmes.".csv";
$destino_1 = "L:/zz_InputsExternos/WebGescot/Incidencias/Reporte_Incidencias_cot_per_".$xmes.".csv";

file_put_contents ($destino_1, "");

if (!copy($origen,$destino_1)) {
    echo "Error al copiar $destino_1...\n";
}
?>
