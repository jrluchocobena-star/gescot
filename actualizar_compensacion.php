<?php

include_once("conexion_bd.php");

$id		=$_GET["id"];
$clase  =$_GET["clase"];

//echo $clase;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript1.2">
function cerrar_modal_1(){
	//alert("entro")
		parent.modal.hide();
}	

</script>
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<? if ($clase=="PROGRAMACION"){
	
	$cad	="select * from programacion_extra where id='$id'";
	//echo $cad;
	$res 	=mysql_query($cad);		
	$reg	=mysql_fetch_row($res);
		
?>
<table width="60%" border="0">
  <tr>
    <td width="24%" valign="top" class="etiqueta_p">TIPO</td>
    <td width="76%" colspan="3" valign="top"><select name="tp_incidencia" class="caja_texto_pe" id="tp_incidencia" >
      <option value="0">ESCOGER</option>
      <option value="TRABAJOS DE FDS">TRABAJOS DE FDS</option>
      <option value="NECESIDAD DEL SERVICIO">NECESIDAD DEL SERVICIO</option>
      <? if ($idperfil=="5"){ ?>
      <? }else{ ?>
      <? if ($idperfil=="0"){  ?>
      <? }else{?>
      <? if ($iduser=="189"){ ?>
      <? }?>
      <? } 
			}?>
    </select>
      <span class="casilla_texto">
      <input name="xtipo" class="caja_texto_pe" type="hidden" size="20" maxlength="22" id="xtipo" 
      value="<? echo $reg[4]?>" />
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">FACTOR</td>
    <td colspan="3" valign="top"><select name="modo" size="1" class="caja_texto_pe" id="modo" onchange="javascript:mostrar_modo_P(this.value);" >
      <option value="0">Seleccionar</option>
      <option value="D">DIAS</option>
      <option value="H">HORAS</option>
    </select>
      <span class="casilla_texto">
      <input name="xmodo" class="caja_texto_pe" type="hidden" size="20" maxlength="22" id="xmodo" value="<? echo $reg[11]?>" />
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">FEC.INICIO</td>
    <td colspan="3" valign="top"><span class="casilla_texto">
      <input name="fec_ini" class="caja_texto_pe" type="text" size="20" maxlength="22" id="fec_ini" value="<? echo $reg[6]?>" />
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">FEC.FINAL</td>
    <td colspan="3" valign="top"><span class="caja_text1">
      <input name="fec_fin" class="caja_texto_pe" type="text" size="20" maxlength="22" id="fec_fin" value="<? echo $reg[7]?>" />
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">TIEMPO</td>
    <td colspan="3" valign="top" >
    <input name="tiempo_1" class="caja_texto_pe" type="text" size="15" maxlength="22" id="tiempo_1" 
    value="<? echo $reg[10]?>" readonly="readonly" />
      (Horas)</td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">OBS</td>
    <td colspan="3" valign="top"><textarea name="obs_2" cols="50" rows="3" class="caja_texto_pe" id="obs_2" onclick="calcular_tiempos_1()">
				<? 
				//$obs = limpia_espacios($reg[8]);
				echo limpia_espacios($reg[8]); ?>
                </textarea></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" class="clsCurrentMonthDay"><table width="100%" border="0">
      <tr>
        <td width="19%" class="caja_texto_pe" onclick="javascript:cerrar_modal_1()">Cerrar</td>
        <td width="18%" class="caja_texto_pe">Grabar</td>
        <td width="49%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<? } ?>

<? if ($clase=="COMPENSACION"){
	
	$cad_c	="select * from compensacion_extra where id='$id'";
	//echo $cad_c;
	$res_c 	=mysql_query($cad_c);		
	$reg_c	=mysql_fetch_row($res_c);	
?>
<table width="60%" border="0" class="marco_tabla_bandeja">
  <tr>
    <td width="24%" valign="top" class="etiqueta_p">FEC.INICIO</td>
    <td width="684%" colspan="3" valign="top"><span class="casilla_texto">
      <input name="fec_ini" class="caja_texto_pe" type="text" size="20" maxlength="22" id="fec_ini" 
      value="<? echo $reg_c[4]?>" />
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">FEC.FINAL</td>
    <td colspan="3" valign="top"><span class="caja_text1">
      <input name="fec_fin" class="caja_texto_pe" type="text" size="20" maxlength="22" id="fec_fin" 
      value="<? echo $reg_c[5]?>" />
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">TIEMPO</td>
    <td colspan="3" valign="top" ><input name="tiempo_1" class="caja_texto_pe" type="text" size="15" maxlength="22" id="tiempo_1" 
                  value="<? echo $reg_c[6]?>" readonly="readonly" />
      (Horas)</td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta_p">OBS</td>
    <td colspan="3" valign="top"><textarea name="obs_2" cols="50" rows="3" class="caja_texto_pe" id="obs_2" onclick="calcular_tiempos_1()">
				<? 
				//$obs = limpia_espacios($reg[8]);
				echo $reg[8]; ?>
                </textarea></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" class="clsCurrentMonthDay"><table width="100%" border="0">
      <tr>
        <td width="19%" class="caja_texto_pe" onclick="javascript:cerrar_modal_1()">Cerrar</td>
        <td width="19%" class="caja_texto_pe">Grabar</td>
        <td width="48%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<? } ?>
</body>
</html>