<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$xmes    = date ("Y-m");
$archivo = "d://compartido/data/incidencias/Reporte_Incidencias_cot_".$xmes.".csv";

$origen	 = "D:/compartido/data/incidencias/Reporte_Incidencias_cot_".$xmes.".csv";

unlink($origen);

$paso_1	 ="TRUNCATE TABLE Reporte_incidencia_cot";
$res_p1	 = mysql_query($paso_1);

$paso_2	="INSERT INTO reporte_incidencia_cot(
SELECT id,TRIM(cip),'' AS cod_horario,'' AS horario,'','',fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,c_doid,dni,dias
,SUBSTR(fec_ini_inc,1,7),''  
	FROM cab_incidencia 
	WHERE SUBSTR(fec_reg,1,7)='$xmes'
	ORDER BY fec_reg DESC
)UNION(
SELECT id,TRIM(cip),'','','','',fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,modo,c_doid,dni,dias
,SUBSTR(fec_ini_inc,1,7),''  
	FROM cab_capacitacion 
	WHERE SUBSTR(fec_reg,1,7)='$xmes'
	ORDER BY fec_reg DESC)";

//echo $paso_2;
$res_p2	= mysql_query($paso_2);


$paso_3_	="UPDATE reporte_incidencia_cot SET cip=trim(cip),dni=trim(dni),obs_incidencia=trim(obs_incidencia)";
$res_p3_	= mysql_query($paso_3_);

$paso_3	="UPDATE reporte_incidencia_cot SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10";
$res_p3	= mysql_query($paso_3);


$paso_4	="UPDATE reporte_incidencia_cot a, tb_usuarios b
SET a.cargo=b.sgrupo
WHERE a.dni=b.dni;";
$res_p4	= mysql_query($paso_4);


$paso_3a	="UPDATE reporte_incidencia_cot set cargo='-' where cargo is null or cargo=''";
$res_p3a	= mysql_query($paso_3a);


$xmes_h    = date ("m/Y");
$paso_5	="UPDATE reporte_incidencia_cot a, horarios_cot b, horarios_rrhh c 
SET a.cod_horario=b.cod_horario 
WHERE a.cip=b.cip AND b.cod_horario=c.cod_horario
AND c.tipo_horario<>'Verano'";
//echo $paso_5;
$res_p5	= mysql_query($paso_5);

$paso_6	="UPDATE reporte_incidencia_cot a,horarios_rrhh b
SET a.horario=b.descripcion_1,a.f1=b.f1,a.f2=b.f2
WHERE a.cod_horario=b.cod_horario";
$res_p6	= mysql_query($paso_6);


$paso_7	="UPDATE reporte_incidencia_cot 
SET ejecuto='1',fec_fin_inc=CONCAT(SUBSTR(fec_fin_inc,1,11),f2)
WHERE modo ='h' AND SUBSTR(fec_fin_inc,12,5)>f2 AND f2<>''";
$res_p7	= mysql_query($paso_7);



$lista="
(select 'ID','CIP','COD_HORARIO','HORARIO','H.INGRESO','H.SALIDA','FEC_REG','USU_REG','TP_INCIDENCIA','MOTIVO_INCIDENCIA','FEC_INI_INC','FEC_FIN_INC','OBS_INCIDENCIA','NRO_PARTICIPANTES','COD_INCIDENCIA','EJECUTO','TIEMPO','MODO','C_DOID','DNI','DIAS','XMES'
)union(
SELECT 
	id,cip,cod_horario,horario,f1,f2,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,
	modo,c_doid,dni,dias,SUBSTR(fec_ini_inc,1,7)  
	FROM reporte_incidencia_cot 
	WHERE SUBSTR(fec_reg,1,7)='$xmes'
	ORDER BY fec_reg DESC
	INTO OUTFILE '$archivo' FIELDS TERMINATED BY '|')";
//echo $lista;
$res_lista = mysql_query($lista);





$destino = "k:/Informes/001Bases/Reporte_Incidencias_cot_".$xmes.".csv";

file_put_contents ($destino, "");

if (!copy($origen,$destino)) {
    echo "Error al copiar $fichero...\n";
}


?>
