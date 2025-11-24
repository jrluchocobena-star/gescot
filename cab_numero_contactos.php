<?php
include ("conexion_bd.php"); 
$iduser=$_GET["iduser"];
validar_logeo($iduser);
$idperfil=$_GET["idperfil"];
$pc=$_GET["pc"];



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="javascript1.2" type="text/javascript" src="funciones_js.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>


</head>

<body>
<input name="usu_contactos" type="text" class="caja_sb_st" id="usu_contactos" value="<? echo $iduser; ?>" size="30"/>

<table width="90%" align="center">
<tr>
  <td colspan="9" bgcolor="#185363"><img src="image/AGENDA.jpg" alt=""  />    
    </td>
</tr>
<tr>
  <td colspan="9" class="TitTablaI">EN ESTE MODULO SE MOSTRARA TODOS LOS NUMEROS TELEFONICOS QUE EL CLIENTE INDICA COMO NUMERO DE CONTACTO, SEA NUMERO FIJO Y/O NUMERO DE CELULAR DE CUALQUIER OPERADOR (CLARO, MOVISTAR, ETC).</td>
</tr>
<tr class="clsHoliDayCell">
  <td width="158" ><strong>PEDIDO</strong></td>
  <td width="158" ><strong>NUMERO DE DNI /RUC/CEX</strong></td>
  <td width="158"><strong>NUMERO CONTACTO</strong></td>
  <td width="128"><strong>APE. PATERNO</strong></td>
  <td width="128" class=""><strong>APE.MATERNO</strong></td>
  <td colspan="3" class=""><strong>PANEL</strong></td>
</tr>
<tr>
  <td ><input name="pedido" type="text" class="caja_texto_pe" id="pedido" size="20" maxlength="20" /></td>
  <td ><input name="dni" type="text" class="caja_texto_pe" id="dni" size="20" maxlength="20" /></td>
  <td><input name="ncontacto" type="text" class="caja_texto_pe" id="ncontacto" size="20"  /></td>
  <td><input name="ape_pat" type="text" class="caja_texto_pe" id="ape_pat" size="30" /></td>
  <td align="center" ><input name="ape_mat" type="text" class="caja_texto_pe" id="ape_mat" size="30"/></td>
  <td width="82" class="caja_texto_pe" onclick="javascript:buscar_contacto()">
    <img src="image/busca.jpg" alt="" width="30" height="30" >
    Buscar</td>
  <td width="129" class="caja_texto_pe" onclick="javascript:nuevo_nro_contacto()">
    <img src="image/usumas.jpg" width="30" height="30" />Nuevo Contacto</td>
  <td width="87" class="caja_texto_pe" > <img src="image/reg3.jpg" width="30" height="30" onclick="javascript:nueva_busqueda()"/>Limpia</td>
</tr>
<tr>
  <td colspan="9" class="clsHoliDayCell" >&nbsp;</td>
</tr>
</table>

<table width="90%" border="0" align="center">
  <tr>
    <td><div id="load" style="float:none" align="center"></div></td>
  </tr>
  <tr>
    <td><div id="div_lista_contactos" style="width:100%; height:600px;  overflow:auto; display:none" ></div>	</td>
  </tr>
  <tr>
    <td><div id="d_historico_contactos" style="width:100%; height:400px; overflow:auto; display:none" align="center"></div></td>
  </tr>
</table>





<!--
<div id="d_editar_contactos" style="width:100%; height:100px; display:none">
</div>	-->
<div id="div_registro_contacto" style="display:NONE">
<table width="90%" border="0" class="marco_tabla" align="center">
  <tr class="caja_texto_color">
    <td width="9%" >DNI</td>
    <td width="38%">APE.PAT</td>
    <td width="38%">APE.MAT</td>
    <td width="38%">NOMBRES</td>
    <td width="38%">TELEFONO</td>
    <td width="45%">OPERADOR</td>
    <td width="8%">GUARDAR</td>
  </tr> 
  <tr>
    <td><input name="n_dni" type="text" class="caja_texto_est" id="n_dni"  size="20" maxlength="9"  /></td>
    <td><input name="xape_pat" type="text" class="caja_texto_est" id="xape_pat" size="30"  /></td>
    <td><input name="xape_mat" type="text" class="caja_texto_est" id="xape_mat"  size="30"  /></td>
    <td><input name="nombres" type="text" class="caja_texto_est" id="nombres"  size="30"  /></td>
    <td><input name="n_referencia" type="text" class="caja_texto_est" id="n_referencia" size="20" maxlength="9" /></td>
    
    <td><select name="n_oper" id="n_oper" class="caja_texto_est" >
      <? 			
			print "<option value='0' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[1]'>$rowper[1]</option>";
			}
			?>
    </select></td>
    <td class="caja_texto_est"><img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_contacto()" /></td>
  </tr>
</table>
</div>
</body>
</html>