<?php

$f_actual=date("Y-m-d");
$n_archivo="rep_incidencias_cot_".$f_actual.".xls";


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);


include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$cip=trim($_GET["cip"]);
$xmes=date("Y")."-".trim($_GET["xmes"]);
$supervisor=trim($_GET["supervisor"]);

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REPORTE INCIDENCIAS COT</title>

</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>

<p>
<? 

$lista="select *,SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,fec_ini_inc, fec_fin_inc))*60) AS diferencia  
from cab_incidencia order by fec_reg desc";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1'  style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>ITEM </td>";	
			echo "<td class='fdotxttabla2'>CIP </td>";	
			echo "<td class='fdotxttabla2'>DNI </td>";														
			echo "<td class='fdotxttabla2' width='300'>TRABAJADOR </td>";												
			echo "<td class='fdotxttabla2'>FEC.REGISTRO</td>";			
			echo "<td class='fdotxttabla2'>USU.MOVIMIENTO</td>";		
			echo "<td class='fdotxttabla2'>TIPO INCIDENCIA</td>";			
			echo "<td class='fdotxttabla2'>MOTIVO INCIDENCIA</td>";		
			echo "<td class='fdotxttabla2'>FEC. INICIAL</td>";			
			echo "<td class='fdotxttabla2'>FEC. FINAL</td>";		
			echo "<td class='fdotxttabla2'>T.PERMISO</td>";			
			echo "<td class='fdotxttabla2'>OBSERVACIONES</td>";				
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td class='casilla_texto'>";
		echo $i=$i+1; 			
		echo "</td>";
		
		$c1="select * from tb_usuarios where dni='$reg_lis[15]'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		$c2="select * from tb_usuarios where iduser='$reg_lis[3]'";
		//echo $c2;
		$res_c2 = mysql_query($c2);
		$reg_c2=mysql_fetch_row($res_c2);
		
		$c3="select * from tb_motivos_incidencia where tp_inc='$reg_lis[4]' AND cod_mot_inc='$reg_lis[5]'";
		//echo $c3;
		$res_c3 = mysql_query($c3);
		$reg_c3=mysql_fetch_row($res_c3);
		
		echo "<td class='casilla_texto'>";
		echo $reg_c1[3]; 				
		echo "</td>";	
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[15]; 				
		echo "</td>";			
		
		echo "<td class='casilla_texto'>";
		echo $reg_c1[1]; 				
		echo "</td>";			
		
		echo "<td  class='casilla_texto'>";
		echo $reg_lis[2]; 			
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_c2[1]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>";
		echo $reg_lis[4]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		echo $reg_c3[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[7]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		/*if (substr($reg_lis[7],11,8)=="00:00:00"){
			$fec1=substr($reg_lis[6],0,10);
			$fec2=substr($reg_lis[7],0,10);
			$dfec=calcular_tiempo_trasnc($fec2,$fec1);
			$fec_r=explode(", ",$dfec); 
			echo $fec_r[0];
			
		}else{
			echo calcular_tiempo_($reg_lis[7],$reg_lis[6]); 				
		}
		*/
		
		echo $reg_lis[16];
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[8]; 				
		echo "</td>";
				
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>



</body>
</html>