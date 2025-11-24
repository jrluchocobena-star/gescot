<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones_js.js"></script>


<?php
include("conexion_bd.php");
include("funciones_fechas.php");

set_time_limit(300);

$iduser=$_GET["iduser"];
$perfil=$_GET["idperfil"];
$c_inc=$_GET["c_inc"];
$gestor=$_GET["gestor"];
$u_reg=$_GET["u_reg"];
$fec_i=$_GET["fec_i"];
$fec_f=$_GET["fec_f"];
$estado=$_GET["estado"];
$supervisor=$_GET['supervisor'];

echo "<input name='iduser' type='hidden' class='casilla_texto' id='iduser' value='$iduser'/>";
echo "<input name='idperfil' type='hidden' id='idperfil' value='$idperfil'/>";

//echo $perfil."|".$iduser."|".$u_reg;


if ($c_inc=="" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){   
	if($perfil=="1"){
        $cad=" and  usu_reg='$u_reg'";
		
	} else {
		$cad="";
	}
}else{

	if ($c_inc<>"" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
		if($perfil!=1){
			$cad=" and  cod_incidencia='$c_inc'";
		} else {
			$cad=" and  cod_incidencia='$c_inc' and  usu_reg='$u_reg'";
		}
		}else{
			if ($c_inc=="" and $gestor=="0" and $u_reg=="0"){
				if($perfil!=1){
					$cad=" and DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";	
				} else {
					$cad=" and DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f' and  usu_reg='$iduser'";
				}
			}else{
				if ($c_inc=="" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
					$cad=" and  dni='$gestor'";	
				}else{
					if ($c_inc=="" and $u_reg=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0"){
						$cad=" and  dni='$gestor' and  DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";	
					}else{
						if ($u_reg<>"0" and $c_inc=="" and $gestor=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0" ){
							$cad=" and  usu_reg='$u_reg' and  DATE_FORMAT( fec_ini_inc, '%Y/%m/%d') BETWEEN '$fec_i' AND '$fec_f'";								 					}else{		
							$cad=" and usu_reg='$u_reg'";						
						}
					}
					
				}
			}
		}
}


if($estado!='Todos'){
	$cad =  $cad ." AND estado_inc = '" . $estado . "'";
}

if($supervisor!='Todos'){
	//$cad = $cad ." AND lider.iduser = " .$supervisor;
}
/*
$lista="SELECT  * FROM cab_incidencia inc 
INNER JOIN tb_usuarios usu ON  dni = usu.dni
INNER JOIN tb_usuarios lider ON usu.c_supervisor = lider.iduser
WHERE tp_incidencia NOT IN ('MONITOREO Y CAPACITACION COT') ".$cad." AND  fec_reg >= DATE_SUB(NOW(), INTERVAL 365 DAY) GROUP BY cod_incidencia, tp_incidencia";
*/

$lista ="Select * from cab_incidencia where substr(fec_reg,1,4)='2025'".$cad." GROUP BY cod_incidencia, tp_incidencia order by fec_reg desc";

$res_lista 	= mysql_query($lista);
//exit();

	
	echo "<table width='100%'>";											
	echo "<tr>";		
			//echo "<td class='caja_texto_peke' width='2%'>PANEL</td>";												
			echo "<td class='caja_texto_peke' width='5%'>C.INDICENCIA </td>";	
			echo "<td class='caja_texto_peke' width='5%'>ESTADO </td>";						
			echo "<td class='caja_texto_peke' width='5%'>DNI</td>";	
			echo "<td class='caja_texto_peke' width='20%'>TRABAJADOR COT</td>";		
			echo "<td class='caja_texto_peke' width='10%'>TP.INCIDENCIA</td>";	
			echo "<td class='caja_texto_peke' width='10%'>MOTIVO</td>";	
			echo "<td class='caja_texto_peke'>FEC.INI INCIDENCIA</td>";						
			echo "<td class='caja_texto_peke'>FEC.FIN INCIDENCIA</td>";				
			echo "<td class='caja_texto_peke'>MODO</td>";
			echo "<td class='caja_texto_peke'>TIEMPO</td>";	
			echo "<td class='caja_texto_peke'>MINUTOS</td>";
			echo "<td class='caja_texto_peke'>OBSERVACION</td>";
			/*
			echo "<td class='caja_texto_peke'>FEC.RECHAZO</td>";
			echo "<td class='caja_texto_peke'>RESP.RECHAZO</td>";
			echo "<td class='caja_texto_peke'>MOTIVO RECHAZO</td>";
			*/

	echo "</tr>";
	
	$con = 0		;
	while($reg_lista=mysql_fetch_row($res_lista)){			
		
		$con = $con + 1;			
		
		$fila = "fila_".$con;
		 
		echo "<tr id='$fila' name='$fila' >";					
		
		$fec		= "SELECT min(fec_ini_inc),max(fec_fin_inc) FROM cab_incidencia WHERE cod_incidencia='$reg_lista[10]' ";	
		//echo $fec;	
		$res_fec	= mysql_query($fec);
		$reg_fec	= mysql_fetch_row($res_fec);
		
		$contar		= "SELECT dni FROM cab_incidencia WHERE cod_incidencia='$reg_lista[10]' group by 1";		
		$res_contar	= mysql_query($contar);
		$reg_contar	= mysql_fetch_row($res_contar);
		$nreg_contar = mysql_num_rows($res_contar);
		
		
		$gestor		= "select ncompleto from tb_usuarios where dni='$reg_lista[17]'";		
		$res_gestor	= mysql_query($gestor);
		$reg_gestor	= mysql_fetch_row($res_gestor);
		
		$usu		= "select ncompleto,cip,dni from tb_usuarios where iduser='$reg_lista[3]'";		
		$res_usu	= mysql_query($usu);
		$reg_usu	= mysql_fetch_row($res_usu);
		
		$c1="select * from tb_motivos_incidencia where tp_inc = '$reg_lista[4]' AND cod_mot_inc='$reg_lista[5]'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		/*
		echo "<td class='TitTablaI' width='2%'>" ; // PANEL		}
		if ($reg_lista[4]!="INCIDENCIAS DE SISTEMAS"){
		?>
		
		<img src='image/visto2.jpg' width='15' height='15' 
		onClick="javascript:ver_incidencia('<?php echo $reg_lista[4] ?>','<?php echo $reg_lista[10] ?>','<?php echo $reg_lista[6] ?>',
        '<?php echo $reg_lista[7]?>','<?php echo $reg_lista[8] ?>','<?php echo $fila ?>','<?php echo $reg_lista[2] ?>','<?php echo $reg_gestor[3]."-".$reg_gestor[1]; ?>',
		'<?php echo $reg_usu[0];?>','<?php echo $reg_lista[17];?>')">
		<?php }else{ ?>
		<img src='image/visto2.jpg' width='15' height='15' 
		onClick="javascript:ver_incidencia('<?php echo $reg_lista[4] ?>','<?php echo $reg_lista[10] ?>','<?php echo $reg_lista[6] ?>',
        '<?php echo $reg_lista[7]?>','<?php echo $reg_lista[8] ?>','<?php echo $fila ?>','<?php echo $reg_lista[2] ?>','<?php echo $reg_gestor[3]."-".$reg_gestor[1]; ?>',
		'<?php echo $reg_usu[0];?>')">
		<?php } ?> 	
									 <!--
        <img src='image/eliminar2.jpg' width='15' height='15' border="0" 
		onClick="javascript:eliminar_incidencia('<?php echo $reg_lista[0] ?>','<?php echo $reg_lista[10]; ?>','<?php echo $reg_lista[15]; ?>')"> 																																	   -->
		<?php
        echo "</td>";	
		*/
		
		
				
		/*
		echo "<td class='TitTablaI' width='12%'>"; // FEC REGISTRO
		echo $reg_lista[2]; 				
		echo "</td>";
		*/
		echo "<td class='caja_texto_peke'>"; // C.INDCIDENCIA
        $cod_inc=substr($reg_lista[10],4,20);
        ?>
		<a href="javascript:poner_incidencia('<?php echo $cod_inc; ?>')">
        <?php echo $reg_lista[10]; ?>
        </a>	
        <?php
		echo "</td>";	

		 // ESTADO
		switch($reg_lista[15]){
			case 0 :
				$est= "PENDIENTE";
                $color="#318CE7";
			break;
			case 1 :
				$est=  "APROBADO";
                $color="#50C878";
			break;
			case 2 :
				$est=  "RECHAZADO";
                $color="#EB4C42";
				break;
			case 3 :
				$est=  "CANCELADO";
                $color="#F4CA16";
				break;
			default:
				$est=  $reg_lista[15];
		}	
        echo "<td class='caja_texto_peke' style='color: $color'>$est</td>";	
		
			echo "<td class='TitTablaI'>"; // dni
			echo $reg_lista[17]; 				
			echo "</td>";			
			
			echo "<td  class='TitTablaI'>"; // nombre
			echo $reg_gestor[0]; 			
			echo "</td>";			
		
		echo "<td  class='TitTablaI'>"; // TP INCIDENCIA
		echo $reg_lista[4]; 			
		echo "</td>";	
		
		echo "<td  class='TitTablaI'>"; //MOTIVO
		echo $reg_c1[1]; 			
		echo "</td>";	
		
		
		echo "<td  class='TitTablaI'>";// F INICIO
		echo $reg_fec[0]; 			
		echo "</td>";	
			
		
		echo "<td class='TitTablaI'>"; // F FIN
		echo $reg_fec[1]; 				
		echo "</td>";
			
					
			echo "<td class='TitTablaI'>"; //MODO
			echo $reg_lista[14]; 				
			echo "</td>";
			
			echo "<td class='TitTablaI'>";
            echo $reg_lista[12];//TIEMPO						
			echo "</td>";
		
			echo "<td class='TitTablaI' align='center'>"; // MINUTOS
			
			if ($reg_lista[14]=="H"){
				echo $reg_lista[13];
			}else{
				echo "";
			}				
			echo "</td>";
		
		echo "<td class='TitTablaI'>"; // tipo_incidencia
		echo $reg_lista[8];
		echo "</td>";
		
		
		/*
		echo "<td class='TitTablaI'>";  // fecha rechazo
			if ($reg_lista[24]){
				echo $reg_lista[24]; 	
			}else{
				echo "-";
			}		
		echo "</td>";
		
		echo "<td class='TitTablaI'>";  // responsable rechazo
			if ($reg_lista[23]){
				echo $reg_lista[23]; 	
			}else{
				echo "-";
			}	
		echo "</td>";
		
		echo "<td class='TitTablaI'>";  //  motivo rechazo
			if ($reg_lista[22]){
				echo $reg_lista[22]; 	
			}else{
				echo "-";
			}	
		
		echo "</td>";
		*/
		echo "</tr>";				
		}	
	echo "</table>";
	//echo "total: ".$con;
?>
