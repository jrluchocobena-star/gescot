<?php
include("conexion_bd.php");	
	
	$lista="select cod_incidencia,fec_ini_inc,fec_fin_inc,modo,tiempo,dias
	from cab_incidencia 
	WHERE modo='d' and fec_ini_inc<>'0000-00-00 00:00:00'
	order by fec_reg desc";
	echo $lista;
	$i=0;
	$res_lis = mysql_query($lista);


	echo "<table width='100%' border='1'  style='border-collapse:collapse'>";
	echo "<tr>";
	echo "<td class='fdotxttabla2'>INI INC</td>";	
	echo "<td class='fdotxttabla2'>FIN INC</td>";	
	echo "<td class='fdotxttabla2'>TIEMPO</td>";	
	echo "<td class='fdotxttabla2'>DIAS</td>";	
	echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
						
		echo "<tr>";	
		

			echo "<td class='caja_sb'>";
			echo $reg_lis[1]; 				
			echo "</td>";
			
			echo "<td class='caja_sb'>";
			echo $reg_lis[2]; 				
			echo "</td>";
			
						
			echo "<td class='caja_sb'>";
			if ($reg_lis[3]=="h"){
				$tiempo = $reg_lis[4];	
			}else{
				$tiempo = $reg_lis[5]; 
			}
			echo $tiempo;								
			echo "</td>";
			

			/*	
			echo "<td>";
			
				
		
		
			if ($tiempo>1){
				$f1 = substr($reg_lis[1],8,2);	
						
				for($i = $f1; $i <= $tiempo; $i) {					
					echo $i; 				
				}
			}
			
			echo "</td>";	
			*/
			
		echo "</tr>";				
		}	
	echo "</table>";
?>