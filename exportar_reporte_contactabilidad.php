<?php
include("conexion_bd.php");

set_time_limit(100000);

$f_actual	= date("Y");
$archivo_	="rep_contactabilidad.txt";
$n_archivo	="D://COMPARTIDO/DATA/CONTACTABILIDAD/rep_contactabilidad.txt";
$origen	 = "D:/COMPARTIDO/DATA/CONTACTABILIDAD/rep_contactabilidad.txt";

file_put_contents ($origen, "");  // LIMPIA ARCHIVO

	/******************************************************************************************************/	
	
	$cabecera="ITEM|CIP|DNI|GESTOR|FECHA|SUPERVISOR|OBSERVACION|DATO|EFECTIVIDAD|CRITERIO";	
		
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
	
	$hoy = date("Y/m/d h:m:s");
	$año = date("Y");
		
	$lista="SELECT * FROM movimiento_contactos WHERE SUBSTR(fec_mov,1,4) in ('2020','2021') GROUP BY 1";	
	$res_lis = mysql_query($lista);	
		
	while($reg_lis=mysql_fetch_row($res_lis)){	
	
			$item=$item + 1;
					
			$d1 = "select * from tb_usuarios a WHERE iduser='$reg_lis[2]'";
			$res_d1 = mysql_query($d1);	
			$reg_d1=mysql_fetch_row($res_d1);			
		
			$d2 = "select * from tb_supervisores WHERE cod_supervisor='$reg_d1[23]'";
			$res_d2 = mysql_query($d2);	
			$reg_d2=mysql_fetch_row($res_d2);	
			
			$gestor = str_replace(',', '', $reg_d1[1]);
			
			$supervisor = str_replace(',', '', $reg_d2[1]);
			
			
	$cuerpo="$item|$reg_d1[3]|$reg_d1[2]|$gestor|$reg_lis[3]|$supervisor|$reg_lis[4]|$reg_lis[7]|$reg_lis[8]|$reg_lis[9]";		
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


$destino="L:/zz_InputsExternos/WebGescot/Contactabilidad/rep_contactabilidad.txt";

file_put_contents ($destino, "");

if (!copy($origen, $destino)) {
    echo "Error al copiar $fichero...\n";
}


?>
