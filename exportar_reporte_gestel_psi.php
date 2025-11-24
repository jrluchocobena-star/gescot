<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="gestel_423_".$hoy.".xls";

//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=".$n_archivo);

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

$lista="select * from formato_psi";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
		echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
		
		echo "<tr>";
		echo"<td>QUIEBRE</td>";
		echo"<td>ATENCION</td>";
		echo"<td>FUENTE</td>";
		echo"<td>CODACTU</td>";
		echo"<td>CODCLI</td>";
		echo"<td>TIPOAVERIA</td>";
		echo"<td>CLIENTENOMBRE</td>";
		echo"<td>CLIENTECELULAR</td>";
		echo"<td>CLIENTETELEFONO</td>";
		echo"<td>CLIENTECORREO</td>";
		echo"<td>CLIENTEDNI</td>";
		echo"<td>CONTACTONOMBRE</td>";
		echo"<td>CONTACTOCELULAR</td>";
		echo"<td>CONTACTOTELEFONO</td>";
		echo"<td>CONTACTOCORREO</td>";
		echo"<td>CONTACTODNI</td>";
		echo"<td>EMBAJADORNOMBRE</td>";
		echo"<td>EMBAJADORCORREO</td>";
		echo"<td>EMBAJADORCELULAR</td>";
		echo"<td>EMBAJADORDNI</td>";
		echo"<td>COMENTARIO</td>";
		echo"<td>FH_REG104</td>";
		echo"<td>FH_REG1L</td>";
		echo"<td>FH_REG2L</td>";
		echo"<td>CODMULTIGESTION</td>";
		echo"<td>LLAMADOR</td>";
		echo"<td>TITULAR</td>";
		echo"<td>Direccion</td>";
		echo"<td>Distrito</td>";
		echo"<td>Urbanizacion</td>";
		echo"<td>TELF_GESTION</td>";
		echo"<td>TELF_ENTRANTE</td>";
		echo"<td>OPERADOR</td>";
		echo"<td>MOTIVO_CALL</td>";
		echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
			
		echo "<tr>";	
		echo"<td>$reg_lis[1]</td>";
		echo"<td>$reg_lis[2]</td>";
		echo"<td>$reg_lis[3]</td>";
		echo"<td>$reg_lis[4]</td>";
		echo"<td>$reg_lis[5]</td>";
		echo"<td>$reg_lis[6]</td>";
		echo"<td>$reg_lis[7]</td>";
		echo"<td>$reg_lis[8]</td>";
		echo"<td>$reg_lis[9]</td>";
		echo"<td>$reg_lis[10]</td>";
		echo"<td>$reg_lis[11]</td>";
		echo"<td>$reg_lis[12]</td>";
		echo"<td>$reg_lis[13]</td>";
		echo"<td>$reg_lis[14]</td>";
		echo"<td>$reg_lis[15]</td>";
		echo"<td>$reg_lis[16]</td>";
		echo"<td>$reg_lis[17]</td>";
		echo"<td>$reg_lis[18]</td>";
		echo"<td>$reg_lis[19]</td>";
		echo"<td>$reg_lis[20]</td>";
		echo"<td>$reg_lis[21]</td>";
		echo"<td>$reg_lis[22]</td>";
		echo"<td>$reg_lis[23]</td>";
		echo"<td>$reg_lis[24]</td>";
		echo"<td>$reg_lis[25]</td>";
		echo"<td>$reg_lis[26]</td>";
		echo"<td>$reg_lis[27]</td>";
		echo"<td>$reg_lis[28]</td>";
		echo"<td>$reg_lis[29]</td>";
		echo"<td>$reg_lis[30]</td>";
		echo"<td>$reg_lis[31]</td>";
		echo"<td>$reg_lis[32]</td>";
		echo"<td>$reg_lis[33]</td>";
		echo"<td>$reg_lis[34]</td>";		
		echo "</tr>";				
		
		}	
	echo "</table>";
	

?>


</body>
</html>