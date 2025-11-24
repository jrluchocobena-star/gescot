<link href="../estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"> 
function exportar_101(){
	var win=null;
	var url="../exportar_consultas_101.php";
	win=window.open(url,true);
}

</script>

<?php
include_once("../conexion_w101.php");


$connection_w101	= db_conn_w101();
	
	$dato=$_GET["dni"];
	
	$listax="select * from wt_maestra_consultas order by resultado";
	//echo $listax;
	$res_lis_x = mysql_query($listax,$connection_w101);
	
	echo "<table width='100%' border='0' style='border-collapse:collapse'>";
			echo "<tr >"; 
			echo "<td colspan='22' class='caja_texto_pe' onclick='javascript:exportar_101();'>
			<img src='../image/EXCELES.JPG' width='30' height='30' border='0' />Exportar</td>";
			echo "</tr>";					
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