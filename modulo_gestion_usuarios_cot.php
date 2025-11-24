
<?PHP
include("conexion_bd.php");

$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="funciones_js.js"></script>
<script language="JavaScript" src="calendar1.js"></script> 
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo  $iduser; ?>"/>
  <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
  
<table width="80%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" class="marco_tabla">
      <tr class="boton">
        <td width="24%" class="">TRABAJADOR</td>
        <td width="23%" class="">TIPO DE REGISTRO</td>
        <td width="22%" class="">FECHA</td>
        <td width="25%" class="">NUM.REQUERIMIENTO</td>
      </tr>
      <tr>
        <td><select name="cb_gestor" id="cb_gestor" class="caja_sb" >
          <? 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			$sql1="select cip,dni,ncompleto from tb_usuarios where estado='HABILITADO' order by ncompleto";
		  	$queryresult1 = mysql_query($sql1) or die (mysql_error());
			while ($rowper1=mysql_fetch_row($queryresult1)) { 										  
			print "<option value='$rowper1[1]'>$rowper1[2] - $rowper1[1]</option>";
			}
			?>
        </select></td>
        <td><select name="cb_solicitud" id="cb_solicitud" class="caja_texto_pe" onchange="javascript:carga_combo_gu('c_motivos_gu',this.value,'gu_motivos','cod_tp_solicitud')" >
          <? 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			$sql2="select * from gu_tipo_solicitud";
		  	$queryresult2 = mysql_query($sql2) or die (mysql_error());
			while ($rowper2=mysql_fetch_row($queryresult2)) { 										  
			print "<option value='$rowper2[0]'>$rowper2[1]</option>";
			}
			?>
        </select></td>
        <td><form name="form1" id="form1">
          <input readonly="readonly" name="input1" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input1" />
          <a href="javascript:cal1.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
    /></a>
        </form></td>
        <td class="casilla_texto"><input name="n_req" class="caja_texto_pe" type="text" size="20" maxlength="22" id="n_req"  /></td>
      </tr>
      <tr class="boton">
        <td class="">MOTIVOS</td>
        <td class="">ESTADO</td>
        <td class="">POR</td>
        <td class="">AREA</td>
      </tr>
      <tr>
        <td><div id="d_motivos_gu"></div></td>
        <td><select name="cb_tpregistro" id="cb_tpregistro" class="caja_sb" 
     onchange="javascript:mostrar_coordinado('cb_aplicativos',this.value)" style="display:none">
          <? 			
			print "<option value='0' selected>Seleccione Motivos</option>";
			$sql4="select * from gu_estados";
		  	$queryresult4 = mysql_query($sql4) or die (mysql_error());
			while ($rowper4=mysql_fetch_row($queryresult4)) { 										  
			print "<option value='$rowper4[0]'>$rowper4[1]</option>";
			}
			?>
        </select></td>
        <td><div id="d_coordinado"></div></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" class="boton">OBSERVACIONES</td>
      </tr>
      <tr>
        <td colspan="4" ><textarea name="obs" cols="150" rows="3" class="caja_texto_sb" id="obs" 
        onkeypress="return tecla(event)"></textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="14%" class="caja_texto_pe" onclick="javascript:mostrar_frame_gu();"><img src="image/LISTAS.JPG" width="30" height="30" />LISTAR</td>
        <td width="15%" class="caja_texto_pe" onclick="javascript:grabar_gestion_usu()" id="bt_aceptar_gu" 
        style="display:none"><img src="image/usumas.jpg" width="30" height="30" />ACEPTAR</td>      
        <td width="18%">&nbsp;</td>
        <td width="16%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    <br>
    <div id="d_gestion_usuarios" style="display:none; overflow:auto">
        <iframe id="f_gestion_usuarios"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
            width="100%"  scrolling="Auto"  height="300px" > </iframe>
</div>
    </td>
  </tr>
</table>
<script language="JavaScript" type="text/javascript">
                        var cal1 = new calendar1(document.forms["form1"].elements['input1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;								
     </script>
</body>
</html>