<? 
include_once("conexion_bd.php");


$peticion	=$_GET["peticion"];
$iduser		=$_GET["iduser"];
$pedido		=$_GET["pedido"];
$origen		=$_GET["origen"];
$tipo		=$_GET["tipo"];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language='javascript1.2' type='text/javascript' src="funciones_js.js"></script>
</head>

<body>

<? if ($tipo=="1"){ 

$data="select * from tb_gestel_423 where peticion='$peticion'";	
//echo $data;
$res_data = mysql_query($data);
$reg_data=mysql_fetch_row($res_data);

?>
<table width="70%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" class="TitTablaI">
    <input type="hidden" name="iduser" id="iduser" value='<?=$iduser?>'/>
    <input type="hidden" name="pedido" id="pedido" value='<?=$pedido?>'/>
    <input type="hidden" name="peticion" id="peticion" value='<?=$peticion?>'/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <? if($origen	=="CMS"){?>
    <td valign="top" class="caja_texto_pe" width="20%">REQUERIMIENTO</td>
  <? }else{?>
    <td valign="top" class="caja_texto_pe" width="20%">PETICION</td>
  <? } ?>
  
    <td width="16%" class="caja_texto_pe"><input name="peticion2" type="text" class="caja_texto_sb" id="peticion2" value="<? echo $peticion;?>" /></td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">PEDIDO</td>
    <td class="caja_texto_pe"><? echo $pedido;?></td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">AGRUPACION</td>
    <td class="caja_texto_pe"><? echo $reg_data[13];?></td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">INSCRIPCION</td>
    <td class="caja_texto_pe"><? echo $reg_data[2];?></td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">CIUDAD</td>
    <td class="caja_texto_pe"><? echo $reg_data[0];?></td>
  </tr>
  <tr>
    <td width="29%" valign="top" class="caja_texto_pe">EXCLUSIONES</td>
    <td width="55%" class="caja_texto_pe"><select name="exc" class="casilla_texto" id="exc">
      <option value="ATENDIDO">SELECCIONAR</option>
      <option value="PORT IN">PORTABILIDAD</option>
      <option value="CANCELACIONES CMS">CANCELACIONES CMS</option>
      <option value="MIGRACIONES">MIGRACIONES</option>
      <option value="CANCELACIONES ATIS">CANCELACIONES ATIS</option>
      <option value="SE ENCONTRO RESUELTO">SE ENCONTRO RESUELTO</option>
      <option value="COMERCIAL">COMERCIAL</option>
      <option value="PLANTA SATURADA">PLANTA SATURADA</option>
      <option value="PLANTA RURAL">PLANTA RURAL</option>      
    </select></td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">OBSERVACION</td>
    <td class="caja_texto_pe"><textarea name="obs" cols="50" rows="5" class="caja_texto_sb" id="obs"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">
    <table width="225" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="89" class="caja_textop" onclick="javascript:grabar_asignacion('<? echo $peticion ?>')">
          <img id='bt_aceptar' src='image/visto2.jpg' alt='' 
          width='25' height='25'  />Grabar</td>
          <td width="10" >&nbsp;</td>
          <td width="102" class="caja_textop" onclick="JAVASCRIPT:cerrar_win('0')">
          <img src="image/SAL.jpg" alt="" width="25" height="25" />Cerrar</td>
          <td width="24">&nbsp;</td>
        </tr>
    </table></td>
  </tr>  
</table>
<? } ?>

<? if ($tipo=="5"){

$data_1 	="select * from cab_asignaciones_cot where peticion='$peticion'";	
//echo $data_1;
$res_data_1 = mysql_query($data_1);
$reg_data_1 = mysql_fetch_row($res_data_1);

$usu="select * from tb_usuarios where iduser='$reg_data_1[2]'";
$res_usu = mysql_query($usu);
$reg_usu =mysql_fetch_row($res_usu);

	
?>
<table width="70%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <? if($origen	=="CMS"){?>
    <td valign="top" class="TitTablaI" width="16%">REQUERIMIENTO</td>
    <? }else{?>
    <td valign="top" class="TitTablaI" width="47%">PETICION</td>
    <? } ?>
    
    <td width="37%"><input name="peticion3" type="text" class="caja_texto_cb" id="peticion3" value="<? echo $peticion;?>" /></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="16%" valign="top" class="TitTablaI">EXCLUSIONES</td>
    <td width="47%" class="caja_texto_hr"><? echo $reg_data_1[9]; ?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">GESTOR</td>
    <td class="caja_texto_hr"><? echo $reg_usu[1]?></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">OBSERVACION</td>
    <td class="caja_texto_hr"><? echo $reg_data_1[7]; ?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="TitTablaI">
    <table width="225" border="0" cellpadding="0" cellspacing="0">
        <tr>          
          <td width="94" class="caja_textop" onclick="JAVASCRIPT:cerrar_win('0')">
          <img src="image/SAL.jpg" alt="" width="25" height="25" />Cerrar</td>
          <td width="115">&nbsp;</td>
        </tr>
    </table></td>
  </tr>  
</table>
<? } ?>
</body>
</html>