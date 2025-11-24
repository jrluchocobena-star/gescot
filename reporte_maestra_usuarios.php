<?php 
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="reporte_maestra_usuarios_".$hoy.".xls";

$iduser = $_GET["iduser"];


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);


$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<p>
<? 

$lista="SELECT a.*,b.* FROM tb_usuarios a, movimientos_maestra b
WHERE a.dni=b.dni AND b.est='ACTIVO' AND a.estado='HABILITADO'
GROUP BY a.dni,b.dato
ORDER BY a.ncompleto";
//echo $lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' cellpadding='' cellspacing='0' style='border-collapse:collapse'>";		
			echo "<td >ITEM</td>";				
			echo "<td >NOMBRE COMPLETO</td>";
			echo "<td >DNI</td>";
			echo "<td >CIP</td>";			
			echo "<td >ESTADO</td>";
			echo "<td >AREA</td>";
			echo "<td >GRUPO</td>";
			echo "<td >S-GRUPO</td>";
			echo "<td >CORREO PERSONAL</td>";
			echo "<td >CORREO TRABAJO</td>";
			echo "<td >CEL.1</td>";
			echo "<td >CEL.2</td>";
			echo "<td >ANEXO</td>";			
			echo "<td >LOCAL-PISO</td>";
			echo "<td >SUPERVISOR</td>";
			echo "<td >MONITOR(A)</td>";
			echo "<td >INVENTARIO PC</td>";
			echo "<td >INVENTARIO MONITOR</td>";		
			//echo "<td >CUMPLEAÑOS</td>";			
			echo "<td >USUARIO</td>";
			echo "<td >APLICATIVO</td>";
			
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td class='caja_textop'>"; //item
		echo $i=$i+1; 			
		echo "</td>";
			
		echo "<td class='casilla_texto'>"; // NOMBRE COMPLETO
		echo $reg_lis[1]; 				
		echo "</td>";			
		
		
		echo "<td class='casilla_texto'>"; // DNI
		echo $reg_lis[2]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>"; // CIP
		echo $reg_lis[3]; 				
		echo "</td>";
/*
		$perfil="select * from tb_perfil where id='$reg_lis[6]'";	
		//echo "<br>".$perfil;	
		$res_perfil = mysql_query($perfil);
		$reg_perfil=mysql_fetch_row($res_perfil);

		echo "<td class='casilla_texto'>"; // PERFIL
		echo $reg_perfil[1]; 				
		echo "</td>";
*/		 
		echo "<td class='casilla_texto'>"; //  ESTADO
		echo $reg_lis[9]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // AREA
		echo $reg_lis[12]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // GRUPO
		echo $reg_lis[13]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // S-GRUPO
		echo $reg_lis[14]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // CORREO PERSONAL
		echo $reg_lis[17]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //  CORREO TRABAJO
		echo $reg_lis[18]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; //   CEL.1
		echo $reg_lis[19]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // CEL.2
		echo $reg_lis[20]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // ANEXO
		echo $reg_lis[21]; 				
		echo "</td>";
		
		
		$local="select * from tb_locales where cod_local='$reg_lis[22]'";	
//		echo $sup;	
		$res_local = mysql_query($local);
		$reg_local = mysql_fetch_row($res_local);
		
		
		echo "<td class='casilla_texto'>"; // LOCAL-PISO
		echo $reg_local[1]." - ".$reg_local[2]."-".$reg_lis[27]; 				
		echo "</td>";
		
		$sup="select * from tb_supervisores where cod_supervisor='$reg_lis[23]'";	
//		echo $sup;	
		$res_sup = mysql_query($sup);
		$reg_sup = mysql_fetch_row($res_sup);


		$monitor="select * from tb_monitores where cod_monitor='$reg_lis[24]'";	
//		echo $sup;	
		$res_monitor = mysql_query($monitor);
		$reg_monitor = mysql_fetch_row($res_monitor);
		
				
		
		echo "<td class='casilla_texto'>"; // SUPERVISOR
		echo $reg_sup[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // MONITORAS
		echo $reg_monitor[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //  PC
		echo $reg_lis[25]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // MONITOR
		echo $reg_lis[26]; 				
		echo "</td>";
		
		/*
		$fec_nac=$reg_lis[28];
		$fec_nac = explode("-", $fec_nac);
		$dia=$fec_nac[0]; // porción1
		$mes=$fec_nac[1]; // porción2
		
		if ($mes=="01") { $xmes="ENERO";}
		if ($mes=="02") { $xmes="FEBRERO";}
		if ($mes=="03") { $xmes="MARZO";}
		if ($mes=="04") { $xmes="ABRIL";}
		if ($mes=="05") { $xmes="MAYO";}
		if ($mes=="06") { $xmes="JUNIO";}
		if ($mes=="07") { $xmes="JULIO";}
		if ($mes=="08") { $xmes="AGOSTO";}
		if ($mes=="09") { $xmes="SEPTIEMBRE";}
		if ($mes=="10") { $xmes="OCTUBRE";}
		if ($mes=="11") { $xmes="NOVIEMBRE";}
		if ($mes=="12") { $xmes="DICIEMBRE";}
	
		
		echo "<td class='casilla_texto'>"; // CUMPLEAÑOS
		echo $dia."-".$xmes; 				
		echo "</td>";		
		*/
		
		echo "<td class='casilla_texto'>"; // USUARIO
		echo $reg_lis[42]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // aplicativo
		echo $reg_lis[43]; 				
		echo "</td>";
	
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>


</body>
</html>