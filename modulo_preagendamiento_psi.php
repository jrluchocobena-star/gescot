<?php 
include ("conexion_bd.php"); 
$iduser=$_GET["iduser"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MODULO PRE AGENDAMIENTO PSI</title>
<script language="javascript" src="ac.js"></script>
<link rel="stylesheet" href="ac.css" >
<script language="JavaScript1.2" src="/js/dqm_loader.js"></script>
<script language="JavaScript" src="calendar1.js"></script> 
<li


<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post" name="ingreso" id="ingreso">
<table width="80%" border="0">
  <tr>
    <td colspan="4" bgcolor="#0C3249"><img src="image/ICO2.jpg" alt="" width="520" height="68" /></td>
  </tr>
  <tr>
    <td width="129" height="15" class="clsDataArea">NRO. TICKETS PSI</td>
    <td width="199" class="TitTablaI">E<input name="ticket" type="text" class="caja_sb" id="ticket" size="20" maxlength="8" /></td>
    <td width="102" class="TitTablaI">&nbsp;</td>
    <td width="219">&nbsp;</td>
  </tr>
  <tr>
    <td class="clsDataArea">REGISTRADO POR</td>
    <td><? 
	$qry100 = "select * from tb_usuarios where iduser='$iduser'";
	//echo $qry100;
	$res100 = mysql_query($qry100);											
	$usu	= mysql_fetch_array($res100);
	echo $usu[1];
	?></td>
    <td class="TitTablaI">FECHA REGISTRO</td>
    <td><? echo date("Y-m-d H:i:s");;?></td>
  </tr>
  <tr>
    <td class="clsDataArea">NOMBRE CONTACTO</td>
    <td><input name="n_contacto" type="text" class="aviso" id="n_contacto" size="60"  /></td>
    <td class="TitTablaI">TELF. CONTACTO</td>
    <td><input name="t_contacto" type="text" class="aviso" id="t_contacto" /></td>
  </tr>
  <tr>
    <td class="clsDataArea">MOTIVO</td>
    <td><select name="t_servicio" class="caja_texto1" id="t_servicio" onchange="">
      <option value="0" selected="selected">ESCOGER</option>
      <option value="1">TELEFONO TUPS</option>
      <option value="2">TELEFONO MOVIL</option>
    </select></td>
    <td colspan="2" class="TitTablaI">&nbsp;</td>
  </tr>
  <tr>
    <td class="clsDataArea">FEC.REG. AVERIA</td>
    <td><span class="caja_texto1">
      <input readonly="readonly" name="input1" class="caja_texto1" type="text" value="<? echo date("d");?>-<? echo date("m");?>-<? echo date("20y");?>" size="10" maxlength="10" id="input1" />
    <a href="javascript:cal1.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></span></td>
    <td class="TitTablaI">FEC.FIN AVERIA</td>
    <td><span class="caja_texto1">
      <input readonly="readonly" name="input2" class="caja_texto1" type="text" value="<? echo date("d");?>-<? echo date("m");?>-<? echo date("20y");?>" size="10" maxlength="10" id="input2" />
    <a href="javascript:cal2.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></span></td>
  </tr>
  <tr>
    <td class="clsDataArea">FEC. AGENDAMIENTO</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="clsDataArea">OBSERVACION</td>
    <td colspan="3" valign="top"><textarea name="obs" cols="60"  rows="4" class="aviso" id="obs" ></textarea></td>
    </tr>
</table>
</form>
<script language="JavaScript">
				var cal1 = new calendar1(document.forms["ingreso"].elements['input1']);
				cal1.year_scroll = true;
				cal1.time_comp = false;
				
				var cal2 = new calendar1(document.forms["ingreso"].elements['input2']);
				cal2.year_scroll = true;
				cal2.time_comp = false;
				/*
				var cal3 = new calendar1(document.forms["ingreso1"].elements['input3']);
				cal3.year_scroll = true;
				cal3.time_comp = false;
				*/
      </script>

</body>
</html>