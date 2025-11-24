<?php
echo "<link href='estilos.css' rel='stylesheet' type='text/css' />";
echo "<script language='javascript1.2' type='text/javascript' src='funciones_js.js'></script>";

include("conexion_bd.php");
include("funciones_fechas.php");

$lista=$_GET["lista"];
$iduser=$_GET["iduser"];
$opc=$_GET["opc"];

//echo $lista;



if ($opc=="1"){
	$f_actual=date("Y-m-d");
	$cad="substr(fec_reg_web,1,10)='$f_actual' order by fec_reg_web desc";
}
if ($opc=="2"){
	$f_actual=date("m");
	$cad="substr(fec_reg_web,6,2)='$f_actual' order by fec_reg_web desc";
}

if ($opc=="3"){
	$cad="";
}

	
	
$lista="select * from cab_asignaciones_cot where ".$cad;
//echo $lista;
$res_lis = mysql_query($lista);
	
	echo "<table width='2000px' border='0'>";				
			echo "<tr>";							
			echo "<td><img src='image/exportar.jpg' alt='' width='70' height='35' onclick='javascript:exportar_reporte_modulo($iduser,$opc);' /></td>";																												
			echo "</tr>";
			echo "<tr>";							
			echo "<td class='cabec_1'>PEDIDO </td>";		
			echo "<td class='cabec_1'>USUARIO </td>";												
			echo "<td class='cabec_1'>FEC. REG. GESTEL</td>";					
			echo "<td class='cabec_1'>FEC. INICIO ATENCION </td>";
			echo "<td class='cabec_1'>FEC. CIERRE ATENCION</td>";
			echo "<td class='cabec_1'>MOTIVO </td>";
			//echo "<td class='cabec_1'>TIEMPO DE ATENCION 1</td>";
			//echo "<td class='cabec_1'>TIEMPO DE ATENCION 2</td>";
			echo "<td class='cabec_1'>ESTADO</td>";									
			echo "<td class='cabec_1'>OBSERVACION</td>";									
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";			
						
		echo "<td  class='caja_texto_hr'>";
		echo $reg_lis[1]; 			
		echo "</td>";		
		
		$sql_usu = "select * from tb_usuarios where iduser='$reg_lis[2]'";
		//echo $sql_usu;
		$res_USU = mysql_query($sql_usu);											
		$usu	= mysql_fetch_array($res_USU);
		
		echo "<td class='caja_texto_hr'>";
		echo $usu[1]; 				
		echo "</td>";	
		
		
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[4]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[3]; 				
		echo "</td>";
			
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[9]; 				
		echo "</td>";
		
		/*
		echo "<td class='caja_texto_hr'>";
		echo calcular_tiempo_trasnc($reg_lis[5],$reg_lis[3]); 				
		echo "</td>";
		
		echo "<td class='caja_texto_hr'>";
		echo calcular_tiempo_trasnc($reg_lis[5],$reg_lis[4]); 				
		echo "</td>";
		*/		
		
		$est="select * from tb_estados_asignacion where cod_estado='$reg_lis[6]'";
		$res_est= mysql_query($est);
		$reg_est=mysql_fetch_row($res_est);
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_est[1]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_hr'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";	
	



?>

