<?php
include_once("../conexion_bd.php");
include_once("../funciones_fechas.php");




$iduser=$_GET["iduser"];
$cip=$_GET["cip"];
$c_inc=$_GET["c_inc"];
$idperfil=$_GET["idperfil"];		
$xmes=date("Y-m");

//echo $c_inc;

	$sql_2="select iduser,ncompleto,dni,cip,c_supervisor,c_monitor from tb_usuarios where estado='HABILITADO' ";
	//echo $sql_2;
	$res = mysql_query($sql_2);
	$reg=mysql_fetch_row($res);


	$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_capacitacion ORDER BY 1 DESC";
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);	
	$franq 	= limpia_espacios($rg[0]);
	$franqueo = "INC-".$franq;
	//echo $franqueo;	


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="../estilos.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="../funciones_js.js"></script> 
<script language="JavaScript" src="calendar1.js"></script>

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>

<script language="JavaScript1.2" src="table.js"></script>
<script language="JavaScript1.2" src="jquery.js"></script>
<link rel="stylesheet" type="text/css" href="table.css" media="all">

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
	document.getElementById("tiempo").value = "";	
	document.getElementById("btn_addgestor").style.display="block";
	document.getElementById("btn_grabar_inc").style.display="block";
	
}

function calcular_tiempos_capa(){
	var modo = document.getElementById("modo").value;

		if (document.getElementById("modo").value=="D"){			
		var fec1 = document.getElementById("input1").value;
		var fec = document.getElementById("input2").value;
		var fec2 = document.getElementById("input2").value;		
		document.getElementById("exc").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var fec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];
		
		
			if (fec_fin > fec_ini){
				/*
				alert(fec1[1])
				alert(fec2[1])
				
				if (fec2[1]> fec1[1]){
					
				}else{
					alert("ALERTA: ERROR CON EL FORMATO DE HORAS")
					return	
				}
				*/
				document.getElementById("grabar_inc").style.display="block"; 
			}else{
				alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
				document.getElementById("btn_grabar").style.display="none"; 
			}

		
		}else{	// si modo=H

		var fec = document.getElementById("input3").value;
		var hor_ini = document.getElementById("h_ini").value + ":" + document.getElementById("mm_ini").value;
		var hor_fin = document.getElementById("h_fin").value + ":" + document.getElementById("mm_fin").value;
		document.getElementById("exc").value="HH:MM";	
	}

	if (document.getElementById("modo").value=="D" || document.getElementById("modo").value=="0"){
		if (document.getElementById("input1").value=="" || document.getElementById("input2").value==""){
			document.getElementById("grabar_inc").style.display="none";	
			alert("ERROR: NO HA INGRESADO FECHAS")
			return
		}else{
			document.getElementById("grabar_inc").style.display="block";	
		}		
	}else{
		if (document.getElementById("input3").value=="" || 
		document.getElementById("h_ini").value=="0" || document.getElementById("h_fin").value=="0"
		){
			document.getElementById("grabar_inc").style.display="none";	
			alert("ERROR: NO HA INGRESADO HORAS COMPLETAS")
			return
		}else{
			document.getElementById("grabar_inc").style.display="block";	
		}		
	}
	
	
	var pag4 = "../funciones_php.php?fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&fec="+fec+"&modo="+modo+"&hor_ini="+hor_ini
	+"&hor_fin="+hor_fin+"&accion=calcular_tiempo_capa";
	
	//alert(pag4);

	ajaxc = new createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
		//alert(ajaxc.responseText)
			var msn_  = ajaxc.responseText; 			
			var msn = msn_.split("|");         
			document.getElementById("tt_c").value = msn[2];			
			document.getElementById("tiempo").value = msn[0];
			document.getElementById("ndia").value = msn[1];		
			
        }
	}
	ajaxc.send(null)
	
	
	}

</script>

<title>LISTADO DE PARTICIPANTES</title>
</head>

<body>
<input name="arr_escogidos" type="hidden" class="casilla_texto" id="arr_escogidos" />
<input name="cip" type="hidden" class="casilla_texto" id="cip" value="<? echo $reg[3];?>" />
<input name="dni" type="hidden" class="casilla_texto" id="dni" value="<? echo $reg[4];?>" />
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser;?>" />
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil;?>" />
<input name="tp_incidencia" type="hidden" class="casilla_texto" id="tp_incidencia" value="<? echo "MONITOREO Y CAPACITACION COT";?>" />
<input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<? echo $franqueo;?>" />
<input name="chk_escogidos" type="hidden" class="caja_texto_sb" id="chk_escogidos" />
<input name="tt_c" type="hidden" class="caja_texto_sb" id="tt_c" />



<table width="100%">
<tr>		
        <td colspan="3"> 
        <input name="chk_escogidos_" type="text" class="caja_texto_sb" id="chk_escogidos_" /></td>
        <td colspan="2" align="right"> 
        <table width="200" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td class="caja_texto_pe" id="add_part" onclick="javascript:agregar_part()">
                <img src="../image/LISTAS.JPG" width="20" height="20" />Agregar particpantes</td>
                <td class="caja_texto_pe" id="grabar_inc" onclick="javascript:grabar_capacitacion()" 
                style="display:none">
                <img src="../image/LISTAS.JPG" width="20" height="20" />Grabar</td>
                <td>&nbsp;</td>
                <td class="caja_texto_pe" onclick="javascript:cerrar_win('3')"><img src="../image/SAL.jpg" width="20" height="20" />Salir</td>
              </tr>
		</table>

        </td>
		<td>&nbsp;</td>		
  </tr>
</table>
<br>
<div id="lista_participantes" style="overflow:scroll">  
  <table width="100%" 
 class="example table-autosort table-autofilter table-autopage:20 table-stripeclass:alternate table-page-number:t1page over:auto  table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">

<thead>
	
  <tr>
   			<?					
			
			//echo "<th>ITEM</th>";				
			echo "<th>...</th>";
			
			echo "<th class='filterable' align='left'>CIP";						
			echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";	
				
			echo "<th class='filterable' align='left'>NOMBRE COMPLETO";						
			echo "<input class='caja_texto_pe' name='filter' size='60' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
			
			echo "<th class='filterable' align='left'>DNI";						
			echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
						
			echo "<th class='table-filterable table-sortable:default'>SUPERVISOR</th>";
			
			echo "<th class='table-filterable table-sortable:default'>MONITOR</th>";
			?>	
  </tr>
</thead>
<tbody>
		<?
		$i=0;
		while($reg=mysql_fetch_row($res))
		{	
		$s="select nom_supervisor from tb_supervisores where cod_supervisor='".$reg[4]."'";
		//echo $s;
		$rs_s = mysql_query($s);											
		$rg_s = mysql_fetch_row($rs_s);
		
		$m="select nom_monitor from tb_monitores where cod_monitor='".$reg[5]."'";
		//echo $s;
		$rs_m = mysql_query($m);											
		$rg_m = mysql_fetch_row($rs_m);
				
		echo "<tr class='alternate'>";		
		
		/*
		echo "<td>";		
		echo $con = $con + 1; 				
		echo "</td>";
		*/
		$i = $i + 1; 
		$nn="d_obs_".$con;
		$nnx="f_obs_".$con;
		
			
		echo "<td>";
		?>
    <input type="checkbox" name="<? echo "check".$i; ?>" id="<? echo "check".$i; ?>" value="<? echo $reg[2]; ?>" 
    onclick="javascript:escojer_gestor()" /> 
        <?
		echo "</td>";
		
		echo "<td>";		//CIP		
		echo $reg[3]; 				
		echo "</td>";
		
		echo "<td>";
		echo $reg[1]; 		//NOMBRE	
		echo "</td>";
			
		echo "<td>";		//DNI		
		echo $reg[2]; 				
		echo "</td>";
		
		
		echo "<td>";		//SUPERVISOR		
		echo $rg_s[0]; 				
		echo "</td>";
		
		
		echo "<td>";		//monitor		
		echo $rg_m[0]; 				
		echo "</td>";
		
		
		echo "</tr>";	
				
		}		
	?>
</tbody>		

</table>
</div>

<div id="registro_cap" style="display:none">
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
      <td valign="top" class="clsCurrentMonthDay">CODIGO</td>
      <td colspan="3"><input name="c_incx" type="text" class="aviso" id="c_incx" size="30" value="<? echo $franqueo;?>" readonly /></td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">TIPO</td>
      <td><select name="tp_capa" id="tp_capa" class="caja_texto_pe">
          <option value="0">Escoger Tema</option>
		  <option value="CAPACITACION INTEGRAL">CAPACITACION INTEGRAL</option>
          <option value="CAPACITACION PDC">CAPACITACION PDC</option>
          <option value="CAPACITACION 360">CAPACITACION 360</option>
          <option value="RICA REFUERZO">RICA REFUERZO</option>
          <option value="PRACTICAS">PRACTICAS</option>
          <option value="REFUERZO">REFUERZO</option>
          <option value="ACTUALIZACION">ACTUALIZACION</option>
          <option value="PILOTO">PILOTO</option>
          <option value="COMUNICADOS">COMUNICADOS</option>
          <option value="DESPLIEGUE SOPORTES">DESPLIEGUE SOPORTES</option>
      </select></td>
      <td><span class="clsCurrentMonthDay">TEMA</span></td>
      <td><select name="combo_mot" class="caja_texto_pe" id="combo_mot">
        <option value="0">Escoger Tema</option>
        <?
			$sql7="select * from tb_motivos_incidencia where tp_inc='MONITOREO Y CAPACITACION COT'";			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
      </select></td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">SUBTEMA</td>
      <td colspan="3"><input name="tema" type="text" class="caja_texto_pe" id="tema" size="100" /></td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">MODO</td>
      <td  colspan="3"><select name="modo" size="1" class="caja_texto_pe" id="modo" 
    onchange="javascript:mostrar_modo_inc(this.value);" >
          <option value="0">Seleccionar</option>
          <option value="D">DIAS</option>
          <option value="H">HORAS</option>
      </select></td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="3"><form name="form1">
          <div id="f_dias" style="display:NONE">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="18%" class="caja_sb">FEC. INICIO </td>
                <td width="34%"><input readonly="readonly" name="input1" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input1" />
                  <a href="javascript:cal1.popup();"> <img src="../cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
           /></a> </td>
                <td width="11%" class="caja_sb">FEC. FIN </td>
                <td width="37%"><input readonly="readonly" name="input2" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input2" />
                  <a href="javascript:cal2.popup();"> <img src="../cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"
          /></a></td>
              </tr>
            </table>
          </div>
        <div id="f_horas" style="display:none">
            <table width="100%"  class="marco_tabla">
              <tr>
                <td width="18%" class="caja_sb">FECHA </td>
                <td colspan="5"><input readonly="readonly" name="input3" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input3" />
                  <a href="javascript:cal3.popup();"> <img src="../cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
          /></a></td>
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
                  : </td>
                <td><select name="mm_ini" size="1" class="caja_texto_cb" id="mm_ini" >
                    <option value="00">00</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                </select></td>
                <td width="18%" class="caja_sb">HORA FIN</td>
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
                        
						
                        
        </script>      </td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">TIEMPO</td>
      <td colspan="3"><input name="tiempo" type="text" class="caja_texto_pe" id="tiempo" size="5" readonly="readonly" />
          <input name="exc" type="hidden" class="caja_texto_pe" id="exc" size="10" readonly="readonly" /></td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">OBSERVACION</td>
      <td colspan="3"><textarea name="obs" cols="50" rows="3" class="caja_texto_pe" id="obs" onclick="javascript:calcular_tiempos_capa()"></textarea></td>
    </tr>
    <tr>
      <td colspan="4" valign="top" class="clsCurrentMonthDay">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>