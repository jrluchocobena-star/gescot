<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>
<? 

$lista="select * from dinamica_por_usuario";
//echo $lista;
$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
			echo "<td class='cabec_2'>ITEM </td>";												
			echo "<td class='cabec_2' width='300'>RESPONSABLE </td>";												
			echo "<td class='cabec_2'>01</td>";			
			echo "<td class='cabec_2'>02</td>";		
			echo "<td class='cabec_2'>03</td>";			
			echo "<td class='cabec_2'>04</td>";		
			echo "<td class='cabec_2'>05</td>";			
			echo "<td class='cabec_2'>06</td>";		
			echo "<td class='cabec_2'>07</td>";			
			echo "<td class='cabec_2'>08</td>";		
			echo "<td class='cabec_2'>09</td>";			
			echo "<td class='cabec_2'>10</td>";		
			echo "<td class='cabec_2'>11</td>";			
			echo "<td class='cabec_2'>12</td>";		
			echo "<td class='cabec_2'>13</td>";			
			echo "<td class='cabec_2'>14</td>";		
			echo "<td class='cabec_2'>15</td>";			
			echo "<td class='cabec_2'>16</td>";		
			echo "<td class='cabec_2'>17</td>";			
			echo "<td class='cabec_2'>18</td>";		
			echo "<td class='cabec_2'>19</td>";			
			echo "<td class='cabec_2'>20</td>";		
			echo "<td class='cabec_2'>21</td>";			
			echo "<td class='cabec_2'>22</td>";		
			echo "<td class='cabec_2'>23</td>";			
			echo "<td class='cabec_2'>24</td>";		
			echo "<td class='cabec_2'>25</td>";			
			echo "<td class='cabec_2'>26</td>";		
			echo "<td class='cabec_2'>27</td>";			
			echo "<td class='cabec_2'>28</td>";		
			echo "<td class='cabec_2'>29</td>";			
			echo "<td class='cabec_2'>30</td>";		
			echo "<td class='cabec_2'>31</td>";			
			echo "<td class='cabec_2'>TOTAL</td>";			

			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='caja_textop'>";
		echo $i=$i+1; 			
		echo "</td>";
						
		echo "<td  class='caja_textop'>";
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
		
		$tot=$reg_lis[1]+$reg_lis[2]+$reg_lis[3]+$reg_lis[4]+$reg_lis[5]+$reg_lis[6]+$reg_lis[7]+$reg_lis[8]+$reg_lis[9]+$reg_lis[10]+$reg_lis[11]+$reg_lis[12]+
		$reg_lis[13]+$reg_lis[14]+$reg_lis[15]+$reg_lis[16]+$reg_lis[17]+$reg_lis[18]+$reg_lis[19]+$reg_lis[20]+$reg_lis[21]+$reg_lis[22]+$reg_lis[23]+$reg_lis[24]+$reg_lis[25]+
		$reg_lis[26]+$reg_lis[27]+$reg_lis[28]+$reg_lis[29]+$reg_lis[30]+$reg_lis[31];
		
		echo "<td class='casilla_texto'>";
		echo $tot; 				
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>