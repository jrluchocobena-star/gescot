<script language="javascript" src="funciones_js.js"></script>
<script language="JavaScript" src="calendar1.js"></script>


<?php
include("conexion_bd.php");

$iduser 			= $_GET["iduser"];
$perfil 			= $_GET["perfil"];
$modo 				= $_GET["modo"];
$c_incidencia 		= trim($_GET["texto_ini"]);

//echo 'Bedwer='.$c_incidencia;
echo var_dump($c_incidencia);
$texto_intermedio 	= $_GET["texto_int"];
$texto_final 		= $_GET["texto_fin"];
$estado				= 1;
$dni 				= $_GET["dni"];
$motivo 			= $_GET["c_mot_inc_gru"];

?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser;?>" />
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil;?>" />
<input name="modalidad" type="hidden" class="casilla_texto" id="modalidad" value="<?php echo $modo;?>" />
<input name="motivo" type="hidden" class="casilla_texto" id="motivo" value="<?php echo $motivo;?>" />

<div id="form_resultado_incidencia">
<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
    <td colspan="2" class="cabeceras_grid">
    <?php
		if ($estado=="1"){
			echo "<img src='registrado.png' width='500' height='150'>";
		}else{
			echo "<img src='error_registrado.png' width='500' height='150'>";
			}
	?>
    
    </td>
  </tr>
  <tr>
    <td colspan="2" class="cabeceras_grid"><?php 
	if (trim($_GET["texto_ini"])=="0"){
	echo "<a class='boton_acero'>No se genero Codigo de Incidencia</a>"."\n";	
	echo "<a class='boton_3' onclick='javascript:cerrar_alertas(0);'>CERRAR</a>";	
	}else{
	echo "Se registro con el codigo de incidencia "."<a class='boton_acero'>$c_incidencia</a>";
	}
	?>
	</td>	
  </tr> 	 
  <tr>
    <?php 
	$list="select * from cab_incidencia where cod_incidencia='$c_incidencia' group by dni";
	//echo $lista;
	$res_list = mysql_query($list);
	$reg_list =mysql_fetch_row($res_list);
	
	echo "<input name='arr_hor' type='hidden' id='arr_hor' value='$reg_list[15]'/>";
	
	//echo $reg_list[4];
		if ($reg_list[4]=="PERMISO" or $reg_list[4]=="COMPENSACIONES"){
			echo "<td width='40%' class='cabeceras_grid'>";
			echo "Atencion: Desea Agregar Compensacion?    ";
			echo "<td width='60%' class='cabeceras_grid'><a class='boton_3' onclick='javascript:mostrar_compensacion();'>SI</a>  
            <a class='boton_3' onclick='javascript:cerrar_alertas(0);'>NO</a>	</td>";
		?>	
		<?php
        }else{
			echo "<td width='30%' class='cabeceras_grid'>";
			echo "<a class='boton_3' onClick='javascript:cerrar_alertas(0);'>Cerrar</a>";
			echo "</td>";
		}
		
	?></td>
   
  </tr>
  <tr>
    <td colspan="2" class="cabeceras_grid">
	<?php 
	$lista="select * from cab_incidencia where cod_incidencia='$c_incidencia' group by dni";
	//echo $lista;
	$res_lis = mysql_query($lista);

	
	echo "<table width='100%' class='marco_tabla'>";				
		echo "<tr>";		
		echo "<td class='caja_texto_pekecab'>CIP</td>";							
		echo "<td class='caja_texto_pekecab'>DNI</td>";							
		echo "<td class='caja_texto_pekecab'>NOMBRE COMPLETO</td>";		
		echo "<td class='caja_texto_pekecab'>OBSERVACION</td>";
		echo "</tr>";		
		
		while($reg_lis=mysql_fetch_row($res_lis)){	
						$ch1		="select * from tb_usuarios where dni='$reg_lis[15]'";
						//echo $ch1;
						$res_ch1 	= mysql_query($ch1);
						$reg_ch1	= mysql_fetch_row($res_ch1);
									
		echo "<tr>";		
		
				
		echo "<td class='caja_texto_peke'>";		//CIP		
		echo $reg_lis[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";		//dni		
		echo $reg_lis[15]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_peke'>";//NOMBRE	
		echo $reg_ch1[1]; 		
		echo "</td>";
		
		
			
		if ($reg_lis[17]=="0"){
			$clas='caja_texto_peke';
			$estado ="REGISTRADO OK";
		}
		
	
		if ($reg_lis[17]=="3"){
			$clas='aviso_horario';
			$estado ="MAL REGISTRADO";
		}
		
		echo "<td class='$color'>";		// 	ESTADO
		echo $estado; 				
		echo "</td>";
		
	
		
		echo "</tr>";				
		}	
	echo "</table>";	
	?></td>
  </tr>
  
 	
</table>
</div>


<div id="form_compensacion" style="display:none">

<input name="tiempo_gru" type="hidden" class="caja_texto_pe" id="tiempo_gru" value="0" size="8" readonly="readonly" />
<input name="exc_gru" type="hidden" class="caja_sb" id="exc_gru" size="15" readonly="readonly" />
<input readonly="readonly" name="tt_acu_comp" class="caja_texto_pe" type="hidden" size="10" maxlength="20" id="tt_acu_comp" 
              value="00:00:00" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>      
        <td align="right"><a href="javascript:cerrar_esto()"><img src="image/SAL.jpg" width="25" height="30" border="0"/>CERRAR</a></td>
    </tr>
	<tr>
    <td class="cabec_2">&nbsp;</td>
    </tr>
      <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td width="22%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="19%">&nbsp;</td>
        <td width="21%">&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>DNI</td>
        <td><input name="dni" type="text" class="caja_texto_pe" id="dni" value="<?php echo substr($_GET["dni"],1,8); ?>" /></td>
        <td>&nbsp;</td>
        <td>COD.INCIDENCIA</td>
        <td><input name="c_incidencia" type="text" class="caja_texto_pe" id="c_incidencia" value="<?php echo $c_incidencia; ?>" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <?php 
	  if ($reg_list[13]=="D"){
	 	$list2="SELECT cod_incidencia, min(fec_ini_inc),max(fec_fin_inc),tiempo FROM cab_incidencia 
						WHERE cod_incidencia='$c_incidencia' and modo='D'
						GROUP BY cod_incidencia";
		//echo $lista;
		
	  }else{
		  $list2="select cod_incidencia,fec_ini_inc,fec_fin_inc,tiempo from cab_incidencia WHERE cod_incidencia='$c_incidencia'";
	  }
	  //echo $list2;
	 	$res_list2 = mysql_query($list2);
		$reg_list2 =mysql_fetch_row($res_list2);
		

				
	  $s_tiempo="SELECT tiempo  FROM cab_incidencia where cod_incidencia='$c_incidencia'";
	  //echo $s_tiempo;
	  $row_s_tiempo	= 	mysql_query($s_tiempo) or die(mysql_error($s_tiempo));
	  $reg_s_tiempo	=	mysql_fetch_row($row_s_tiempo);
				
	  ?>
      <tr>
        <td>FEC.INI DE PERMISO</td>
        <td><input name="fec_ini_inc" type="text" class="caja_texto_pe" id="fec_ini_inc" value="<?php echo $reg_list2[1];?>" /></td>
        <td>&nbsp;</td>
        <td>FEC. FIN DE PERMISO</td>
        <td><input name="fec_fin_inc" type="text" class="caja_texto_pe" id="fec_fin_inc" value="<?php echo $reg_list2[2];?>" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
	  <?php
	  //echo $reg_s_tiempo[0]."|".substr($reg_s_tiempo[0],1,1);
	  
	  if (substr($reg_s_tiempo[0],0,1)=="-"){
	  	$tiempo_acum = trim(substr($reg_s_tiempo[0],1,10));
	  }else{
	  	$tiempo_acum = $reg_s_tiempo[0];
	  }
	  ?>
      <tr>
        <td>T. PERMISO</td>
        <td><input readonly="readonly" name="tt_acumulado" class="caja_texto_pe" type="text" size="10" maxlength="20" id="tt_acumulado" 
              value="<?PHP echo $tiempo_acum; ?>" /></td>
        <td>&nbsp;</td>
        <td>T.  ACUMULADO</td>
        <td><input readonly="readonly" name="tt_comp_tot" class="caja_texto_pe" type="text" size="10" maxlength="20" id="tt_comp_tot" 
		value="00:00:00" /></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td width="23%">HORARIO</td>
        <td colspan="4"><?php  
		$xdni=substr($_GET["dni"],1,8);
		$hor = "select a.cod_horario,b.descripcion_2
		from horarios_gestores_cot a, horarios_rrhh b
		where a.cod_horario=b.cod_horario and a.dni='$xdni' group by 1";
		//echo $hor;
		$res_hor = mysql_query($hor);
		$reg_hor =mysql_fetch_row($res_hor);
		
		echo $reg_hor[0]."-".$reg_hor[1]?></td>
        <td width="7%">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <form name="form1" id="form1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="5" valign="top"><div id="f_horas_gru" style="display:BLOCK">
          <table width="100%"  class="marco_tabla">
            <tr>
              <td width="20%" class="caja_sb">FECHA </td>
              <td colspan="3"><input readonly="readonly" name="inputg3" class="caja_texto_pe" type="text" size="17" maxlength="20" id="inputg3" />
                <a href="javascript:cal3.popup();"> <img src="cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" />
                </a></td>
          
              <td class="caja_sb">&nbsp;</td>
              <td>&nbsp;</td>
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
              <td><select name="h_ini_gru" size="1" class="caja_texto_pe" id="h_ini_gru" >
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
              <td><select name="mm_ini_gru" size="1" class="caja_texto_pe" id="mm_ini_gru" >
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="45">45</option>
              </select></td>
              <td width="15%" class="caja_sb">HORA FIN</td>
              <td><select name="h_fin_gru" size="1" class="caja_texto_pe" id="h_fin_gru" onchange="javascript:calc_tiempo_comp()" >
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
              <td><select name="mm_fin_gru" size="1" class="caja_texto_pe" id="mm_fin_gru" onchange="javascript:calc_tiempo_comp()" >
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="45">45</option>
              </select></td>
            </tr>
          </table>
        </div></td>
        </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="7%" valign="top"><b><a id="bt_compensacion" class="botonera" onclick="javascript:save_compensaciones_inc();">Agregar</a></td>
        <td width="12%" valign="top"> 
        </td>
        <td width="13%" valign="top"></td>
        <td width="1%">&nbsp;</td>
        <td width="67%">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">
        <div id="f_dias_comp" style="display:none">
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
                  <a href="javascript:cal6.popup();"> <img src="cal.gif" width="16" height="16" border="0" 
                  alt="Click Here to Pick up the date" /></a></td>
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
                  <option value="15">15</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
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
                  <option value="15">15</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
                  </select></td>
                 
                </tr>
              </table>
            </div>    
       
      </td>
        </tr>
    </table>
    <p>
    </form>
     
      <script language="JavaScript" type="text/javascript">
              
						
						var cal3 = new calendar1(document.forms["form1"].elements['inputg3']);
                        cal3.year_scroll = true;
                        cal3.time_comp = false;	
						
					
		          	</script>    
                    </form>
     
                    
    </td>
  </tr>
  <tr>
    <td><div id="d_listado_compensaciones"></div></td>
  </tr>
  <tr>
    <td width="38%">&nbsp;</td>
  </tr>
</table>
</div>