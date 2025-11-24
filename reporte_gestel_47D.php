<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="gestel_47D_".$hoy.".xls";

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

$lista="select * from gestel_47d";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
			echo "<td>Item</td>";
			echo "<td>Fecha</td>";
			echo "<td>Comprob_</td>";
			echo "<td>Inscripcion</td>";
			echo "<td>Solicitud</td>";
			echo "<td>Usuario</td>";
			echo "<td>Cod_Sol</td>";
			echo "<td>Motivo</td>";
			echo "<td>Pedido</td>";
			echo "<td>Red</td>";
			echo "<td>MDF</td>";
			echo "<td>Cabl</td>";
			echo "<td>PAli</td>";
			echo "<td>Armar</td>";
			echo "<td>Bloq</td>";
			echo "<td>PDis</td>";
			echo "<td>Caja</td>";
			echo "<td>Born</td>";
			echo "<td>MDFd</td>";
			echo "<td>Cabld</td>";
			echo "<td>PAlid</td>";
			echo "<td>Armard</td>";
			echo "<td>Bloqd</td>";
			echo "<td>PDisd</td>";
			echo "<td>Cajad</td>";
			echo "<td>Bornd</td>";
			echo "<td>Telefono</td>";
			echo "<td>Sect</td>";
			echo "<td>Manz</td>";
			echo "<td>Peticion</td>";
			echo "<td>Agrupacion</td>";
			echo "<td>Cliente</td>";
			echo "<td>Cuenta</td>";
			echo "<td>PC</td>";			
			echo "<td>Origen</td>";
			echo "<td>Area</td>";			

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
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[31]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[32]; 				
		echo "</td>";
		
		
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[38]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[40]; 				
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>