<link href="estilos.css" rel="stylesheet" type="text/css">
<?
include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$c_inc=$_GET["c_inc"];
$gestor=$_GET["gestor"];
$fec_i=$_GET["fec_i"];
$fec_f=$_GET["fec_f"];
$u_reg=$_GET["u_reg"];

if ($gestor<>"0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0"){	

	$lista="(
	SELECT a.dni,b.ncompleto,SUBSTR(a.fec_ini_inc,1,7) AS xmes,modo,
	SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo))),SUM(a.dias)
	FROM cab_incidencia a, tb_usuarios b
	WHERE a.dni=b.dni AND a.tp_incidencia not in('INCIDENCIAS DE SISTEMAS','MONITOREO Y CAPACITACION COT') 
	and a.dni='$gestor' 
	GROUP BY 1,2,3 order by a.fec_ini_inc desc
	)union(
	SELECT a.dni,b.ncompleto,SUBSTR(a.fec_ini_inc,1,7) AS xmes,modo,
	SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo))),SUM(a.dias)
	FROM cab_incidencia_2018 a, tb_usuarios b
	WHERE a.dni=b.dni AND a.tp_incidencia not in('INCIDENCIAS DE SISTEMAS','MONITOREO Y CAPACITACION COT') 
	and a.dni='$gestor' 
	GROUP BY 1,2,3 order by a.fec_ini_inc desc	
	)";
		
}else{		

	$lista="(
	SELECT a.dni,b.ncompleto,SUBSTR(a.fec_ini_inc,1,7) AS xmes,modo,
	SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo))),SUM(a.dias)
	FROM cab_incidencia a, tb_usuarios b
	WHERE a.dni=b.dni AND a.tp_incidencia not in('INCIDENCIAS DE SISTEMAS','MONITOREO Y CAPACITACION COT')  
	and a.dni='$gestor' 
	and  a.fec_ini_inc BETWEEN '$fec_i' AND '$fec_f' 
	GROUP BY 1,2,3 order by a.fec_ini_inc desc
	)union(
	SELECT a.dni,b.ncompleto,SUBSTR(a.fec_ini_inc,1,7) AS xmes,modo,
	SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo))),SUM(a.dias)
	FROM cab_incidencia_2018 a, tb_usuarios b
	WHERE a.dni=b.dni AND a.tp_incidencia not in('INCIDENCIAS DE SISTEMAS','MONITOREO Y CAPACITACION COT') 	
	GROUP BY 1,2,3 order by a.fec_ini_inc desc
	)";
	
}
//echo $lista;

$res_lista = mysql_query($lista);
			
echo "<input name='dni_' type='hidden' id='dni_'>"; 				

			echo "<table width='80%'>";	
				
				echo "<tr>";					
					echo "<td class='caja_texto_db' width='10%'>DNI</td>";
					echo "<td class='caja_texto_db' width='30%'>NCOMPLETO</td>";
					echo "<td class='caja_texto_db' width='10%'>MES</td>";					
					echo "<td class='caja_texto_db' width='5%'  align='center' >MODO</td>";	
					echo "<td class='caja_texto_db' colspan='2'  align='center' >TIEMPO</td>";							
				echo "</tr>";									
				
				while($reg_lista=mysql_fetch_row($res_lista)){			
								
					echo "<tr>";					
					
					
					echo "<td  class='TitTablaI' width='12%'>"; //
					echo $reg_lista[0]; 			
					echo "</td>";
					
					
					echo "<td  class='TitTablaI' width='12%'>"; //
					echo $reg_lista[1]; 		
					echo "</td>";	
				
					
					echo "<td  class='TitTablaI' width='12%'>"; //
					echo $reg_lista[2]; 
					echo "</td>";	
					
					echo "<td  class='TitTablaI' width='12%'  align='center'>"; //
					echo $reg_lista[3]; 
					echo "</td>";	
					
					if ($reg_lista[3]=="H"){					
					echo "<td  class='TitTablaI' width='12%'  align='center'>";//
					echo $reg_lista[4]; 			
					echo "</td>";
					echo "<td  class='TitTablaI'>(HH:mm:ss)</td>";						
					}else{
					echo "<td  class='TitTablaI' width='12%' align='center'>";//
					echo $reg_lista[5];		
					echo "</td>";						 
					echo "<td  class='TitTablaI' width='12%'>dias</td>";	
					}
					/*	
					
					if ($reg_lista[3]=="H"){
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[4]; 			
						echo "</td>";
						echo "<td  class='TitTablaI'>(HH:mm:ss)</td>";						
						
					}else{
						echo "<td  class='TitTablaI' width='12%'>";//
						echo $reg_lista[5];		
						echo "</td>";						 
						echo "<td  class='TitTablaI' width='12%'>dias</td>";			
					}
					
					*/
					
					echo "</tr>";				
					}	
			echo "</table>";

?>

