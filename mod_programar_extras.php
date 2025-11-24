<?php
include("conexion_bd.php");

$accion		=$_GET["accion"];
$iduser		=$_GET["iduser"];
$idperfil	=$_GET["idperfil"];
$dni		=$_GET["dni"];
$cip		=$_GET["cip"];



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="js.js"></script>

<script language="javascript">

function mostrar_modo_P(valor_c){
	
	
	if (valor_c=="D"){
		document.getElementById("f_dias").style.display="block";	
		document.getElementById("f_horas").style.display="none";
		document.getElementById("input1").value ="";			
		
	}
	if (valor_c=="H"){
		document.getElementById("f_horas").style.display="block";	
		document.getElementById("f_dias").style.display="none";	
		document.getElementById("input3").value ="";
		document.getElementById("h_ini").value ="0";
		document.getElementById("mm_ini").value ="00";
		document.getElementById("h_fin").value ="0";
		document.getElementById("mm_fin").value ="00";
	}
	 
	document.getElementById("tiempo").value = "00:00";	
	document.getElementById("factor").value = "0";	 
}

function cerrar_ventana(){
	parent.window.close();
}


</script>
<script language="JavaScript" src="calendar1.js"></script> 
<title>FORMULARIO: PROGRAMACION DE EXTRAS</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
  <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
  <input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<? echo $c_inc; ?>"/>
  <input name="dni" type="hidden" class="casilla_texto" id="dni" value="<? echo $dni; ?>"/>
  <input name="cip" type="hidden" class="casilla_texto" id="cip" value="<? echo $cip; ?>"/>
<p>
  
  <? if ($accion=="Registro"){
	  
	    $hor="SELECT a.cip,a.cod_horario,b.periodo,b.tiempo
		FROM horarios_cot a, tb_horarios b
		WHERE a.cod_horario=b.cod_horario AND a.cip='$cip' GROUP BY 1 ";
		//echo $hor;
		$res_hor = mysql_query($hor);
		$reg_hor =mysql_fetch_row($res_hor);
	  
	  ?>
  
</p>
<table width="90%" border="0">
  <tr>
    <td width="110" class="caja_texto_pe" onclick="JAVASCRIPT:cerrar_ventana()"><img src="image/BT5.gif" alt="" width="30" height="30" onclick="javascript:cerrar_ventana()" />Cerrar</td>
    
         <td width="27" >&nbsp;</td>
    <td width="110"  class="caja_texto_pe" id="btn_grabar" style="display:none" onclick="javascript:grabar_incidencia_comp()"><img src="image/BT4.gif" alt="" width="30" height="30" />Grabar</td>
    
     <td width="110"  class="caja_texto_pe" id="btn_grabar" style="display:none" onclick="javascript:grabar_incidencia_comp()"><img src="image/BT4.gif" alt="" width="30" height="30" />Grabar1</td>    
   
    <td width="103">&nbsp;</td>
  </tr>
</table>
<br>
<table width="100%" border="0">
  <tr>
    <td class="clsInnerFrame" onclick="JAVASCRIPT:cerrar_ventana()">&nbsp;</td>
  </tr>
</table>
<br>
<table width="90%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td valign="top" class="etiqueta">HORARIO</td>
    <td><input name="c_horario" type="text" class="caja_texto_pe" id="c_horario" 
                value="<? echo $reg_hor[1]?>" size="25" maxlength="20" readonly="readonly"/></td>
    <td width="145" class="etiqueta">HOR. VIGENTE</td>
    <td width="339" class="aviso"><? echo $reg_hor[2]." - ".$reg_hor[3]; ?></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="118" valign="top" class="etiqueta">TIPO</td>
    <td width="281"><select name="tp_incidencia" class="caja_texto_pe" id="tp_incidencia" >
      <option value="0">ESCOGER</option>
      <option value="TRABAJOS DE FDS">TRABAJOS DE FDS</option>
      <option value="NECESIDAD DEL SERVICIO">NECESIDAD DEL SERVICIO</option>
      <option value="PERMISO AUTORIZADO">PERMISO AUTORIZADO</option>
      <? if ($idperfil=="5"){ ?>
      <? }else{ ?>
      <? if ($idperfil=="0"){  ?>
      <? }else{?>
      <? if ($iduser=="189"){ ?>
      <? }?>
      <? } 
			}?>
    </select></td>
    <td colspan="2"><div id="d_doid" style="display:none">DOID:  
      <input name="c_doid" type="text" class="caja_texto_pe" id="c_doid" size="25" 
      maxlength="20"                />
    </div></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta">MODO</td>
    <td colspan="3"><select name="modo" size="1" class="caja_texto_pe" id="modo" onchange="javascript:mostrar_modo_P(this.value);" > 
      <option value="0">Seleccionar</option>
      <option value="D">DIAS</option>
      <option value="H">HORAS</option>      
    </select></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr> 
  <tr>
    <td colspan="4" valign="top" class="etiqueta">
      
      <form name="form1">
        <div id="f_dias" style="display:NONE">        
          <table width="100%">
            <tr>
              <td width="15%" class="etiqueta">FECHA </td>
              <td width="85%">
                <input readonly name="input1" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input1" />
                <a href="javascript:cal1.popup();"> 
                <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
           /></a></span>
              </td>
              <!--
              <td width="11%" class="etiqueta">FEC. FIN  </td>
              <td width="37%">
                <input readonly="readonly" name="input2" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input2" />
                <a href="javascript:cal2.popup();"> 
              <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"
          /></a></span></td>
          -->
            </tr>
          </table>        
        </div>
        <div id="f_horas" style="display:none">
          <table width="90%" >
            <tr>
              <td width="17%" class="etiqueta">FECHA  </td>
              <td colspan="5">
                <input readonly="readonly" name="input3" class="caja_text" type="text" size="17" maxlength="20" id="input3" />
                <a href="javascript:cal3.popup();"> 
              <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
          /></a></span></td>
            </tr>
            <tr>
              <td class="caja_sb">&nbsp;</td>
              <td width="18%" class="etiqueta">HORAS</td>
              <td width="14%" class="etiqueta">MINUTOS</td>
              <td class="caja_sb">&nbsp;</td>
              <td width="13%" class="etiqueta">HORAS</td>
              <td width="20%" class="etiqueta">MINUTOS</td>
            </tr>
            <tr>
              <td width="17%" class="etiqueta">HORA INICIO</td>
              <td><label for="tiempo_1"></label>
                <select name="h_ini" size="1" class="caja_texto_pe" id="h_ini" >
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
              :          </td>
              <td><select name="mm_ini" size="1" class="caja_texto_pe" id="mm_ini" >
                <option value="00">00</option>
                  <option value="15">15</option>
                  <option value="30">30</option>
              </select></td>
              <td width="18%" class="etiqueta">HORA FIN</td>
              <td>
                <select name="h_fin" size="1" class="caja_texto_pe" id="h_fin" 
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
              :          </td>
              <td><select name="mm_fin" size="1" class="caja_texto_pe" id="mm_fin" >
                  <option value="00">00</option>
                  <option value="15">15</option>
                  <option value="30">30</option>
              </select></td>
            </tr>
          </table>       
        </div>
      </form> 
      <script language="JavaScript">
                        var cal1 = new calendar1(document.forms["form1"].elements['input1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;						
										
                        /*
                        var cal2 = new calendar1(document.forms["form1"].elements['input2']);
                        cal2.year_scroll = true;
                        cal2.time_comp = false;		
						*/
						var cal3 = new calendar1(document.forms["form1"].elements['input3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;									
                        
						
                        
        </script>    </td>
  </tr>
   <tr>
    <td valign="top" class="etiqueta">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
     <td valign="top" class="etiqueta">FACTOR</td>
     <td colspan="3"><select name="factor" size="1" class="caja_texto_pe" id="factor" onchange="javascript:calcular_tiempos();" >
       <option value="0">Seleccionar</option>
       <option value="1.5">1.5</option>
       <option value="2.0">2.0</option>
     </select></td>
  </tr>
  <tr>
     <td valign="top" class="etiqueta">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
     <td valign="top" class="etiqueta">TIEMPO</td>
     <td colspan="3">
     	<input name="tiempo" type="text" class="caja_texto_pe" id="tiempo" size="15" readonly="readonly" />
    	<input name="exc" type="hidden" class="caja_text" id="exc" size="15" readonly="readonly" />
	    <input name="tt_c" type="hidden" class="caja_texto_pe" id="tt_c" />
    </td>
    
  </tr>
  <tr>
     <td valign="top" class="etiqueta">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
  </tr> 
  <tr>
    <td valign="top" class="etiqueta">OBSERVACION</td>
    <td colspan="3"><textarea name="obs" cols="50" rows="3" class="caja_texto_pe" id="obs" onclick=""></textarea></td>
  </tr>
  <tr>
    <td colspan="4" valign="top" class="clsCurrentMonthDay">&nbsp;</td>
  </tr>
</table>
<br>
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
                <td width="47%" valign="top"><input name="xcip_" type="text" class="caja_texto_pe" id="xcip_" 
                value="<? echo $c_inc?>" size="25" maxlength="20" readonly/></td>
                <td width="4%" valign="top">&nbsp;</td>
                <td width="35%" valign="top"><input name="ejecutado" type="checkbox" id="ejecutado" value="1" checked="checked" />
                  EJECUTADO</td>
  </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">FEC.INICIO</td>
                <td colspan="3" valign="top"><span class="casilla_texto">
                  <input name="fec_ini" class="caja_texto_pe" type="text" size="20" maxlength="22" id="fec_ini" value="<? echo $reg[6]?>" />
                </span></td>
  </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">FEC.FINAL</td>
                <td colspan="3" valign="top"><span class="caja_text1">
                  <input name="fec_fin" class="caja_texto_pe" type="text" size="20" maxlength="22" id="fec_fin" value="<? echo $reg[7]?>" />
                </span></td>
  </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">TIEMPO</td>
                <td colspan="3" valign="top" >
                  <input name="tiempo_1" class="caja_texto_pe" type="text" size="15" maxlength="22" id="tiempo_1" 
                  value="<? echo $reg[12]?>" readonly />
                (Horas)</td>
              </tr>
              <tr>
                <td valign="top" class="clsCurrentMonthDay">OBS</td>
                <td colspan="3" valign="top">
                <textarea name="obs_2" cols="50" rows="3" class="caja_texto_pe" id="obs_2" onclick="calcular_tiempos_1()">
				<? 
				//$obs = limpia_espacios($reg[8]);
				echo $reg[8]; ?>
                </textarea></td>
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
              <td onclick="javascript:act_incidencias();">
              <a class="boton_3" >ACTUALIZAR</a>              
              </td>
              <td onclick="JAVASCRIPT:cerrar_win('4')">              
              <a class="boton_3" >CERRAR</a>
  </tr>
</table>
<? } ?>

</body>

</html>