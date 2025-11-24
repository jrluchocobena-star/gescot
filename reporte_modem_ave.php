<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="REPORTE_MODEM_AVERIADOS_".$hoy.".xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);

$iduser	=$_GET["iduser"];
$xmes	=$_GET["xmes"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<p>
<? 

$lista="SELECT a.*,b.dpto,b.contrata 
FROM cab_modem_averiados a, deta_modem_averiados b
WHERE a.c_averia=b.c_averia
GROUP BY a.c_averia";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
			echo "<td >ITEM</td>";	
			echo "<td >COD.AVERIA</td>";
			echo "<td >USUARIO</td>";
			echo "<td >FEC.REGISTRO</td>";
			echo "<td >TIPO</td>";
			echo "<td >ESTADO</td>";
			echo "<td >DEPARTAMENTO</td>";
			echo "<td >CONTRATA</td>";			
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
	
		$d="select ncompleto from tb_usuarios where iduser='".$reg_lis[2]."'";
		//echo $q;
		$rs_d = mysql_query($d);											
		$rg_d = mysql_fetch_row($rs_d);
					
		echo "<tr>";	
		
		echo "<td  class='caja_textop'>"; //item
		echo $i=$i+1; 			
		echo "</td>";
						
		echo "<td  class='caja_textop'>"; // 
		echo $reg_lis[1]; 			
		echo "</td>";		
		
		echo "<td class='casilla_texto'>"; //
		echo $rg_d[0]; 				
		echo "</td>";			
		
		
		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[3]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[4]; 				
		echo "</td>";
		 
		echo "<td class='casilla_texto'>"; // 
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[7]; 				
		echo "</td>";
		


		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>