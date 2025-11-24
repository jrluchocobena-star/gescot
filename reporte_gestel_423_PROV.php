<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="gestel_423_".$hoy.".xls";

//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=".$n_archivo);

$iduser=$_GET["iduser"];
$xmes=$_GET["xmes"]."/".date("y");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<p>
<? 

$lista="select CIUDAD,PEDIDO,INSCRIPCION,DIRECCION,DISTRITO,PROMOCION,GRUPO,NRO_REF,FECHA_REG,TIPO_SERVICIO,PRIORIDAD,OFIC_COM,PETICION,
			AGRUPACION,CLIENTE,CUENTA,PC,NEGOCIO,PREFIJO,SEGMENTO,CANTIDAD,SUB_SEGMENTO,IRIS,DIRECCION_ANTIGUA,SECTOR,MANZANA,COORD_X,COORD_Y,zonal 
			from tb_gestel_423_PROV where SUBSTR(fecha_reg,4,5)='$xmes' order by fecha_reg";
echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
			echo "<td >ITEM</td>";	
			echo "<td >CIUDAD</td>";
			echo "<td >PEDIDO</td>";
			echo "<td >INSCRIPCION</td>";
			echo "<td >DIRECCION</td>";
			echo "<td >DISTRITO</td>";
			echo "<td >PROMOCION</td>";
			echo "<td >GRUPO</td>";
			echo "<td >NRO_REF</td>";
			echo "<td >FECHA_REG</td>";
			echo "<td >TIPO_SERVICIO</td>";
			echo "<td >PRIORIDAD</td>";
			echo "<td >OFIC_COM</td>";
			echo "<td >PETICION</td>";
			echo "<td >AGRUPACION</td>";
			echo "<td >CLIENTE</td>";
			echo "<td >CUENTA</td>";
			echo "<td >PC</td>";
			echo "<td >NEGOCIO</td>";
			echo "<td >PREFIJO</td>";
			echo "<td >SEGMENTO</td>";
			echo "<td >CANTIDAD</td>";
			echo "<td >SUB_SEGMENTO</td>";
			echo "<td >IRIS</td>";
			echo "<td >DIRECCION_ANTIGUA</td>";
			echo "<td >SECTOR</td>";
			echo "<td >MANZANA</td>";
			echo "<td >COORD_X</td>";
			echo "<td >COORD_Y</td>";
			echo "<td >ZONAL</td>";					

			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='caja_textop'>";
		echo $i=$i+1; 			
		echo "</td>";
						
		echo "<td  class='caja_textop'>";
		echo $reg_lis[0]; 			
		echo "</td>";		
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[1]; 				
		echo "</td>";			
		
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[2]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>";
		echo $reg_lis[3]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		echo $reg_lis[4]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[8]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[9]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[10]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		echo $reg_lis[11]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[12]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[13]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[14]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[15]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[16]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[17]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[18]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[19]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[20]; 				
		echo "</td>";
		
	
		echo "<td class='casilla_texto'>";
		echo $reg_lis[21]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[22]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[23]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[24]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[25]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[26]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[27]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[28]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[29]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[30]; 				
		echo "</td>";
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>