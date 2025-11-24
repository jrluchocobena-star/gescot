<?php
include("conexion_bd.php");
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
validar_logeo($iduser);
//ini_set("default_charset", "UTF-8");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js"></script>


<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>

<style type="text/css">
.style1 {color: #0000FF}
.error_color { color: #FF3333;font-size: 12px;}
.ok_color { color: #0C9306;font-size: 12px;}
.warning_color { color: #F4A417;font-size: 12px;}
.loading_color { color: #7B7D7B; font-size: 12px;}
</style>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
<table width="100%" border="0">
  <tr>
    <td width="11%" valign="top" class="cabeceras_grid_color">Carga masiva de gestores con el horario.</td>
    <td width="19%" valign="top" class="cabeceras_grid_color">
    <input type="file" name="imp_archivo_horario" id="imp_archivo_horario" class="caja_texto_pe">
    </td>
    <td  class="caja_texto_pe"  width="10%">
     <button style="cursor: pointer" id="btn_cargar_file" class="caja_texto_pe" onclick="javascript:cargar_horarios();"><img src="image/upload.gif" width="22" height="22" />Cargar archivo</button></td>
    <td width="38%" valign="top" class="cabeceras_grid_color"><div id="mensaje_carga_horarios"></div>
</td>
  </tr>
</table>

</body>
</html>
