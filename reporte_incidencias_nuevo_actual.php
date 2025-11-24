<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$xmes    = date ("Y-m");
#$xmes = "2019-11";
$archivo = "d://compartido/data/incidencias/Reporte_Incidencias_cot_".$xmes.".csv";
$origen	 = "D:/compartido/data/incidencias/Reporte_Incidencias_cot_".$xmes.".csv";

unlink($origen);

$paso_1	 ="TRUNCATE TABLE Reporte_incidencia_cot";
$res_p1	 = mysql_query($paso_1) or die(mysql_error($paso_1));


$paso_2	="INSERT INTO reporte_incidencia_cot(
SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,
tiempo,modo,c_doid,dni,dias
,SUBSTR(fec_ini_inc,1,7),'','','',''  
	FROM cab_incidencia 
	WHERE SUBSTR(fec_ini_inc,1,7)='$xmes'
	AND estado_inc IN('0','1')
	ORDER BY fec_reg DESC
)union(SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,trim(motivo_incidencia),fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,
trim(tiempo),modo,c_doid,dni,dias
,SUBSTR(fec_ini_inc,1,7),'','','',''  
	FROM cab_capacitacion 
	WHERE SUBSTR(fec_ini_inc,1,7)='$xmes'	
	ORDER BY fec_reg DESC)";

$res_p2	= mysql_query($paso_2) or die(mysql_error($paso_2));

$paso_3	="UPDATE reporte_incidencia_cot SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10;";
$res_p3	= mysql_query($paso_3) or die(mysql_error($paso_3));

$paso_4	="UPDATE reporte_incidencia_cot a, tb_usuarios b
SET a.cargo=b.sgrupo
WHERE a.dni=b.dni;";
$res_p4	= mysql_query($paso_4) or die(mysql_error($paso_4));

$paso_5	="UPDATE reporte_incidencia_cot a, tb_usuarios b
SET a.estado_rep=b.estado,a.supervisor=b.c_supervisor,a.ncompleto=b.ncompleto
WHERE a.dni=b.dni";
//echo $paso_5;

$res_p5	= mysql_query($paso_5) or die(mysql_error($paso_5));

$paso_6	="UPDATE reporte_incidencia_cot a, tb_supervisores b
SET a.supervisor=b.nom_supervisor
WHERE a.supervisor=b.cod_supervisor";
//echo "<br>".$paso_6;

$res_p6	= mysql_query($paso_6) or die(mysql_error($paso_6));


$xmes_h    = date ("m/Y");
$paso_10	="UPDATE reporte_incidencia_cot a, horarios_gestores_cot b
SET a.cod_horario=b.cod_horario
WHERE a.dni=b.dni";
//echo $paso_5;
$res_p10	= mysql_query($paso_10) or die(mysql_error($paso_10));

$paso_11	="UPDATE reporte_incidencia_cot a,horarios_rrhh b
SET a.horario=b.descripcion_1,a.f1=b.f1,a.f2=b.f2
WHERE a.cod_horario=b.cod_horario";
$res_p11	= mysql_query($paso_11) or die(mysql_error($paso_11));

//
$paso_12	="UPDATE reporte_incidencia_cot 
set ejecuto='1', fec_fin_inc=concat(substr(fec_fin_inc,1,11),f2)
where modo='h' and substr(fec_fin_inc,12,5)>f2 and f2<>''";
$res_p12	= mysql_query($paso_12) or die(mysql_error($paso_12));


$paso_13	="UPDATE reporte_incidencia_cot a, tb_motivos_incidencia b
SET a.motivo_incidencia=rtrim(b.nom_mot_inc)
WHERE a.motivo_incidencia=b.cod_mot_inc";
$res_p13	= mysql_query($paso_13) or die(mysql_error($paso_13));

$paso_14	="UPDATE reporte_incidencia_cot SET ncompleto=REPLACE(ncompleto, ',', ''), supervisor=REPLACE(supervisor, ',', '')";
$res_p14	= mysql_query($paso_14) or die(mysql_error($paso_14));

/*****************************************************************************/


$lista="
(select 'ID','CIP','COD_HORARIO','HORARIO','H_INGRESO','H_SALIDA','FEC_REG','USU_REG','TP_INCIDENCIA','FEC_INI_INC','FEC_FIN_INC','COD_INCIDENCIA','TIEMPO','MODO','C_DOID','DNI','DIAS','XMES','AREA','ESTADO','SUPERVISOR','NOMBRES COMPLETOS','FECHACORTE','OBS INCIDENCIA','MOT.INCIDENCIA'
)union(
SELECT id,cip,cod_horario,horario,f1,f2,fec_reg,usu_reg,tp_incidencia,fec_ini_inc,fec_fin_inc,
cod_incidencia,trim(tiempo),modo,c_doid,dni,dias,SUBSTR(fec_ini_inc,1,7),cargo,estado_rep,supervisor,ncompleto,now(),obs_incidencia,motivo_incidencia 
FROM reporte_incidencia_cot 
WHERE cargo<>'TDP' and estado_rep='HABILITADO'
ORDER BY fec_ini_inc DESC
INTO OUTFILE '$archivo' FIELDS TERMINATED BY '|')";
//echo $lista;
$res_lista = mysql_query($lista);


/*****************************************************************************/


//$destino_1 = "k:/Incidencias_COT/Reporte_Incidencias_cot_".$xmes.".csv";
$destino_1 = "L:/zz_InputsExternos/WebGescot/Incidencias/Reporte_Incidencias_cot_".$xmes.".csv";

file_put_contents ($destino_1, "");

if (!copy($origen,$destino_1)) {
    echo "Error al copiar $destino_1...\n";
}


/*****************************************************************************/
/*
$paso_5="truncate table horarios_gestores_cot";
$res_p5	= mysql_query($paso_5);

$paso_6="INSERT INTO horarios_gestores_cot
SELECT dni,cip,ncompleto,'' AS cargo,'' AS cod_horario FROM tb_usuarios WHERE estado='HABILITADO' AND grupo='COT-TDP'";
$res_p6	= mysql_query($paso_6);

$paso_6a="UPDATE horarios_gestores_cot SET cod_horario='',cargo=''";
$res_p6a	= mysql_query($paso_6a);


$paso_7="UPDATE horarios_gestores_cot a, horario_cot_mes b
SET a.cod_horario=b.cod_horario
WHERE a.dni=b.dni";
$res_p7	= mysql_query($paso_7);

$paso_8="UPDATE horarios_gestores_cot a,tb_usuarios b
SET a.cargo=b.sgrupo
WHERE a.dni=b.dni";
$res_p8	= mysql_query($paso_8);

$paso_9="UPDATE horarios_gestores_cot a, horarios_cot b
SET a.cod_horario=b.cod_horario
WHERE a.dni=b.dni AND a.cod_horario=''";
$res_p9	= mysql_query($paso_9);
*/

?>
