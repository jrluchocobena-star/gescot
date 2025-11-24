<?php
include("conexion_bd.php");

$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

$gru="select grupo,sgrupo,c_supervisor from tb_usuarios where iduser='$iduser'";
$res_gru = mysql_query($gru) or die (mysql_error());
$reg_gru=mysql_fetch_row($res_gru);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js?v=20232211"></script>

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>


</head>

<body>
<table width="100%" border="0">
<tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>cab_consultas_inc.php</a>"; ?></td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" class="caja_texto_pe">      
      <tr>
        <td colspan="5" valign="top"><table width="60%" border="0">
          <tr>
		    <td width="11%" class="caja_texto_pe" onclick="javascript:limpiar_inc();"><img src="image/actualizar.jpg" width="22" height="22" />Nueva Busqueda</td>
			  <!--
		 	<?php if ($idperfil=="0"){ ?>
					  <td align="center" class="caja_texto_pe" width="7%" onclick="javascript:popup_reclamo('12','<?php echo $iduser;?>',
			'<?php echo $idperfil; ?>','<?php echo "Registro"; ?>','','')"><img src="image/04-07-2017 04-47-10 p.m..jpg" width="22" height="22" /> Registrar</td>       			
			<?php } ?>
			-->
<td align="center" class="caja_texto_pe" width="12%" onclick="javascript:popup_reclamo('3','<?php echo $iduser; ?>',			
			'<?php echo $idperfil; ?>','<?php echo "Registro"; ?>','','')"><img src="image/usumas.jpg" width="22" height="22" /> Registrar</td>         <!--
            <td width="9%" class="caja_texto_pe" onclick="javascript:ver_div_incidencias();"><img src="image/Symbol-Search.gif" width="22" height="22" />Buscar</td>-->
            <?php if ($idperfil != 1) { ?>
              <td width="21%" class="caja_texto_pe" onclick="javascript:ventana_modal('7')"><img src="image/BT1.gif" width="22" height="22" />Bandeja Aprobaciones</td>
             <!-- <td width="15%" class="caja_texto_pe" onclick="javascript:ventana_modal('9')"><img src="image/bookmark_add.png" width="25" height="25" />Bandeja Horarios</td>-->
             <?php } ?>             
            
			 <td width="11%" class="caja_texto_pe" onclick="javascript:reporte_inc('1');" align="center">
             <img src="image/EXCELES.JPG" width="22" height="22" /> Exportar </td>
             <!--<td align="left" width="16%">(Reportes Inc.Administrativas y De Sistemas ) 
             </td>-->
           
			<td align="center" width="19%">&nbsp;</td>
			<td align="center" width="11%">
            <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $_GET["idperfil"]; ?>"/>			  
            <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $_GET["iduser"];?>"/></td>
			<!--
            <td width="8%" class="caja_texto_pe" onclick="javascript:mostrar_rep_inc('1');"><img src="image/liquidar.jpg" width="22" height="22" /> Por Dia</td>  
            <td width="8%" class="caja_texto_pe" onclick="javascript:mostrar_rep_inc('2');"><img src="image/liquidar.jpg" width="22" height="22" /> Por Mes</td>         
            <td align="center" width="4%">&nbsp;</td>
            <td width="8%" class="caja_texto_pe" onclick="javascript:reporte_inc('1');">
            <img src="image/EXCELES.JPG" width="22" height="22" /> REPORTE_1</td>
            <td width="8%" class="caja_texto_pe" onclick="javascript:reporte_inc('2');">
            <img src="image/EXCELES.JPG" width="22" height="22" /> REPORTE_2</td>          
			<td width="8%" class="caja_texto_pe" onclick="javascript:reporte_inc('3');">
            <img src="image/EXCELES.JPG" width="22" height="22" /> REPORTE_3</td>
           
			-->
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="5" valign="top" class="contador">&nbsp;</td>
      </tr>
      <tr>
       <td colspan="8">
       </td>
    <tr>
    <td colspan="8">
        
    <?php if($idperfil!=1){ ?>
    <table width="100%">
        <tr>
        <td width="19%" valign="top"><span class="TitTablaI">C. Indicencia</span></td>
        <td width="33%" valign="top">
        <input name="c_i" type="text" class="caja_texto_sb" id="c_i" size="3" maxlength="3" value="INC-" readonly />          
        <input name="c_inc" type="text" class="caja_texto_pe" id="c_inc" /></td>
        <td width="21%"><span class="TitTablaI">Estado</span></td>
        <td colspan="2">
          <select id="select_estado_incidencia" class="caja_texto_pe">
            <option value="Todos">Todos</option>
            <option value="0">Pendiente</option>
            <option value="1">Aprobado</option>
            <option value="2">Rechazado</option>
            <option value="3">Cancelado</option>
          </select>
        </td>
      </tr>
      <tr>
        <td valign="top"><span class="TitTablaI">Supervisor</span></td>
        <td valign="top"><select name="cb_supervisor" id="cb_supervisor" class="caja_texto_pe">
          <option value="Todos">Seleccione Supervisor</option>
          <?php
            
                $sqlSupervisor="SELECT * FROM tb_usuarios WHERE estado='HABILITADO' AND perfil='3' order by ncompleto";
              

              $querySupervisor = mysql_query($sqlSupervisor) or die (mysql_error());
              while ($rowSuper=mysql_fetch_row($querySupervisor)) { 										  
                echo "<option value='$rowSuper[0]'>$rowSuper[1]</option>";
              }

            ?>
        </select></td>
        <td valign="top"><span class="TitTablaI">Gestor</span></td>
        <td valign="top"><select name="cb_gestor" id="cb_gestor" class="caja_texto_pe" >
          <?php 			
          $cond="";
          
			print "<option value='0' selected>Seleccione Gestor</option>";
			$sql1="select cip,dni,ncompleto from tb_usuarios where estado='HABILITADO' $cond order by ncompleto";
			//echo $sql1;
		  	$queryresult1 = mysql_query($sql1) or die (mysql_error());
			while ($rowper1=mysql_fetch_row($queryresult1)) { 										  
			print "<option value='$rowper1[1]'>$rowper1[2] - $rowper1[1]</option>";
			}
			?>
        </select></td>
      </tr>
      <tr>
        <td class="TitTablaI">Registrado por</td>
        <td><select name="cb_reg" id="cb_reg" class="caja_texto_pe" >
          <?php
          $cond="";
          if ($idperfil==1){
            $cond = " and a.usu_reg=".$iduser;
          }
			print "<option value='0' selected>Seleccione...</option>";
			$sql1="SELECT a.usu_reg,b.dni,b.ncompleto
			FROM cab_incidencia a, tb_usuarios b WHERE a.usu_reg=b.iduser and b.estado='HABILITADO' AND
			a.tp_incidencia not in('INCIDENCIAS DE SISTEMAS','MONITOREO Y CAPACITACION COT') $cond
			 GROUP BY 1 order by 3";
		  	$queryresult1 = mysql_query($sql1) or die (mysql_error());
			while ($rowper1=mysql_fetch_row($queryresult1)) { 										  
			print "<option value='$rowper1[0]'>$rowper1[2] - $rowper1[1]</option>";
			}
			?>
          </select></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" class="TitTablaI">Fecha Inicio</td>
        <td><table width="200" border="0" class="caja_texto_pe">
          <tr>
            <td width="51"> DD
              <input name="dia_i" type="text" class="caja_texto_pe" id="dia_i" value="0" size="6" maxlength="2" /></td>
            <td width="65">MM
              <select name="mes_i" size="1" class="caja_texto_pe" id="mes_i" >
                <option value="0"> </option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
				        <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select></td>
            <td width="70">AA
              <select name="an_i" size="1" class="caja_texto_pe" id="an_i" >
                <option value="0000"> </option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                </select></td>
            </tr>
          </table></td>
        <td valign="top"><span class="TitTablaI">Fecha Final</span></td>
        <td width="27%"><table width="200" border="0" class="caja_texto_pe">
          <tr>
            <td width="51"> DD
              <input name="dia_f" type="text" class="caja_texto_pe" id="dia_f" value="0" size="6" maxlength="2" /></td>
            <td width="65">MM
              <select name="mes_f" size="1" class="caja_texto_pe" id="mes_f" >
                <option value="0"> </option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select></td>
            <td width="70">AA
              <select name="an_f" size="1" class="caja_texto_pe" id="an_f" >
                <option value="0000"> </option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                </select></td>
            </tr>
          </table>      
        </td>
        </tr>
		<tr>
        <td colspan='10'>
        <div id="ctr_bot"> </div>
        
      </tr>
    </table>
    <?php } ?>
        
    <?php if($idperfil=="1"){ ?>
     <table width="100%">
        <tr>
        <td width="19%" valign="top"><span class="TitTablaI">C. Indicencia</span></td> 
        <td width="33%" valign="top">
        <input name="c_i" type="text" class="caja_texto_sb" id="c_i" size="3" maxlength="3" value="INC-" readonly />          
        <input name="c_inc" type="text" class="caja_texto_pe" id="c_inc" /></td>
        
        <td width="21%"><span class="TitTablaI">Estado</span></td>
        <td colspan="2">
          <select id="select_estado_incidencia" class="caja_texto_pe">
            <option value="Todos">Todos</option>
            <option value="0">Pendiente</option>
            <option value="1">Aprobado</option>
            <option value="2">Rechazado</option>
            <option value="3">Cancelado</option>
          </select>
        </td>
      <tr>
        <td valign="top" class="TitTablaI">Fecha Inicio</td>
        <td><table width="200" border="0" class="caja_texto_pe">
          <tr>
            <td width="51"> DD
              <input name="dia_i" type="text" class="caja_texto_pe" id="dia_i" value="0" size="6" maxlength="2" /></td>
            <td width="65">MM
              <select name="mes_i" size="1" class="caja_texto_pe" id="mes_i" >
                <option value="0"> </option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
				        <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select></td>
            <td width="70">AA
              <select name="an_i" size="1" class="caja_texto_pe" id="an_i" >
                <option value="0000"> </option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                </select></td>
            </tr>
          </table></td>
        <td valign="top"><span class="TitTablaI">Fecha Final</span></td>
        <td width="27%"><table width="200" border="0" class="caja_texto_pe">
          <tr>
            <td width="51"> DD
              <input name="dia_f" type="text" class="caja_texto_pe" id="dia_f" value="0" size="6" maxlength="2" /></td>
            <td width="65">MM
              <select name="mes_f" size="1" class="caja_texto_pe" id="mes_f" >
                <option value="0"> </option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                </select></td>
            <td width="70">AA
              <select name="an_f" size="1" class="caja_texto_pe" id="an_f" >
                <option value="0000"> </option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                </select></td>
            </tr>
          </table>      
        </td>
        </tr>
		
    </table>       
    
    <?php } ?>
        
    </td>
  </tr>
        
  <tr>
        <td colspan='10'>
        <div id="ctr_bot">
        <table width="20%" border="0" cellspacing="1" cellpadding="1">
          <tr>
		    <td  class="caja_texto_pe" onclick="javascript:ver_div_incidencias();"><img src="image/Symbol-Search.gif" width="22" height="22" />Buscar</td>
            <!--
              <td width="20%" class="caja_texto_pe" onclick="javascript:eliminar_incidencia_todo()"><img src="image/eliminar.jpg" width="20" height="20" />Eliminar Inc.</td>		
            -->
            <td width="59%"   >
			<a id="btn_compensa" style="display:none" class="caja_texto_pe" onclick="javascript:edit_incidencia()">
			<img src="image/04-07-2017 04-46-52 p.m..jpg" width="25" height="25" />Editar Incidencia</a>			
			</td>
            </tr>
        </table>
        </div>
        
      </tr>
        
        
  <tr>
    <td class="contador">&nbsp;</td>
  </tr>
  <tr>
    <td> 
      <iframe id="f_lista_incidencias" width="100%" frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  
        marginheight="0"  scrolling="Auto"  height="250px" > </iframe>
    </td>
  </tr>
  
  <tr>
    <td class="contador">&nbsp;</td>
  </tr>
  
  <tr>    
    <td valign="top">   
    <div id="d_incidencias_1" style="display:none"> 
    <iframe id="f_incidencias_1"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  
    marginheight="0" width="100%"  scrolling="Auto"  height="450px" > </iframe>
    </div>
    <div id="div_editar_incidencia" style="display:none">
    <table width="100%" border="0">  	
  	<tr >
    <td width="2%" class='caja_texto_pe'>PANEL</td>
    <td width="5%" class='caja_texto_pe'>COD. INCIDENCIA</td>
	 <td width="20%" class='caja_texto_pe'>GESTOR</td>
    <td width="5%" class='caja_texto_pe'>FEC. REGISTRO</td>
    <td width="5%" class='caja_texto_pe'>FEC. INICIO</td>
    <td width="5%" class='caja_texto_pe'>FEC. FIN</td>
	<td width="5%" class='caja_texto_pe'>REGISTRADO POR</td>
    <td width="5%" class='caja_texto_pe'>ESTADO</td>
    <td width="20%" class='caja_texto_pe'>OBSERVACION</td>   
    </tr>
  	<tr>
    <td valign="top"><!--<img src="image/BT4.gif" width="20" height="20" onclick="javascript:grabar_edicion_incidencia()" />--></td>
    <td valign="top"><input name="x_tp" type="hidden" class="caja_texto_pe" id="x_tp" readonly />
	<input name="x_inc" type="text" class="caja_sb_pe" id="x_inc" readonly /></td>
	<td valign="top"><input name="x_ges" type="text" class="caja_sb_pe" id="x_ges" size="60"  /></td>
    <td valign="top"><input name="x_fecr" type="text" class="caja_sb_pe" id="x_fecr" /></td>
    <td valign="top"><input name="x_fec1" type="text" class="caja_sb_pe" id="x_fec1" /></td>
    <td valign="top"><input name="x_fec2" type="text" class="caja_sb_pe" id="x_fec2" /></td>
	<td valign="top"><input name="x_registrado" type="text" class="caja_sb_pe" id="x_registrado"  /></td>	
    <td valign="top"><input name="x_estado_inc" type="text" class="caja_sb_pe" id="x_estado_inc" size="30" /></td>	
    <td valign="top"><textarea name="x_obs" cols="60" rows="3" class="caja_sb_pe" id="x_obs"></textarea></td>    
    </tr>
	</table>    
    </div>
    
    </td>
    
  </tr>
  
</table>
<p>&nbsp;</p>


<script>
document.getElementById('cb_supervisor').addEventListener('change', function (e) {
  e.preventDefault();

  var supervisor = this.value;

  var xhr = new XMLHttpRequest();
  var url = 'funciones_cot.php?accion=obtenerGestores&supervisor='+supervisor;
	
  xhr.open('GET', url, true);

  xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
          // La solicitud fue exitosa, puedes manejar la respuesta aquí
          //console.log(xhr.responseText);
          var cbGestorElement = document.getElementById("cb_gestor");

          // Imprime el resultado en el elemento
          cbGestorElement.innerHTML = xhr.responseText;
      }
  };

  xhr.send(); // No es necesario enviar parámetros con el método GET

  

});

</script>
</body>
</html>