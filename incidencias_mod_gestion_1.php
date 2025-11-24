<?php
include("conexion_bd.php");

$iduser		=$_GET["iduser"];
$idperfil	=$_GET["idperfil"];
$accion		=$_GET["accion"];
$cip		=$_GET["cip"];
$dni		=$_GET["dni"];
$ejec		=$_GET["ejec"];

	$dia=date("Y-m-d");
	
	$cad=" SELECT cod_incidencia FROM cab_incidencia ORDER BY 1 desc LIMIT 1";
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);	
	$franq = explode("-", $rg[0]);
	$pre =$franq[0];
	$franq = $franq[1] + 1;
	$franqueo = $pre."-".$franq;
	//echo $franqueo;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript">


function mostrar_modo_inc(valor_c){
		
	if (valor_c=="D"){
		document.getElementById("f_dias").style.display="block";	
		document.getElementById("f_horas").style.display="none";
		document.getElementById("input1").value = "";					
		
	}
	if (valor_c=="H"){
		document.getElementById("f_horas").style.display="block";	
		document.getElementById("f_dias").style.display="none";	
		document.getElementById("input3").value = "";
		document.getElementById("h_ini").value = "0";
		document.getElementById("h_fin").value = "0";
		document.getElementById("mm_ini").value = "00";
		document.getElementById("mm_fin").value = "00";
		
	}
		
	document.getElementById("btn_grabar_inc").style.display="block";
	
}

</script>

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<script language="javascript" src="funciones_js.js"></script>
<script language="JavaScript" src="calendar1.js"></script> 
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <p>
    <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
    <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/> 
    <input name="cip" type="hidden" class="casilla_texto" id="cip" value="<? echo $cip; ?>"/>
    <input name="dni" type="hidden" class="casilla_texto" id="dni" value="<? echo $dni; ?>"/>
    <input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<? echo $franqueo; ?>"/>
    
    <? if ($accion=="Registro"){?>
  </p>
  <table width="90%" border="0">
    <tr>
      <td width="17%" class="caja_texto_sb" onclick="JAVASCRIPT:cerrar_ventana()">
      <img src="image/SAL.jpg" alt="" width="25" height="25" />Cerrar</td>  
    
      <td width="15%"  class="caja_texto_sb" id="bt_aceptar" style="display:none" 
      onclick="javascript:grabar_incidencia('2')">
      <img src="image/grabar.jpg" alt="" width="30" height="30" />Grabar</td> 
    
     
      <td width="68%"   >&nbsp;</td>
    </tr>
  </table>  
<table width="100%" border="0">
  <tr>
    <td class="clsInnerFrame" onclick="JAVASCRIPT:cerrar_ventana()">&nbsp;</td>
  </tr>
</table>
<br>
<table width="90%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <!--
    <td width="94" valign="top" class="clsCurrentMonthDay">TRABAJADOR</td>
    <td colspan="2"><select name="gestor" id="gestor" class="caja_sb" >
      <? 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			$sql7="select cip,ncompleto from tb_usuarios where estado='HABILITADO' order by ncompleto";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1] - $rowper[0]</option>";
			}
			?>
    </select>

	</td>
   -->
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">TIPO</td>
    <td width="330"><select name="tp_incidencia" class="caja_texto_pe" id="tp_incidencia" 
    onchange="javascript:carga_combo('c_mot_inc',this.value)">
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
    <td width="324"><div id="d_doid" style="display:none">DOID:  
      <input name="c_doid" type="text" class="caja_texto_cb" id="c_doid" size="25" 
      maxlength="20"                />
    </div></td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">MOTIVO</td>
    <td colspan="2"><div id="c_mot_inc"></div></td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">MODO</td>
    <td colspan="2"><select name="modo" size="1" class="caja_texto_pe" id="modo" 
    onchange="javascript:mostrar_modo_inc(this.value);" > 
      <option value="0">Seleccionar</option>
      <option value="D">DIAS</option>
      <option value="H">HORAS</option>      
    </select></td>
  </tr>
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr> 
  <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">
    
    <form name="form1">
    <div id="f_dias" style="display:NONE">        
    <table width="100%" class="marco_tabla">
      <tr>
        <td width="18%" class="caja_sb">FEC. INICIO </td>
        <td width="34%">
          <input readonly="readonly" name="input1" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input1" />
          <a href="javascript:cal1.popup();"> 
          <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
           /></a></span>
          </td>
        <td width="11%" class="caja_sb">FEC. FIN  </td>
        <td width="37%">
          <input readonly="readonly" name="input2" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input2" />
          <a href="javascript:cal2.popup();"> 
          <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"
          /></a></span></td>
        </tr>
    </table>        
    </div>
    <div id="f_horas" style="display:none">
     <table width="100%"  class="marco_tabla">
    	<tr>
    	  <td width="18%" class="caja_sb">FECHA  </td>
    	  <td colspan="5">
    	    <input readonly="readonly" name="input3" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input3" />
    	    <a href="javascript:cal3.popup();"> 
    	      <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
          /></a></span></td>
  	  </tr>
    	<tr>
    	  <td class="caja_sb">&nbsp;</td>
    	  <td width="12%">HORAS</td>
    	  <td width="13%">MINUTOS</td>
    	  <td class="caja_sb">&nbsp;</td>
    	  <td width="12%">HORAS</td>
    	  <td width="27%">MINUTOS</td>
  	  </tr>
    	<tr>
        <td width="18%" class="caja_sb">HORA INICIO</td>
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
          :          </td>
        <td><select name="mm_ini" size="1" class="caja_texto_cb" id="mm_ini" >
          <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select></td>
        <td width="18%" class="caja_sb">HORA FIN</td>
        <td>
        <select name="h_fin" size="1" class="caja_texto_cb" id="h_fin" 
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
     <script language="JavaScript">
                        var cal1 = new calendar1(document.forms["form1"].elements['input1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;
										
                        
                        var cal2 = new calendar1(document.forms["form1"].elements['input2']);
                        cal2.year_scroll = true;
                        cal2.time_comp = false;		
						
						var cal3 = new calendar1(document.forms["form1"].elements['input3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;									
                        
						
                        
        </script>
    </td>
  </tr>
   <tr>
    <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
     <td valign="top" class="clsCurrentMonthDay">TIEMPO</td>
     <td colspan="2">
     <input name="tiempo" type="text" class="caja_texto_pe" id="tiempo" size="5" readonly="readonly" />
    <input name="exc" type="text" class="caja_texto_pe" id="exc" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
     <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
  </tr> 
  <tr>
    <td valign="top" class="clsCurrentMonthDay">OBSERVACION</td>
    <td colspan="2"><textarea name="obs" cols="50" rows="3" class="caja_texto_pe" id="obs" onclick="calcular_tiempos()"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" class="clsCurrentMonthDay">&nbsp;</td>
  </tr>
</table>
<p><br>
  <? } ?>
</p>
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
                <td width="47%" valign="top"><input name="xcip_" type="text" class="caja_texto_pe" id="xcip_" size="25" maxlength="20" 
                value="<? echo $c_inc?>" readonly/></td>
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
                <td colspan="3" valign="top"><span class="caja_texto1">
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