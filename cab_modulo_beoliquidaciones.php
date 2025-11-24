<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		
validar_logeo($iduser);
/*
$sql_2="SELECT a.PETICION,a.PEDIDO,a.INSCRIPCION,a.DIRECCION,a.FECHA_REG,a.origen,a.estado,a.zonal
FROM carga_pedidos_total a LEFT JOIN cab_asignaciones_cot b 
ON a.PEDIDO = b.pedido
WHERE a.estado in(0,4,5) 
ORDER BY  RAND(), a.estado asc, a.peticion desc, a.FECHA_REG ASC LIMIT 1";

$res_lis_2 = mysql_query($sql_2);
*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<script language='javascript1.2' type='text/javascript' src="funciones_js.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<title></title>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr>
  <td colspan='11' class='enc_grid'>MODULO DE BO-LIQUIDACIONES</td>
</tr>
<tr>
  <td colspan="7">&nbsp;</td>
</tr>
<tr>
  <td width="17%" class="btn" onclick="javascript:listar_bandeja_asignaciones_pend_bl('1','<? echo $iduser; ?>','<? echo $idperfil; ?>');">PEDIDOS TRABAJADOS</td>
  <td width="3%" >&nbsp;</td>
  <? if($idperfil<>"1" ){?>
  <td width="20%" class="btn" onclick="javascript:listar_bandeja_asignaciones_pend_bl('2','<? echo $iduser; ?>','<? echo $idperfil; ?>');">PEDIDOS PENDIENTES</td>
  <? } ?>
  <td width="3%" >&nbsp;</td>
  <td width="3%" >&nbsp;</td>
  
  <td width="10%" class="caja_textom">ANTIGUEDAD</td>
  <td width="11%" class="caja_textom"><span class="casilla_texto">
    <select name="t_carga" id="t_carga" class="casilla_texto" >
      <? 			
			print "<option value='0' selected>Seleccione</option>";
			$sql7="SELECT SUBSTR(fh_reg104,1,10) FROM tb_beoliquidacion GROUP BY 1";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";
			}
			?>
    </select>
  </span></td>
  <!--
  <td width="26%" class="casilla_texto" >DARLE CLICK PARA SOLICITAR PEDIDO </td>-->
  
  <td width="4%" ><img id="bt_asig" src="image/baja.JPG" width="40" height="40" onclick="javascript:mostrar_pedido_bl()" /></td>
  <? if ($idperfil<>1){?>
  <td width="10%" ><img src="image/EXCELES.JPG" alt="" name="bt_asig2" width="40" height="40" id="bt_asig2" onclick="javascript:mant_incidencia('9')" /></td>
  <? }?>
  <td width="19%" valign="top"><div id="d_contadores"></div></td>
  
</tr>

</table>
<p>
<div id="d_pedido_bl" style="display:none"></div>

<p>
<div id="bandeja_asignaciones"> 
	<iframe id="i_bandeja_asignaciones"  
    frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" 
    style="border-collapse:collapse" class="marco_tabla"
    width="100%"  scrolling="Auto"  height="500"> 
	</iframe>
</div>
<p>

