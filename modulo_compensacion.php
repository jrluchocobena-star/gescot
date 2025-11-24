<?Php
include("conexion_bd.php");
$id		=$_GET["id"];
$dni	=trim($_GET["dni"]);
$iduser	=trim($_GET["iduser"]);

function dif_horas($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);
 
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);
 
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin-$ini;
 
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H:i:s",mktime($difh,$difm,$difs));
}

			$a="SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo)))
			FROM programacion_extra WHERE dni='$dni'";
			//echo $a;
			$rs_a = mysql_query($a);											
			$rg_a = mysql_fetch_row($rs_a);
			
			if ($rg_a[0]==""){
				$tt_acu="00:00";
			}else{				
				$tt_acu=$rg_a[0];
			}
			
			$b="SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo_comp))) 
			FROM compensacion_extra b WHERE dni='$dni'";
			//echo $b;
			$rs_b = mysql_query($b);											
			$rg_b = mysql_fetch_row($rs_b);
			
			if ($rg_b[0]==""){
				$tt_comp="00:00";
				$tt_rest="00:00";
			}else{
				$tt_comp=$rg_b[0];
				
				/*
				$c="SELECT SEC_TO_TIME(SEC_TO_TIME(SUM(TIME_TO_SEC(a.tiempo))) - SEC_TO_TIME(SUM(TIME_TO_SEC(b.tiempo_comp)))) 
				FROM programacion_extra a, compensacion_extra b WHERE a.dni=b.dni and a.dni='$dni'";
				
				$c="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$tt_acu','$tt_comp'))*60) as dif";
				echo $c;
				$rs_c = mysql_query($c);											
				$rg_c = mysql_fetch_row($rs_c);
				$tt_rest=$rg_c[0];
				*/
				$tt_rest= dif_horas($tt_comp,$tt_acu);
				
			}
			
			
		

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="JavaScript" src="js.js"></script> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO: MODULO DE COMPENSACION</title>
<script language="JavaScript" src="calendar1.js"></script> 
<link href="estilos.css" rel="stylesheet" type="text/css" />

</head>

<body>
 <input name="iduser" type="hidden"  id="iduser" value="<? echo $iduser; ?>">
    <table width="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td colspan="4"><table width="100%" border="0" cellpadding="1" cellspacing="1">
          <tr>
            <td colspan="5" class="contador" >MODULO DE REGISTRO DE&nbsp;COMPENSACIONES</td>
            <td>&nbsp;</td>
            <td class="caja_texto_pe">
            <a href="JAVASCRIPT:grabar_compensaciones()" style="display:none"  id="bt_grabar" >
        	<img src="image/BT4.gif" alt="" width="35" height="35" border="0" />Grabar
        	</a>  </td>
            <td align="center" class="caja_texto_pe">  
       		<a href="JAVASCRIPT:cerrar_ventana()" >
        	<img src="image/BT5.gif" alt="" width="35" height="35" border="0" />Cerrar
        	</a></td>
          </tr>
          <tr>
            <td class="etiqueta_p">DNI</td>
            <td colspan="3" ><input name="dni" type="text" class="caja_texto_pe" id="dni" value="<? echo $dni; ?>" /></td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td class="etiqueta_p">&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td class="etiqueta_p"><span class="etiqueta_1p">T.T Acumulado </span></td>
            <td ><input name="tt_acumulado" type="text" class="caja_texto_pe" id="tt_acumulado" value="<? echo $tt_acu; ?>" readonly/></td>
            <td align="center" class="etiqueta_p">&nbsp;</td>
            <td class="etiqueta_1p">Tiempo Total Compensado </td>
            <td ><input name="tt_compensando" type="text" class="caja_texto_pe" id="tt_compensando" value="<? echo $tt_comp; ?>"readonly /></td>
            <td>&nbsp;</td>
            <td class="etiqueta_1p">Tiempo Total Restante</td>
            <td ><input name="tt_restante" type="text" class="caja_texto_pe" id="tt_restante" 
            value="<? echo $tt_rest; ?>"readonly /></td>
          </tr>
          <tr>
            <td width="12%" class="etiqueta_p">&nbsp;</td>
            <td width="19%" >&nbsp;</td>
            <td width="1%" class="etiqueta_p">&nbsp;</td>
            <td width="21%" class="etiqueta_1p"><span class="etiqueta_p">T.Comp.act</span></td>
            <td width="14%" ><input name="t_comp_a" type="text" class="caja_texto_pe" id="t_comp_a" value="00:00" /></td>
            <td width="1%">&nbsp;</td>
            <td width="21%" class="etiqueta_1p">&nbsp;</td>
            <td width="11%" ><input name="t_saldo_a" type="text" class="caja_texto_pe" id="t_saldo_a" value="00:00" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" class="txt_pequeño">&nbsp;</td>
      </tr>
       <tr>
    		<td colspan="4" bgcolor="#66CCCC" class="txt_pequeño">&nbsp;</td>    
	  </tr>
      <tr>
        <td width="11%"><span class="etiqueta_p">MODO</span></td>
        <td width="21%" valign="top"><select name="modo" size="1" class="caja_texto_pe" id="modo" 
        onchange="javascript:mostrar_modo(this.value);" >
          <option value="0">Seleccionar</option>
          <option value="D">DIAS</option>
          <option value="H">HORAS</option>
        </select>       
        <input name="exc" type="hidden" class="caja_text" id="exc" size="15" readonly="readonly" /></td>       
        <td width="55%" valign="top">&nbsp;</td>
      </tr>
      <tr>
    		<td colspan="4" bgcolor="#66CCCC" class="txt_pequeño">&nbsp;</td>    
	  </tr>
       <tr>
    <td colspan="6" valign="top" class="etiqueta">
      
      <form name="form1">
        <div id="f_dias" style="display:none">        
          <table width="100%" >
            <tr>
              <td width="12%" class="etiqueta_p">FECHA </td>
              <td width="88%" >
                <input readonly="readonly" name="input1" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input1" />
                <a href="javascript:cal1.popup();"> 
                <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
           /></a></span>
             </td>
             
              <!--
              <td  class="etiqueta_p">FEC. FIN  </td>
              <td>
                <input readonly="readonly" name="input2" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input2" />
                <a href="javascript:cal2.popup();"> 
              <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"
          /></a></span></td>
          -->
            </tr>
          </table>        
        </div>
        <div id="f_horas" style="display:none">
          <table width="100%" >
            <tr>
              <td width="12%"  class="etiqueta_p">FECHA  </td>
              <td colspan="5">
                <input readonly="readonly" name="input3" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input3" />
                <a href="javascript:cal3.popup();"> 
              <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
          /></a></span></td>
            </tr>
            <tr>
              <td class="caja_sb">&nbsp;</td>
              <td width="9%" class="etiqueta_p">HORAS</td>
              <td width="15%" class="etiqueta_p">MINUTOS</td>
              <td width="10%" class="caja_sb">&nbsp;</td>
              <td width="9%"  class="etiqueta_p">HORAS</td>
              <td width="45%"  class="etiqueta_p">MINUTOS</td>
            </tr>
            <tr>
              <td class="etiqueta_p">HORA INICIO</td>
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
                  <option value="45">45</option>
              </select></td>
              <td  class="etiqueta_p">HORA FIN</td>
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
              <td><select name="mm_fin" size="1" class="caja_texto_pe" id="mm_fin" onchange="JAVASCRIPT:javascript:calcular_tiempos_comp()" >
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
        <td valign="top" class="etiqueta_p">OBSERVACION</td>
        <td colspan="4">   
        <textarea name="obs" cols="50" rows="3" class="caja_texto_pe" id="obs" onclick="javascript:calcular_tiempos_comp();">
        </textarea>              </td>
      </tr>
      
 	 <tr>
    	<td colspan="4" bgcolor="#66CCCC" class="txt_pequeño">&nbsp;</td>    
	 </tr>
     
      <tr>
       <td colspan="5" >
       
      
        
        </td>   
      </tr>  
      
</table>
   
   
 
        
        
       
    <p>&nbsp;</p>
</body>
</html>