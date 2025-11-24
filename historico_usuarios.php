<?php

include ("conexion_bd.php"); 
	
	$dato=$_GET["dni"];
	
	$listax="select * from movimiento_usuarios where dato='$dato' order by fec_mov desc";
	//echo $listax;
	$res_lis_x = mysql_query($listax);
	
	echo "<table width='80%'>";							
			echo "<tr>";					
			echo "<td class='contador' colspan='5'>HISTORICO DE MOVIMIENTOS</td>";		
			echo "</tr>";
			echo "<tr>";							
			echo "<td class='fdotxttabla' width='150'>FECHA </td>";												
			echo "<td class='fdotxttabla'>SUPERVISOR</td>";	
			echo "<td class='fdotxttabla'>USU.MOVIMIENTO</td>";						
			echo "<td class='fdotxttabla'>PROCESO</td>";		
			echo "</tr>";
	
	while($reg_lis_x=mysql_fetch_row($res_lis_x)){		
	
		$usu="select * from tb_usuarios where iduser='$reg_lis_x[2]'";
		$res_usu= mysql_query($usu);
		$reg_usu=mysql_fetch_row($res_usu);
		
		$sup="select * from tb_supervisores where cod_supervisor='$reg_usu[23]'";
//		echo $sup;
		$res_sup= mysql_query($sup);
		$reg_sup=mysql_fetch_row($res_sup);
					
		echo "<tr>";	
		
						
			
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis_x[3]; 				
		echo "</td>";			
		
		echo "<td  class='clsDataArea'>";
		echo $reg_sup[1]; 			
		echo "</td>";	
		
		echo "<td  class='clsDataArea'>";
		echo $reg_usu[1]; 			
		echo "</td>";	
			
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis_x[1]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";	
	

?>