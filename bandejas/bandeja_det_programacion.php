<link href="../estilos.css" rel="stylesheet" type="text/css">

<?php
include("../conexion_bd.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$dni=trim($_GET["dni"]);

	$lista="select * from compensacion_extra where dni='$dni' order by fec_mov desc";
	echo $lista;
	$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'>";
		
			echo "<td class='cabeceras_grid'>ITEM </td>";	
			//echo "<td class='cabeceras_grid'>CORRELATIVO </td>";											
			echo "<td class='cabeceras_grid'>DNI </td>";																
			echo "<td class='cabeceras_grid'>ESTADO</td>";		
			echo "<td class='cabeceras_grid'>TIPO</td>";			
			echo "<td class='cabeceras_grid'>MOTIVO</td>";	
			echo "<td class='cabeceras_grid'>USUARIO</td>";		
			echo "<td class='cabeceras_grid'>FEC. REGISTRO</td>";
			echo "<td class='cabeceras_grid'>FEC. INICIAL</td>";			
			echo "<td class='cabeceras_grid'>FEC. FINAL</td>";		
			echo "<td class='cabeceras_grid'>T.PERMISO INC</td>";
			echo "<td class='cabeceras_grid'>FEC.INI COMP</td>";			
			echo "<td class='cabeceras_grid'>FEC.FIN COMP</td>";		
			echo "<td class='cabeceras_grid'>T.PERMISO COMP</td>";
			
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){	
		
		$usu="select login from tb_usuarios where iduser='".$reg_lis[6]."'";
		//echo $usu;
		$rs_usu = mysql_query($usu);											
		$rg_usu = mysql_fetch_row($rs_usu);		
					
		echo "<tr>";	
		
		echo "<td  class='txt_normal'>";
		echo $i=$i+1; 
		/*
		?>	
        <img src="../image/BT1.gif" width="20" height="20" onClick="javascript:popup_reclamo('1','<? echo $reg_lis[0]?>')">
		<? echo "</td>";
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[1]; 				
		echo "</td>";			
		*/
		
		echo "<td  class='txt_normal'>";
		echo $reg_lis[2]; 			
		echo "</td>";
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[3]; 				
		echo "</td>";


		echo "<td class='txt_normal'>";
		echo $reg_lis[4]; 				
		echo "</td>";

		echo "<td class='txt_normal'>";
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='txt_normal'>";
		echo $rg_usu[0]; 				
		echo "</td>";
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[8]; 				
		echo "</td>";
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[9]; 				
		echo "</td>";
		
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[10]; 				
		echo "</td>";
		
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[11]; 				
		echo "</td>";
		
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[12]; 				
		echo "</td>";
		
		
		echo "<td class='txt_normal'>";
		echo $reg_lis[13]; 				
		echo "</td>";
						
		echo "</tr>";				
		}	
	echo "</table>";
	

?>
