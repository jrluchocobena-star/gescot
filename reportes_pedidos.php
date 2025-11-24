
<?php

$f_actual=date("Y-m-d");
$n_archivo="rep_asignaciones_".$factual.".xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);
	
	
include("conexion_bd.php");
include("funciones_fechas.php");


$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$opc=$_GET["opc"];

if ($_GET["xmes"]=="0"){
	$cri=$xano;	
	$cad="SUBSTR(fec_reg_web,1,4)='$cri'";
}else{
	$cri=$xano."-".$xmes;
 	$cad="SUBSTR(fec_reg_web,1,7)='$cri'";
}

	
$lista="(select * from cab_asignaciones_cot where estado_asig=3 and $cad order by fec_reg_web desc)
union(select * from cab_asignaciones_cot_2018 where estado_asig=3 and $cad order by fec_reg_web desc)";
echo $lista;
$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' >";	
			echo "<tr>";							
			echo "<td colspan='10' align='center'><B>$titulo</B></td>";													
			echo "</tr>";						
			echo "<tr>";							
			echo "<td class='cabec_1'>PEDIDO </td>";		
			echo "<td class='cabec_1'>CIP </td>";												
			echo "<td class='cabec_1'>NOMBRE COMPLETO </td>";												
			echo "<td class='cabec_1'>FEC. REG. GESTEL</td>";					
			echo "<td class='cabec_1'>FEC. INICIO ATENCION </td>";
			echo "<td class='cabec_1'>FEC. CIERRE ATENCION</td>";
			echo "<td class='cabec_1'>MOTIVO </td>";
			echo "<td class='cabec_1'>ORIGEN </td>";
			//echo "<td class='cabec_1'>TIEMPO DE ATENCION 1</td>";
			//echo "<td class='cabec_1'>TIEMPO DE ATENCION 2</td>";
			echo "<td class='cabec_1'>ESTADO</td>";									
			echo "<td class='cabec_1'>OBSERVACION</td>";								
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";			
						
		echo "<td  class='clsDataArea'>";
		echo $reg_lis[1]; 			
		echo "</td>";		
		
		$sql_usu = "select * from tb_usuarios where iduser='$reg_lis[2]'";
		//echo $sql_usu;
		$res_USU = mysql_query($sql_usu);											
		$usu	= mysql_fetch_array($res_USU);
		
		echo "<td class='clsDataArea'>";
		echo $usu[3]; 				
		echo "</td>";	

		echo "<td class='clsDataArea'>";
		echo $usu[1]; 				
		echo "</td>";	
		
		
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[3]; 				
		echo "</td>";	
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[4]; 				
		echo "</td>";
		
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[9]; 				
		echo "</td>";
		
		/*
		echo "<td class='clsDataArea'>";
		echo calcular_tiempo_trasnc($reg_lis[5],$reg_lis[3]); 				
		echo "</td>";
		
		echo "<td class='clsDataArea'>";
		echo calcular_tiempo_trasnc($reg_lis[5],$reg_lis[4]); 				
		echo "</td>";
		*/		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[8]; 				
		echo "</td>";
			
			
		$est="select * from tb_estados_asignacion where cod_estado='$reg_lis[6]'";
		$res_est= mysql_query($est);
		$reg_est=mysql_fetch_row($res_est);
		
		echo "<td class='clsDataArea'>";
		echo $reg_est[1]; 				
		echo "</td>";	
		
		echo "<td class='clsDataArea'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";	
	



?>
<p>&nbsp;</p>
<p>&nbsp;</p>
