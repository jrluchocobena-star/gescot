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
<!--
.style1 {color: #0000FF}
-->
</style>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
<table width="100%" border="0">
  <tr>
    <td width="11%" valign="top" class="cabeceras_grid_color">Supervisor</td>
    <td width="19%" valign="top" class="cabeceras_grid_color">
	<select name="c_supervisor" id="c_supervisor" class="caja_texto_pe" 
	onchange="javascript:mostrar_gestorcot(this.value);" >
      <?php 			
			print "<option value='0' selected>Seleccione Supervisor</option>";
			$sql7="select iduser,ncompleto 
			from tb_usuarios where sgrupo='Sup' and estado='HABILITADO' and grupo='COT-TDP' order by ncompleto";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";			
			}
			print "<option value='T'>TODOS</option>";
			?>
    </select></td>
    <td width="6%" valign="top" class="cabeceras_grid_color">Gestor</td>
    <td width="38%" valign="top" class="cabeceras_grid_color"><div id="d_combo_gestor"></div></td>
    <td width="26%" valign="top" class="cabeceras_grid_color"><table width="200" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="54"><img id="bt_mostrar_detalle" src="image/baja.JPG" width="40" height="40" 
		  onclick="javascript:mostrar_detalle_usuarios()" /></td>
          <td width="49"><img src="image/EXCELES.JPG" width="40" height="40" onclick="javascript:exportar_aplicativos_usuarioscot()" /></td>
          <td width="97" class="cabeceras_grid_color"></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">
	  <a align='right' onclick='javascript:ir(2)' class="style1" style="cursor:pointer">    
	  <input name="t_inicio" type="text" class="caja_sb" id="t_inicio" size="1" maxlength="1" />
	  -->></a></td>
    <td align="right" class="style1">
	  <a align='left' onclick='javascript:ir(1)' style="cursor:pointer"><<--</a>
    <input name='t_fin' type='text' class='caja_sb' id='t_fin' size="1" maxlength="1" /></td>
  </tr>  
  <tr>
    <td colspan="2">
	<div id="load_1" style="float:none" align="center"></div></td>    
  </tr>
  <tr>
    <td colspan="2">	
	<div id="d_bandeja_usuarioscot" style="overflow:scroll"></div>
	</td>    
  </tr>
</table>


</body>
</html>
