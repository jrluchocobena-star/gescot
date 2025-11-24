<?php
include("conexion_bd.php");
include("funciones_fechas.php");
set_time_limit(300);

$hoy=date("Y-m-d");
$n_archivo="rep_incidenciascot_".$hoy.".xls";

//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=".$n_archivo);

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$c_inc=$_GET["c_inc"];
$gestor=$_GET["gestor"];
$u_reg=$_GET["u_reg"];
$fec_i=$_GET["fec_i"];
$fec_f=$_GET["fec_f"];
$estado=$_GET['estado'];
$supervisor=$_GET['supervisor'];

if ($c_inc=="" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
	$cad="";
}else{

	if ($c_inc<>"" and $gestor=="0" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
			$cad=" and inc.cod_incidencia='$c_inc'";	
		}else{
			if ($c_inc=="" and $gestor=="0" and $u_reg=="0"){
				$cad=" and DATE_FORMAT(fec_ini_inc, '%Y/%m/%d')  BETWEEN '$fec_i' AND '$fec_f'";		
			}else{
				if ($c_inc=="" and $fec_i=="0000/0/0" and $fec_f=="0000/0/0" and $u_reg=="0"){
					$cad=" and inc.dni='$gestor'";	
				}else{
					if ($c_inc=="" and $u_reg=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0"){
						$cad=" and inc.dni='$gestor' and  DATE_FORMAT(inc.fec_ini_inc, '%Y/%m/%d')  BETWEEN '$fec_i' AND '$fec_f'";	
					}else{
						if ($u_reg<>"0" and $c_inc=="" and $gestor=="0" and $fec_i<>"0000/0/0" and $fec_f<>"0000/0/0" ){
							$cad=" and inc.usu_reg='$u_reg' and  DATE_FORMAT(inc.fec_ini_inc, '%Y/%m/%d')  BETWEEN '$fec_i' AND '$fec_f'";								 					}else{		
							$cad=" and inc.usu_reg='$u_reg'";						
						}
					}
					
				}
			}
		}
}

if($estado!='Todos'){
	$cad =  $cad ." AND inc.estado_inc = '" . $estado . "'";
}

if($supervisor!='Todos'){
	" AND lider.iduser = " .$supervisor;
}


$lista="SELECT inc.*,lider.ncompleto as lider FROM cab_incidencia inc
INNER JOIN tb_usuarios usu ON inc.dni = usu.dni
INNER JOIN tb_usuarios lider ON usu.c_supervisor = lider.iduser
WHERE inc.tp_incidencia not in('MONITOREO Y CAPACITACION COT') ".$cad." AND inc.fec_reg >= DATE_SUB(NOW(), INTERVAL 365 DAY) ORDER BY inc.fec_ini_inc DESC";


$res_lista = mysql_query($lista);
	
	echo "<table width='100%'>";											
	echo "<tr>";					
					
			echo "<td class='caja_texto_color' width='20px'>DNI</td>";	
			echo "<td class='caja_texto_color' width='150px'>GESTOR COT</td>";																			
			echo "<td class='caja_texto_color' width='150px'>FECHA REGISTRO </td>";												
			echo "<td class='caja_texto_color' width='150px'>C.INDICENCIA </td>";	
			echo "<td class='caja_texto_color' width='50px'>TP.INCIDENCIA</td>";	
			echo "<td class='caja_texto_color'>MOTIVO</td>";	
			echo "<td class='caja_texto_color'>FEC.INICIO</td>";						
			echo "<td class='caja_texto_color'>FEC.FIN</td>";
			echo "<td class='caja_texto_color'>DOID</td>";						
			if ($c_inc<>""){	
			echo "<td class='caja_texto_color' colspan='3' width='150px' >REGISTRADO POR</td>";
			}else{
			echo "<td class='caja_texto_color'>REGISTRADO POR</td>";	
			echo "<td class='caja_texto_color'>MODO</td>";
			echo "<td class='caja_texto_color'>TIEMPO</td>";
			echo "<td class='caja_texto_color'>MINUTOS</td>";	
			}
			echo "<td class='caja_texto_color'>OBSERVACION</td>";
			echo "<td class='caja_texto_color' width='150px'>FECHA APROBACION</td>";
			echo "<td class='caja_texto_color' width='150px'>LIDER/SUPERVISOR</td>";
			echo "<td class='caja_texto_color' width='150px'>ESTADO</td>";
			echo "<td class='caja_texto_color' width='150px'>FECHA RECHAZO</td>";
			echo "<td class='caja_texto_color' width='150px'>USUARIO RECHAZO</td>";
			echo "<td class='caja_texto_color' width='150px'>MOTIVO RECHAZO</td>";
			echo "</tr>";
	
	$con = 0		;
	while($reg_lista=mysql_fetch_row($res_lista)){			
		
		$con = $con + 1;			
		
		$fila = "fila_".$con;
		 
		echo "<tr id='$fila' name='$fila' >";					
		
		$gestor		= "select * from tb_usuarios where dni='$reg_lista[18]'";		
		$res_gestor	= mysql_query($gestor);
		$reg_gestor	= mysql_fetch_row($res_gestor);
		
		$usu		= "select ncompleto,cip,dni from tb_usuarios where iduser='$reg_lista[3]'";		
		$res_usu	= mysql_query($usu);
		$reg_usu	= mysql_fetch_row($res_usu);
		
		$c1="select * from tb_motivos_incidencia where tp_inc='$reg_lista[4]' AND cod_mot_inc='$reg_lista[5]'";
		//echo $c3;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
				
		echo "<td class='TitTablaI' width='12%'>"; // 
		echo $reg_gestor[2]; 				
		echo "</td>";			
			
		echo "<td  class='TitTablaI' width='18%'>"; // 
		echo $reg_gestor[1]; 			
		echo "</td>";	
		
		
		echo "<td class='TitTablaI' width='12%'>"; // FEC REGISTRO
		echo $reg_lista[2]; 				
		echo "</td>";
		
		echo "<td class='TitTablaI' width='12%'>"; // C.INDCIDENCIA
		echo $reg_lista[10]; 				
		echo "</td>";		
		
		echo "<td  class='TitTablaI' width='18%'>"; // TP INCIDENCIA
		echo $reg_lista[4]; 			
		echo "</td>";	
		
		echo "<td  class='TitTablaI' width='12%'>"; //MOTIVO
		echo $reg_c1[1]; 			
		echo "</td>";	
		
		
		echo "<td  class='TitTablaI' width='12%'>";// F INICIO
		echo $reg_lista[6]; 			
		echo "</td>";	
			
		
		echo "<td class='TitTablaI' width='10%'>"; // F FIN
		echo $reg_lista[7]; 				
		echo "</td>";
		
		if ($reg_lista[4]=="INCIDENCIAS DE SISTEMAS"){
			echo "<td class='TitTablaI' width='10%'>"; // doid
			echo $reg_lista[14]; 				
			echo "</td>";	
		}else{
			echo "<td class='TitTablaI' width='10%'>"; // doid						
			echo "</td>";
			}
			
		if ($c_inc<>""){
			echo "<td class='TitTablaI' width='24%' colspan='3'>"; //USUARIO
			echo $reg_usu[0]; 				
			echo "</td>";			
			
		}else{
			echo "<td class='TitTablaI' width='24%'>"; //USUARIO
			echo $reg_usu[0]; 				
			echo "</td>";
			
			echo "<td class='TitTablaI' width='5%'>"; //MODO
			echo $reg_lista[14]; 				
			echo "</td>";
			
			echo "<td class='TitTablaI' width='10%'>";
			echo $reg_lista[12];
			echo "</td>";
			
			echo "<td class='TitTablaI' width='10%'>";
			echo $reg_lista[13];
			echo "</td>";
			
			/*
			if ($reg_lista[13]=="H"){
				echo $reg_lista[12];
			}else{
				echo $reg_lista[16];
			}				
			*/
				
		}
		
		echo "<td class='TitTablaI' width='10%'>"; // OBS
		echo $reg_lista[8]; 				
		echo "</td>";
		$fecha_aprobado = '';
		if($reg_lista[17]==1){
			$fecha_aprobado = $reg_lista[18];
		}
		echo "<td class='TitTablaI' width='12%'>".$fecha_aprobado."</td>";

		echo "<td class='TitTablaI' width='12%'>".$reg_lista[25]."</td>"; //lider
		
		echo "<td class='TitTablaI' width='12%'>"; // ESTADO
		switch($reg_lista[17]){
			case 0 :
				echo "PENDIENTE";
			break;
			case 1 :
				echo "APROBADO";
			break;
			case 2 :
				echo "RECHAZADO";
				break;
			default:
				echo $reg_lista[17];
		}				
		echo "</td>";	

		echo "<td class='TitTablaI' width='12%'>".$reg_lista[24]."</td>"; //fecha_rechazo
		echo "<td class='TitTablaI' width='12%'>".$reg_lista[23]."</td>";  //responsable_rechazo
		echo "<td class='TitTablaI' width='12%'>".$reg_lista[22]."</td>"; //motivo_rechazo
		echo "</tr>";				
		}	
	echo "</table>";
?>