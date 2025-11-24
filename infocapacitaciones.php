<?php
include("conexion_bd.php");

$pedido = $_GET["pedido"];
$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];
$xinc = $_GET["xinc"];

$cad	="select * from cab_capacitacion WHERE cod_incidencia='$xinc' order by fec_reg desc";
//echo $cad;
$rs_cad = mysql_query($cad) or die(mysql_error());												
$rg_cad = mysql_fetch_row($rs_cad);		

		$usu="select * from tb_usuarios where iduser='$rg_cad[3]'";
		//echo $c1;
		$res_usu = mysql_query($usu);
		$reg_usu = mysql_fetch_row($res_usu);

		$c3="select * from tb_motivos_incidencia where cod_mot_inc='$rg_cad[5]'";
		//echo $c3;
		$res_c3 = mysql_query($c3);
		$reg_c3=mysql_fetch_row($res_c3);
		
		$sup="select nom_supervisor from tb_supervisores where cod_supervisor='$reg_usu[23]'";
//		echo $sup;
		$rs_sup = mysql_query($sup);											
		$rg_sup = mysql_fetch_row($rs_sup);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td colspan="4" class="fdotxttabla2">&nbsp;</td>
  </tr>
  <tr>
    <td width="18%" class="etiqueta_p">INCIDENCIA</td>
    <td width="30%" class="aviso"><?php echo $rg_cad[10]?></td>
    <td width="14%">&nbsp;</td>
    <td width="38%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="caja_sb">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="etiqueta_p">SUPERVISOR</td>
    <td class="caja_sb"><?php echo $rg_sup[0]?></td>
    <td class="etiqueta_p">FECHA REGISTRO</td>
    <td class="caja_sb"><?php echo $rg_cad[2]?></td>
  </tr>
  <tr>
    <td class="etiqueta_p">CAPACITADOR</td>
    <td class="caja_sb"><?php echo $reg_usu[1]?></td>
    <td class="etiqueta_p">FECHA INICIO</td>
    <td class="caja_sb"><?php echo $rg_cad[6]?></td>
  </tr>
  <tr>
    <td class="etiqueta_p">CURSO</td>
    <td class="caja_sb"><?php echo $reg_c3[1]?></td>
    <td class="etiqueta_p">FECHA FIN</td>
    <td class="caja_sb"><?php echo $rg_cad[7]?></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p"># PARTICIPANTES</td>
    <td valign="top" class="caja_sb"><?php echo $rg_cad[9]?></td>
    <td valign="top" class="etiqueta_p">OBS</td>
    <td valign="top" class="caja_sb"><?php echo $rg_cad[8]?></td>
  </tr>
</table>
<P>
<?php 

		echo "<table width='100%'  style='border-collapse:collapse'>";		
		echo "<tr>";	
			echo "<td class='fdotxttabla2' width='10%'>ITEM </td>";	
			echo "<td class='fdotxttabla2' width='10%'>DNI </td>";	
			echo "<td class='fdotxttabla2' width='10%'>CIP </td>";											
			echo "<td class='fdotxttabla2' width='40%'>TRABAJADOR </td>";	
		echo "</tr></table>";	
?>
<div id="listado" style="overflow:auto; width:auto; height:300px">

<?php 

	$lista="select * from cab_capacitacion WHERE cod_incidencia='$xinc' order by fec_reg desc";
	//echo $lista;
	$i=0;
	$res_lis = mysql_query($lista);
																
	echo "<table width='100%'  style='border-collapse:collapse'>";	
			
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td class='caja_sb' width='10%'>";
		echo $i=$i+1; 
		echo "</td>";
		
		$c1="select * from tb_usuarios where cip='$reg_lis[1]'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		
		echo "<td class='caja_sb' width='10%'>";
		echo $reg_c1[2]; 				
		echo "</td>";
		
		echo "<td class='caja_sb' width='10%'>";
		echo $reg_c1[3]; 				
		echo "</td>";					


		echo "<td class='caja_sb' width='40%'>";
		echo $reg_c1[1]; 				
		echo "</td>";
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	
?>
</div>
</body>
</html>