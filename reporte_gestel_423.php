<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="gestel_423_".$hoy.".xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);

$iduser=$_GET["iduser"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<p>
<? 

$lista="select CIUDAD,PEDIDO,INSCRIPCION,DIRECCION,DISTRITO,PROMOCION,GRUPO,NRO_REF,FECHA_REG,TIPO_SERVICIO,PRIORIDAD,OFIC_COM,PETICION,			AGRUPACION,CLIENTE,CUENTA,PC,NEGOCIO,PREFIJO,SEGMENTO,CANTIDAD,SUB_SEGMENTO,IRIS,DIRECCION_ANTIGUA,SECTOR,MANZANA,COORD_X,COORD_Y 
from tb_gestel_423";
//echo $lista;

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
		
		echo "<td  class='caja_textop'>"; //item
		echo $i=$i+1; 			
		echo "</td>";
						
		echo "<td  class='caja_textop'>"; // ciudad
		echo $reg_lis[0]; 			
		echo "</td>";		
		
		echo "<td class='casilla_texto'>"; //pedido
		echo $reg_lis[1]; 				
		echo "</td>";			
		
		
		echo "<td class='casilla_texto'>"; //inscripcion
		echo $reg_lis[2]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>"; //direccion
		echo $reg_lis[3]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; //distrito
		echo $reg_lis[4]; 				
		echo "</td>";
		 
		echo "<td class='casilla_texto'>"; //promocion 
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //grupo
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //nro refere
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //fecha registro
		echo $reg_lis[8]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //tipo de servicio
		echo $reg_lis[9]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // prioridad
		echo $reg_lis[10]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; // oficna comercial
		echo $reg_lis[11]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //peticion
		echo $reg_lis[12]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //agrupacion
		echo $reg_lis[13]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //cliente
		echo $reg_lis[14]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //cuenta
		echo $reg_lis[15]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //pc
		echo $reg_lis[16]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // negocio
		echo $reg_lis[17]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //prefijo
		echo $reg_lis[18]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //segmento
		echo $reg_lis[19]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //cantidad
		echo $reg_lis[20]; 				
		echo "</td>";
		
	
		echo "<td class='casilla_texto'>"; //subsegmento
		echo $reg_lis[21]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //	iris
		echo $reg_lis[22]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //direccion antigua
		echo $reg_lis[23]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //sector
		echo $reg_lis[24]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //manzana
		echo $reg_lis[25]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //coord x
		echo $reg_lis[26]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //corrd y
		echo $reg_lis[27]; 				
		echo "</td>";		
				
		
		$zon="select zonal from carga_pedidos_total where peticion=$reg_lis[1]";		
		//echo $zon;		
		$res_zon = mysql_query($zon);
		$reg_zon = mysql_fetch_row($res_zon);
		
		echo "<td class='casilla_texto'>";
		if ($reg_zon[0]==""){
			echo ""; 					
		}else{		
			echo $reg_zon[0]; 				
		}
		echo "</td>";		
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>