<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="gestel_beoliquidaciones_".$hoy.".xls";

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

$lista="select * from cab_beoliquidaciones_cot order by fec_reg_web desc";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
			echo "<td >ITEM</td>";	
			echo "<td >COD.MULTIGESTION</td>";
			echo "<td >COD.REQ.</td>";
			echo "<td >COD.CLIENTE</td>";
			echo "<td >REGISTRADO POR</td>";
			echo "<td >FEC.REG.WEB</td>";
			echo "<td >FEC.REG.CLIENTE</td>";
			echo "<td >FEC.REG.CARGA</td>";
			echo "<td >FEC.REG.ATENTO</td>";
			echo "<td >FEC.CIERRE</td>";
			echo "<td >ESTADO</td>";
			echo "<td >ACCIONES</td>";
			echo "<td >OBSERVACIONES</td>";
			
			

			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
		$c1="select * from tb_usuarios where iduser='$reg_lis[2]'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		$c2="select * from tb_estados_asignacion where cod_estado='$reg_lis[8]'";
		//echo $c1;
		$res_c2 = mysql_query($c2);
		$reg_c2=mysql_fetch_row($res_c2);
		
		$c3="select * from tb_motivos_beo where cod_mot='$reg_lis[10]'";
		//echo $c1;
		$res_c3 = mysql_query($c3);
		$reg_c3=mysql_fetch_row($res_c3);
			
		echo "<tr>";	
		
		echo "<td  class='caja_textop'>"; //
		echo $i=$i+1; 			
		echo "</td>";
						
		echo "<td  class='caja_textop'>"; // MULTIGESTION
		echo $reg_lis[1]; 			
		echo "</td>";		
		
		echo "<td class='casilla_texto'>"; //COD.REQ.
		echo "-"; 				
		echo "</td>";			
		
		
		echo "<td class='casilla_texto'>"; //COD.CLIENTE
		echo $reg_lis[11]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>"; // USER
		echo $reg_c1[1]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[3]; 				
		echo "</td>";
		 
		echo "<td class='casilla_texto'>"; // 
		echo $reg_lis[4]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //estado
		echo $reg_c2[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // ACCIONES
		echo $reg_c3[1]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; // OBS
		echo $reg_lis[9]; 				
		echo "</td>";

	
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>
