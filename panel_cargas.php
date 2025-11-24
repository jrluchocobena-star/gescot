
<? 
include("conexion_bd.php");
include("funciones_fechas.php");

$accion=$_GET["accion"];
$iduser=$_GET["iduser"];


	$origen=$_GET["origen"];
	
	if ($origen=="G423"){
	
		$ss_2	= "SELECT origen,COUNT(*) FROM carga_pedidos_total GROUP BY 1 ORDER BY 1 ";
		$res_ss_2 	= mysql_query($ss_2);		
		
		echo "<table width='50%'>";				
			echo "<tr>";								
			echo "<td class='txtlabel' width='15%'>ORIGEN </td>";	
			echo "<td class='txtlabel' width='10%'>REGISTROS</td>";	
			echo "<td class='txtlabel' width='10%'> </td>";															
			echo "</tr>";
	
		while($reg_ss_2 = mysql_fetch_row($res_ss_2)){		
		
		echo "<tr>";			
						
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss_2[0]; 			
		echo "</td>";	
				
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss_2[1]; 			
		echo "</td>";
		
		echo "<td class='caja_texto1_n'>";
		echo "<img src='image/semaforo_v.JPG' width='20' height='20'>";		
		echo "</td>";		
		
		echo "</tr>";	
		
		$tot = 	$tot + $reg_ss_2[1]; 					
		}
		
		echo "<tr>";		
		echo "<td class='caja_texto1_n'>";
		echo "TOTAL"; 			
		echo "</td>";	
		echo "<td class='caja_texto1_n'>";
		echo $tot; 			
		echo "</td>";	
		echo "</tr>";	
		
	echo "</table>";	
	

	/**************************************************************************/
	echo "<br>";	
			
			$ss_1	= "SELECT origen,estado,COUNT(*) FROM carga_pedidos_total GROUP BY 1,2 ORDER BY 1 ";
			//echo $ss_1;
			
			$res_ss_1 	= mysql_query($ss_1);		
			
			echo "<table width='50%'>";				
			echo "<tr>";								
			echo "<td class='txtlabel' width='15%'>ORIGEN </td>";	
			echo "<td class='txtlabel' width='15%'>ESTADO </td>";	
			echo "<td class='txtlabel' width='10%'>REGISTROS</td>";															
			echo "</tr>";
	
			while($reg_ss_1=mysql_fetch_row($res_ss_1)){		
			
			$cc1			="select * from tb_estados_asignacion where cod_estado=$reg_ss_1[1]";		
			$res_cc1 		= mysql_query($cc1);			
			$reg_cc1		=mysql_fetch_row($res_cc1);
			
			echo "<tr>";			
							
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss_1[0]; 			
			echo "</td>";	
					
			echo "<td class='caja_texto1_n'>";
			echo $reg_cc1[1]; 			
			echo "</td>";	
			
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss_1[2]; 			
			echo "</td>";	
			
			echo "</tr>";		
					
			}	
		echo "</table>";	
		
	
	/**************************************************************************/
	
	echo "<br>";		
	$ss		= "SELECT * FROM origen_zonal ORDER BY zonal";	
	$res_ss 	= mysql_query($ss);		
	
	echo "<table width='50%'>";				
			echo "<tr>";					
			echo "<td class='txtlabel' width='15%'>ZONAL</td>";		
			echo "<td class='txtlabel' width='15%'>ORIGEN </td>";	
			echo "<td class='txtlabel' width='15%'>ESTADO </td>";	
			echo "<td class='txtlabel' width='10%'>REGISTROS</td>";															
			echo "</tr>";
	
	while($reg_ss=mysql_fetch_row($res_ss)){		
		
		$cc			="select * from tb_estados_asignacion where cod_estado=$reg_ss[2]";		
		$res_cc 	= mysql_query($cc);			
		$reg_cc		=mysql_fetch_row($res_cc);
		
		echo "<tr>";			
						
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss[0]; 			
		echo "</td>";	
		
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss[1]; 			
		echo "</td>";	
		
		echo "<td class='caja_texto1_n'>";
		echo $reg_cc[1]; 			
		echo "</td>";	
		
		echo "<td class='caja_texto1_n'>";
		echo $reg_ss[3]; 			
		echo "</td>";	
		
		echo "</tr>";		
				
		}	
	echo "</table>";	
		
	
		
	}else{
		
		echo "<br>";		
		$ss		= "SELECT 'CARGA GESTEL 47D',SUBSTR(fecha,1,10),COUNT(*) FROM gestel_47d GROUP BY 2 order by 2 desc";	
		//echo $ss;
		
		$res_ss 	= mysql_query($ss);		
		
		echo "<table width='50%'>";				
				echo "<tr>";					
				echo "<td class='txtlabel' width='15%'>PROCESO</td>";		
				echo "<td class='txtlabel' width='15%'>FECHA </td>";	
				echo "<td class='txtlabel' width='10%'>REGISTROS</td>";															
				echo "</tr>";
		
		while($reg_ss=mysql_fetch_row($res_ss)){		
			
			echo "<tr>";			
							
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss[0]; 			
			echo "</td>";	
			
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss[1]; 			
			echo "</td>";	
			
			echo "<td class='caja_texto1_n'>";
			echo $reg_ss[2]; 			
			echo "</td>";	
			
		
			echo "</tr>";		
					
			}	
		echo "</table>";
	}


?>