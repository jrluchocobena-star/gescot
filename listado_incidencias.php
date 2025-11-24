<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$iduser	= $_GET["iduser"];
$f_inc	= $_GET["f_inc"];

$dni = explode("|",$_GET["dni_escogidos"]);
$dni = $dni[1];
			   
$hoy 	= date("Y-m-d");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="funciones_js.js"></script>

<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>

<?php 

	$lista="select * from cab_incidencia where dni='$dni' and substr(fec_ini_inc,1,10)='$f_inc' and estado_inc <> '3' order by fec_reg asc";
	//echo $lista;
	$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'  style='border-collapse:collapse'>";
			/*
			echo "<tr>";
			echo "<td colspan='7' align='right'> <a onclick='javascript:cerrar_win(0)' class='caja_texto_pe'>CERRAR</a><p></td>";	
			echo "</tr>";	
				*/
	
			$conta_d	 = "SELECT sum(tt_min) FROM cab_incidencia WHERE dni='$dni' and substr(fec_ini_inc,1,10)='$f_inc' and estado_inc <> '3'";
			//echo $conta_d;
			$res_conta_d = mysql_query($conta_d);
			$reg_conta_d = mysql_fetch_row($res_conta_d);
	
			if ($reg_conta_d[0]>=360){
				$etiqueta_color="aviso";
			}else{
				$etiqueta_color="aviso_horario_verde";
			}
				
				
			echo "<tr>";
			echo "<td class='cabeceras_grid'colspan='2'>Minutos acumulados por Dia </td>";	
			echo "<td class='cabeceras_grid' colspan='8'>";
			?>
			<input readonly name="min_acu" type="text" class="<?php echo $etiqueta_color;?>" style="width:100px;height:15px" id="min_acu" 
				   value="<?php echo $reg_conta_d[0]; ?>"/><a class="<?php echo $etiqueta_color;?>">Minutos</a>
			<?php
			
			echo "</td>";
			echo "</tr>";
	
			echo "<tr>";
			echo "<td class='caja_texto_db'>ITEM </td>";	
			echo "<td class='caja_texto_db'>COD.INCIDENCIA </td>";											
			echo "<td class='caja_texto_db' width='300'>TRABAJADOR </td>";						echo "<td class='caja_texto_db' width='300'>HORARIO </td>";						
			echo "<td class='caja_texto_db'>TIPO INCIDENCIA</td>";					
			echo "<td class='caja_texto_db'>FEC. INICIAL</td>";			
			echo "<td class='caja_texto_db'>FEC. FINAL</td>";
			echo "<td class='caja_texto_db'>MIN. ACUMULADOS</td>";
			echo "</tr>";		
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='casilla_texto'>";
		echo $i=$i+1; 
		echo "</td>";
		
		$c1="select * from tb_usuarios where dni='$dni'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		$c2="select * from tb_usuarios where iduser='$reg_lis[3]'";
		//echo $c2;
		$res_c2 = mysql_query($c2);
		$reg_c2=mysql_fetch_row($res_c2);
		
		$c3="select * from tb_motivos_incidencia where cod_mot_inc='$reg_lis[5]'";
		//echo $c3;
		$res_c3 = mysql_query($c3);
		$reg_c3=mysql_fetch_row($res_c3);
		
		$c4="select * from horarios_gestores_cot where dni='$dni'";
		//echo $c4;
		$res_c4 = mysql_query($c4);
		$reg_c4=mysql_fetch_row($res_c4);
			
		
		echo "<td class='caja_sb'>";		
		echo $reg_lis[10]; 				
		echo "</a>";
		echo "</td>";			
		
		echo "<td class='caja_sb'>";
		echo $reg_c1[1]; 				
		echo "</td>";			
	
		echo "<td class='caja_sb'>";
		echo $reg_c4[6]; 				
		echo "</td>";
		
		echo "<td class='caja_sb'>";
		echo $reg_c3[1]; 				
		echo "</td>";	
		
		echo "<td class='caja_sb'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='caja_sb'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='caja_sb'>";
		echo $reg_lis[13]; 				
		echo "</td>";
	
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>



</body>
</html>