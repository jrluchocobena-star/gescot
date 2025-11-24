<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$cip=trim($_GET["cip"]);
$supervisor=trim($_GET["supervisor"]);
$xmes=date("Y")."-".trim($_GET["xmes"]);
//echo "usu".$iduser."|cip".$cip."|super".$supervisor."|ini".$fec_ini."|fin".$fec_fin;

if ($cip=="" and $_GET["xmes"]=="0"  and $supervisor=="0"){
		$mes_actual=date("Y-m");
		$cad="and SUBSTR(fec_ini_inc,1,7)='$mes_actual'";
	}else{
		if ($cip=="" and $supervisor=="0"){
			$cad="and SUBSTR(fec_ini_inc,1,7)='$xmes'";	
		}else{
			if ($supervisor=="0"){
				$cad="and cip like '%$cip%'";			
			}else{			
				$cad="and usu_reg='$supervisor'";				
			}
		}
	}
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
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>

<p>
<? 

	$lista="select * from cab_incidencia where tp_incidencia='MONITOREO Y CAPACITACION COT' $cad order by fec_reg desc";
	//echo $lista;
	$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'  style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>ITEM </td>";	
			echo "<td class='fdotxttabla2'>COD.INCIDENCIA </td>";														
			echo "<td class='fdotxttabla2' width='300'>TRABAJADOR </td>";																
			//echo "<td class='fdotxttabla2'>USU.MOVIMIENTO</td>";		
			echo "<td class='fdotxttabla2'>TIPO INCIDENCIA</td>";			
			echo "<td class='fdotxttabla2'>MOTIVO INCIDENCIA</td>";		
			echo "<td class='fdotxttabla2'>FEC. INICIAL</td>";			
			echo "<td class='fdotxttabla2'>FEC. FINAL</td>";		
			echo "<td class='fdotxttabla2'>T.PERMISO</td>";
			if ($perfil=="0"){ 
			echo "<td class='fdotxttabla2'>PANEL</td>";
			}
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='casilla_texto'>";
		echo $i=$i+1; 
		$nam="cond".$i;
		echo "<input type='checkbox' id='$nam' name='$nam' value='1'>";	
		?>	
        
		<? echo "</td>";
		
		$c1="select * from tb_usuarios where cip='$reg_lis[1]'";
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
		
		echo "<td class='casilla_texto'>";
		?>
        <a href="javascript:edit_incidencia('<? echo $reg_lis[1] ?>','<? echo $reg_lis[4] ?>','<? echo $reg_lis[6] ?>','<? echo $reg_lis[7]  ?>',
        '<? echo quitar_tildes($reg_lis[8])?>','<? echo $reg_lis[0]  ?>','<? echo $nam ?>' );">
		<? echo $reg_lis[10]; 				
		echo "</a>";
		echo "</td>";			
		
		echo "<td class='casilla_texto'>";
		echo $reg_c1[1]; 				
		echo "</td>";			
		
		/*
		echo "<td  class='casilla_texto'>";
		echo $reg_lis[2]; 			
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_c2[1]; 				
		echo "</td>";

*/
		echo "<td class='casilla_texto'>";
		echo $reg_lis[4]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		echo $reg_c3[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		$n_fecfin="xfec_fin".$i;
		$x_fecfin="fec_fin".$i;
		
		echo "<td class='casilla_texto'>";		
		echo "<div id='$x_fecfin'>$reg_lis[7]</div>"; 						
		echo "<input name='$n_fecfin' type='text' class='caja_texto1' id='$n_fecfin' size='20' value='$reg_lis[7]' style='display:none'>"; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		if (substr($reg_lis[7],11,8)=="00:00:00"){
			$fec1=substr($reg_lis[6],0,10);
			$fec2=substr($reg_lis[7],0,10);
			$dfec=calcular_tiempo_trasnc($fec2,$fec1);
			$fec_r=explode(", ",$dfec); 
			echo $fec_r[0];
			
		}else{
			echo calcular_tiempo_trasnc($reg_lis[7],$reg_lis[6]); 				
		}
		echo "</td>";
		
		echo "<td>";
		
		$bt_i="bt_edit".$i;
		$bt_a="bt_act".$i;
		?>   
		      

        <img id="<? echo $bt_act;?>" src="image/edit-find-replace.png" width="15" height="15" style="display:none"
        onclick="javascript:act_incidencia();" title="Actualizar" />
        
        <!--<img src="image/eliminar3.jpg" width="15" height="15" onclick="javascript:borrar_incidencia('<? echo $reg_lis[0] ?>');" title="Eliminar" />	-->
		<?
        echo "</td>";
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>



</body>
</html>