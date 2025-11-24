<? 
include("conexion_bd.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js"></script> 
<script language="JavaScript" src="calendar1.js"></script>


<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<script language="JavaScript1.2" src="bandejas/table.js"></script>
<script language="JavaScript1.2" src="bandejas/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="bandejas/table.css" media="all">

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
<input name="chk_escogidos_" type="text" class="caja_texto_sb" id="chk_escogidos_" />		

<table width="100%" border="1">
  <tr>
    <td colspan="3" class="celdas">&nbsp;</td>
  </tr>
  <tr>
    <td width="190" class="TRegistros">Incidencia</td>
    <td width="226" class="TRegistros"><select name="tp_incidencia" class="caja_texto_pe" id="tp_incidencia" 
    onchange="javascript:mostrar_registro_incidenciacot(this.value)">
      <option value="0">ESCOGER</option>
      <option value="2">INDIVIDUAL/GRUPAL</option>
      <option value="3">MASIVA</option>
    </select></td>
    <td width="856" class="TRegistros"> <a href="javascript:javascript:cerrar_win('3')"><img src="image/SAL.jpg" width="25" height="30" border="0"/>Salir</a></td>	 
  </tr>
  <tr>
    <td colspan="3" class="cabeceras_grid">	
	
	<div id="div_registro_incidencias" style="display:block">
		<table width="100%" border="0" cellpadding="1" cellspacing="1" class="marco_tabla_red">
          <tr>
            <td width="87" valign="top" class="cabeceras_grid">TRABAJADOR</td>
            <td colspan="2" class="cabeceras_grid">
			<select name="gestor" id="gestor" class="caja_sb" >
                <? 			
			print "<option value='0' selected>Seleccione Gestor</option>";
			print "<option value='T'>TODOS</option>";
			$sql7="select cip,dni,ncompleto from tb_usuarios where estado='HABILITADO' order by ncompleto";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]-$rowper[1]'>$rowper[2] - $rowper[0]</option>";			
			}
			?>
            </select>			</td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">&nbsp;</td>
            <td colspan="2" class="cabeceras_grid">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">TIPO</td>
            <td width="208" class="cabeceras_grid">
			<select name="c_inc" id="gestor" class="c_inc" onchange="javascript:carga_combo('c_mot_inc',this.value)" >
                <? 			
			print "<option value='0'>ESCOGER</option>";
			$sql7="select tp_inc from tb_motivos_incidencia where est=1 AND tp_inc<>'MONITOREO Y CAPACITACION COT' group by 1";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";			
			}
			?>
            </select>			</td>
            <td width="276" class="cabeceras_grid">
			<div id="d_doid" style="display:none">DOID:
            <input name="c_doid" type="text" class="caja_texto_cb" id="c_doid" size="25" maxlength="20">
            </div>			</td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">&nbsp;</td>
            <td colspan="2" class="cabeceras_grid">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">MOTIVO</td>
            <td colspan="2" class="cabeceras_grid"><div id="c_mot_inc"></div></td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">&nbsp;</td>
            <td colspan="2" class="cabeceras_grid">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">MODO</td>
            <td class="cabeceras_grid"><select name="modo" size="1" class="caja_sb" id="modo" onchange="javascript:mostrar_modo(this.value);" >
                <option value="0">Seleccionar</option>
                <option value="D">DIAS</option>
                <option value="H">HORAS</option>
            </select></td>
            <td class="cabeceras_grid"><div id="d_numero_afe" style="display:none">AFECTADOS:
              <input name="nro" type="text" class="caja_texto_cb" id="nro" size="25" 
      maxlength="20">
            </div></td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">&nbsp;</td>
            <td colspan="2" class="cabeceras_grid">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" >&nbsp;</td>
            <td colspan="2">
			<form name="form1" id="form1">	
			<div id="f_dias" style="display:NONE">
                <table width="100%" class="marco_tabla">
                  <tr>
                    <td width="18%" class="caja_sb">FEC. INICIO </td>
                    <td width="34%"><input readonly="readonly" name="input1" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input1" />
                        <a href="javascript:cal1.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                    <td width="11%" class="caja_sb">FEC. FIN </td>
                    <td width="37%"><input readonly="readonly" name="input2" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input2" />
                        <a href="javascript:cal2.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"/></a></td>
                  </tr>
                </table>
            </div>
                <div id="f_horas" style="display:none">							
                  <table width="100%"  class="marco_tabla">
                    <tr>
                      <td width="20%" class="caja_sb">FECHA </td>
                      <td colspan="5"><input readonly="readonly" name="input3" class="caja_texto_cb" type="text" size="17" maxlength="20" id="input3" />
                          <a href="javascript:cal3.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
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
		          	</script>
          <tr>
            <td valign="top" class="cabeceras_grid">TIEMPO</td>
            <td colspan="2" class="cabeceras_grid"><input name="tiempo" type="text" class="caja_sb" id="tiempo" value="0" size="8" readonly="readonly" />
                <input name="exc" type="text" class="caja_sb" id="exc" size="15" readonly="readonly" /></td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">&nbsp;</td>
            <td colspan="2" class="cabeceras_grid">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top" class="cabeceras_grid">OBSERVACION</td>
            <td colspan="2" class="cabeceras_grid"><textarea name="obs" cols="50" rows="3" class="casilla_texto" id="obs" onclick="calcular_tiempos()">
        </textarea>            </td>
          </tr>      
</table>
</div>

<!--- BOTONES  -->
<table width="100%" border="0">
<tr>
<td>
	<div id="botones_gru" style="display:NONE">  
		<table width="30%" align="right">
			  <tr>
			  <td width="10px" class="caja_texto_pe"><a id="add_gestores" href="javascript:agregar_gestores()">
			  <img src="image/LISTAS.JPG" width="20" height="20" border="0" />Agregar participantes</a></td>
			  <td width="10px" class="caja_texto_pe">
			  <a id="bt_aceptar_gru" style="display:none"  href="javascript:grabar_incidencia_grupal()">
			  <img src="image/panel.jpg" width="25" height="30" border="0" />Grabar</a></td>			 
			  </tr>
		</table>
	</div></td>
</tr>
<tr>
<td>
<p>
<?
$sql_2="(select '','','','','','','','' )
UNION(select iduser,ncompleto,dni,cip,c_supervisor,c_monitor,local,ola from tb_usuarios where estado='HABILITADO' and grupo='COT-TDP' ORDER BY ncompleto)";
//echo $sql_2;
$res = mysql_query($sql_2);
$reg=mysql_fetch_row($res);
?>
<div id="lista_participantes" style="display:block; overflow:scroll">  
<form name="f1">
	 <table width="100%" 
	 class="example table-autosort table-autofilter table-autopage:20 table-stripeclass:alternate table-page-number:t1page over:auto  
	 table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount table-stripeclass:alternate altstripe sort01 table-autostripe 
	 table-autosort:2 table-stripeclass:alternate2" id="t1" summary="">
		
		<thead>
		<tr>
				<td colspan="7">
				<a href="javascript:seleccionar_incidencia_todo()">Marcar todos</a> |
				<a href="javascript:deseleccionar_incidencia_todo()">Marcar ninguno</a>				</td>
		</tr>
			
		  <tr>
					<?					
					
					//echo "<th>ITEM</th>";				
					echo "<th>...</th>";
					
					echo "<th class='filterable' align='left'>CIP";						
					echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";	
					
					
					echo "<th class='filterable' align='left'>DNI";						
					echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";	
					
						
					echo "<th class='filterable table-sortable:default' align='left' >NOMBRE COMPLETO";						
					echo "<input class='caja_texto_pe' name='filter' size='40' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
					/*
					echo "<th class='filterable' align='left'>DNI";						
					echo "<input class='caja_texto_pe' name='filter' size='15' maxlength='15' onkeyup='Table.filter(this,this)'></th>";
						*/		
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
		
		$lo="select nom_local from tb_locales where cod_local='".$reg[6]."'";
		//echo $s;
		$rs_lo = mysql_query($lo);											
		$rg_lo = mysql_fetch_row($rs_lo);
		
				
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
		//echo "check".$i."|".$reg[2];
		?>
    <input type="checkbox" name="<? echo "check".$i; ?>" id="<? echo "check".$i; ?>" value="<? echo $reg[2]; ?>" 
    onclick="javascript:escojer_gestor()" /> 
        <?
		echo "</td>";
		
		echo "<td>";		//CIP		
		echo $reg[3]; 				
		echo "</td>";
		
		echo "<td>";		//CIP		
		echo $reg[2]; 				
		echo "</td>";
		
		echo "<td>";
		echo $reg[1]; 		//NOMBRE	
		echo "</td>";
		
		/*	
		echo "<td>";		//DNI		
		echo $reg[2]; 				
		echo "</td>";
		*/
		
		echo "<td>";		// SUPERVISOR		
		echo $rg_s[0]; 				
		echo "</td>";
		
		
		echo "<td>";		// monitor		
		echo $rg_m[0]; 				
		echo "</td>";
		
	
		
		echo "</tr>";	
				
		}		
	?>
</tbody>		
<tfoot>
	<tr>		
        <td colspan="2" class="table-page:previous" style="cursor:pointer;">&lt; &lt; Anterior</td>
		<td colspan="3" style="text-align:center;">Pagina <span id="t1page"></span>&nbsp;de <span id="t1pages"></span></td>

		<td colspan="2" class="table-page:next" style="cursor:pointer;">Siguiente &gt; &gt;</td>			
	</tr>
    <!--
	<tr>
	<td colspan="11" align="center">
    <span id="t1filtercount"></span>&nbsp;de <span id="t1allcount"></span>&nbsp;registro(s)
    </td>		
	</tr>
    -->
</tfoot>	
</table>
</form>
</div>
<!---   --></td>
</tr>
<tr>
<td>
<div id="registro_gestores" style="display:none">
  <table width="70%" border="0" cellpadding="1" cellspacing="1">     
    <tr>
      <td colspan="3" valign="top" class="caja_texto_db">Registro Individual / Grupal </td>
      </tr>
    <tr>	
      <td valign="top" class="cabeceras_grid">CODIGO</td>
      <td colspan="2" class="caja_texto_pe"><input name="c_incidencia" type="text" class="caja_texto_pe" id="c_incidencia" size="30" /></td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="cabeceras_grid">TIPO</td>
      <td width="208" class="cabeceras_grid">
	  <select name="c_mot_gru" id="c_mot_gru" class="caja_texto_pe" onchange="javascript:carga_combo('c_mot_inc_gru',this.value)" >
                <? 			
			print "<option value='0'>ESCOGER</option>";
			$sql7="select tp_inc from tb_motivos_incidencia where est=1 AND tp_inc<>'MONITOREO Y CAPACITACION COT' group by 1";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";			
			}
			?>
        </select>	 </td>
      <td width="276" class="cabeceras_grid"><div id="div" style="display:none">DOID:
        <input name="c_doid_gru" type="text" class="caja_texto_cb" id="c_doid_gru" size="25" maxlength="20" />
      </div></td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">MOTIVO</td>
      <td colspan="2" class="cabeceras_grid"><div id="c_mot_inc_gru"></div></td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">MODO</td>
      <td class="cabeceras_grid"><select name="modo_gru" size="1" class="caja_texto_pe" id="modo_gru" onchange="javascript:mostrar_modo_gru(this.value);" >
          <option value="0">Seleccionar</option>
          <option value="D">DIAS</option>
          <option value="H">HORAS</option>
      </select></td>
      <td class="cabeceras_grid"><div id="div2" style="display:none">AFECTADOS:
        <input name="nro2" type="text" class="caja_texto_cb" id="nro2" size="25" 
      maxlength="20" />
      </div></td>
    </tr>
    
    <tr>
      <td valign="top" >&nbsp;</td>
      <td colspan="2">
	  <form name="form2" id="form2">
          <div id="f_dias_gru" style="display:none">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="18%" class="caja_sb">FEC. INICIO </td>
                <td width="34%"><input readonly="readonly" name="inputg1" class="caja_texto_cb" type="text" size="17" maxlength="20" id="inputg1" />
                  <a href="javascript:cal1.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                <td width="11%" class="caja_sb">FEC. FIN </td>
                <td width="37%"><input readonly="readonly" name="inputg2" class="caja_texto_cb" type="text" size="17" maxlength="20" id="inputg2" />
                  <a href="javascript:cal2.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"/></a></td>
              </tr>
            </table>
          </div>
        <div id="f_horas_gru" style="display:none">
            <table width="100%"  class="marco_tabla">
              <tr>
                <td width="20%" class="caja_sb">FECHA </td>
                <td colspan="5"><input readonly="readonly" name="inputg3" class="caja_texto_cb" type="text" size="17" maxlength="20" id="inputg3" />
                  <a href="javascript:cal3.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
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
                <td>
                    <select name="h_ini_gru" size="1" class="caja_texto_cb" id="h_ini_gru" >
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
                <td><select name="mm_ini_gru" size="1" class="caja_texto_cb" id="mm_ini_gru" >
                    <option value="00">00</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                </select></td>
				
                <td width="15%" class="caja_sb">HORA FIN</td>
                <td>
				<select name="h_fin_gru" size="1" class="caja_texto_cb" id="h_fin_gru" onchange="javascript:validar_horas_gru(this.value);" >
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
                <td><select name="mm_fin_gru" size="1" class="caja_texto_cb" id="mm_fin_gru" >
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
                        var cal1 = new calendar1(document.forms["form2"].elements['inputg1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;
										
                        
                        var cal2 = new calendar1(document.forms["form2"].elements['inputg2']);
                        cal2.year_scroll = true;
                        cal2.time_comp = false;		
						
						var cal3 = new calendar1(document.forms["form2"].elements['inputg3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;									
		          	</script>      </td>
    </tr>
    <tr>
      <td valign="top" class="cabeceras_grid">TIEMPO</td>
      <td colspan="2" class="cabeceras_grid"><input name="tiempo_gru" type="text" class="caja_texto_pe" id="tiempo_gru" value="0" size="8" readonly="readonly" />
          <input name="exc_gru" type="text" class="caja_sb" id="exc_gru" size="15" readonly="readonly" /></td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">OBSERVACION</td>
      <td colspan="2" class="cabeceras_grid"><textarea name="obs_gru" cols="50" rows="3" class="caja_texto_pe" id="obs_gru" onclick="calcular_tiempos_gru()">
        </textarea>      </td>
    </tr>
  </table>
</div></td>
</tr>
</table>

<!---  modulo masivo --->

<div id="div_modulo_masivo" style="display:none">

<table width="70%" border="0" cellpadding="1" cellspacing="1"> 
	  <tr>
	    <td colspan="3" valign="top" class="caja_texto_db">Registro Masivo </td>
	    </tr>
	  <tr>	  
			  <td width="46%" valign="top" class="cabeceras_grid">SUPERVISION</td>
			  <td width="54%" colspan="2" class="caja_texto_pe"><select name="c_supervisor" id="c_supervisor" class="caja_texto_pe">
				<option value="0">Escoger</option>
				<?
					print "<option value='T'>TODO COT</option>";
					$sql7="select * from tb_supervisores where est=1";			
					$queryresult7 = mysql_query($sql7) or die (mysql_error());
					while ($rowper=mysql_fetch_row($queryresult7)) { 										  
					print "<option value='$rowper[0]'>$rowper[1]</option>";
					}
					?>
			  </select></td>	 
	</tr>
	<? 
	
	$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia_ ORDER BY 1 DESC";
	//echo $cad;
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);	
	$franq 	= limpia_espacios($rg[0]);
	$franqueo_ = "INC-".$franq;
	
	?>	
    <tr>	
      <td valign="top" class="cabeceras_grid">CODIGO</td>
      <td colspan="2" class="caja_texto_pe"><input name="c_incidencia_mas" type="text" class="caja_texto_pe" id="c_incidencia_mas" size="30" value="<? echo $franqueo_?>" /></td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    
    <tr>
      <td valign="top" class="cabeceras_grid">CODIGO DOID </td>
      <td class="cabeceras_grid"> <input name="c_doid_mas" type="text" class="caja_texto_pe" id="c_doid_mas" size="25" maxlength="20"></td>
      <td class="cabeceras_grid">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="cabeceras_grid">MODO</td>
      <td class="cabeceras_grid"><select name="modo_mas" size="1" class="caja_texto_pe" id="modo_mas" onchange="javascript:mostrar_modo_mas(this.value);" >
          <option value="0">Seleccionar</option>
          <option value="D">DIAS</option>
          <option value="H">HORAS</option>
      </select></td>
      <td class="cabeceras_grid">
	  <div id="div2" style="display:none">AFECTADOS:
        <input name="nro2" type="text" class="caja_texto_cb" id="nro2" size="25" 
      maxlength="20" />
      </div></td>
    </tr>
    
    <tr>
      <td valign="top" >&nbsp;</td>
      <td colspan="2">
	  <form name="form3" id="form3">
          <div id="f_dias_mas" style="display:none">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="18%" class="caja_sb">FEC. INICIO </td>
                <td width="34%"><input readonly="readonly" name="inputm1" class="caja_texto_cb" type="text" size="17" maxlength="20" id="inputm1" />
                  <a href="javascript:cal4.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                <td width="11%" class="caja_sb">FEC. FIN </td>
                <td width="37%"><input readonly="readonly" name="inputm2" class="caja_texto_cb" type="text" size="17" maxlength="20" id="inputm2" />
                  <a href="javascript:cal5.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date"/></a></td>
              </tr>
            </table>
          </div>
        <div id="f_horas_mas" style="display:none">
            <table width="100%"  class="marco_tabla">
              <tr>
                <td width="20%" class="caja_sb">FECHA </td>
                <td colspan="5"><input readonly="readonly" name="inputm3" class="caja_texto_cb" type="text" size="17" maxlength="20" id="inputm3" />
                  <a href="javascript:cal6.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
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
                <td>
                    <select name="h_ini_mas" size="1" class="caja_texto_cb" id="h_ini_mas" >
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
                <td><select name="mm_ini_mas" size="1" class="caja_texto_cb" id="mm_ini_mas" >
                    <option value="00">00</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="45">45</option>
                </select></td>
				
                <td width="15%" class="caja_sb">HORA FIN</td>
                <td>
				<select name="h_fin_mas" size="1" class="caja_texto_cb" id="h_fin_mas" onchange="javascript:validar_horas_gru(this.value);" >
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
                <td><select name="mm_fin_mas" size="1" class="caja_texto_cb" id="mm_fin_mas" >
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
                        var cal4 = new calendar1(document.forms["form3"].elements['inputm1']);
                        cal4.year_scroll = true;
                        cal4.time_comp = false;
										
                        
                        var cal5 = new calendar1(document.forms["form3"].elements['inputm2']);
                        cal5.year_scroll = true;
                        cal5.time_comp = false;		
						
						var cal6 = new calendar1(document.forms["form3"].elements['inputm3']);
                        cal6.year_scroll = true;
                        cal6.time_comp = false;									
		          	</script>      </td>
    </tr>
    <tr>
      <td valign="top" class="cabeceras_grid">TIEMPO</td>
      <td colspan="2" class="cabeceras_grid"><input name="tiempo_mas" type="text" class="caja_texto_pe" id="tiempo_mas" value="0" size="8" readonly="readonly" />
          <input name="exc_mas" type="text" class="caja_sb" id="exc_mas" size="15" readonly="readonly" /></td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">OBSERVACION</td>
      <td colspan="2" class="cabeceras_grid"><textarea name="obs_mas" cols="50" rows="3" class="caja_texto_pe" id="obs_mas" onclick="calcular_tiempos_mas()">
        </textarea>      </td>
    </tr>
	
	<tr>
      <td valign="top"  colspan="3">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<th width="12%" class="cabeceras_grid" scope="col" onclick="javascript:grabar_incidencia_masiva();">
				<a id="bt_grabar_mas" style="display:none"><img src="image/vis.jpg" width="20" height="20" />Grabar</a></th>
				<th width="12%" scope="col">&nbsp;</th>
				<th width="76%" scope="col">&nbsp;</th>
			  </tr>
	</table>	</td>
    </tr>
  </table>
</div>
</table>
</body>
</html>
