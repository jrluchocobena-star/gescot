<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="rep_pedidos_pendientes".$hoy.".xls";

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

$lista="select * from carga_pedidos_total order by fecha_reg desc";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
			echo "<td >ITEM</td>";	
			echo "<td >PETICION</td>";	
			echo "<td >PEDIDO</td>";
			echo "<td >INSCRIPCION</td>";
			echo "<td >DIRECCION</td>";
			echo "<td >FEC.REGISTRO</td>";
			echo "<td >ORIGEN</td>";
			echo "<td >ESTADO</td>";
			echo "<td >ZONAL</td>";
		
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='caja_textop'>"; //item
		echo $i=$i+1; 			
		echo "</td>";
						
		echo "<td  class='caja_textop'>"; // PETICION
		echo $reg_lis[0]; 			
		echo "</td>";		
		
		echo "<td class='casilla_texto'>"; //PEDIDO
		echo $reg_lis[1]; 				
		echo "</td>";			
		
		
		echo "<td class='casilla_texto'>"; //INSCRIPCION
		echo $reg_lis[2]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>"; //DIRECCION
		echo $reg_lis[3]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; //FEC.REGISTRO
		echo $reg_lis[4]; 				
		echo "</td>";
		 
		echo "<td class='casilla_texto'>"; //ESTADO 
		echo $reg_lis[5]; 				
		echo "</td>";
		
		$est="select * from tb_estados_asignacion where cod_estado=$reg_lis[6]";		
		$res_est = mysql_query($est);
		$reg_est=mysql_fetch_row($res_est);
		
		echo "<td class='casilla_texto'>";
		echo $reg_est[1]; 				
		echo "</td>";
		
		
		
		echo "<td class='casilla_texto'>"; //ZONAL
		echo $reg_lis[7]; 				
		echo "</td>";
		
						
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>