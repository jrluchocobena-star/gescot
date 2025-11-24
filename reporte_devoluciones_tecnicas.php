<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="rep_devoluciones_tecnicas_".$hoy.".xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);

$iduser=$_GET["iduser"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<p>
<? 

$lista="select * from tabla_devueltas";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
		echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
		echo"<td>Fuente</td>";
		echo"<td>base</td>";
		echo"<td>gestion</td>";
		echo"<td>zona</td>";
		echo"<td>jef</td>";
		echo"<td>petreq</td>";
		echo"<td>mov</td>";
		echo"<td>motivopt</td>";
		echo"<td>desmotv</td>";
		echo"<td>contra</td>";
		echo"<td>detmotv</td>";
		echo"<td>actividad</td>";
		echo"<td>des_mot</td>";
		echo"<td>det_mot</td>";
		echo"<td>nomb_tco</td>";
		echo"<td>cipte</td>";
		echo"<td>area</td>";
		echo"<td>eecc</td>";
		echo"<td>tematico1</td>";
		echo"<td>tematico2</td>";
		echo"<td>tematico3</td>";
		echo"<td>tematico4</td>";
		echo"<td>obsgest</td>";
		echo"<td>f_carga</td>";
		echo"<td>f_sms</td>";
		echo"<td>f_gestion</td>";
		echo"<td>f_bloqueo</td>";
		echo"<td>situa</td>";
		echo"<td>us</td>";
		echo"<td>Situacion_z</td>";
		echo"<td>ANIO_CARGA</td>";
		echo"<td>MES_CARGA</td>";
		echo"<td>DIA_CARGA</td>";
		echo"<td>HORA_MINUTO_CARGA</td>";
		echo"<td>HORA_CARGA</td>";
		echo"<td>ANIO_BLOQUEO</td>";
		echo"<td>MES_BLOQUEO</td>";
		echo"<td>DIA_BLOQUEO</td>";
		echo"<td>HORA_MINUTO_BLOQUEO</td>";
		echo"<td>HORA_BLOQUEO</td>";
		echo"<td>ANIO_GESTION</td>";
		echo"<td>MES_GESTION</td>";
		echo"<td>DIA_GESTION</td>";
		echo"<td>HORA_MINUTO_GESTION</td>";
		echo"<td>HORA_GESTION</td>";
		echo"<td>OBSERVACION</td>";
		echo"<td>MINUTOS_FC_FG</td>";
		echo"<td>Deta_dia_Carga</td>";
		echo"<td>Deta_dia_Gestion</td>";
		echo"<td>TIEMPO_ATENCION_ONLINE_FC_FG</td>";
		echo"<td>MOTIVO</td>";
		echo"<td>EECC_OK</td>";
		echo"<td>SEMANA_CALC_FC</td>";
		echo"<td>MES_CALC_FC</td>";
		echo"<td>SEMANA_CALC_FG</td>";
		echo"<td>MES_CALC_FG</td>";
		echo"<td>Mov_Total</td>";
		echo"<td>responsable</td>";
		echo"<td>resultado</td>";
		echo"<td>casuistica</td>";
		echo"<td>FECREG</td>";

		echo "</tr>";
	
		while($reg_lis=mysql_fetch_row($res_lis)){	
			
		echo"<td>$reg_lis[0]</td>";	
		echo"<td>$reg_lis[1]</td>";
		echo"<td>$reg_lis[2]</td>";
		echo"<td>$reg_lis[3]</td>";
		echo"<td>$reg_lis[4]</td>";
		echo"<td>$reg_lis[5]</td>";
		echo"<td>$reg_lis[6]</td>";
		echo"<td>$reg_lis[7]</td>";
		echo"<td>$reg_lis[8]</td>";
		echo"<td>$reg_lis[9]</td>";
		echo"<td>$reg_lis[10]</td>";
		echo"<td>$reg_lis[11]</td>";
		echo"<td>$reg_lis[12]</td>";
		echo"<td>$reg_lis[13]</td>";
		echo"<td>$reg_lis[14]</td>";
		echo"<td>$reg_lis[15]</td>";
		echo"<td>$reg_lis[16]</td>";
		echo"<td>$reg_lis[17]</td>";
		echo"<td>$reg_lis[18]</td>";
		echo"<td>$reg_lis[19]</td>";
		echo"<td>$reg_lis[20]</td>";
		echo"<td>$reg_lis[21]</td>";
		echo"<td>$reg_lis[22]</td>";
		echo"<td>$reg_lis[23]</td>";
		echo"<td>$reg_lis[24]</td>";
		echo"<td>$reg_lis[25]</td>";
		echo"<td>$reg_lis[26]</td>";
		echo"<td>$reg_lis[27]</td>";
		echo"<td>$reg_lis[28]</td>";
		echo"<td>$reg_lis[29]</td>";
		echo"<td>$reg_lis[30]</td>";
		echo"<td>$reg_lis[31]</td>";
		echo"<td>$reg_lis[32]</td>";
		echo"<td>$reg_lis[33]</td>";
		echo"<td>$reg_lis[34]</td>";
		echo"<td>$reg_lis[35]</td>";
		echo"<td>$reg_lis[36]</td>";
		echo"<td>$reg_lis[37]</td>";
		echo"<td>$reg_lis[38]</td>";
		echo"<td>$reg_lis[39]</td>";
		echo"<td>$reg_lis[40]</td>";
		echo"<td>$reg_lis[41]</td>";
		echo"<td>$reg_lis[42]</td>";
		echo"<td>$reg_lis[43]</td>";
		echo"<td>$reg_lis[44]</td>";
		echo"<td>$reg_lis[45]</td>";
		echo"<td>$reg_lis[46]</td>";
		echo"<td>$reg_lis[47]</td>";
		echo"<td>$reg_lis[48]</td>";
		echo"<td>$reg_lis[49]</td>";
		echo"<td>$reg_lis[50]</td>";
		echo"<td>$reg_lis[51]</td>";
		echo"<td>$reg_lis[52]</td>";
		echo"<td>$reg_lis[53]</td>";
		echo"<td>$reg_lis[54]</td>";
		echo"<td>$reg_lis[55]</td>";
		echo"<td>$reg_lis[56]</td>";
		echo"<td>$reg_lis[57]</td>";
		echo"<td>$reg_lis[58]</td>";
		echo"<td>$reg_lis[59]</td>";
		echo"<td>$reg_lis[60]</td>";
		echo"<td>$reg_lis[61]</td>";


	
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>
