<?php
include("conexion_bd.php");
$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

$gru="select grupo,sgrupo,c_supervisor from tb_usuarios where iduser='$iduser'";
//echo $gru;
$res_gru = mysql_query($gru) or die (mysql_error());
$reg_gru=mysql_fetch_row($res_gru);


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

<script>
    
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;    
}
    

</script>
    
</head>

<body>	

<input name="arr_escogidos" type="hidden" class="casilla_texto" id="arr_escogidos" />
<input name="arr_hor" type="hidden" class="casilla_texto" id="arr_hor" />
<input name="chk_escogidos_" type="hidden" class="caja_texto_sb" id="chk_escogidos_" />
<input name="chk_escogidos" type="hidden" class="caja_texto_sb" id="chk_escogidos" />
<input name="cip" type="hidden" class="casilla_texto" id="cip" value="<?php echo $reg[3];?>" />
<input name="dni" type="hidden" class="casilla_texto" id="dni" value="<?php echo $reg[4];?>" />
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser;?>" />
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil;?>" />
<input name="tp_incidencia1" type="hidden" class="casilla_texto" id="tp_incidencia1" value="<?php echo "MONITOREO Y CAPACITACION COT";?>" />
<input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<?php echo $franqueo;?>" />
<input name="tt_c" type="hidden" class="caja_texto_sb" id="tt_c" />
<input name="sw" type="hidden" id="sw" value="1" />		

<table width="100%" border="0">
<tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>cab_registro_incidenciascot_n1.php</a>"; ?></td>
  </tr>
  <tr>
	  
    <td colspan="3" class="caja_texto_VERDE">REGISTRO DE INCIDENCIAS </td>
  </tr>
  <tr>
    <td width="190" valign="top" class="caja_texto_pe">TIPO DE INCIDENCIA </td>
    <td width="226" class="caja_texto_pe">
	<select name="tp_incidencia" class="caja_texto_cb" id="tp_incidencia" 
    onchange="javascript:mostrar_registro_incidenciacot(this.value)">
      <option value="0">ESCOGER</option>
	  <!--<option value="5">INDIVIDUAL</option>-->
      <option value="2">INDIVIDUAL/GRUPAL</option>
      <option value="3">MASIVA</option>
      <option value="4">MASIVA EXCEL</option>      
    </select></td>
    <td width="856" class="caja_texto_pe"> 
	<a href="javascript:cerrar_win('2')"><img src="image/SAL.jpg" width="25" height="30" border="0"/>Salir</a></td>	
  </tr>
	
  <tr>
	<td colspan="3" class="cabeceras_grid">	
	<div id="div_registro_individual" style="display:none">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td class="caja_texto_pe">Gestor</td>
				<td>  
				<select id="c_gestor" class="caja_texto_pe" onchange="javascript:muestra_horarios_gestor(this.value)">
            	<option value="Todos">Todos</option>
				<?php			
				$queryObtenerGestoresPorSupervisor = "SELECT iduser, ncompleto, dni FROM tb_usuarios WHERE  estado='HABILITADO' ORDER BY 2";			
				$res_gestores			= mysql_query($queryObtenerGestoresPorSupervisor);
				echo "<option value='0'>Seleccione Gestor</option>";
				while($reg_gestores=mysql_fetch_row($res_gestores)){
					echo "<option value=".$reg_gestores[2].">".$reg_gestores[1]." - ".$reg_gestores[2]."</option>";
				}
				?>
				</select>
					
				</td>
			  </tr>
	</table>	
	
	</div>  
	  </td>
  </tr>
  <tr>
    <td colspan="3" class="cabeceras_grid">		
	<div id="lista_participantes" style="display:none; overflow:scroll">  
	<table width="100%" border="0">
		<tr>
			<td width="16%" class="caja_texto_pe">SUPERVISOR</td>	
			<td width="14%"><select name="c_supervisor" imodod="c_supervisor" class="caja_texto_pe" onchange="javascript:mostrar_bandeja_gestores(this.value)"  >
              <?php 			
			print "<option value='0' selected>Seleccione Supervisor</option>";
			if ($idperfil==1) {
                $sql7="SELECT * FROM tb_usuarios WHERE estado='HABILITADO' and iduser='$reg_gru[2]'  order by ncompleto";
            } else {
                $sql7="SELECT * FROM tb_usuarios WHERE estado='HABILITADO' AND perfil='3' order by ncompleto";
                }
				echo $sql7;
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
            </select>
			</td>
			<td width="6%" valign="top" class="">&nbsp;</td>			
			<td width="15%" class="cabeceras_grid">			
				<a id="add_gestores" href="javascript:agregar_gestores_inc()" style="display:none">
				 <img src="image/LISTAS.JPG" width="20" height="20" border="0" />Agregar</a>			</td>
			<td width="20%" valign="top" class="">&nbsp;</td>		
			<td width="20%" valign="top" class="">&nbsp;</td>					 			 
				
		</tr>
		<tr>
			<td colspan="6">
			<p>
			<form name="f1">
			<div id="d_bandeja_gestores_cot"></div>
			</form>			</td>
		</tr>
	</table>
</div>
<table width="100%" border="0">
<tr>
    <td><div id="load" style="float:none" align="center"></div></td>
  </tr>
<tr>
<td height="393">
<input name="tiempo_gru" type="hidden" class="caja_texto_pe" id="tiempo_gru" value="0" size="8" readonly="readonly" />
<input name="exc_gru" type="hidden" class="caja_sb" id="exc_gru" size="15" readonly="readonly" />
        
<div id="registro_gestores" style="display:block">
  
    <table width="50%" border="0" cellpadding="1" cellspacing="1" >  
  		<tr>            
          <td width="20%" valign="top" class="boton_c">           
          <a  href="javascript:grabar_incidencias_cot_nuevo()" id="bt_aceptar_gru" style="display:none">
		  <img src="image/vis.jpg" width="15" height="20" border="0" />GRABAR</a>          
		  </td>
           	
          <td width="20%" valign="top" class="boton_c"><? if ($idperfil==0){ ?>          
           <a  href="javascript:validar_incidencia()" id="bt_aceptar_gru">
		  <img src="image/vis.jpg" width="15" height="20" border="0" />OK</a> 
          <?  }?>
          </td>
            
          <td width="80%" class="boton_c"  >
			  <input type="text" class="aviso" style="width:400px;height:15px" id="alerta_tiempo" readonly="readonly" />
          </td>	 		
      	</tr>
 </table>
    
    
    <table width="100%" border="0" cellpadding="1" cellspacing="1" class="marco_tabla"> 
    <tr>
      <td colspan="3" valign="top" class="caja_texto_db">Registro Individual / Grupal</td>
      </tr>
     <!--
    <tr>	
      <td width="303" valign="top" class="cabeceras_grid">CODIGO</td>
      <td colspan="2" class="caja_texto_pe"><input name="c_incidencia" type="text" class="caja_texto_pe" id="c_incidencia" size="30" />
        </td>
    </tr>}-->
    <tr>
      <td valign="top" class="clsCurrentMonthDay">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
	
    <tr>
      <td valign="top" class="cabeceras_grid">INFORMACION</td>
      <td valign="top" class="cabeceras_grid" colspan="2">
		<div id="div_horarios"></div></td>
      
    </tr>
    <tr>
      <td valign="top" class="cabeceras_grid">TIPO</td>
      <td width="387" valign="top" class="cabeceras_grid">
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
        </select>	 </td>
      <td width="399" class="cabeceras_grid">
      <div id="div_doid" style="display:none">DOID:
        <input name="c_doid_gru" type="text" class="caja_texto_cb" id="c_doid_gru" size="25" maxlength="20" />
      </div>  
      <div id="div_msn_incsis" style="display:none">
      <a class="aviso_peke">LAS INCIDENCIAS DE SISTEMAS NO AFECTAN EN LA PRODUCTIVIDAD, NO SON CONTABILIZADAS.</a>      
      </div>  
      </td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">MOTIVO</td>
      <td colspan="2" class="cabeceras_grid"><div id="c_mot_inc_gru"></div></td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">MODO</td>
      <td class="cabeceras_grid">
      <!--<select name="modo_gru" size="1" class="caja_texto_pe" id="modo_gru" onchange="javascript:mostrar_modo_gru(this.value);" >
          <option value="0">Seleccionar</option>
          <option value="D">DIAS</option>
          <option value="H">HORAS</option>
      </select>-->
      <div id="modo_gru"></div>
      
      </td>
      <td class="cabeceras_grid">
      <div id="div2" style="display:none">AFECTADOS:
        <input name="nro2" type="text" class="caja_texto_cb" id="nro2" size="25" 
      maxlength="20" />
      </div>
      <!--<a id="bt_compensacion" style="display:none" href="javascript:ventana_modal('8')">
      <img src="image/BT6.gif" width="25" height="30" border="0"/>Compensaciones
      </a>-->
      </td>
    </tr>
    
    <tr>
      <td valign="top" >&nbsp;</td>
      <td colspan="2">
        <form name="form2" id="form2">
          <div id="f_dias_gru" style="display:none">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="18%" class="caja_sb">FEC. INICIO </td>
                <td width="34%"><input readonly="readonly" name="inputg1" class="caja_texto_pe" type="text" size="17" maxlength="20" id="inputg1" />
                  <a href="javascript:cal1.popup();"> 
				  <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" 
				   />
				  </a></td>
                
                <td width="11%" class="caja_sb">FEC. FIN </td>
                <td width="40%">
                <input readonly="readonly" name="inputg2" class="caja_texto_pe" type="text" size="17" maxlength="20" id="inputg2" />         
                  <a href="javascript:cal2.popup();">
                  <img id="b_cal2" src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                
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
                    <option value="21">21</option>
                    <option value="22">22</option>                      
                    <option value="23">23</option>
                    <option value="24">24</option>
                      
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
                       onkeypress='return validaNumericos(event)' maxlength="2"> 
                </td>
                
               
                <td width="15%" class="caja_sb">HORA FIN</td>
                <td>
                  <select name="h_fin_gru" size="1" class="caja_texto_pe" id="h_fin_gru" onchange="listenerHorasFinal(event)"> 
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
                    <option value="21">21</option>
                    <option value="22">22</option>                      
                    <option value="23">23</option>
                    <option value="24">24</option>
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
        <div id="f_dias_comp" style="display:NONE">
            <table width="100%" class="marco_tabla">
              <tr>
                <td width="18%" class="caja_sb">FEC INICIO COMPENSACION </td>
                <td width="34%">
                <input readonly="readonly" name="input_i_c" class="caja_texto_pe" type="text" size="17" maxlength="20" id="input_i_c" />
                  <a href="javascript:cal4.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a></td>
                  <td width="11%" class="caja_sb">FEC FIN COMPENSACION</td>
                <td width="40%">
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
      
      
    <tr>
      <td valign="top" class="cabeceras_grid">TIEMPO</td>
      <td class="cabeceras_grid"><input name="tiempo_inc" type="text" class="caja_sb" id="tiempo_inc" value="0" size="8" readonly="readonly" />
		<input name="exc" type="text" class="caja_sb" id="exc" size="15" readonly="readonly" />
		<input name="tiempo_minutos" type="text" class="AVISO" id="tiempo_minutos" value="0" size="8" readonly="readonly" /> MINUTOS
		</td>
      <td class="cabeceras_grid" valign="top">
          <a href="javascript:calcular_tiempos_inc();" class="caja_texto_peke">CALCULAR TIEMPOS</a>
          <!--<a href="javascript:validar_horarios();" class="caja_texto_peke">HISTORICO</a></td>-->
    </tr>
    <tr>
      <td valign="top" class="cabeceras_grid">OBSERVACION</td>
      <td class="cabeceras_grid"><textarea name="obs_gru" cols="50" rows="3" class="caja_texto_pe" 
	  id="obs_gru" onkeypress="return soloLetras(event)"> 
        </textarea>      </td>
      <td class="cabeceras_grid" valign="top">Nota Importante: En las observaciones no se aceptan caracteres especiales. Por ese motivo no se aceptara copiar y pegar
      <div style="margin-top: 5px">
        <span id="flag_validacion_jornada" style="color: red"></span>    
        </div>
        <div style="margin-top: 5px">
        <span id="flag_validacion_horas"style="color: red"></span>  
        </div>         
        </td>
    </tr>
    <tr>
    	<td colspan="4"><div id="d_horario_gestor" style="display:none"></div></td>
    </tr>
  </table> 
</div>


<!---  modulo masivo --->

<div id="div_modulo_masivo" style="display:none">

<table width="100%" border="0" cellpadding="1" cellspacing="1"> 
	  <tr>
	    <td colspan="3" valign="top" class="caja_texto_db">Registro Masivo </td>
	    </tr>
	  <tr>
			  <td width="31%" valign="top" class="cabeceras_grid">SUPERVISION</td>
			  <td colspan="2" class="caja_texto_pe"><select name="c_supervisor_m" id="c_supervisor_m" class="caja_texto_pe">
				<option value="0">Escoger</option>
				<?php
					print "<option value='T'>TODO COT</option>";
					$sql7="SELECT * FROM tb_usuarios WHERE estado='HABILITADO' AND perfil='3' AND grupo='$reg_gru[0]' 
					order by ncompleto";	
					
					$queryresult7 = mysql_query($sql7) or die (mysql_error());
					while ($rowper=mysql_fetch_row($queryresult7)) { 										  
					print "<option value='$rowper[2]'>$rowper[1]</option>";
					}
					?>
			  </select></td>	 
	</tr>
	<?php 
	
	$cad="SELECT MAX(SUBSTR(cod_incidencia,5,13))+1 FROM cab_incidencia ORDER BY 1 DESC";
	//echo $cad;
	$rs = mysql_query($cad);
	$rg = mysql_fetch_array($rs);	
	$franq 	= limpia_espacios($rg[0]);
	$franqueo_ = "IMAS-".$franq;
	
	?>	
    
    
    
    
    <tr>
      <td valign="top" class="cabeceras_grid">CODIGO DOID </td>
      <td width="64%" class="cabeceras_grid"> <input name="c_doid_mas" type="text" class="caja_texto_pe" id="c_doid_mas" size="25" maxlength="20"></td>
      <td width="5%" class="cabeceras_grid">&nbsp;</td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">MOTIVO</td>
      <td class="cabeceras_grid">
	    <select name="c_mot_gru" id="c_mot_gru" class="caja_texto_pe" 
		onchange="javascript:carga_combo('c_mot_inc_gru',this.value)" >
            <?php 			
			print "<option value='0' selected>Seleccione Motivo</option>";
			$sql7="select * from tb_motivos_incidencia where tp_inc='AVERIA MASIVA' and est<>0 order by nom_mot_inc";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
        </select>	  </td>
      <td class="cabeceras_grid">&nbsp;</td>
    </tr>
    
    <tr>
      <td valign="top" class="cabeceras_grid">MODO</td>
      <td class="cabeceras_grid"><select name="modo_mas" size="1" class="caja_texto_pe" id="modo_mas" onchange="javascript:mostrar_modo_mas(this.value);" >
          <option value="0">Seleccionar</option>
          <option value="D">DIAS</option>
          <!--<option value="H">HORAS</option>-->
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


<div id="div_modulo_masivo_excel" style="display:none">
  <div>
    <a style="font-size:16px;text-decoration:none" href="./importar_masivas_excel/exportar_plantilla.php?usuario=<?php echo $_GET['iduser']?>">Descargar Plantilla Excel</a>
    <br>
    <br>
    <br>
  </div>
  <div id="ContentUploadExcel">
    <input type="hidden" id="usuario_excel_masiva" name="usuario" value="<?php echo $_GET["iduser"] ?>">
    <input type="hidden" id="perfil_excel_masiva" name="perfil" value="<?php echo $_GET["idperfil"] ?>">
    <input type="file" name="archivo_excel" id="archivo_excel"></input>
    <button class="btn" id="uploadMasivasExcel" type="button">Subir archivo</button>
  </div>
  <div style="font-size:16px;display:none" id="ContentProcesando">Procesando...</div>
</div>


</td>
</tr>
</table>

</table>

	<div id="div_listado_incidencias">	</div>
	
	
</body>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="importar_masivas_excel/main.js"></script>
</html>
