<?php
include("conexion_bd.php");

$anual 		= date("Y");
$f_actual	= date("Y");
$archivo_	= "RTMMPEBOGC001.txt";
$mes		= date("mY");
$n_archivo	="k://informes/001Bases/Reporte_Incidencias_anual_cot_08_09_2019_v1.txt";
//$n_archivo	="w://001Bases/Reporte_Incidencias_anual_cot_".$mes.".txt";

file_put_contents ($n_archivo, "");  // LIMPIA ARCHIVO


	/******************************************************************************************************/	
	
	$cabecera= "CIP|DNI|TRABAJADOR|COD.HORARIO|HORARIO|FEC.REGISTRO|SUPERVISOR|USU.REGISTRO|TIPO INCIDENCIA|MOTIVO INCIDENCIA|CODIGO INCIDENCIA|FEC. INICIAL|FEC. FINAL|MODO|T.PERMISO|BACK|LOCAL";	
		
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
	
	$anual = date("Y");
	$mes = date ("Y-m");
	$hoy = date ("Y-m-d");
	
	/*	
	$lista="select *,SUBSTR(fec_ini_inc,1,7)  
	from cab_incidencia 
	WHERE SUBSTR(fec_reg,1,4) ='$anual'	
	order by fec_reg desc";
	*/
	$lista="SELECT 
	id,cip,cod_horario,horario,fec_reg,usu_reg,tp_incidencia,motivo_incidencia,fec_ini_inc,fec_fin_inc,obs_incidencia,nro_participantes,cod_incidencia,ejecuto,tiempo,
	modo,c_doid,dni,dias,SUBSTR(fec_ini_inc,1,7)  
	FROM reporte_incidencia_cot 
	WHERE SUBSTR(fec_reg,1,7) IN ('2019-09','2019-08')
	ORDER BY fec_reg DESC";
	
	echo $lista;	
	
	$res_lis = mysql_query($lista);	
	
	
	
	while($reg_lis=mysql_fetch_row($res_lis)){	
		 
		//TRABAJADOR 
		$c1="select * from tb_usuarios where dni='$reg_lis[17]'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		//USU_MOVIMIENTO
		$c2="select * from tb_usuarios where iduser='$reg_lis[5]'";
		//echo $c2;
		$res_c2 = mysql_query($c2);
		$reg_c2=mysql_fetch_row($res_c2);
		
		$c3="select * from tb_motivos_incidencia where cod_mot_inc='$reg_lis[7]'";
		//echo $c3;
		$res_c3 = mysql_query($c3);
		$reg_c3=mysql_fetch_row($res_c3);
		
		$c4="select * from tb_supervisores where cod_supervisor='$reg_c2[25]'";
		//echo $c3;
		$res_c4 = mysql_query($c4);
		$reg_c4=mysql_fetch_row($res_c4);
		
		if ($reg_lis[15]=="H"){
			$tiempo = $reg_lis[14];
		}else{
			$tiempo = $reg_lis[18];
		}
		
		$f_reg		=substr($reg_lis[4],0,10);
		$f_ini_inc	=substr($reg_lis[8],0,10);
		$f_fin_inc	=substr($reg_lis[9],0,10);
		
				
	$cuerpo="$reg_c1[3]|$reg_lis[17]|$reg_c1[1]|$reg_lis[3]|$reg_lis[4]|$f_reg|$reg_c2[1]|$reg_c2[1]|$reg_lis[4]|$reg_c3[1]|$reg_lis[12]|$f_ini_inc|$f_fin_inc|$reg_lis[15]|$tiempo|$reg_c2[14]|$reg_c2[22]";	
	
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
		$ruta="//gppesplcli1235/GES_COT_2018/Informes/001CotInsidencias/RTMMPEBOGC001.txt";
		
		$sql="insert into log_exportaciones values('','$ruta',now(),'156','PROCESO AUTOMATICO PARA EXPORTAR EL ARCHIVO $archivo_' )";
		//echo $c1;
		$res_sql = mysql_query($sql);	

	

?>
