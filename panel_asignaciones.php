<?php
include_once("conexion_bd.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="calendar1.js"></script> 
<script language="javascript" src="funciones_js.js"></script>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>

<table width="100%" border="0">
  <tr class="caja_texto_db">
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="14%">SUPERVISOR</td>
    <td>NOMBRE COMPLETO</td>
    <td>FECHA</td>
    <td>HORA</td>
    <td>ORIGEN</td>
    <td>&nbsp;</td>
     <td width="8%">&nbsp;</td>
  </tr>
  <tr>
  <td><select name="c_supervisor" id="c_supervisor" class="caja_texto_pe" onchange="javascript:mostrar_combo_gestores('d_gestores',this.value)">
    <option value="0">Escoger</option>
    <?
			$sql7="select * from tb_supervisores where est=1";			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
  </select></td>
    <td width="31%">
    <div id="d_gestores">
      <select name="" size="1" class="caja_texto_pe" id="" >
        <option value="0"> </option>       
      </select>
    </div>
    </td>
    <td width="17%">
    <form name="form1" id="form1">
    <input readonly="readonly" name="input1" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input1" />
    <a href="javascript:cal1.popup();"> <img src="cal.gif" width="16" height="16" border="0" 
    alt="Click Here to Pick up the date" /></a></span>          
    </form>    
    </td>
    <td width="11%"><select name="h_ini" size="1" class="caja_texto_pe" id="h_ini" >
                    <option value="0">Escoger </option>
                    <option value="06">06:00</option>
                    <option value="07">07:00</option>
                    <option value="08">08:00</option>
                    <option value="09">09:00</option>
                    <option value="10">10:00</option>
                    <option value="11">11:00</option>
                    <option value="12">12:00</option>
                    <option value="13">13:00</option>
                    <option value="14">14:00</option>
                    <option value="15">15:00</option>
                    <option value="16">16:00</option>
                    <option value="17">17:00</option>
                    <option value="18">18:00</option>
                    <option value="19">19:00</option>
                    <option value="20">20:00</option>
                    <option value="21">21:00</option>
                    <option value="22">22:00</option>
                    <option value="23">23:00</option>
    </select></td>
    <td width="10%"><select name="origen" size="1" class="caja_texto_pe" id="origen" >
      <option value="0">Escoger </option>
      <option value="CMS">CMS</option>
      <option value="GESTEL-423">GESTEL</option>     
    </select></td>
    <td class="caja_texto_pe" width="9%"><img src="image/adjuntar.jpg" width="30" height="30" onclick="javascript:buscar_gestores_asig()"/>Aceptar</td>
    <td class="caja_texto_pe" onclick="javascript:cerrar_win('6')">
     <img src="image/SAL.jpg" width="30" height="30" />Salir</td>
  </tr>
  		 <script language="JavaScript" type="text/javascript">
                        var cal1 = new calendar1(document.forms["form1"].elements['input1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;                        
        </script>
   	<tr>
    <td colspan='7' class="caja_texto_db">&nbsp;</td>
 	</tr>     
 	<tr>
    <td colspan="7"><div id="div_bandeja_asignaciones"></div></td>
    </tr>
</table>
</body>
</html>