<?php 
include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$c_inc="INC-".$_GET["c_inc"];

$cad=" and cod_incidencia='$c_inc'";	

/*
$lista="(select * from cab_incidencia where tp_incidencia not in('MONITOREO Y CAPACITACION COT') $cad 
 group by cod_incidencia,fec_ini_inc
)union(
select * from cab_incidencia_2018 where tp_incidencia not in('MONITOREO Y CAPACITACION COT')
$cad group by cod_incidencia)union(
select * from cab_incidencia_2019 where tp_incidencia not in('MONITOREO Y CAPACITACION COT')
$cad group by cod_incidencia) order by fec_ini_inc";
*/
$lista="select * from cab_incidencia where substr(fec_reg,1,4)='2025'".$cad;

//echo $lista;

$res_lista 	= mysql_query($lista);
$reg_lista	= mysql_fetch_row($res_lista);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js"></script>
<script language="JavaScript" src="calendar1.js"></script>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td valign="top" >&nbsp;</td>
    <td valign="top"><div id="div_msn_incsis" style="display:none">
      <a class="aviso_peke">LAS INCIDENCIAS DE SISTEMAS NO AFECTAN EN LA PRODUCTIVIDAD, NO SON CONTABILIZADAS.</a>      
      </div></td>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top" class="caja_texto_pe"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="32%" onclick="javascript:edicion_inc();" class="caja_texto_pe"><img src="image/BT6.gif" width="25" height="25" />Editar</td>
        <td width="30%" onclick="javascript:actualizar_indicencia()" class="caja_texto_pe">
        <a id="bt_aceptar" style="display: none"><img src="image/MONITOR.jpg" width="25" height="25" />Grabar</a></td>
        <td width="38%" onclick="javascript:cerrar_edit_incidencia()" class="caja_texto_pe">
		<img src="image/BT5.gif" width="25" height="25" />CERRAR</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="5" valign="top" class="resolucion">&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" valign="top" class="caja_texto_pe">Cod. Incidencia </td>
    <td width="27%" valign="top" class="caja_texto_pe"><input name="c_incidencia" type="text" class="caja_sb" id="c_incidencia" value="<?php echo $reg_lista[10]; ?>" /></td>
    <td width="4%" valign="top">
        <input name="tiempo_gru" type="hidden" id="tiempo_gru" value="0"   />
        <input name="exc_gru" type="hidden" id="exc_gru"  />
        <input name="sw" type="hidden" id="sw" value="2" />
      </td>
    <td width="13%" valign="top" class="caja_texto_pe">Fecha. Registro</td>
    <td width="41%" valign="top" class="caja_texto_pe"><input name="" type="text" class="caja_sb" id="" value="<?php echo $reg_lista[2]; ?>" /></td>
  </tr>

  <tr>
    <td valign="top" class="caja_texto_pe">Tipo Incidencia </td>
    <td valign="top" class="caja_texto_pe">
      <input id="tpincidencia" type="text" class="caja_sb" value="<?php echo $reg_lista[4]; ?>" size="40" />
      <div id="c_tpindicencia" style="display: none">
        <select name="c_mot_gru" id="c_mot_gru" class="caja_texto_pe" onchange="javascript:carga_combo('c_mot_inc_gru',this.value)" >
                <?php 			
			print "<option value='0'>ESCOGER</option>";
			$sql7="select tp_inc from tb_motivos_incidencia 
			where est>0 AND estado_tp_inc >0 AND tp_inc<>'MONITOREO Y CAPACITACION COT' group by 1";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";			
			}
			?>
        </select>	
      </div>
    </td>
    <td valign="top">&nbsp;</td>
	<?PHP 
		$c1="select * from tb_motivos_incidencia where cod_mot_inc='$reg_lista[5]' AND tp_inc='$reg_lista[4]'";
		//echo "<br>".$c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		$usu		= "select ncompleto,cip,dni from tb_usuarios where iduser='$reg_lista[3]'";		
		$res_usu	= mysql_query($usu);
		$reg_usu	= mysql_fetch_row($res_usu);
		
		$fec		= "SELECT MIN(fec_ini_inc),MAX(fec_fin_inc) FROM cab_incidencia WHERE cod_incidencia='$reg_lista[10]' ";	
		//echo $fec;	
		$res_fec	= mysql_query($fec);
		$reg_fec	= mysql_fetch_row($res_fec);
		
		if ($reg_lista[4]=="COMPENSACIONES"){
		
			$n_inc="select * from cab_incidencia where cod_incidencia='$c_inc' and motivo_incidencia in ('153','155','157','154')";
			//echo $n_inc;
			$res_n_inc	= mysql_query($n_inc);
			$reg_n_inc	= mysql_fetch_row($res_n_inc);
			
			if ($reg_lista[5]=="156"){
			$nuevo_motivo="155";
			}
			if ($reg_lista[5]=="158"){
			$nuevo_motivo="157";
			}
			if ($reg_lista[5]=="159"){
			$nuevo_motivo="154";
			}
			if ($reg_lista[5]=="160"){
			$nuevo_motivo="153";
			}
			
			if ($reg_lista[13]=="D"){
				$fec_ini = $reg_fec[0];
				$fec_fin = $reg_fec[1];
			 }else{
				$fec_ini = $reg_n_inc[6];
				$fec_fin = $reg_n_inc[7];
			 }
			 
		}else{
			$nuevo_motivo	= $reg_lista[5];
			
			if ($reg_lista[13]=="D"){
				$fec_ini = $reg_fec[0];
				$fec_fin = $reg_fec[1];
			 }else{
				$fec_ini 		= $reg_lista[6];
				$fec_fin 		= $reg_lista[7];
			 }
				
		}		
		
	?>
    <td valign="top" class="caja_texto_pe">Motivo Incidencia </td>
    <td valign="top" class="caja_texto_pe">
     <div id="div_motivo">   
    <input name="motivo" type="text" class="caja_sb" id="motivo" value="<?php echo $reg_lista[5]; ?>" size="3"  />-
    <input name="text" type="text" class="caja_sb" value="<?php echo $reg_c1[1]; ?>" size="30" />
     </div>
    <div id="c_mot_inc_gru"></div>
    </td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">Usu. Registro </td>
    <td valign="top" class="caja_texto_pe"><input type="text" class="caja_sb" value="<?php echo $reg_usu[0]; ?>" size="50" /></td>
    <td valign="top"  >&nbsp;</td>
    <td valign="top" class="caja_texto_pe">Modo</td>
    <td valign="top" class="caja_texto_pe"><?php echo $reg_lista[14]; ?>
    <select name="modalidad" size="1" class="caja_texto_pe" id="modalidad" onchange="javascript:mostrar_modo_gru(this.value);" style="display: none">
          <option value="0">Seleccionar</option>
        <?php if($reg_lista[14]=="H"){ ?>          
           <option value="H">HORAS</option>
        <?php }else{ ?>
           <option value="D">DIAS</option>
        <?php }  ?>
      </select>
 </td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">Fec.Inicial</td>
	
    <td valign="top" class="caja_texto_pe"><input name="fec_ini_inc" id='fec_ini_inc' type="text" class="caja_sb" value="<?php echo $fec_ini; ?>" size="40" readonly/></td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">Fec. Final </td>
    <td valign="top" class="caja_texto_pe"><input name="fec_fin_inc" id="fec_fin_inc"type="text" class="caja_sb" value="<?php echo $fec_fin; ?>" size="40" readonly /></td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe"></td>
    <td colspan="4" valign="top">
       <form name="form2" id="form2">
          <div id="f_dias_gru" style="display:none">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="10%" class="caja_sb">FEC. INICIO </td>
                <td width="25%"><input readonly="readonly" name="inputg1" class="caja_texto_pe" type="text" size="15" maxlength="15" id="inputg1" />
                  <a href="javascript:cal1.popup();"> 
				  <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
				   />
				  </a></td>
                
                <td width="12%" class="caja_sb">FEC. FIN </td>
                <td width="53%">
                <input readonly="readonly" name="inputg2" class="caja_texto_pe" type="text" size="15" maxlength="15" id="inputg2" />         
                  <a href="javascript:cal2.popup();">
                  <img id="b_cal2" src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a>
                  </td>
                
                </tr>
              </table>
            </div>
          <div id="f_horas_gru" style="display:none">
            <table width="100%"  class="marco_tabla">
              <tr>
                <td width="20%" class="caja_sb">FECHA </td>
                <td colspan="5"><input readonly="readonly" name="inputg3" class="caja_texto_pe" type="text" size="17" maxlength="20" id="inputg3" />
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
                  <select name="h_ini_gru" size="1" class="caja_texto_pe" id="h_ini_gru" onchange="listenerHorasInicio(event)" >
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
                <td>
                    <!--
                  <select name="mm_ini_gru" size="1" class="caja_texto_pe" id="mm_ini_gru" onchange="listenerMinutosInicio(event)" disabled >
                  <option value="00">00</option>
                  <option value="05">05</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                  <option value="25">25</option>
                  <option value="30">30</option>
                  <option value="35">35</option>
                  <option value="40">40</option>
                  <option value="45">45</option>
                  <option value="50">50</option>
                  <option value="55">55</option> 
                  </select>
                -->
                <input id="mm_ini_gru" name="mm_ini_gru" type="text"  size="5" class="caja_texto_pe" 
                       onkeypress='return validaNumericos(event)' maxlength="2" onchange="listenerMinutosInicio(event)"> 
                </td>
                
               
                <td width="15%" class="caja_sb">HORA FIN</td>
                <td>
                  <select name="h_fin_gru" size="1" class="caja_texto_pe" id="h_fin_gru" onchange="listenerHorasFinal(event)" disabled> 
                    <!--onchange="javascript:validar_horas_gru(this.value);" -->
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
                <td>
                  <!--
                  <select name="mm_fin_gru" size="1" class="caja_texto_pe" id="mm_fin_gru" onchange="listenerMinutosFinal(event)" disabled >
                  <option value="00">00</option>
                  <option value="05">05</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                  <option value="25">25</option>
                  <option value="30">30</option>
                  <option value="35">35</option>
                  <option value="40">40</option>
                  <option value="45">45</option>
                  <option value="50">50</option>
                  <option value="55">55</option>>
                  </select>
                -->
                <input id="mm_fin_gru" name="mm_fin_gru" type="text"  size="5" class="caja_texto_pe" 
                       onkeypress='return validaNumericos(event)' maxlength="2" onchange="listenerMinutosFinal(event)">     

                </td>
                 
                </tr>
              </table>
            </div>


            <div id="f_horas_gru_lactancia" style="display:none">
            <table width="100%"  class="marco_tabla">
              <tr>
                <td class="caja_sb">FEC. INICIO </td>
                <td><input readonly="readonly" name="inputg1_lac" class="caja_texto_pe" type="text" size="17" maxlength="20" id="inputg1_lac" />
                  <a href="javascript:cal1_lac.popup();"> 
				          <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
				            />
				            </a></td>
                <td class="caja_sb">FEC. FIN </td>
                <td>
                <input readonly="readonly" name="inputg2_lac" class="caja_texto_pe" type="text" size="17" maxlength="20" id="inputg2_lac" />         
                  <a href="javascript:cal2_lac.popup();">
                  <img id="b_cal2" src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                
                </tr>
              <tr>
                
                <td colspan="2" width="13%">HORAS</td>
                <td width="15%">MINUTOS</td>
                <td class="caja_sb">&nbsp;</td>
                <td width="14%">HORAS</td>
                <td width="23%">MINUTOS</td>
                </tr>
              <tr>
                <td width="20%" class="caja_sb">HORA INICIO</td>
                <td>
                  <select name="h_ini_gru_lac" size="1" class="caja_texto_pe" id="h_ini_gru_lac" >
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
                <td><select name="mm_ini_gru_lac" size="1" class="caja_texto_pe" id="mm_ini_gru_lac" >
                  <option value="00">00</option>
                  <option value="05">05</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                  <option value="25">25</option>
                  <option value="30">30</option>
                  <option value="35">35</option>
                  <option value="40">40</option>
                  <option value="45">45</option>
                  <option value="50">50</option>
                  <option value="55">55</option>>
                  </select></td>
                
               
                <td width="15%" class="caja_sb">HORA FIN</td>
                <td>
                  <select name="h_fin_gru_lac" size="1" class="caja_texto_pe" id="h_fin_gru_lac"> 
                    <!--onchange="javascript:validar_horas_gru(this.value);" -->
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
                <td><select name="mm_fin_gru_lac" size="1" class="caja_texto_pe" id="mm_fin_gru_lac" >
                  <option value="00">00</option>
                  <option value="05">05</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                  <option value="25">25</option>
                  <option value="30">30</option>
                  <option value="35">35</option>
                  <option value="40">40</option>
                  <option value="45">45</option>
                  <option value="50">50</option>
                  <option value="55">55</option>>
                  </select></td>
                 
                </tr>
              </table>
            </div>
       
         
     
    <tr>
        <td colspan="4">
        <div id="f_dias_comp" style="display:none">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="22%" class="caja_sb">FEC INICIO COMPENSACION </td>
                <td width="24%">
                <input readonly="readonly" name="input_i_c" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input_i_c" />
                  <a href="javascript:cal4.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                  <td width="19%" class="caja_sb">FEC FIN COMPENSACION</td>
                <td width="35%">
                <input readonly="readonly" name="input_f_c" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input_f_c" />         
                  <a href="javascript:cal5.popup();">
                  <img id="b_cal2" src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                </tr>
              </table>
            </div>
            
            <div id="f_horas_comp" style="display:none">
            <table width="100%"  class="marco_tabla">
              <tr>
               
                <td width="20%" class="caja_sb">FECHA COMPENSACION</td>
                <td colspan="5"><input readonly="readonly" name="input_h_c" class="caja_texto_pe" type="text" size="17" 
                maxlength="20" id="input_h_c" />
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
                  <select name="h_ini_comp" size="1" class="caja_texto_pe" id="h_ini_comp" >
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
                <td><select name="mm_ini_comp" size="1" class="caja_texto_pe" id="mm_ini_comp" >
                  <option value="00">00</option>
                  <option value="05">05</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                  <option value="25">25</option>
                  <option value="30">30</option>
                  <option value="35">35</option>
                  <option value="40">40</option>
                  <option value="45">45</option>
                  <option value="50">50</option>
                  <option value="55">55</option>>
                  </select></td>
                
               
                <td width="15%" class="caja_sb">HORA FIN</td>
                <td>
                  <select name="h_fin_comp" size="1" class="caja_texto_pe" id="h_fin_comp"> 
                    <!--onchange="javascript:validar_horas_gru(this.value);" -->
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
                <td><select name="mm_fin_comp" size="1" class="caja_texto_pe" id="mm_fin_comp" >
                  <option value="00">00</option>
                  <option value="05">05</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                  <option value="25">25</option>
                  <option value="30">30</option>
                  <option value="35">35</option>
                  <option value="40">40</option>
                  <option value="45">45</option>
                  <option value="50">50</option>
                  <option value="55">55</option>>
                  </select></td>
                 
                </tr>
              </table>
            </div>
        </td>
        </tr>
      </form>
     
      <script language="JavaScript" type="text/javascript">
                        var cal1 = new calendar1(document.forms["form2"].elements['inputg1']);
                        cal1.year_scroll = true;
                        cal1.time_comp = false;
										
                      
						
						var cal3 = new calendar1(document.forms["form2"].elements['inputg3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;	
						
					
							  
                        var cal2 = new calendar1(document.forms["form2"].elements['inputg2']);
                        cal2.year_scroll = true;
                        cal2.time_comp = false;		
						
							  
                        var cal4 = new calendar1(document.forms["form2"].elements['input_i_c']);
                        cal4.year_scroll = true;
                        cal4.time_comp = false;		
						
						 var cal5 = new calendar1(document.forms["form2"].elements['input_f_c']);
                        cal5.year_scroll = true;
                        cal5.time_comp = false;	
						
						
						 var cal6 = new calendar1(document.forms["form2"].elements['input_h_c']);
                        cal6.year_scroll = true;
                        cal6.time_comp = false;	
                
              var cal1_lac = new calendar1(document.forms["form2"].elements['inputg1_lac']);
              cal1_lac.year_scroll = true;
              cal1_lac.time_comp = false;
              
              var cal2_lac = new calendar1(document.forms["form2"].elements['inputg2_lac']);
              cal2_lac.year_scroll = true;
              cal2_lac.time_comp = false;
		          	</script>     
      
      
    </td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">Tiempo Permiso </td>
	<?php 
	 
	 
	$c ="select * from cab_incidencia where cod_incidencia='$c_inc' and tp_incidencia='COMPENSACIONES' 
	and motivo_incidencia in('153','154','155','157')";
	$res_c	= mysql_query($c);
	$reg_c	= mysql_fetch_row($res_c);
	
	if (substr($reg_c[12],0,1)=="-"){
	 	$tiempo_acum = substr($reg_c[12],1,8);
	 }else{
	 	$tiempo_acum = $reg_c[12];
	 }
	 
	$d ="select SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo)*-1)) from cab_incidencia where cod_incidencia='$c_inc' and tp_incidencia='COMPENSACIONES' 
	and motivo_incidencia in('156','158','159','160')";
	$res_d	= mysql_query($d);
	$reg_d	= mysql_fetch_row($res_d);
	
	if (substr($reg_d[0],0,1)=="-"){
	 	$t_acu_comp = substr($reg_d[0],1,8);
	 }else{
	 	$t_acu_comp = $reg_d[0];
	 }
	
	$t_permiso ="SELECT SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini', '$fec_fin'))*60) from cab_incidencia 
	where tp_incidencia='COMPENSACIONES' and motivo_incidencia in('155','157','154','153','88') group by 1 ";
	//echo $t_permiso;
	$res_t_permiso	= mysql_query($t_permiso);
	$reg_t_permiso	= mysql_fetch_row($res_t_permiso);
	/*  
	if ($reg_lista[13]=="D"){
	 	$fec_permiso = $reg_lista[16]." dias | ".$reg_lista[12];
	 }else{
		$fec_permiso = $reg_t_permiso[0];
	 }
	 */
	 $fec_permiso = $reg_t_permiso[0];
	?>
	
    <td class="caja_texto_pe" valign="top">
        <input name="tiempo_inc" type="text" class="caja_sb" id="tiempo_inc" value="0" size="8" readonly="readonly" />
		<input name="exc" type="text" class="caja_sb" id="exc" size="15" readonly="readonly" />
		<input name="tiempo_minutos" type="text" class="caja_sb" id="tiempo_minutos" value="0" size="8" readonly="readonly" /> MINUTOS
		</td>
      <td valign="top"><input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $_GET["idperfil"]; ?>"/>
      <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $_GET["iduser"];?>"/>
      <input readonly="readonly" name="tt_acu_comp3" class="caja_texto_pe" type="hidden" size="10" maxlength="20" id="tt_acu_comp3" 
     value="00:00:00" /></td>
    <td valign="top" class="caja_texto_pe">Observacion</td>
    <td valign="top" class="caja_texto_pe">
      <p><?php 
          $obs=explode("#",$reg_lista[8]);
        echo trim($obs[0]); ?></p>
      <p>
        <textarea value="<?php echo trim($reg_lista[8]); ?>" 
       name="obs_gru" cols="50" rows="3" class="caja_texto_pe"      
	   id="obs_gru" onclick="calcular_tiempos_inc()"> 
        </textarea>
      </p>
    </td>
  </tr>
    <!--
 <tr>
     <td colspan="8">
       <div id="fec_corregidas" style="display: none">
    <table width="100%" class="marco_tabla">
    <tr>
    <td valign="top" class="caja_texto_pe">Fecha Inicial Corregida</td>
    <td valign="top" class="caja_texto_pe"><input name="nfec_ini_inc" id='nfec_ini_inc' type="text" class="caja_texto_peke"  size="40" /></td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">Fecha Final Corregida</td>
    <td valign="top">
      <input name="nfec_fin_inc" id='nfec_fin_inc' type="text" class="caja_texto_peke"  size="40" />
    </td>
    </tr>
    </table>
 </div>  
     </td>
 </tr>
 -->
  <tr>
    <td colspan="2" valign="top" class="caja_texto_pe"><div id="div_doid" style="display:none">DOID:
        <input name="c_doid_gru" type="text" class="caja_texto_cb" id="c_doid_gru" size="25" maxlength="20" />
      </div></td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">&nbsp;</td>
  </tr>
  <?php
  //echo $reg_lista[13];
  /*
  if ($reg_lista[13]=="H"){ //modo hora
  	 $ges="(select dni,fec_ini_inc,fec_fin_inc from cab_incidencia where cod_incidencia='$c_inc' group by dni	 
	 )union(
	select dni,fec_ini_inc,fec_fin_inc from cab_incidencia_2018 where cod_incidencia='$c_inc' group by dni)union(
	select dni,fec_ini_inc,fec_fin_inc from cab_incidencia_2019 where cod_incidencia='$c_inc' group by dni) order by fec_ini_inc";
	$c_reg="(select dni,fec_ini_inc from cab_incidencia where cod_incidencia='$c_inc' group by dni 	 
	)union(
   select dni,fec_ini_inc from cab_incidencia_2018 where cod_incidencia='$c_inc' group by dni)union(
   select dni,fec_ini_inc from cab_incidencia_2019 where cod_incidencia='$c_inc' group by dni) order by fec_ini_inc";
  }else{
 	 $ges="(select dni,fec_ini_inc,fec_fin_inc from cab_incidencia where cod_incidencia='$c_inc' group by 1,2
	 )union(
	select dni,fec_ini_inc,fec_fin_inc from cab_incidencia_2018 where cod_incidencia='$c_inc' group by 1,2)union(
	select dni,fec_ini_inc,fec_fin_inc from cab_incidencia_2019 where cod_incidencia='$c_inc' group by 1,2) order by fec_ini_inc";
	$c_reg="(select dni,fec_ini_inc from cab_incidencia where cod_incidencia='$c_inc' group by 1,2 	 
	)union(
   select dni,fec_ini_inc from cab_incidencia_2018 where cod_incidencia='$c_inc' group by 1,2)union(
   select dni,fec_ini_inc from cab_incidencia_2019 where cod_incidencia='$c_inc' group by 1,2) order by fec_ini_inc";
  }
  */
  $ges="select dni,fec_ini_inc,fec_fin_inc from cab_incidencia where cod_incidencia='$c_inc' and estado_inc<>'3' group by dni";  

 //echo $ges;
  
	$res_ges 	= mysql_query($ges);
	$cn_reg    = mysql_query($c_reg);
	//$cnt_reg   = mysql_num_rows($cn_reg);
  ?>
  <tr>
    <td colspan="5" valign="top" class="resolucion">LISTA DE GESTORES </td>
  </tr>
  <tr>  
    <td colspan="5" valign="top">
	<div style="overflow:scroll; width:100%; height:200px">
		<table width="100%" border="0">
		  <tr>
		    <td width="5%" class="caja_texto_pe">ITEM</td>	
			<td width="5%" class="caja_texto_pe">DNI</td>	
			<td width="5%" class="caja_texto_pe">CIP</td>			
			<td width="30%" class="caja_texto_pe">GESTORES</td>			
			<td width="20%" class="caja_texto_pe">FEC.INI.INC</td>
			<td width="20%" class="caja_texto_pe">FEC.FIN.FIN</td>
			<td width="5%" class="caja_texto_pe">PANEL</td>
		  </tr>
		  <?php 
		    $con = 0		;
			while($reg_ges=mysql_fetch_row($res_ges)){
                $con = $con + 1;
			
				$gestor		= "select dni,cip,ncompleto from tb_usuarios where dni='$reg_ges[0]'";	
				//echo $gestor;	
				$res_gestor	= mysql_query($gestor);
				$reg_gestor	= mysql_fetch_row($res_gestor);		
				
						
	 	  ?>
		  <tr>
		    <td class="caja_texto_peke"><?php echo $con=$con+1; ?></td>			
			<td class="caja_texto_peke">
		    <input name="dni" id="dni" type="text" value="<?php echo $reg_gestor[0]; ?>" size="20" class="caja_sb" />
			</td>		
			<td class="caja_texto_peke"><?php echo $reg_gestor[1]; ?></td>			
			<td class="caja_texto_peke"><?php echo $reg_gestor[2]; ?></td>
			<td class="caja_texto_peke"><?php echo $reg_ges[1]; ?></td>
			<td class="caja_texto_peke"><?php echo $reg_ges[2]; ?></td>
			<?php
			if ($con>1){
			?>
            
			<td class="caja_texto_peke">
            <img src="image/eliminar2.jpg" title="Eliminar" 
            onclick="javascript:eliminar_gestor_inc('<?php echo $reg_lista[10].'\',\''.$reg_gestor[0].'\',\''.$reg_ges[1].'\',\''.$reg_lista[0]; ?>');">
            </td>
            
			<?php
			}
			?>
		  </tr>
		  <?php } ?>
		</table>
		</div>	</td>
  </tr>
   <?php
   
  // echo $reg_lista[5];
  if ($reg_lista[4]=="COMPENSACIONES"){
  	/*
 		 $fec1		= "SELECT * FROM cab_incidencia WHERE cod_incidencia='$c_inc' AND tp_incidencia='COMPENSACIONES'";	
		// echo $fec1;	
		 $res_fec1	= mysql_query($fec1);
		 $nreg1		= mysql_num_rows($res_fec1);
		 //echo $nreg1;
		 
		 if ($nreg1>1){
		 */
   ?>
  <tr>
    <td valign="top" class="caja_texto_pe">Tiempo Compensado </td>
    <td valign="top"><input name="tt_acu_comp" type="text"  id="tt_acu_comp" value="<?PHP echo $t_acu_comp; ?>" readonly="readonly" class="caja_texto_peke"/>
    <input readonly="readonly" name="tt_acu_comp2" class="caja_texto_peke" type="hidden"  id="tt_acu_comp2" 
              value="<?PHP echo $t_acu_comp; ?>" /></td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">Tiempo Acumulado </td>
    <td valign="top"><input readonly="readonly" name="tt_comp_tot" class="caja_texto_peke" type="text"  id="tt_comp_tot" 
		value="00:00:00" /></td>
  </tr> 
  
   <tr>
    <td colspan="4" valign="top" class="resolucion">COMPENSACIONES    </td>
    <td valign="top" class="resolucion">  
			  <table width="40%" border="0" cellpadding="0" cellspacing="0" align="right">
			  <tr>
			  <?php
			  if ($tiempo_acum==t_acu_comp){?>
			   <td width="51%" onclick="javascript:mostrar_comp();" >&nbsp;</td>
			  <?php }else{ ?>	   
			   <td width="51%" onclick="javascript:mostrar_comp();" class="caja_texto_pe" style="cursor:pointer">Agregar</td>
			  <?php } ?>
			  <td width="51%" onclick="javascript:mostrar_comp();" >&nbsp;</td>
				<td width="49%" onclick="javascript:eliminiar_comp();" class="caja_texto_pe"  style="cursor:pointer">Eliminar</td>
			  </tr>
			</table>	</td>
  </tr>
 
  <tr>
    <td colspan="5" valign="top" >
	<div id="frm_comp" style="display:none">
	<form name="form1" id="form1">
	<table width="100%"  class="marco_tabla">
            <tr>
              <td width="20%" class="caja_sb">FECHA </td>
              <td colspan="3">
			  <input readonly="readonly" name="inputg3" class="caja_texto_peke" type="text" size="17" maxlength="20" id="inputg3" />
                <a href="javascript:cal3.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" />                </a></td>
          
              <td class="caja_sb"></td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td class="caja_sb">&nbsp;</td>
              <td width="13%">HORAS</td>
              <td width="15%">MINUTOS</td>
              <td class="caja_sb">&nbsp;</td>
              <td width="14%">HORAS</td>
              <td width="23%" colspan="2">MINUTOS</td>
            </tr>
            <tr>
              <td width="20%" class="caja_sb">HORA INICIO</td>
              <td><select name="h_ini_gru" size="1" class="caja_texto_peke" id="h_ini_gru" >
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
              <td><select name="mm_ini_gru" size="1" class="caja_texto_peke" id="mm_ini_gru" >
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="45">45</option>
              </select></td>
              <td width="15%" class="caja_sb">HORA FIN</td>
              <td><select name="h_fin_gru" size="1" class="caja_texto_peke" id="h_fin_gru" onchange="javascript:calc_tiempo_comp()" >
                <!--onchange="javascript:validar_horas_gru(this.value);" -->
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
              <td><select name="mm_fin_gru" size="1" class="caja_texto_peke" id="mm_fin_gru" onchange="javascript:calc_tiempo_comp()" >
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="45">45</option>
              </select>			  	 </td>
              <td><a id="bt_compensacion" class="caja_texto_pe" onclick="javascript:save_compensaciones_inc();">Agregar</a>		</td>
            </tr>
          </table>
	    </form>
     </div>
      				<script language="JavaScript" type="text/javascript">
              
						
						var cal3 = new calendar1(document.forms["form1"].elements['inputg3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;	
						
					
		          	</script>	</td>
  </tr>
  <tr>
    <td colspan="5" valign="top" >
	<div id='d_listado_compensaciones' style="overflow:scroll; width:100%; height:200px">
  	<?PHP
	
  	$comp="select * from cab_incidencia where cod_incidencia='$c_inc' and tp_incidencia='COMPENSACIONES' 
	and motivo_incidencia in('154','156','158','159','160','33')";
	//echo $comp;
	$res_comp = mysql_query($comp);
	
	echo "<table width='100%' >";	
			echo "<tr>";							
			echo "<td class='caja_texto_pe'>ITEM </td>";													
			echo "<td class='caja_texto_pe'>FEC. INICIO</td>";
			echo "<td class='caja_texto_pe'>FEC. FIN</td>";
			echo "<td class='caja_texto_pe'>DIF.</td>";				
							
			echo "</tr>";
	$i=0;
	while($reg_comp=mysql_fetch_row($res_comp)){		
		
					
		echo "<tr>";	
		
		echo "<td  class='caja_texto_peke'>";
		echo "<input type='checkbox' name='check".$i."' id='check".$i."' value='$reg_comp[0]' onclick='javascript:escojer_check()'/>";
		echo $i=$i+1; 			
		echo "</td>";	
		
		$fec_ini =$reg_comp[6];
		$fec_fin =$reg_comp[7];
						
		$calc="select SEC_TO_TIME((TIMESTAMPDIFF(MINUTE ,'$fec_ini','$fec_fin'))*60) as dif";
		//echo $calc;
			
		$rs_calc = mysql_query($calc);											
		$rg_calc = mysql_fetch_row($rs_calc);	
					 
		echo "<td class='caja_texto_peke'>";		
		echo $reg_comp[6]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";
		echo $reg_comp[7]; 				
		echo "</td>";			
		
		echo "<td class='caja_texto_peke'>";
		echo $rg_calc[0]; 				
		echo "</td>";
		
		
		echo "</tr>";				
		}	
	echo "</table>";	
	
  ?>
    <input name="valor_escogido" type="hidden" class="casilla_texto" id="valor_escogido"/>
	<input name="nro_escogidos" type="hidden" class="casilla_texto" id="nro_escogidos"/>
	</div>  </td>
  </tr>
  <tr>
    <td colspan="5" valign="top" class="caja_texto_pe">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="caja_texto_pe">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  
   <?php } ?>
</table>
</body>
</html>
