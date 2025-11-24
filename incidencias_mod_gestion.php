<?php
include("conexion_bd.php");

$iduser		=$_GET["iduser"];
$idperfil	=$_GET["idperfil"];
$accion		=$_GET["accion"];
$c_inc		=$_GET["c_inc"];
$ejec		=$_GET["ejec"];



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
  <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
  <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
  <input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<? echo $c_inc; ?>"/>
<p>
  
<? if ($accion=="Registro"){?>

<table width="100%" border="0" cellpadding="1" cellspacing="1" class="marco_tabla_red">
      <tr class="caja_texto1">
        <td width="87" valign="top" class="clsCurrentMonthDay">TRABAJADOR</td>
        <td colspan="2"><select name="gestor" id="gestor" class="caja_sb" >
          <? 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			print "<option value='T'>TODOS</option>";
			$sql7="select cip,dni,ncompleto from tb_usuarios where estado='HABILITADO' order by ncompleto";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]-$rowper[1]'>$rowper[2] - $rowper[0]</option>";			
			}
			?>
        </select></td>
      </tr>
      <tr>
        <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="caja_texto1">
        <td valign="top" class="clsCurrentMonthDay">TIPO</td>
        <td width="208"><select name="tp_incidencia" class="caja_sb" id="tp_incidencia" 
    onchange="javascript:carga_combo('c_mot_inc',this.value)">
          <option value="0">ESCOGER</option>
		  <option value="INCIDENCIAS">INCIDENCIAS</option>
          <option value="PERMISO">PERMISO</option>
          <option value="LICENCIAS">LICENCIAS</option>
		   <option value="FALTA CON AVISO">FALTA CON AVISO</option>
          <option value="INCIDENCIAS DE SISTEMAS">INCIDENCIAS DE SISTEMAS</option>
          <option value="CAMBIO DE TURNO">CAMBIO DE TURNO</option>
          <option value="COMPENSACIONES">COMPENSACIONES</option>
        </select></td>
        <td width="276"><div id="d_doid" style="display:none">DOID:
          <input name="c_doid" type="text" class="caja_texto_cb" id="c_doid" size="25" 
      maxlength="20"                />
        </div></td>
      </tr>
      <tr>
        <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="caja_texto1">
        <td valign="top" class="clsCurrentMonthDay">MOTIVO</td>
        <td colspan="2"><div id="c_mot_inc"></div></td>
      </tr>
      <tr>
        <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="caja_texto1">
        <td valign="top" class="clsCurrentMonthDay">MODO</td>
        <td><select name="modo" size="1" class="caja_sb" id="modo" onchange="javascript:mostrar_modo(this.value);" >
          <option value="0">Seleccionar</option>
          <option value="D">DIAS</option>
          <option value="H">HORAS</option>
        </select></td>
        <td><div id="d_numero_afe" style="display:none">AFECTADOS:
          <input name="nro" type="text" class="caja_texto_cb" id="nro" size="25" 
      maxlength="20"                />
        </div></td>
      </tr>
      <tr>
        <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" class="caja_texto1">&nbsp;</td>
        <td colspan="2">
        <form name="form1" id="form1">
          <div id="f_dias" style="display:NONE">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="18%" class="caja_sb">FEC. INICIO </td>
                <td width="34%"><input readonly="readonly" name="input1" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input1" />
                  <a href="javascript:cal1.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
           /></a></span></td>
                <td width="11%" class="caja_sb">FEC. FIN </td>
                <td width="37%"><input readonly="readonly" name="input2" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input2" />
                  <a href="javascript:cal2.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"
          /></a></span></td>
              </tr>
            </table>
          </div>
          <div id="f_horas" style="display:none">
            <table width="100%"  class="marco_tabla">
              <tr>
                <td width="20%" class="caja_sb">FECHA </td>
                <td colspan="5"><input readonly="readonly" name="input3" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input3" />
                  <a href="javascript:cal3.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
          /></a></span></td>
              </tr>
              <tr>
                <td class="caja_sb">&nbsp;</td>
                <td width="13%">HORAS</td>
                <td width="15%">MINUTOS</td>
                <td class="caja_sb">&nbsp;</td>
                <td width="14%">HORAS</td>
                <td width="23%">MINUTOS</td>
              </tr>
              <tr>
                <td width="20%" class="caja_sb">HORA INICIO</td>
                <td><label for="tiempo_1"></label>
                  <select name="h_ini" size="1" class="caja_texto_cb" id="h_ini" >
                    <option value="0"> </option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                  </select>
                  : </td>
                <td><select name="mm_ini" size="1" class="caja_texto_cb" id="mm_ini" >
                  <option value="00">00</option>
                  <option value="15">15</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
                </select></td>
                <td width="15%" class="caja_sb">HORA FIN</td>
                <td><select name="h_fin" size="1" class="caja_texto_cb" id="h_fin" 
        onchange="javascript:validar_horas(this.value);" >
                  <option value="0"> </option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                </select>
                  : </td>
                <td><select name="mm_fin" size="1" class="caja_texto_cb" id="mm_fin" >
                  <option value="00">00</option>
                  <option value="15">15</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
                </select></td>
              </tr>
            </table>
          </div>
        </form>
          <script language="JavaScript" type="text/javascript">
                        var cal1 = new calendar1(document.forms["form1"].elements['input1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;
										
                        
                        var cal2 = new calendar1(document.forms["form1"].elements['input2']);
                        cal2.year_scroll = true;
                        cal2.time_comp = false;		
						
						var cal3 = new calendar1(document.forms["form1"].elements['input3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;									
                        
						
                        
        </script></td>
      </tr>
      <tr>
        <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="caja_texto1">
        <td valign="top" class="clsCurrentMonthDay">TIEMPO</td>
        <td colspan="2"><input name="tiempo" type="text" class="caja_sb" id="tiempo" value="0" size="8" readonly="readonly" />
        <input name="exc" type="text" class="caja_sb" id="exc" size="15" readonly="readonly" /></td>
      </tr>
      <tr>
        <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr class="caja_texto1">
        <td valign="top" class="clsCurrentMonthDay">OBSERVACION</td>
        <td colspan="2"><textarea name="obs" cols="50" rows="3" class="casilla_texto" id="obs" onclick="calcular_tiempos()">
        </textarea>						</td>
      </tr>
     
</table>

<table width="100%" border="0">
  <tr>     
    <td width="13%" onclick="JAVASCRIPT:cerrar_win('3')" class="caja_texto_pe">
    <img src="image/SAL.jpg" alt="" width="25" height="25" />Cerrar</td>
    <td width="2%">&nbsp;</td>
    <td width="15%" class="caja_texto_pe" id="bt_aceptar" onclick="javascript:grabar_incidencia('1')">
    <img src="image/grabar.jpg" alt="" width="30" height="25" />Grabar</td>
    <!--
     <td width="106" class="caja_texto_pe" onclick="javascript:grabar_incidencia_prueba('1')">
    <img src="image/grabar.jpg" alt="" width="30" height="25" />Grabar1</td>
    -->
    <td width="38%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
  </tr>
</table>
<? } ?>
<p>
<? if ($accion=="Editar"){
	
$cad="select * from cab_incidencia where cod_incidencia='$c_inc'";	
//echo $cad;
$res = mysql_query($cad);
$reg =mysql_fetch_row($res);	
	
	?>
<table width="80%" border="0" class="marco_tabla_bandeja">
              <tr>
                <td valign="top" class="clsCurrentMonthDay">COD.INCIDENCIA</td>
                <td width="47%" valign="top"><input name="xcip_" type="text" class="caja_texto_cb" id="xcip_" size="25" maxlength="20" 
                value="<? echo $c_inc?>" readonly/></td>
                <td width="4%" valign="top">&nbsp;</td>
                <td width="35%" valign="top"><input name="ejecutado" type="checkbox" id="ejecutado" value="1" checked="checked" />
                  EJECUTADO</td>
  </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">FEC.INICIO</td>
                <td colspan="3" valign="top"><span class="casilla_texto">
                  <input name="fec_ini" class="caja_sb" type="text" size="20" maxlength="22" id="fec_ini" value="<? echo $reg[6]?>" />
                </span></td>
  </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">FEC.FINAL</td>
                <td colspan="3" valign="top"><span class="caja_texto1">
                  <input name="fec_fin" class="caja_sb" type="text" size="20" maxlength="22" id="fec_fin" value="<? echo $reg[7]?>" />
                </span></td>
  </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">TIEMPO</td>
                <td colspan="3" valign="top" >
                  <input name="tiempo_1" class="caja_sb" type="text" size="15" maxlength="22" id="tiempo_1" 
                  value="<? echo $reg[12]?>" readonly />
                (Horas)</td>
              </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">OBS</td>
                <td colspan="3" valign="top">                
                <textarea  cols="50" rows="3" class="caja_sb">
				<? 
				//$obs = limpia_espacios($reg[8]);
				echo trim($reg[8]); ?>
                </textarea>
               </td>
  			</tr>
            <tr>
                <td width="14%" valign="top">&nbsp;</td>
 			</tr>
            <tr>
                <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
                <td colspan="3" valign="top">&nbsp;</td>
  </tr>
            
</table>

<table border="0">           
              <tr>             
              <td onclick="JAVASCRIPT:cerrar_win('4')">              
              <a class="caja_texto_pe" >CERRAR</a>
              <td onclick="javascript:act_incidencias();" style="display:none">
              <a class="caja_texto_pe" >ACTUALIZAR</a>              
              </td>
  </tr>
</table>
<? } ?>

</body>

</html>