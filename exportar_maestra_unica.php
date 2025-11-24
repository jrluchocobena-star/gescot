<?php
include("conexion_bd.php");


$f_actual	=date("Y");
$archivo_	="maestra_usuarios_cot.txt";
$n_archivo	="D://COMPARTIDO/DATA/Maestra/maestra_usuarios_cot.txt";
$origen	 = "D:/COMPARTIDO/DATA/Maestra/maestra_usuarios_cot.txt";

file_put_contents ($origen, "");  // LIMPIA ARCHIVO

	/******************************************************************************************************/	
	
$cabecera="ITEM|CIP|DOC|DOC2|Nombre_Apellidos|DISTRIB_FISICA|1_AREA|2_SUB_AREA|3_STATUS_ACTUAL|OBS_STATUS_ACTUAL|4_GESTION_1|5_DET_GESTION1|FECHA_NAC|EDAD|Rango_Edad|Sexo|OLA_LLEGA|OLA_LLEGADA|CIUDAD|NLOCAL|Correo|CARGO_RRHH|SUPERVISOR|FECHA_CORTE|IDUSER";	
		
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
		
	$lista="select * from tb_usuarios group by dni order by dni";	
	$res_lis = mysql_query($lista);	
		
	while($reg_maestra=mysql_fetch_row($res_lis)){	
	
			$item=$item + 1;
			$det_gestion="";
			$edad = "0";	
			$rango_edad="";
			$sexo = " ";			
			$ola_="";
			$ciudad ="";
			$nlocal="";
			
			$d1 = "select * from tb_locales WHERE cod_local='$reg_maestra[22]'";
			$res_d1 = mysql_query($d1);	
			$reg_d1=mysql_fetch_row($res_d1);
			
			$d2 = "select * from tb_supervisores WHERE cod_supervisor='$reg_maestra[23]'";
			$res_d2 = mysql_query($d2);	
			$reg_d2=mysql_fetch_row($res_d2);
			
			$d3 = "select * from tb_monitores WHERE cod_monitor='$reg_maestra[24]'";
			$res_d3 = mysql_query($d3);	
			$reg_d3=mysql_fetch_row($res_d3);		
			
			$d4 = "select * from info_zuta WHERE dni='$reg_maestra[2]'";
			$res_d4 = mysql_query($d4);	
			$reg_d4=mysql_fetch_row($res_d4);			
			
			$fec = substr($reg_maestra[28],6,4); 
			
			if($reg_maestra[28]==""){
			$edad = 0;
			}else{
			$edad = date("Y") - $fec;
			}
$cuerpo="$item|$reg_maestra[3]|$reg_maestra[2]||$reg_maestra[1]|$reg_d4[7]|$reg_maestra[13]|$reg_maestra[14]|$reg_maestra[9]||||$reg_maestra[28]|$edad|$rango_edad|$reg_d4[8]|$ola_|$reg_maestra[37]|$reg_d1[3]|$reg_d1[1]|$reg_maestra[18]|$reg_maestra[39]|$reg_d2[1]|$hoy|$reg_maestra[0]";	
	
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


$destino="L:/zz_InputsExternos/WebGescot/Maestra/maestra_usuarios_cot.txt";

file_put_contents ($destino, "");

if (!copy($origen, $destino)) {
    echo "Error al copiar $fichero...\n";
}


?>
