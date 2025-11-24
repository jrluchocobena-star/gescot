<?php
include("conexion_bd.php");
validar_logeo($iduser);

//var_dump($iduser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="funciones_js.js"></script> 


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>


<!-- jQuery --> 
<script type="text/javascript" src="js/jquery-min.js"></script>
<script type="text/javascript" src="js/ui.datepicker/ui.datepicker.js"></script>
<script type="text/javascript" src="js/ui.datepicker/ui.datepicker-es.js"></script>
<link href="js/ui.datepicker/ui.datepicker.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/abc_masivo/js/jquery.timer.js"></script>


</head>

<body>

<p>
<table width="70%" border="0" align="center">
  <tr>
    <td colspan="5" class="contador">INFORMACION DE TECNICOS DE LA CONTRATA</td>
  </tr>
  <tr>
    <td><input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/></td>
    <td colspan="3">&nbsp;</td>
    <td width="15%" rowspan="4" align="center">
    <img src="image/busca.jpg" alt=""  width="40" height="40" title="Busqueda" onclick="javascript:listar_tecnicos()" /></td>
  </tr>
  <tr>
    <td width="18%">NOMBRE COMPLETO</td>
    <td colspan="3"><select name="xtecnico" id="xtecnico" class="casilla_texto" onchange="javascript:listar_tecnicos()" >
      <? 			
			print "<option value='0' selected>SELECCIONE TECNICO</option>";
			$sql7="select * from tb_tecnicos where estado='HABILITADO' order by ncompleto";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[1]'>$rowper[3]-$rowper[2]-$rowper[1]</option>";
			}
			?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>DNI</td>
    <td width="21%"><span class="casilla_texto">
      <input name="xdni" type="text" class="casilla_texto" id="xdni" size="15" maxlength="10" />
    </span></td>
    <td width="9%">CIP</td>
    <td width="37%"><span class="casilla_texto">
      <input name="xcip" type="text" class="casilla_texto" id="xcip" size="15" maxlength="10" />
    </span></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5"><div id="d_lista_tecnicos"></div></td>
  </tr>
  
</table>




</body>
</html>
