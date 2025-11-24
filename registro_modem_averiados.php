<?php
include("conexion_bd.php");
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
validar_logeo($iduser);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script src="funciones_js.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td colspan="10"><input name="iduser" type="hidden" id="iduser" value="<? echo $iduser; ?>" size="30" />
      <input name="idperfil" type="hidden" id="idperfil" value="<? echo $idperfil; ?>" size="30" /></td>
  </tr>
  <tr>
    <td width="8%" class="caja_texto1">COD.AVERIA</td>
    <td width="15%" class="caja_texto1"><span class="casilla_texto">
      <input name="c_averia" type="text" class="casilla_texto" id="c_averia" size="20" maxlength="9" />
    </span></td>
    <td width="3%" class="caja_texto1">TIPO</td>
    <td width="12%" class="caja_texto1"><select name="tipo" id="tipo" class="casilla_texto" >
      <option selected value="0">ESCOGER</option>
      <option value="DECO">DECO</option>
      <option value="MODEM" selected>CABLE MODEM</option>     
    </select></td>
    <td width="4%" class="caja_texto1">CANAL</td>
    <td width="13%" class="caja_texto1">
    <select name="medio" id="medio" class="casilla_texto" >
    <option selected value="0">ESCOGER</option>     
      <option value="CORREO">VIA CORREO</option>
      <option value="TELEGRAM">VIA TELEGRAM</option>     
    </select></td>
   <td class="caja_texto_cb" id="bt_sep" onclick="javascript:registro_modem()" >
   <img  src="image/visto3.jpg" width="32" height="32" />RESERVAR</td>
    <td width="5%" class="caja_texto1">&nbsp;</td>
    <td width="9%" class="caja_texto1">&nbsp;</td>
    <td width="1%" class="caja_texto1">&nbsp;</td>
    <? if ($idperfil<>1){?>
    <td width="13%" class="caja_texto_cb" onclick="javascript:bandeja_modem_ave('<? echo $iduser; ?>','<? echo $idperfil; ?>');"><img src="image/LISTAS.JPG" width="40" height="40" />BANDEJA</td>
	<? } ?>    
    <td width="6%" class="caja_texto1">&nbsp;</td>
  </tr>
</table>
<br>
<div id="d_detalle_pedidos_decos" style="display:none">
<table width="100%" border="0" cellpadding="1" cellspacing="1">
  
  <tr>
    <td colspan="9" valign="top" class="cabec_1">&nbsp;</td>
    </tr>
  <tr>
    <td width="9%" valign="top">DEPARTAMENTO</td>
    <td width="22%" valign="top"><span class="caja_textom">
      <select name="dpto" id="dpto" class="casilla_texto" >
        <option value="0">ESCOGER</option>
        <option value="AMA">AMA|AMAZONAS</option>
        <option value="ARE">ARE|AREQUIPA</option>
        <option value="AYA">AYA|AYACUCHO</option>
        <option value="CAJ">CAJ|CAJAMARCA</option>
        <option value="CHI">CHI|CHICLAYO</option>
        <option value="CTE">CTE|CHIMBOTE</option>
        <option value="CUS">CUS|CUSCO</option>
        <option value="HCV">HCV|HUANCAVELICA</option>
        <option value="HNC">HNC|HUANUCO</option>
        <option value="HUA">HUA|HUANCAYO</option>
        <option value="ICA">ICA|ICA</option>
        <option value="LIM">LIM|LIMA</option>
        <option value="LOR">LOR|LORETO</option>
        <option value="MDD">MDD|MADRE DE DIOS</option>
        <option value="MOQ">MOQ|MOQUEGUA</option>
        <option value="PAS">PAS|PASCO</option>
        <option value="PIU">PIU|PIURA</option>
        <option value="PUN">PUN|PUNO</option>
        <option value="SMT">SMT|SANMARTIN</option>
        <option value="TAC">TAC|TACNA</option>
        <option value="TRU">TRU|TRUJILLO</option>
        <option value="TUM">TUM|TUMBES</option>
        <option value="UCA">UCA|UCAYALI</option>
        <option value="IQU">IQU|IQUITOS</option>
      </select>
    </span></td>
    <td width="11%" valign="top">CONTRATA</td>
    <td width="14%" valign="top"><span class="caja_texto1">
      <select name="contrata" id="contrata" class="casilla_texto" >
        <option value="0">ESCOGER</option>
        <option value="COBRA">COBRA</option>
        <option value="LARI">LARI</option>
        <option value="ANOVO">ANOVO</option>
        <option value="DOMINIUM">DOMINIUM</option>
        <option value="EZENTIS">EZENTIS</option>
            </select>
    </span></td>
    <td width="14%" valign="top">RESULTADO</td>
    <td width="28%" valign="top"><span class="caja_texto1">
      <select name="est" id="est" class="casilla_texto" >
        <option value="0">ESCOGER</option>
        <option value="PROCEDE">PROCEDE</option>
        <option value="NO PROCEDE">NO PROCEDE</option>
      </select>
    </span></td>
    <td width="20%" class="caja_texto_cb"><img src="image/grabar.jpg" width="40" height="40" onclick="javascript:act_pedido_modem();" />GUARDAR</td>
    <td width="2%">&nbsp;</td>
    <td width="20%" class="caja_texto_cb"><img src="image/anula3.jpg" width="45" height="45" onclick="javascript:rechazar_modem();" />RECHAZAR</td>
  </tr>
   <tr>
    <td colspan="9" valign="top" class="cabec_1">&nbsp;</td>
    </tr>
</table>

</div>

<br><div id="d_bandeja_pedidos_decos" style="overflow:scroll;display:none"></div>
<br> 
<div id="d_bandeja_modem_ave" style="display:none"> 
	<iframe id="i_bandeja_modem_ave"  
    frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" 
    style="border-collapse:collapse" class="marco_tabla"
    width="100%"  scrolling="Auto"  height="500"> 
	</iframe>
</div>

</body>
</html>
