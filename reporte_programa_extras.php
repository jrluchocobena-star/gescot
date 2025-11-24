<?php

$f_actual=date("Y-m-d");
$n_archivo="rep_incidencias_cot_".$f_actual.".xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);

include("conexion_bd.php");

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
$lista="(select dni,usu_reg,fec_reg,tp_incidencia,fec_ini_inc,tiempo,'PROGRAMACION' 
from programacion_extra order by fec_reg desc)
union
(select dni,usu_reg,fec_reg,'',fec_ini_comp,tiempo_comp,'COMPENSACION' from compensacion_extra order by fec_reg desc)";//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'  style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>DNI </td>";	
			echo "<td class='fdotxttabla2'>N.COMPLETO </td>";	
			echo "<td class='fdotxttabla2'>TIPO </td>";	
			echo "<td class='fdotxttabla2'>FEC.REGISTRO </td>";														
			echo "<td class='fdotxttabla2'>FEC.COMPENSACION </td>";												
			echo "<td class='fdotxttabla2'>TIEMPO</td>";			
			echo "<td class='fdotxttabla2'>USUARIO</td>";		
			echo "<td class='fdotxttabla2'>OBSERVACION</td>";			
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr class='alternate'>";
				
		$q="select iduser,ncompleto,c_supervisor from tb_usuarios where dni='".$reg_lis[0]."'";
		//echo $q;
		$rs_q = mysql_query($q);											
		$rg_q = mysql_fetch_row($rs_q);
		
		$usu="select ncompleto from tb_usuarios where iduser='".$reg_lis[1]."'";
		//echo $usu;
		$rs_usu = mysql_query($usu);											
		$rg_usu = mysql_fetch_row($rs_usu);
			
		/*
		echo "<td>";
		?>
        <a href="javascript:mostrar_detalle('<? echo $reg[1]; ?>')">
        <?		
		echo $reg[9]; 				
		echo "</a></td>";
		*/
		echo "<td class='caja_texto_hr'>";		
		echo $reg_lis[0]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $rg_q[1]; 				
		echo "</td>";
				
			
		echo "<td class='caja_texto_hr'>";		
		echo $reg_lis[3]; 				
		echo "</td>";
						
		echo "<td class='caja_texto_hr'>";		
		echo $reg_lis[2]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg_lis[4]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg_lis[5]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_hr'>";		
		echo $rg_usu[0]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_hr'>";		
		echo $reg_lis[6]; 						
		echo "</td>";
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>



</body>
</html>