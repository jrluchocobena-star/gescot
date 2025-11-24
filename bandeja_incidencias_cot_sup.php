<?php
include("conexion_bd.php");
$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

$m_actual=date("Y-m");


	$cad=" where usu_reg='$iduser ' and substr(fec_reg,1,7)='$m_actual'";

	$lista="select * from cab_incidencia  $cad  group by cod_incidencia";
	//echo $lista;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'>";	
	
		echo "<tr>
				<td colspan='10'>
				<a href='javascript:seleccionar_incidencia_todo()'>Marcar todos</a> |
				<a href='javascript:deseleccionar_incidencia_todo()'>Marcar ninguno</a>				
				</td>
		</tr>";
				
		echo "<tr>";
		echo "<td colspan='2' class='caja_texto_db'>...</td>";				
		echo "<td class='caja_texto_db'>COD.INCIDENCIA</td>";	
		echo "<td class='caja_texto_db'>CIP</td>";						
		echo "<td class='caja_texto_db'>DNI</td>";							
		echo "<td class='caja_texto_db'>NOMBRE COMPLETO</td>";
		echo "<td class='caja_texto_db'>TP.INCIDENCIA</td>";
		echo "<td class='caja_texto_db'>MOTIVO</td>";
		echo "<td class='caja_texto_db'>HORARIO</td>";
		echo "<td class='caja_texto_db'>MODO</td>";
		echo "<td class='caja_texto_db'>FEC.INI.INC</td>";
		echo "<td class='caja_texto_db'>FEC.FIN.INC</td>";
		echo "<td class='caja_texto_db'>DIF.</td>";
		echo "<td class='caja_texto_db'>ESTADO</td>";
		echo "</tr>";
	$i=0;
	while($reg_lis=mysql_fetch_row($res_lis)){	
	
		$s="select * from tb_usuarios where dni='".$reg_lis[15]."'";
		//echo $s;
		$rs_s = mysql_query($s);											
		$rg_s = mysql_fetch_row($rs_s);
		
		$m="select * from tb_motivos_incidencia where cod_mot_inc='".$reg_lis[5]."'";
		//echo $s;
		$rs_m = mysql_query($m);											
		$rg_m = mysql_fetch_row($rs_m);
		
		$hor="select * from horarios_gestores_cot where dni='".$reg_lis[15]."'";
		//echo $s;
		$rs_hor = mysql_query($hor);											
		$rg_hor = mysql_fetch_row($rs_hor);
	
		echo "<tr>";	
		
		
		/*
		echo "<td>";		
		echo $con = $con + 1; 				
		echo "</td>";
		*/
		$i = $i + 1; 
		$nn="d_obs_".$con;
		$nnx="f_obs_".$con;
		
		echo "<td class='caja_texto_pe'>$i</td>";
			
		echo "<td class='caja_texto_peke'>";		
		//echo "check".$i."|".$reg[2];
		?>
   		 <input type="checkbox" name="<?php echo "check".$i; ?>" id="<?php echo "check".$i; ?>" value="<?php echo $reg_lis[10]; ?>" 
    	onclick="javascript:escojer_gestor()" /> 
        <?php
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//C.INCIDENCIA		
		echo $reg_lis[10]; 				
		echo "</td>";
	
		echo "<td class='caja_texto_peke'>";		//CIP		
		echo $reg_lis[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//dni		
		echo $reg_lis[15]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";
		echo $rg_s[1]; 		//NOMBRE	
		echo "</td>";
	
		
		echo "<td class='caja_texto_peke'>";		// tp incidencia		
		echo $reg_lis[4]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_peke'>";		// motivo		
		echo $rg_m[1]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_peke'>";		// HORARIO		
		echo $rg_hor[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//modo		
		echo $reg_lis[13]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//fecini		
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//fecfin		
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";
		if ($reg_lis[13]=="D"){
			echo $reg_lis[16]; 		
		}else{
			echo $reg_lis[12]; 		
			}
		
		echo "</td>";
		
		
		echo "<td class='caja_texto_peke'>";		//ESTADO	
			if ($reg_lis[17]==0){
				echo "PENDIENTE";
			}
			if ($reg_lis[17]==1){
				echo "APROBADO";
			}	
			
			if ($reg_lis[17]==2){
				echo "RECHAZADO";
			}
					
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";	

?>