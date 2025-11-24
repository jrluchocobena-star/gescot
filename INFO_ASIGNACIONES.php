<?php
include("conexion_bd.php");

$pedido = $_GET["pedido"];
$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

$cad	="(select * from cab_asignaciones_cot_acu where peticion='$pedido')UNION(select * from cab_asignaciones_cot where peticion='$pedido')";
//echo $cad;
$rs_cad = mysql_query($cad) or die(mysql_error());												
$rg_cad = mysql_fetch_row($rs_cad);		



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5" class="celdas_detalle_guias">&nbsp;</td>
  </tr>
  <tr>
    <td width="13%" class="TitTablaI">PETICION</td>
    <td width="33%" class="caja_texto_pe"><? echo $rg_cad[1]; ?></td>
    <td width="2%">&nbsp;</td>
    <td width="16%" class="TitTablaI">ESTADO</td>
    <td width="36%" class="caja_texto_pe"><? 
	$est="select * from tb_estados_asignacion where cod_estado='".$rg_cad[6]."'";
		//echo $s;
	$rs_s = mysql_query($est);											
	$rg_s = mysql_fetch_row($rs_s);
		
	echo $rg_s[1]; ?> </td>
  </tr>
  <tr>
    <td class="TitTablaI">GESTIONADO POR</td>
    <td class="caja_texto_pe">
	<? 
		$usu="select ncompleto from tb_usuarios where iduser='".$rg_cad[2]."'";
		//echo $usu;
		$rs_usu = mysql_query($usu);											
		$rg_usu = mysql_fetch_row($rs_usu);		
		echo $rg_usu[0]; 
	?></td>
    <td>&nbsp;</td>
    <td class="TitTablaI">ORIGEN</td>
    <tD class="caja_texto_pe"><? echo $rg_cad[8]; ?> </td>
  </tr>
  <tr>
    <td class="TitTablaI">FECHA REGISTRO</td>
    <td class="caja_texto_pe"><? echo $rg_cad[3]; ?></td>
    <td>&nbsp;</td>
    <td class="TitTablaI">EXCLUSIONES</td>
    <td class="caja_texto_pe"><? echo $rg_cad[9]; ?> </td>
  </tr>
  <tr>
    <td class="TitTablaI">FECHA ORIGEN</td>
    <td class="caja_texto_pe"><? echo $rg_cad[4]; ?></td>
    <td>&nbsp;</td>
    <td class="TitTablaI">OBSERVACIONES</td>
    <td rowspan="3" valign="top" class="caja_texto_pe"><? echo $rg_cad[7]; ?> </td>
  </tr>
  <tr>
    <td height="30" valign="top" class="TitTablaI">FECHA FIN</td>
    <td valign="top" class="caja_texto_pe"><? echo $rg_cad[5]; ?></td>
    <td>&nbsp;</td>
    <td class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td height="38" valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="celdas_detalle_guias">&nbsp;</td>
  </tr>
</table>
</body>
</html>