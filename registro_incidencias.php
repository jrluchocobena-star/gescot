<?php
include("conexion_bd.php");
validar_logeo($iduser);
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript" src="js/ac.js"></script>
<link rel="stylesheet" href="js/ac.css" >
<script language="JavaScript" src="calendar1.js"></script> 
<script language="javascript" src="funciones_js.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />

</head>

<body>

<table width="100%" border="0">
  <tr>
    <td valign="top">    
    <table width="500" border="0" class="marco_tabla_bandeja">
      <tr>        
        <td onclick="javascript:mant_incidencia('1');"><img src="image/bt1.jpg" alt="" width="128" height="37"></td>
        <? if ($idperfil=="0" or $idperfil=="2" or $idperfil=="3"){?>
        <td onclick="javascript:mant_incidencia('2');"><img src="image/bt_2.jpg" alt="" width="141" height="40" /></td>    	        
        <? } ?>
        <? if ($idperfil=="0" or $idperfil=="5"){?>
	        <td onclick="javascript:mant_incidencia('7');"><img src="image/bt_3.jpg" alt="" width="150" height="38" /></td>
        <? } ?>
        <td class="">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
   </td>
  </tr>
     <tr>
    <td>
    <p>
     <div id="d_nuevo_incidencia" style="display:block">    
      <table width="98%" class="marco_tabla_red">
        <tr class="clsOuterFrame">
          <td colspan="13" class="Et_horarios">MODULO DE REGISTRO DE INCIDENCIAS DEL TRABAJADOR
            <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
            <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/></td>
        </tr>
        <tr>
          <td class="caja_texto_hr">TRABAJADOR</td>
          <td class="caja_cborde"width="0%">&nbsp;</td>
          <td class="caja_texto_hr"width="18%">TIPO</td>
          <td class="caja_cborde" width="0%">&nbsp;</td>
          <td class="caja_texto_hr"width="4%">MOTIVO</td>
          <td class="caja_cborde"width="0%">&nbsp;</td>
          <td class="caja_texto_hr"width="13%">FECHA INICIO</td>
          <td class="caja_cborde"width="0%">&nbsp;</td>
          <td class="caja_texto_hr"width="11%">FECHA FIN </td>
          <td class="caja_cborde"width="0%">&nbsp;</td>
          <? if ($idperfil=="5" or $idperfil=="0"){ ?>         
          <td class="caja_texto_hr"width="6%">NRO.PART</td>
          <? } ?>
          <td class="caja_cborde"width="0%">&nbsp;</td>
          <td class="caja_texto_hr"width="21%">OBSERVACION</td>
        </tr>
        <form name="form1">    
          <tr>
            <?php
//	$empresa=1;
    $caja_busqueda='tecnico'.$empresa;
    //print $caja_busqueda;
    ?>
            <td valign="top">
            <select name="gestor" id="gestor" class="caja_texto1" >
              <? 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			$sql7="select cip,ncompleto from tb_usuarios where estado='HABILITADO'";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1] - $rowper[0]</option>";
			}
			?>
            </select>
            <!--
            <input autocomplete="off" type="text" id="<?php print $caja_busqueda; ?>" 
		name="tecnico" value="" size="60" class="caja_texto1" style="width:310"/></td>
            
            <script language="javascript">
        //var tec = 'tecnico'+<? print $empresa;?>;
        
        var ac3 = new AC('<?php print $caja_busqueda; ?>', '<?php print $caja_busqueda; ?>');
        ac3.enable_unicode();
        ac3.update_input = function() {
            this.obj.value = this.div.childNodes[this.selected_option].value;
            //alert(this.obj.value);
            
        }
        
        var tecnico = new AC('<?php print $caja_busqueda; ?>');
        
        tecnico.url = 'js/frame.php';
        tecnico.highlight = true;
        tecnico.update_input = function() {
            this.obj.value = this.div.childNodes[this.selected_option].value;
        
            
        }
        //document.form2.tecnico.focus();
        </script>
          -->  
            <td valign="top">&nbsp;</td>
            <td valign="top"><select name="tp_incidencia" class="caja_texto1" id="tp_incidencia" onchange="javascript:carga_combo('c_mot_inc',this.value)">          
              <option value="0">ESCOGER</option>            
              <? if ($idperfil=="5"){ ?>
              <option value="MONITOREO Y CAPACITACION COT">MONITOREO Y CAPACITACION COT</option>
              <? }else{ ?>
				  <? if ($idperfil=="0"){  ?>
                  <option value="MONITOREO Y CAPACITACION COT">MONITOREO Y CAPACITACION COT</option>
                  <option value="PERMISO">PERMISO</option>                              
                  <option value="INCIDENCIAS DE SISTEMAS">INCIDENCIAS DE SISTEMAS</option>
                  <option value="VACACIONES">VACACIONES</option>
                  <option value="HORAS EXTRAS">HORAS EXTRAS</option>
                  <? }else{?>
                  			<? if ($iduser=="189"){ ?>
                            <option value="MONITOREO Y CAPACITACION COT">MONITOREO Y CAPACITACION COT</option>
                            <? }?>
                  <option value="PERMISO">PERMISO</option>
                  <option value="INCIDENCIAS DE SISTEMAS">INCIDENCIAS DE SISTEMAS</option>
                  <option value="VACACIONES">VACACIONES</option>
                  <option value="HORAS EXTRAS">HORAS EXTRAS</option>                
              <? } 
			}?>
              </select></td>
            <td valign="top">&nbsp;</td>
            <td valign="top"><div id="c_mot_inc"></div></td>
            <td valign="top">&nbsp;</td>
            <td valign="top"><span class="caja_texto1">
              <input readonly="readonly" name="input1" class="caja_texto1" type="text" size="17" maxlength="20" id="input1" />
              <a href="javascript:cal1.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></span></td>
            <td valign="top">&nbsp;</td>
            <td valign="top"><span class="caja_texto1">
              <input readonly="readonly" name="input2" class="caja_texto1" type="text" size="17" maxlength="20" id="input2" />
              <a href="javascript:cal2.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></span></td>
            <td>&nbsp;</td>
            <? if ($idperfil=="5" or $idperfil=="0"){ ?>
            <td align="center" valign="top"><input name="num_part" type="text" class="caja_texto1" id="num_part" size="5" maxlength="10" /></td>
            <? } ?>
            <td>&nbsp;</td>
            <td><textarea name="obs" cols="40" rows="3" class="casilla_texto" id="obs"></textarea></td>
            </tr>
        </form>
          
          <tr>
            <td colspan="13" class="Et_horarios" >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="13" ><img src="image/grabando.jpg" name="bt_grabar_incidencia" width="100" height="30" id="bt_grabar_incidencia" onclick="javascript:grabar_incidencia()"/></td>
          </tr>
        </table>     
      </div>   
    </td>
              
       <script language="JavaScript">
                        var cal1 = new calendar1(document.forms["form1"].elements['input1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = true;
										
                        
                        var cal2 = new calendar1(document.forms["form1"].elements['input2']);
                        cal2.year_scroll = true;
                        cal2.time_comp = true;									
                        
                        
        </script>
        
		

  </tr>
  
  
  <tr>
    <td>
    <div id="d_edit_incidencia" style="display:block">
                <table width="110%" border="0" class="marco_tabla_bandeja">
              <tr>
                <td colspan="11" valign="top" class="fdotxttabla">&nbsp;</td>
                </tr>
              <tr>
                <td width="8%" valign="top">COD.INCIDENCIA</td>
                <td width="12%" valign="top">
                 <input name="xid" type="hidden" class="caja_texto1" id="xid" size="10" maxlength="10" readonly/>
                  <input name="xcip_" type="text" class="caja_texto1" id="xcip_" size="20" maxlength="20" readonly/>
                </td>    
                <td width="7%" valign="top">FEC.INICIO</td>
                <td width="10%" valign="top"><span class="casilla_texto">
                  <input name="fec_ini" class="caja_texto1" type="text" size="18" maxlength="22" id="fec_ini" />
                </span></td>
                <td width="5%" valign="top">FEC.FINAL</td>
                <td width="9%" valign="top"><span class="caja_texto1">
                  <input name="fec_fin" class="caja_texto1" type="text" size="18" maxlength="22" id="fec_fin" />
                </span></td>                                                         
                <td width="7%" valign="top">OBS</td>
                <td width="25%"><textarea name="xobs" cols="40" rows="3" class="casilla_texto" id="xobs"></textarea></td>
                <td width="10%" valign="top">
                <input name="ejecutado" type="checkbox" id="ejecutado" value="1" checked="checked" style="display:none" />
                <a id="ejec" style="display:none">EJECUTADO</a>
                </td>  
              </tr>             
              <tr>
              <td onclick="javascript:act_incidencias();">
              <a class="boton_3" >ACTUALIZAR</a>              
              </td>
              <td onclick="javascript:cerrar_edit_indicencia();">              
              <a class="boton_3" >CERRAR</a>
              </tr>
            </table>
    </div>
    </td>
  </tr>
  
  
  
  
  
  <tr>
    <td>
    <form name="form2">

<div id="cab_incidencia" style="display:none">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td ><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="360" class="celdas">CIP</td>
        <td width="259" class="celdas">MES</td>
        <td width="249" class="celdas">SUPERVISOR</td>
        <td width="362" class="celdas">MOTIVO</td>
       <td width="362" class="celdas">PANEL</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td valign="top" >
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td><span class="casilla_texto">
          <input name="xcip1" type="text" class="casilla_texto" id="xcip1" size="30" maxlength="15" />
        </span></td>
        <td>
          <select name="xmes1" class="caja_texto1" id="xmes1"  >
            <option value="0"> </option>
            <option value="01">enero</option>
            <option value="02">febrero</option>
            <option value="03">marzo</option>
            <option value="04">abril</option>
            <option value="05">mayo</option>
            <option value="06">junio</option>
            <option value="07">julio</option>
            <option value="08">agosto</option>
            <option value="09">septiembre</option>
            <option value="10">octubre</option>
            <option value="11">noviembre</option>
            <option value="12">diciembre</option>
            </select>
        </td>
        <td>               
          
          <select name="c_supervisor" id="c_supervisor" class="caja_texto1">
            <option value="0">Escoger</option>       
            <?
			$sql7="select * from tb_supervisores where est=1";			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
            </select>        
        </td>
        
        <td>               
          
          <select name="c_motivo" id="c_motivo" class="caja_texto1">
            <option value="0">Escoger</option>       
            <?
			$sql8="select * from tb_motivos_incidencia";
			//echo $sql8;			
		  	$queryresult8 = mysql_query($sql8);
			while ($rowper8=mysql_fetch_row($queryresult8)) { 										  
			print "<option value='$rowper8[0]'>$rowper8[1]</option>";
			}
			?>
            </select>        
        </td>
        
        <td >
        <img src="image/reg3.jpg" width="25" height="25" onclick="javascript:mant_incidencia('4');" /> 
        <img src="image/Search.gif" width="25" height="25" onclick="javascript:mant_incidencia('6');" /> 
        <img src="image/exportar.jpg" width="70" height="25" onclick="javascript:mant_incidencia('5');" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td valign="top" >
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6" class="celdas">&nbsp;</td>
      </tr>
    </table>
    <br>
    <? 
	echo "<table width='100%'  style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>ITEM </td>";	
			echo "<td class='fdotxttabla2'>COD.INCIDENCIA </td>";											
			echo "<td class='fdotxttabla2' width='300'>TRABAJADOR </td>";																
			echo "<td class='fdotxttabla2'>USU.MOVIMIENTO</td>";		
			echo "<td class='fdotxttabla2'>TIPO INCIDENCIA</td>";			
			echo "<td class='fdotxttabla2'>MOTIVO INCIDENCIA</td>";		
			echo "<td class='fdotxttabla2'>FEC. INICIAL</td>";			
			echo "<td class='fdotxttabla2'>FEC. FINAL</td>";		
			echo "<td class='fdotxttabla2'>T.PERMISO</td>";
			if ($iduser=="156"){ 
			echo "<td class='fdotxttabla2'>PANEL</td>";
			}
			echo "</tr></table>";
			
	?>
    </td>
  </tr>
  </table>
</div>

<div id="cab_capacitacion" style="display:NONE">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td ><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="258" class="celdas">CIP</td>
        <td width="291" class="celdas">MES</td>
        <td width="389" class="celdas">MONITORES</td>
        <td width="292" class="celdas"></td>
       
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td valign="top" >
        <td>&nbsp;</td valign="top" >
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td><span class="casilla_texto">
          <input name="xcip2" type="text" class="casilla_texto" id="xcip2" size="15" maxlength="10" />
        </span></td>
        <td><select name="xmes2" class="caja_texto1" id="xmes2"  >
            <option value="0"> </option>
            <option value="01">enero</option>
            <option value="02">febrero</option>
            <option value="03">marzo</option>
            <option value="04">abril</option>
            <option value="05">mayo</option>
            <option value="06">junio</option>
            <option value="07">julio</option>
            <option value="08">agosto</option>
            <option value="09">septiembre</option>
            <option value="10">octubre</option>
            <option value="11">noviembre</option>
            <option value="12">diciembre</option>
            </select></td>
        <td>               
          
          <select name="c_monitor" id="c_monitor" class="caja_texto1">
            <option value="0">Escoger Monitor</option>       
            <?
			$sql7="select * from tb_monitores";			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
            </select>        
        </td>
        <td >
        <img src="image/reg3.jpg" width="25" height="25" onclick="javascript:mant_incidencia('4');" /> 
        <img src="image/Search.gif" width="25" height="25" onclick="javascript:mant_incidencia('8');" /> 
        <img src="image/exportar.jpg" width="70" height="25" onclick="javascript:mant_incidencia('6');" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td valign="top" >
        <td>&nbsp;</td valign="top" >
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="celdas">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  </table>
</div>
</form>
    
    </td>
  </tr>
  

</table>

 <div id="d_bandeja_incidencias" style="display:block">
   <iframe id="f_bandeja_incidencias" frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" class="marco_tabla_red" 
        width="95%" scrolling="Auto"  height="500"></iframe>
</div>
</body>
</html>