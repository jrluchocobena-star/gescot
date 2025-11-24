<?php

include ("conexion_bd.php"); 
	
	$dato=$_GET["dni"];
	
	$listax="select * from movimiento_contactos where dato='$dato' order by fec_mov desc";
	//echo $listax;
	$res_lis_x = mysql_query($listax);
	
	echo "<table width='100%' align='center'>";							
			echo "<tr>";					
			echo "<td class='clsHoliDayCell' colspan='5'>&nbsp;</td>";		
			echo "</tr>";			
			echo "<tr>";							
			echo "<td class='caja_texto_VERDE' width='150'>FECHA </td>";												
			echo "<td class='caja_texto_VERDE'>SUPERVISOR</td>";	
			echo "<td class='caja_texto_VERDE'>USU.MOVIMIENTO</td>";						
			echo "<td class='caja_texto_VERDE'>PROCESO</td>";		
			echo "</tr>";
	
	while($reg_lis_x=mysql_fetch_row($res_lis_x)){		
	
		$usu="select * from tb_usuarios where iduser='$reg_lis_x[2]'";
		$res_usu= mysql_query($usu);
		$reg_usu=mysql_fetch_row($res_usu);
		
		$sup="select * from tb_supervisores where cod_supervisor='$reg_usu[23]'";
		//echo $sup;
		$res_sup= mysql_query($sup);
		$reg_sup=mysql_fetch_row($res_sup);
					
		echo "<tr>";					
			
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_lis_x[3]; 				
		echo "</td>";			
		
		echo "<td  class='caja_texto_pe'>";
		echo $reg_sup[1]; 			
		echo "</td>";	
		
		echo "<td  class='caja_texto_pe'>";
		echo $reg_usu[1]; 			
		echo "</td>";	
			
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_lis_x[1]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";	
	

?>