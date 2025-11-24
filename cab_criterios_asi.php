<?php
include("conexion_bd.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js"></script>
</head>

<body>
<table width="80%" border="0" cellpadding="0" cellspacing="0" class="marco1">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="3%" valign="top"><span class="TitTablaI">CIP</span></td>
    <td width="22%" valign="top"><span class="casilla_texto">
      <input name="xcip" type="text" class="casilla_texto" id="xcip" size="15" />
    </span></td>
    <td width="6%" valign="top"><span class="TitTablaI">DNI</span></td>
    <td width="20%" valign="top"><span class="casilla_texto">
      <input name="xdni" type="text" class="casilla_texto" id="xdni" size="15" />
    </span></td>
    <td width="3%" align="center" valign="top">&nbsp;</td>
   <td width="8%" align="center" valign="top"><img src="image/busca.jpg" width="30" height="30" onclick="javascript:mostrar_lista_usuarios_asi()" /></td>
   <td width="7%" align="center" valign="top">&nbsp;</td>
   <td width="6%" align="center" valign="top">&nbsp;</td>
  </tr>
</table>
<p>
<div id="bandeja_criterios" style="display:none"> 
	<iframe id="lista_criterios"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"s style="border-collapse:collapse" class="marco_tabla"
    width="100%"  scrolling="Auto"  height="300"> 
	</iframe>
</div>
<p>
<div id="d_datos_usuarios" style="display:none">hola</div>
</body>
</html>