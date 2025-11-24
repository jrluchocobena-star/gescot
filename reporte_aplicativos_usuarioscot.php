<?php

$f_actual=date("Y-m-d");
$n_archivo="reporte_aplicativos_usuarios_".$f_actual.".xls";


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);


include("conexion_bd.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];


$c_supervisor = $_GET["c_supervisor"];
$c_gestor = $_GET["c_gestor"];
	
	if ($c_gestor=="0"){
		$sql_1="select * from tb_usuarios where c_supervisor='$c_supervisor' and estado='HABILITADO' and grupo='COT-TDP'";	
	}else{
		$sql_1="select * from tb_usuarios where dni='$c_gestor' and estado='HABILITADO' and grupo='COT-TDP'";	
	}
	//echo $sql_1;
	$res_1= mysql_query($sql_1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REPORTE INCIDENCIAS COT</title>

</head>

<body>

<?php 

	$i=0;
			echo "<table width='30%'>";					
			echo "<tr>";								
			echo "<td width='5%' align='center'>DNI </td>";	
			echo "<td width='5%' align='center'>CIP</td>";		
			echo "<td width='40%' align='center'>NOMBRES COMPLETOS</td>";	
			
			$col="select * from tb_aplicativos order by orden";
			$res_col= mysql_query($col);
			while($reg_col = mysql_fetch_row($res_col)){
				echo "<td width='30%' align='center'>";	
				echo $reg_col[1]; 					
				echo "</td>";
			}		
										
			echo "</tr>";
	
		while($reg_1 = mysql_fetch_row($res_1)){		
		
		echo "<tr>";			
						
		echo "<td valign='top'>";		
		echo $reg_1[2]; 			
		echo "</td>";	
				
		echo "<td align='center' valign='top'>";
		echo $reg_1[3]; 			
		echo "</td>";	
		
		echo "<td align='center' valign='top'>";
		echo $reg_1[1]; 			
		echo "</td>";	
		
			$col_1="select * from tb_aplicativos order by orden";
			//echo $col_1;
			
			$res_col_1= mysql_query($col_1);
			while($reg_col_1 = mysql_fetch_row($res_col_1)){
			
				$col_2="select dni,dato,aplicativo,est
				from movimientos_maestra where dni='$reg_1[2]' AND aplicativo='$reg_col_1[1]' and est='ACTIVO'";
				//echo $col_2."|";			
				$res_2= mysql_query($col_2);
				$reg_2 = mysql_fetch_row($res_2);
				$nreg2 = mysql_num_rows($res_2);
				
				
				echo "<td width='5%' valign='top'>";
				
				
				if ($nreg2<1){
					echo "USU. DESACTIVADO";
					
				}else{
					if ($reg_2[1]=="-" or $reg_2[1]==" " or $reg_2[1]=="X"){					
					echo "USU. EN BLANDO";
						
					}else{
					echo $reg_2[1];
					
					}
				}	
				echo "</td>";
			} //dowhile	
			
			
		echo "</tr>";	
	
		} // dowhile
		
		
	echo "</table>";	

?>



</body>
</html>