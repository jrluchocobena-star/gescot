<?php
include ("conexion_bd.php"); 

$id = $_GET["id"];
$dni = $_GET["dni"];
$iduser = $_GET["iduser"];

$cad="(select campo2,campo3,campo8 from tb_contactos_prueba where campo2='$dni' order by campo7,campo8)union(select campo2,campo3,campo8 from tb_contactos_prueba_bk where campo2='$dni' order by campo7,campo8)";
//echo $cad;
$res_1 = mysql_query($cad);
//$reg_1 = mysql_fetch_row($res_1);



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
<input name="id" type="hidden" id="id" value="<? echo $id; ?>" />
<input name="iduser" type="hidden" id="iduser" value="<? echo $iduser; ?>" />
<p>
  <? if ($opc=="1"){?>
</p>
<table width="95%" border="1" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
  <tr class="contador">    
    <td colspan="8">DATOS DEL CLIENTE - ACTUALIZACIONES ONLINE</td>
  </tr>

  <tr>    
    <td colspan="8">&nbsp;</td>
  </tr>

  <tr class="fdotxttabla">    
    <td width="15%">DNI</td>
    <td width="15%" >T.FIJO</td>
    <td width="15%">CEL.1 </td>
    <td width="16%">CEL.2</td>
    <td width="15%">CEL.3</td>
    <td width="16%">CEL.4</td>
    <td width="8%">PANEL</td>
  </tr>
  <tr>
    <td valign="top"><input name="xdni" type="text" class="caja_texto_est" id="xdni" size="20" maxlength="10" readonly value="<? echo $dni;?>" /></td>
    <td valign="top">
    <input name="xfijo" type="text" class="caja_texto_est" id="xfijo" size="20" maxlength="10" value="<? echo $reg_1[3];?>"  /></td>
    <td><input name="xcel1" type="text" class="caja_texto_est" id="xcel1" size="20" maxlength="10" value="<? echo $reg_1[4];?>"  />
    </td>
    <td><input name="xcel2" type="text" class="caja_texto_est" id="xcel2" size="20" maxlength="10" value="<? echo $reg_1[6];?>"/></td>
    <td><input name="xcel4" type="text" class="caja_texto_est" id="xcel3" size="20" maxlength="10" value="<? echo $reg_1[8];?>"/></td>
    <td><input name="xcel3" type="text" class="caja_texto_est" id="xcel4" size="20" maxlength="10" value="<? echo $reg_1[10];?>" /></td>
    <td rowspan="3" align="center" valign="top" class="caja_texto_est">&nbsp;</td>
  </tr>
  <tr>
    <td height="33" valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>    
    <td><input name="xop1" type="hidden" id="xop1" value="<? echo $reg_1[5];?>" />
    <select name="oper_1" id="oper_1" class="caja_texto_est" >
        <? 			
			print "<option value='0' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
    </select>
    </td>
    <td><input name="xop2" type="hidden" id="xop2" value="<? echo $reg_1[7];?>" />
    <select name="oper_2" id="oper_2" class="caja_texto_est" >
        <? 			
			print "<option value='0' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
    </select></td>
    <td><input name="xop3" type="hidden" id="xop3" value="<? echo $reg_1[9];?>" />
    <select name="oper_3" id="oper_3" class="caja_texto_est" >
        <? 			
			print "<option value='0' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
    </select></td>
    <td><input name="xop4" type="hidden" id="xop4" value="<? echo $reg_1[11];?>" />
    <select name="oper_4" id="oper_4" class="caja_texto_est" >
        <? 			
			print "<option value='0' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
    </select></td>
  </tr>  
     
</table>
<? } ?>

<table width="95%" border="0">
  <tr>
    <td class="caja_sb">
    <a href="JAVASCRIPT:cerrar_win('2')" class="caja_texto_pe"><img src="image/BT5.gif" width="20" height="20" border="0" />CERRAR</a>&nbsp;<a href="JAVASCRIPT:nuevo_nro_contacto()" class="caja_texto_pe"><img src="image/BT7.gif" width="20" height="20" border="0" />NUEVO</a></td>
    <td width="32%" align="right" >
      <input name="xdni" type="hidden"  id="xdni" size="30" maxlength="10" readonly="readonly" value="<? echo $dni;?>" class="caja_sb" />
    </td>
  </tr>
</table>
<P>
<div style="overflow:scroll">
  <table width="95%" border="0" class="marco_tabla">
  <tr>
    <td width="9%" class="contador">&nbsp;</td>
    <td width="38%" class="contador">TELEFONO</td>
    <td width="45%" class="contador">OPERADOR</td>
    <td width="8%" class="contador">PANEL</td>
  </tr>
  <? 
  while($reg_1=mysql_fetch_row($res_1)){	
  $i=$i+1;	
  ?>
  <tr>
    <td>&nbsp;</td>
    <td><input name="<? echo "xfijo".$i; ?>" type="text" class="caja_texto_est" id="<? echo "xfijo".$i; ?>"
    size="20" maxlength="10" value="<? echo $reg_1[1];?>"  /></td>
    <td><input name="xop_" type="text" class="caja_texto_sb" id="xop_" value="<? echo $reg_1[2];?>" />
      <select name="oper_" id="oper_" class="caja_texto_est" >
        <? 			
			print "<option value='0' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[1]'>$rowper[1]</option>";
			}
			?>
    </select></td>
    <td class="caja_texto_est"><img src="image/act.jpg" alt="" width="35" height="35" onclick="javascript:act_contacto('<? echo $reg_1[0];?>','<? echo "xfijo".$i; ?>')" /></td>
  </tr>
  <? } ?>
</table>
</div>
<p>
<div id="div_registro_contacto" style="display:none">
<table width="95%" border="0" class="marco_tabla">
  <tr>
    <td width="9%" class="contador">&nbsp;</td>
    <td width="38%" class="contador">TELEFONO</td>
    <td width="45%" class="contador">OPERADOR</td>
    <td width="8%" class="contador">PANEL</td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td><input name="nreferencia" type="text" class="caja_texto_pe" id="nreferencia" size="20" maxlength="9" /></td>
    <td><select name="n_oper" id="n_oper" class="caja_texto_pe" >
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