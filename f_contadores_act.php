<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");



$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];	

$hoy = date("Y-m-d");

?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<table width="100%" border="0" cellpadding="1" cellspacing="1" class="caja_texto_pe" >
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><? 
		
	$din_0="SELECT actividad,'PENDIENTES',fuente,marca_1,COUNT(*) FROM cab_gestion_actividades_cot where substr(f_carga,1,10)='$hoy' GROUP BY 1,3,4";
	//echo $listax;
	$res_din_0 = mysql_query($din_0);
	
	echo "<table width='100%'>";	
			echo "<tr>";							
			echo "<td class='caja_texto_ama' COLSPAN='5' align='center'>PENDIENTES</td>";																
			echo "</tr>";										
			echo "<tr>";							
			echo "<td class='caja_texto_ama'>ACTIVIDAD </td>";												
			echo "<td class='caja_texto_ama'>ESTADO</td>";						
			echo "<td class='caja_texto_ama'>FUENTE</td>";		
			echo "<td class='caja_texto_ama'>MARCA</td>";		
			echo "<td class='caja_texto_ama'>CANTIDAD</td>";					
			echo "</tr>";
	
	while($reg_din_0=mysql_fetch_row($res_din_0)){			
	
		echo "<tr>";								
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_0[0]; 				
		echo "</td>";			
		
		echo "<td  class='caja_texto_pe'>";
		echo $reg_din_0[1]; 			
		echo "</td>";			
						
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_0[2]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_0[3]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_0[4]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	?></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">
	<? 
		
	$din_1="SELECT 'ASIGNACIONES',estado_asig,COUNT(*) FROM cab_asignaciones_cot WHERE substr(fec_reg_web,1,10)='$hoy' GROUP BY 2";
	//echo $listax;
	$res_din_1 = mysql_query($din_1);
	
	echo "<table width='100%'>";	
			echo "<tr>";							
			echo "<td class='caja_texto_RED' COLSPAN='4' align='center'>ASIGNACIONES</td>";																
			echo "</tr>";										
			echo "<tr>";							
			echo "<td class='caja_texto_RED'>ACTIVIDAD </td>";												
			echo "<td class='caja_texto_RED'>ESTADO</td>";						
			echo "<td class='caja_texto_RED'>CANTIDAD</td>";		
			echo "</tr>";
	
	while($reg_din_1=mysql_fetch_row($res_din_1)){			
		
		$est="select * from tb_estados_asignacion where cod_estado='$reg_din_1[1]'";
		$res_est= mysql_query($est);
		$reg_est=mysql_fetch_row($res_est);
				
					
		echo "<tr>";								
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_1[0]; 				
		echo "</td>";			
		
		echo "<td  class='caja_texto_pe'>";
		echo $reg_est[1]; 			
		echo "</td>";			
						
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_1[2]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	?>	</td>
    <td valign="top">
	<? 
		
	$din_2="SELECT 'CANCELADAS',est,COUNT(*) FROM cancelaciones_trabajadas WHERE SUBSTR(fec_eje,1,10)='$hoy' GROUP BY 2";
	//echo $listax;
	$res_din_2 = mysql_query($din_2);
	
	echo "<table width='100%'>";
			echo "<tr>";							
			echo "<td class='caja_texto_VERDE' COLSPAN='4' align='center'>CANCELADAS</td>";																
			echo "</tr>";											
			echo "<tr>";							
			echo "<td class='caja_texto_VERDE'>ACTIVIDAD </td>";												
			echo "<td class='caja_texto_VERDE'>ESTADO</td>";						
			echo "<td class='caja_texto_VERDE'>CANTIDAD</td>";		
			echo "</tr>";
	
	while($reg_din_2=mysql_fetch_row($res_din_2)){			
					
					
		echo "<tr>";								
		
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_2[0]; 				
		echo "</td>";			
		
		echo "<td  class='caja_texto_pe'>";
		echo $reg_din_2[1]; 			
		echo "</td>";			
						
		echo "<td class='caja_texto_pe'>";
		echo $reg_din_2[2]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	?>	</td>
    <td valign="top"><? 
		
	$din_3="SELECT 'MIGRACIONES',est,COUNT(*) FROM cab_migraciones_cot WHERE SUBSTR(fec_eje,1,10)='$hoy' GROUP BY 2";
	//echo $listax;
	$res_din_3 = mysql_query($din_3);
	
	echo "<table width='100%'>";	
			echo "<tr>";							
			echo "<td class='caja_texto_db' COLSPAN='4' align='center'>MIGRACIONES</td>";																
			echo "</tr>";										
			echo "<tr>";							
			echo "<td class='caja_texto_db'>ACTIVIDAD </td>";												
			echo "<td class='caja_texto_db'>ESTADO</td>";						
			echo "<td class='caja_texto_db'>CANTIDAD</td>";		
			echo "</tr>";
	
	while($reg_din_2=mysql_fetch_row($res_din_2)){			
					
					
		echo "<tr>";								
		
		echo "<td class='caja_sb'>";
		echo $reg_din_2[0]; 				
		echo "</td>";			
		
		echo "<td  class='caja_sb'>";
		echo $reg_din_2[1]; 			
		echo "</td>";			
						
		echo "<td class='caja_sb'>";
		echo $reg_din_2[2]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	?></td>
	 <td >&nbsp;</td>   
  </tr>
</table>
