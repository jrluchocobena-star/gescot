<?php
include("conexion_bd.php");
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
validar_logeo($iduser);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />


<script language="javascript" src="funciones_js.js"></script>

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="58%"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
      
      <tr>
        <td width="9%" valign="top" class="cabeceras_grid">SUPERVISOR</td>
        <td width="14%" valign="top" class="cabeceras_grid"><select name="c_supervisor" id="c_supervisor" class="caja_texto_pe" >
          <?php 			
			print "<option value='0' selected>Seleccione Supervisor</option>";
			$sql7="select * from tb_supervisores where est='1'";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
        </select></td>
        <td width="10%" valign="top" class="cabeceras_grid">NOM. Y APE.</td>
        <td width="33%" valign="top" class="cabeceras_grid">
          <input name="xcompleto" type="text" class="caja_texto_pe" id="xcompleto" size="100" /></td>
        <td width="4%" valign="top" class="cabeceras_grid">CIP</td>
        <td width="8%" valign="top" class="cabeceras_grid"><input name="xcip" type="text" class="caja_texto_pe" id="xcip" size="15" maxlength="10" /></td>
        <td width="6%" valign="top" class="cabeceras_grid">DNI</td>
        <td width="8%" valign="top" class="cabeceras_grid">
          <input name="xdni" type="text" class="caja_texto_pe" id="xdni" size="15" maxlength="10" />          </td>
        <td width="8%" id="bt_busca" valign="top" class="caja_texto_pe" align="center" onclick="javascript:mostrar_lista_usuarios('1')">
          <img src="image/busca.jpg" alt=""  width="25" height="25" title="Busqueda"  />
          Buscar </td>
      </tr>
      <tr>
          <td colspan="9" class="celdas_detalle_guias">&nbsp;</td>
        </tr>
         <tr>
           <td valign="top" class="TitTablaI">&nbsp;</td>
           <td valign="top" class="TitTablaI">&nbsp;</td>
        <td valign="top" class="TitTablaI">&nbsp;</td>
        <td valign="top" class="TitTablaI">&nbsp;</td>
        <td valign="top" class="TitTablaI">&nbsp;</td>
        <td valign="top" class="TitTablaI">&nbsp;</td>
        <td colspan="2" valign="top" class="TitTablaI">&nbsp;</td>
        <td></td>
      </tr>
        <tr>
        <td colspan="9">
        <table width="60%" border="0">
          <tr>
          <td width="18%" class="caja_texto_pe" onclick="javascript:nuevo_usuario()">
          <img src="image/usumas.jpg" width="25" height="25" title="Nuevo Usuario" onclick="javascript:nuevo_usuario()" />
          Registrar gestor</td>
          <td width="18%" class="caja_texto_pe" id="bt_nuevo" 
          onclick="javascript:blanquea_criterio()">
          <img src="image/stock_copy.png" width="25" height="25" title="NUEVO"/>Nuevo busqueda          </td>
        <td width="14%" class="caja_texto_pe" onclick="javascript:ventana_modal('2')">
        <img src="image/BT3.gif" title="Exportar" width="30" height="25"/>Org</td>        
        <td width="14%" class="caja_texto_pe" id="bt_editar" style="display:none" 
        onclick="javascript:mostrar_edicion_maestra('<?php echo "2"; ?>')">
        <img src="image/liquidar.jpg" title="Editar" width="25" height="25"/> Editar        </td>
        <td width="30%">&nbsp;</td>
        <td width="6%">&nbsp;</td>        
          </tr>
        </table>        </td>
        </tr>
         <tr>
          <td colspan="9" class="celdas_detalle_guias">&nbsp;</td>
        </tr>
</table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
<div id="bandeja_criterios" style="display:none"> 
	<iframe id="lista_criterios"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"s style="border-collapse:collapse" class="marco_tabla"
    width="100%"  scrolling="Auto"  height="700"> 
	</iframe>
</div>
<p>
<div id="d_datos_usuarios" style="display:none"></div>

<div id="d_reg_usuario" style="display:	none">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
  <tr >
    <td width="10%" height="18" class="caja_texto_AMA">DNI</td>
    <td width="10%" class="caja_texto_AMA">CIP</td>
    <td width="10%" class="caja_texto_AMA">GRUPO</td>
    <td width="10%" class="caja_texto_AMA">&nbsp;</td>    
    <td width="10%" class="caja_texto_AMA">&nbsp;</td>
    <td width="10%" class="caja_texto_AMA">&nbsp;</td>
    <td width="10%" class="caja_texto_AMA">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" class="caja_texto_pe"><input name="dni" id="dni" type="text" class="caja_texto_cb"  onkeypress="return justNumbers(event);" size="20" maxlength="8" /> 
    (8 digitos) </td>
    <td class="caja_texto_pe"><input name="cip" id="cip" type="text" class="caja_texto_cb"  onkeypress="return justNumbers(event);" size="20" maxlength="9" />
    (9digitos)</td>
    <td class="caja_texto_pe"><select name="grupo" class="caja_texto_cb" id="grupo" >
      <option value="0">Escoger</option>
      <option value="COT-TDP">COT-TDP</option>
      <option value="TDP">TDP</option>
	   <option value="ATENTO">ATENTO</option>
      <option value="EECC">EECC</option>      
    </select></td>
    <td class="casilla_texto">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
    <td class="casilla_texto">&nbsp;</td>
    </tr>
  <tr>
    <td class="caja_texto_AMA">APELLIDO PATERNO</td>
    <td class="caja_texto_AMA">APELLIDO MATERNO</td>
    <td class="caja_texto_AMA">NOMBRES</td>
    <td class="caja_texto_AMA">LOGIN</td>
    <td class="caja_texto_AMA">CLAVE</td>
    <td class="caja_texto_AMA">PERFIL</td>
    <td class="caja_texto_AMA">&nbsp;</td>
    </tr>
  <tr>
    <td class="caja_texto_pe"><input name="APE_PAT" type="text" class="caja_texto_cb" id="APE_PAT" size="30" /></td>
    <td class="caja_texto_pe"><input name="APE_MAT" type="text" class="caja_texto_cb" id="APE_MAT" size="30" /></td>
    <td class="caja_texto_pe"><input name="NOMBRES" type="text" class="caja_texto_cb" id="NOMBRES" size="30" /></td>
    <td class="caja_texto_pe"><input name="login" type="text" class="caja_texto_cb" id="login" size="20" /></td>    
    <td class="caja_texto_pe"><input name="clave" type="text" class="caja_texto_cb" id="clave" size="20" /></td>    
    <td class="caja_texto_pe"> 
    <select name="perfil" id="perfil" class="caja_texto_cb" >
        <?php 			
			print "<option value='0' selected>Seleccione Perfil</option>";
			$sql7="select * from tb_perfil where id > 0";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
    </select>   </td>
    <td class="caja_texto_pe">
    <img src="image/vis.jpg" alt="" width="30" height="30" onclick="javascript:registrar_usuario()" />Guardar</td>
    </tr>
</table>

</div>
</body>
</html>