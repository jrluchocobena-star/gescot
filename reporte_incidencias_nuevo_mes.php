<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$hoy=date("Y-m-d");
$n_archivo="rep_incidenciascot_".$hoy.".xls";


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$n_archivo);


$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$cip=trim($_GET["cip"]);
$xano=$_GET["xano"];
$xmes=$xano."-".trim($_GET["xmes"]);
$supervisor=trim($_GET["supervisor"]);

if ($_GET["xmes"]=="0"){
	$cri=$_GET["xano"];	
	$cad=" and SUBSTR(fec_ini_inc,1,4)='$cri'";
}else{
	$cri=$xano."/".$_GET["xmes"];
 	$cad=" and SUBSTR(fec_ini_inc,1,7)='$xmes'";
}


$lista="(select * from cab_incidencia where tp_incidencia not in('MONITOREO Y CAPACITACION COT') $cad  order by fec_reg desc
)union(
select * from cab_incidencia_2018 where tp_incidencia not in('MONITOREO Y CAPACITACION COT')
$cad  order by fec_reg desc)";
echo $lista;
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
			}
			echo "<td class='caja_texto_color'>OBSERVACION</td>";
			echo "</tr>";
	
	$con = 0		;
	while($reg_lista=mysql_fetch_row($res_lista)){			
		
		$con = $con + 1;			
		
		$fila = "fila_".$con;
		 
		echo "<tr id='$fila' name='$fila' >";					
		
		$gestor		= "select * from tb_usuarios where dni='$reg_lista[15]'";		
		$res_gestor	= mysql_query($gestor);
		$reg_gestor	= mysql_fetch_row($res_gestor);
		
		$usu		= "select ncompleto,cip,dni from tb_usuarios where iduser='$reg_lista[3]'";		
		$res_usu	= mysql_query($usu);
		$reg_usu	= mysql_fetch_row($res_usu);
		
		$c1="select * from tb_motivos_incidencia where cod_mot_inc='$reg_lista[5]'";
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
			echo $reg_lista[13]; 				
			echo "</td>";
			
			echo "<td class='TitTablaI' width='10%'>";
			//echo $reg_lista[12];
			
			if ($reg_lista[13]=="H"){
				echo $reg_lista[12];
			}else{
				echo $reg_lista[16];
			}				
			
			echo "</td>";	
		}
		
		echo "<td class='TitTablaI' width='10%'>"; // OBS
		echo $reg_lista[8]; 				
		echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";
	
?>
