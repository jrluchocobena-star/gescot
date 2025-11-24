
<?php
	
include("conexion_bd.php");

$f_actual=date("Y-m-d");
$n_archivo="R_consulta_contactos_".$f_actual.".xls";



if ($_GET["xmes"]=="0"){
	$cri = $_GET["xano"];
	$cad="SUBSTR(fec_mov,1,4)='$cri'";
}else{
	$cri = $_GET["xano"]."-".$_GET["xmes"];
 	$cad="SUBSTR(fec_mov,1,7)='$cri'";
}

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);


$lista="select * from movimiento_contactos 
WHERE usu_mov NOT IN('','NULL','N/A','undefined') and $cad order by fec_mov desc";
//echo $lista;
$res_lis = mysql_query($lista);
	
	echo "<table width='100%' border='1' >";		
	echo "<tr>";								
	echo "<td><B>ITEM</B> </td>";	
	echo "<td><B>CIP</B> </td>";
	echo "<td><B>DNI</B> </td>";
	echo "<td><B>OPERADOR</B> </td>";		
	echo "<td><B>FECHA MOVIMIENTO</B> </td>";			
	echo "<td><B>SUPERVISOR</B> </td>";		
	echo "<td><B>OBSERVACION</B> </td>";
	echo "<td><B>DATO</B> </td>";	
	echo "<td><B>EFECTIVIDAD</B> </td>";	
	echo "<td><B>CRITERIO</B> </td>";		
	echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
	
		$sql_usu = "select * from tb_usuarios where iduser='$reg_lis[2]'";
		//echo $sql_usu;
		$res_USU = mysql_query($sql_usu);											
		$usu	= mysql_fetch_array($res_USU);
		
		$sql_usudet = "select * from usuarios_detalle where dni='$usu[2]'";
		//echo "<BR>".$sql_usudet;
		$res_usudet = mysql_query($sql_usudet);											
		$usudet	= mysql_fetch_array($res_usudet);
		
		
		$sql_sup = "select * from tb_supervisores where cod_supervisor='$usu[23]'";
		//echo $sql_sup;
		$res_sup = mysql_query($sql_sup);											
		$sup	= mysql_fetch_array($res_sup);		
					
		echo "<tr>";			
						
		echo "<td  class='clsDataArea'>";
		echo $i=$i+1; 			
		echo "</td>";		
		
		echo "<td class='clsDataArea'>"; // cip
		echo $usu[3]; 				
		echo "</td>";
		
		echo "<td class='clsDataArea'>"; // DNI
		echo $usu[2]; 				
		echo "</td>";
		
		echo "<td class='clsDataArea'>"; //nombre
		echo $usu[1]; 				
		echo "</td>";	

		
		echo "<td class='clsDataArea'>"; // fecha
		echo $reg_lis[3]; 				
		echo "</td>";	
		
		echo "<td class='clsDataArea'>"; //supervisor
		echo $sup[1]; 				
		echo "</td>";
		
		
		echo "<td class='clsDataArea'>"; // observacion 
		echo $reg_lis[4]; 				
		echo "</td>";	
		
		echo "<td class='clsDataArea'>"; // DATO 
		echo $reg_lis[7]; 				
		echo "</td>";	
		
			
		echo "<td class='clsDataArea'>"; // 
		echo $reg_lis[8]; 				
		echo "</td>";		
	
     	echo "<td class='clsDataArea'>"; // 
		echo $reg_lis[9]; 				
		echo "</td>";	
		
		echo "</tr>";				
		}	
	echo "</table>";	
	



?>
<p>&nbsp;</p>
<p>&nbsp;</p>
