<?php
include("conexion_bd.php");


$f_actual	=date("Y");
$archivo_	="maestra_usuarios_cot.txt";
$n_archivo	="D://COMPARTIDO/DATA/ejepen/ejepen.txt";
$origen	 = "D:/COMPARTIDO/DATA/ejepen/ejepen.txt";

file_put_contents ($origen, "");  // LIMPIA ARCHIVO

	/******************************************************************************************************/	
	
$cabecera="negocio|sit|czonal|ofadm|cdiscatv|terreno|cmdf_nodo|coddis|distrito|gzonal|jefatura|mov|prefijo|ccontr|contra2|contra|codser|codmov|codseg|desseg|ins_codcli|pet_req|orden_ot|codreq|orden_rut|nsolic|tspeedyact|tipreq|codmotv|telefono|fecreg|fecacu|fecprg|petpen|motivo_pt|fecha_cita|cumpl_cita|f_formulac|accion_age|marca|dias_reg|hrs_reg|rhrs_reg|rdia_reg|dias_bol|hrs_bol|rhrs_bol|rdia_bol|modalact|csistema|comentario|reprg|reprg_cnt|ind_paq|drp|tipdecoreq|traslados|descript|datofiltro|jefcom|jeflog|region|vsuper|ncable|nparali|nrodsa|nrocaja|npardis|nsector|npardir|nroplano|codtrtrn|codlex|codtap|codbor|spliter|ctpi|prioridad|canalvta|puntovta|fpai_reg|fpai_umov|fecprg1|min_atenua|canc_bitac|velocidad|veloc_des|pqte_|obser_can|can_peti|desmotv|detmotv|ad_speedy|seg_emp|codclasrv|desclasrv|seg_dth|zona_dig|nro_proy|duo_hfc|tipport|up_front|winback|telf1|telf2|win_telf1|win_telf2|win_telf3|tip_catv|deco_smart|ultra_wifi|nodotroba|estado_ges|cobre|dnombre|ddireccion|dias_pai|tipo_tec|tiplinea|prom_|RMA|conting|vcp|microzona|tr_bxa|webpai_fec|webpai_est|naked|facttro|producto|csitiada|remedy";	
		
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
		
	$lista="select * from ejepen_resultado";	
	$res_lis = mysql_query($lista);	
		
	while($reg_ejepen=mysql_fetch_row($res_lis)){	
	
	
			
				
	$cuerpo="$reg_maestra[0]|$reg_maestra[1]|$reg_maestra[2]|$reg_maestra[3]|$reg_maestra[4]|$reg_maestra[5]|$reg_maestra[6]|$reg_maestra[7]|$reg_maestra[8]|$reg_maestra[9]|$reg_maestra[10]|$reg_maestra[11]|$reg_maestra[12]|$reg_maestra[13]|$reg_maestra[14]|$reg_maestra[15]|$reg_maestra[16]|$reg_maestra[17]|$reg_maestra[18]|$reg_maestra[19]|$reg_maestra[20]|$reg_maestra[21]|$reg_maestra[22]|$reg_maestra[23]|$reg_maestra[24]|$reg_maestra[25]|$reg_maestra[26]|$reg_maestra[27]|$reg_maestra[28]|$reg_maestra[29]|$reg_maestra[30]|$reg_maestra[31]|$reg_maestra[32]|$reg_maestra[33]|$reg_maestra[34]|$reg_maestra[35]|$reg_maestra[36]|$reg_maestra[37]|$reg_maestra[38]|$reg_maestra[39]|$reg_maestra[40]|$reg_maestra[41]|$reg_maestra[42]|$reg_maestra[43]|$reg_maestra[44]|$reg_maestra[45]|$reg_maestra[46]|$reg_maestra[47]|$reg_maestra[48]|$reg_maestra[49]|$reg_maestra[50]|$reg_maestra[51]|$reg_maestra[52]|$reg_maestra[53]|$reg_maestra[54]|$reg_maestra[55]|$reg_maestra[56]|$reg_maestra[57]|$reg_maestra[58]|$reg_maestra[59]|$reg_maestra[60]|$reg_maestra[61]|$reg_maestra[62]|$reg_maestra[63]|$reg_maestra[64]|$reg_maestra[65]|$reg_maestra[66]|$reg_maestra[67]|$reg_maestra[68]|$reg_maestra[69]|$reg_maestra[70]|$reg_maestra[71]|$reg_maestra[72]|$reg_maestra[73]|$reg_maestra[74]|$reg_maestra[75]|$reg_maestra[76]|$reg_maestra[77]|$reg_maestra[78]|$reg_maestra[79]|$reg_maestra[80]|$reg_maestra[81]|$reg_maestra[82]|$reg_maestra[83]|$reg_maestra[84]|$reg_maestra[85]|$reg_maestra[86]|$reg_maestra[87]|$reg_maestra[88]|$reg_maestra[89]|$reg_maestra[90]|$reg_maestra[91]|$reg_maestra[92]|$reg_maestra[93]|$reg_maestra[94]|$reg_maestra[95]|$reg_maestra[96]|$reg_maestra[97]|$reg_maestra[98]|$reg_maestra[99]|$reg_maestra[100]|$reg_maestra[101]|$reg_maestra[102]|$reg_maestra[103]|$reg_maestra[104]|$reg_maestra[105]|$reg_maestra[106]|$reg_maestra[107]|$reg_maestra[108]|$reg_maestra[109]|$reg_maestra[110]|$reg_maestra[111]|$reg_maestra[112]|$reg_maestra[113]|$reg_maestra[114]|$reg_maestra[115]|$reg_maestra[116]|$reg_maestra[117]|$reg_maestra[118]|$reg_maestra[119]|$reg_maestra[120]|$reg_maestra[121]|$reg_maestra[122]|$reg_maestra[123]|$reg_maestra[124]|	$reg_maestra[125]|$reg_maestra[126]|$reg_maestra[127]|$reg_maestra[128]|$reg_maestra[129]|$reg_maestra[130]|$reg_maestra[131]";

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


$destino="L:/zz_InputsExternos/ejepen/ejepen_robot.csv";

file_put_contents ($destino, "");

if (!copy($origen, $destino)) {
    echo "Error al copiar $fichero...\n";
}


?>
