<?php
include_once("conexion_w101.php");


$connection_w101	= db_conn_w101();
	

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=resultado_101.xls");

	$dato=$_GET["dni"];
	
	$listax="select * from wt_maestra_consultas order by resultado";
	//echo $listax;
	$res_lis_x = mysql_query($listax,$connection_w101);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<?php
	echo "<table width='100%' border='0' style='border-collapse:collapse'>";					
			echo "<tr>"; 
			echo "<td class='caja_texto_pekecab' width='40%'>RESULTADO</td>";																
			echo "<td class='caja_texto_pekecab' width='5%'>CELULAR</td>";	
			echo "<td class='caja_texto_pekecab' width='5%'>CARNET</td>";						
			echo "<td class='caja_texto_pekecab' width='5%'>DNI</td>";		
			echo "<td class='caja_texto_pekecab' width='40%'>NOMBRE TECNICO</td>";	
			echo "<td class='caja_texto_pekecab' width='5%'>MAESTRA.DNI</td>";				
			echo "<td class='caja_texto_pekecab' width='5%'>MAESTRA.CARNET</td>";	
			echo "<td class='caja_texto_pekecab' width='5%'>MAESTRA.CELULAR</td>";	
			echo "<td class='caja_texto_pekecab' width='5%'>MAESTRA.EECC</td>";	
			echo "<td class='caja_texto_pekecab' width='5%'>MAESTRA.ESTADOTOA</td>";	
			echo "<td class='caja_texto_pekecab' width='5%'>MAESTRA.EST_CELULAR</td>";	
			echo "<td class='caja_texto_pekecab' width='5%'>USSD101.CELULAR</td>";
			echo "<td class='caja_texto_pekecab' width='5%'>USSD101.DNI</td>";
			echo "<td class='caja_texto_pekecab' width='5%'>USSD101.CARNET</td>";
			echo "<td class='caja_texto_pekecab' width='5%'>USSD101.ESTADO</td>";
			echo "<td class='caja_texto_pekecab' width='5%'>ENCONTRO_DNI</td>";
			echo "<td class='caja_texto_pekecab' width='5%'>ENCONTRO_CARNET</td>";
			echo "<td class='caja_texto_pekecab' width='5%'>ENCONTRO_CELULAR</td>";
			echo "<td class='caja_texto_pekecab' width='5%'>ENCONTRO_101</td>";
			
			echo "</tr>";
	
	while($reg_lis_x=mysql_fetch_row($res_lis_x)){		
	

		echo "<tr>";				
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[19]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[1]; 			
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[2]; 			
		echo "</td>";	
			
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[3]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[4]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[5]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[6]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[7]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[8]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[9]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[10]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[11]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[12]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[13]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[14]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[15]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[16]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[17]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_mini'>";
		echo $reg_lis_x[18]; 				
		echo "</td>";	
		
		echo "</tr>";				
		}	
	echo "</table>";	
?>


</body>
</html>