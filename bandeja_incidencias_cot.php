<?php
include("conexion_bd.php");
$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="funciones_js.js"></script> 
<script language="JavaScript" src="calendar1.js"></script>


<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<script language="JavaScript1.2" src="bandejas/table.js"></script>
<script language="JavaScript1.2" src="bandejas/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="bandejas/table.css" media="all">

</head>

<body>	

<input name="arr_escogidos" type="hidden" class="casilla_texto" id="arr_escogidos" /><br>
<input name="arr_hor" type="hidden" class="casilla_texto" id="arr_hor" />
<input name="cip" type="hidden" class="casilla_texto" id="cip" value="<?php echo $reg[3];?>" />
<input name="dni" type="hidden" class="casilla_texto" id="dni" value="<?php echo $reg[4];?>" />
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser;?>" />
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil;?>" />
<input name="tp_incidencia" type="hidden" class="casilla_texto" id="tp_incidencia" value="<?php echo "MONITOREO Y CAPACITACION COT";?>" />
<input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<?php echo $franqueo;?>" />
<input name="chk_escogidos" type="hidden" class="caja_texto_sb" id="chk_escogidos" />
<input name="tt_c" type="hidden" class="caja_texto_sb" id="tt_c" />
<input name="chk_escogidos_" type="hidden" class="caja_texto_sb" id="chk_escogidos_" />
<table width="100%" border="0"> 
	<tr>
  <td colspan="6">
  <table width="100%" border="0">
    <tr>
      <td width="16%" class="caja_texto_pe">SUPERVISOR</td>
      <td width="14%" class="caja_texto_pe"><select name="c_supervisor" id="c_supervisor" class="caja_sb" 
            onchange="javascript:mostrar_bandeja_incidencias(this.value)"  >
        <?php 			
			print "<option value='0' selected>Seleccione Supervisor</option>";
			$sql7="select * from tb_supervisores where est='1' order by nom_supervisor";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
      </select></td>
      <td width="6%" valign="top" class="">&nbsp;</td>      
      <td width="11%" class="caja_texto_pe" id="add_part" onclick="javascript:aprobar_incidencias('1')"><a class="caja_texto_pe"> <img src="image/bookmark_add.png" width="30" height="30" />Aprobar</a></td>
      <td width="11%" class="caja_texto_pe" id="add_part" onclick="javascript:aprobar_incidencias('2')"><a class="caja_texto_pe"> <img src="image/anula2.jpg" width="32" height="32" />Rechazar</a></td>
      <td width="38%" class="caja_texto_pe" onclick="javascript:cerrar_win('3')"><a class="caja_texto_pe"> <img src="image/SAL.jpg" width="30" height="30" />Salir</a></td>
    </tr>
    <tr>
    <td colspan="8"><div id="load" style="float:none" align="center"></div></td>
  </tr>
    <tr>
      <td colspan="8"><p></p>
        <form name="f1">
          <div id="d_bandeja_incidencias_cot"></div>
        </form></td>
    </tr>
  </table></td>
</tr>
</table>
</body>
</html>
