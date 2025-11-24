<?php
include("conexion_bd.php");

set_time_limit(20000);

$f_actual	=date("Y");
$archivo_	="maestra_usuarios_cot_mov.txt";
$n_archivo	="D://COMPARTIDO/DATA/Maestra/maestra_usuarios_cot_mov.txt";
$origen	="D:/COMPARTIDO/DATA/Maestra/maestra_usuarios_cot_mov.txt";

file_put_contents ($origen, "");  // LIMPIA ARCHIVO

	/******************************************************************************************************/	
	
$cabecera="ITEM|CIP|DOC|DOC2|Nombre_Apellidos|DISTRIB_FISICA|1_AREA|2_SUB_AREA|3_STATUS_ACTUAL|OBS_STATUS_ACTUAL|4_GESTION_1|5_DET_GESTION1|FECHA_NAC|EDAD|Rango_Edad|Sexo|OLA_LLEGA|OLA_LLEGADA|Ciudad|NLOCAL|Correo|Nombre_Supervisor|Monitor_Responsable|USUARIO|APLICATIVO|FEC.MOV|FEC_INI|FEC_FIN|USU_MOV|EST_USU_APLI|CARGO_RRHH|USU_MOV";	
		
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
	
	$hoy = date("Y-m-d");
		
	$lista="(SELECT * FROM movimientos_maestra GROUP BY dni,aplicativo)UNION(SELECT * FROM historico_usuarios_maestra GROUP BY dni,aplicativo) ORDER BY dni,aplicativo ";	
	$res_lis = mysql_query($lista);	
		
	while($reg_lis=mysql_fetch_row($res_lis)){	
	
			$item=$item + 1;
			$det_gestion="";
			$edad = "0";	
			$rango_edad="";
			$sexo = " ";			
			$ola_="";
			$ciudad ="";
			$nlocal="";
			
			$d4 = "select * from tb_usuarios WHERE dni='$reg_lis[1]'";
			$res_d4 = mysql_query($d4);	
			$reg_d4=mysql_fetch_row($res_d4);
			
			$d1 = "select * from tb_locales WHERE cod_local='$reg_d4[22]'";
			$res_d1 = mysql_query($d1);	
			$reg_d1=mysql_fetch_row($res_d1);
			
			$d2 = "select * from tb_supervisores WHERE cod_supervisor='$reg_d4[23]'";
			$res_d2 = mysql_query($d2);	
			$reg_d2=mysql_fetch_row($res_d2);
			
			$d3 = "select * from tb_monitores WHERE cod_monitor='$reg_d4[24]'";
			$res_d3 = mysql_query($d3);	
			$reg_d3=mysql_fetch_row($res_d3);			
			
			$d5 = "select * from maestra_zuta_0819 WHERE doc='$reg_d4[2]'";
			$res_d5 = mysql_query($d5);	
			$reg_d5=mysql_fetch_row($res_d5);
			
			$d6 = "select * from tb_usuarios WHERE iduser='$reg_lis[8]'";
			$res_d6 = mysql_query($d6);	
			$reg_d6=mysql_fetch_row($res_d6);
			
			$fec = substr($reg_d4[28],6,4); 
			
			if($reg_d4[28]==""){
			$edad = 0;
			}else{
			$edad = date("Y") - $fec;
			}
			
				
	$cuerpo="$item|$reg_d4[3]|$reg_lis[1]|-|$reg_d4[1]|-|$reg_d4[13]|$reg_d4[14]|$reg_d4[9]|-|-|$reg_d4[12]|$reg_d4[28]|$edad|$rango_edad|$reg_d5[15]|$ola_|$reg_d4[37]|$reg_d5[18]|$reg_d1[1]|$reg_d4[18]|$reg_d2[1]|$reg_d3[1]|$reg_lis[2]|$reg_lis[3]|$reg_lis[5]|$reg_lis[6]|$reg_lis[7]|$reg_d6[1]|$reg_lis[10]|$reg_d4[39]|$reg_d4[0]";	
	
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
//$destino="k:/Informes/Maestra/maestra_usuarios_cot_mov.txt";

$destino="L:/zz_InputsExternos/WebGescot/Maestra/maestra_usuarios_cot_mov.txt";


file_put_contents ($destino, "");

if (!copy($origen, $destino)) {
    echo "Error al copiar $fichero...\n";
}

echo "PROCESO TERMINADO";
?>
