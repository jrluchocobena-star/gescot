<?php
include("conexion_bd.php");
//include("funciones_fechas.php");

$lista=$_GET["lista"];
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
$accion=$_GET["accion"];

$dni=$_GET["dni"];
$cip=$_GET["cip"];

if ($cip==""){
	$cad="dni='$dni'";	
}else{
	$cad="cip like '%$cip%'";	
}
	
  $sql_usu 	= "SELECT * from tb_usuarios where $cad GROUP BY dni";  
  //echo $sql_usu;
  $res_USU 	= mysql_query($sql_usu);											
  $nreg		= mysql_num_rows($res_USU);
  $reg_USU	=mysql_fetch_array($res_USU);
  
  $sql_usu_d 	= "SELECT * from usuarios_detalle where dni='$reg_USU[dni]' GROUP BY dni";  
 // echo $sql_usu_d;
  $res_USU_d 	= mysql_query($sql_usu_d);											
  $nreg_d		= mysql_num_rows($res_USU_d);
  $reg_USU_d	= mysql_fetch_array($res_USU_d);
  
  $i=0;


  $loc="select * from tb_locales where cod_local='$reg_USU[local]'";  
 //	echo $loc;
  $res_loc = mysql_query($loc);											
  $reg_loc=mysql_fetch_array($res_loc);
  
  $sup="select * from tb_supervisores where cod_supervisor='$reg_USU[c_supervisor]'";  
 //	echo $loc;
  $res_sup = mysql_query($sup);											
  $reg_sup=mysql_fetch_array($res_sup);
  
  $mon="select * from tb_monitores where cod_monitor='$reg_USU[c_monitor]'";  
 //	echo $loc;
  $res_mon = mysql_query($mon);											
  $reg_mon=mysql_fetch_array($res_mon);
  
  $per="select * from tb_perfil where id='$reg_USU[perfil]'";  
 //	echo $per;
  $res_per = mysql_query($per);											
  $reg_per=mysql_fetch_array($res_per);
  
  
  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="javascript" src="funciones_js.js"></script>
<link type="text/css" />

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>

  <?php 
		  if($reg_USU["perfil"]=="0"){ $perfil="ADMINISTRADOR";}
  		  if($reg_USU["perfil"]=="1"){ $perfil="OPERADOR";}
		  if($reg_USU["perfil"]=="2"){ $perfil="JEFE";}
  		  if($reg_USU["perfil"]=="3"){ $perfil="SUPERVISOR";}
		  		  
		 
		 ?>
  <input type="hidden"  id="iduser" value="<?php echo $iduser; ?> "  />
  <input type="hidden"  id="idperfil" value="<?php echo $idperfil; ?> "  />
  <input type="hidden"   id="id_g" value="<?php echo  $reg_USU["iduser"]; ?>" size="20"  readonly="readonly" />
         

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla_bandeja" >
<tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>mantenimiento_usuarios_horiz.php</a>"; ?></td>
  </tr>
        <tr>
          <td height="14" colspan="5" class="cabec_1">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" >
		  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
            <tr>
              <td width="50%" class="cabeceras_grid_color" onclick="javascript:actualizar_datos_usu_horiz('<?php echo $dni; ?>')">
			  <img src="image/upload.JPG" width="25" height="25" />Actualizar</td>
			 <!-- <td width="50%" class="cabeceras_grid_color" onclick="javascript:ventana_modal('6')">
			  <img src="image/LISTAS.JPG" width="25" height="25" />Act..Usuarios</td>-->
            </tr>
          </table></td>
          <td colspan="2" ><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="25%" align="left" valign="top" class="TitTablaI" >DETALLE</td>
              <td width="75%" rowspan="2" align="left" scope="col"><textarea name="textarea" cols="60" rows="3" class="caja_texto_pe" id="motivo_cambio"></textarea>
			  </td>
            </tr>
            <tr>
              <td valign="top" >&nbsp;</td>
            </tr>
          </table></td>
          <td width="209" valign="top" class="TitTablaI" >MOTIVO DE ACTUALIZACION</td>
          <td width="270" align="right" valign="top"  >
            <select name="motivo_act" id="motivo_act" class="caja_texto_pe" >
            <option value="INFORMACION GENERAL">INFORMACION GENERAL</option>
              <option value="CAMBIO DE CIP">CAMBIO DE CIP</option>
              <option value="CAMBIO DE PERFIL">CAMBIO DE PERFIL</option>          
              <option value="CAMBIO DE CARGO">CAMBIO DE CARGO</option>
              <option value="CAMBIO DE GRUPO">CAMBIO DE AREA</option>
              <option value="BAJA">BAJA</option>
              <option value="ACTUALIZAR DATOS DE PC/MONITOR">ACTUALIZAR DATOS DE PC/MONITOR</option>
              <option value="CAMBIO DE SUPERVISOR">CAMBIO DE SUPERVISOR</option>
              <option value="CAMBIO DE MONITOR">CAMBIO DE MONITOR</option>
              <option value="CAMBIO DE LOCAL">CAMBIO DE LOCAL</option>
              <option value="CAMBIO DE OLA">CAMBIO DE OLA</option>
            </select>          </td>
        </tr>
        <tr>
          <td height="17" colspan="5" class="texto"  >&nbsp;</td>
        </tr>
        <tr>
          <td width="275" height="17" class="caja_texto_pe"  >DNI</td>
          <td width="260" class="caja_texto_pe"><input type="text" class="caja_sb" id="n_dni" value="<?php echo  $reg_USU["dni"]; ?>" size="20" /></td>
          <td class="caja_texto_pe">CIP</td>
          <td colspan="2" class="caja_texto_pe"><input type="text" class="caja_sb" id="cip" value="<?php echo  $reg_USU["cip"];  ?>" size="20"  /></td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="17" class="caja_texto_pe" >APE. PATERNO</td>
          <td class="caja_texto_pe"><input name="ape_pat" type="text" class="caja_sb" id="ape_pat" value="<?php echo  $reg_USU["ape_pat"];   ?>" size="40" /></td>
          <td class="caja_texto_pe">APE.MATERNO</td>
          <td colspan="2" class="caja_texto_pe"><input name="ape_mat" type="text" class="caja_sb" id="ape_mat" value="<?php echo  $reg_USU["ape_mat"];   ?>" size="40" /></td>
        </tr>
        
        <tr>
         <td height="18" colspan="5" class="texto"  >&nbsp;</td>         
        </tr>
        <tr>
          <td height="17" class="caja_texto_pe"  >NOMBRES</td>
          <td colspan="4" class="caja_texto_pe" ><input name="nombres" type="text" class="caja_sb" id="nombres" value="<?php echo  $reg_USU["nombres"];   ?>" size="40" /></td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>               
        </tr>
        <tr>
          <td height="17" class="caja_texto_pe"  >E-PERSONAL</td>
          <td class="caja_texto_pe" ><input type="text" class="caja_sb" id="correo_p" value="<?php echo $reg_USU["correo_personal"];   ?>" size="40"  /></td>
          <td width="254" class="caja_texto_pe" >E-TRABAJO</td>
          <td colspan="2" class="caja_texto_pe" ><input type="text" class="caja_sb" id="correo_w" value="<?php echo $reg_USU["correo_w"];    ?>" size="40"   /></td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>       
        </tr>
        <tr>
          <td height="17" class="caja_texto_pe"  >CELULAR 1</td>
          <td class="caja_texto_pe"><input type="text" class="caja_sb" id="celular1" value="<?php echo $reg_USU["celular1"];    ?>" size="20"  /></td>
          <td class="caja_texto_pe" >CELULAR 2</td>
          <td colspan="2" class="caja_texto_pe"><input type="text" class="caja_sb" id="celular2" value="<?php echo $reg_USU["celular2"];    ?>" size="20"   /></td>
        </tr>
        <tr>
         <td height="18" colspan="5" class="texto"  >&nbsp;</td>       
        </tr>
        <tr>
          <td height="17" class="caja_texto_pe"  >ANEXO</td>
          <td class="caja_texto_pe"><input type="text" class="caja_sb" id="anexo" value="<?php echo $reg_USU["anexo"];    ?>" size="20"  /></td>
          <td class="caja_texto_pe" >CUMPLEAÑO</td>
          <td colspan="2" class="caja_texto_pe"><input type="text" class="caja_sb" id="fec_nac" value="<?php echo $reg_USU["fec_nacimiento"];    ?>" size="20" maxlength="12"   /> 
            (dd/mm/yyyy)</td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>       
        </tr>
        <tr>          
          <td colspan="2" class="caja_texto_db" >CAMBIO</td>
          <td colspan="3" class="caja_texto_db" >ACTUAL</td>
        </tr>
        
        <tr>
          <td height="19" class="caja_texto_pe"  >AREA</td>
          <td class="caja_texto_pe"><select name="c_grupo" class="caja_sb" id="c_grupo" >
				  <option value="0">Escoger</option>
				  <option value="COT-TDP">COT-TDP</option>
				  <option value="TDP">TDP</option>
				  <option value="CONTRATA">EECC</option>      
				</select></td>
          <td colspan="3" class="caja_texto_pe"><?php echo $reg_USU["grupo"]; ?>
          <input name="i_grupo" type="hidden" class="caja_sb" id="i_grupo" value="<?php echo $reg_USU["grupo"];?> " size="20"  readonly="readonly" /></td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>       
        </tr>
        <tr>
          <td height="19" class="caja_texto_pe"  >CARGO COT</td>
          <td class="caja_texto_pe" ><select name="c_cargocot" class="caja_sb" id="c_cargocot" >
            <option value="0">Escoger</option>
            <option value="Back" selected>BACK</option>
            <option value="Sup">SUP</option>
            <option value="Staff COT">STAFF COT</option>
            <option value="Jefe">JEFE</option>
			<option value="Soporte">SOPORTE</option>
          </select></td>
          <td colspan="3" class="caja_texto_pe" ><?php echo $reg_USU["sgrupo"]; ?>
          <input name="i_cargocot" type="hidden" class="caja_sb" id="i_cargocot" value="<?php echo $reg_USU["sgrupo"];?> " size="20"  readonly="readonly" /></td>
        </tr>
        <tr>
          <td height="19" colspan="5" class="texto"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" class="caja_texto_pe"  >LOCAL</td>
          <td class="caja_texto_pe" ><select name="c_local" id="c_local" class="caja_sb" >
            <?php 			
			print "<option value='0' selected>Seleccione Local</option>";
			$sql7="select * from tb_locales";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
          </select></td>
          <td colspan="3" class="caja_texto_pe" ><?php echo $reg_loc["nom_local"]; ?>
          <input name="i_local" type="hidden" class="caja_sb" id="i_local" value="<?php echo $reg_loc["cod_local"];?> " size="20"  readonly="readonly" /></td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td height="19" class="caja_texto_pe"  >SUPERVISOR(A)</td>
          <td class="caja_texto_pe" ><select name="c_supervisor" id="c_supervisor" class="caja_sb" >
            <?php 			
			print "<option value='0' selected>Seleccione Supervisor</option>";
			$sql7="select * from tb_supervisores";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
          </select></td>
          <td class="caja_texto_pe"  colspan="3" ><?php echo $reg_sup["nom_supervisor"];    ?>
          <input name="i_supervisor" type="hidden" class="caja_sb" id="i_supervisor" value="<?php echo $reg_sup["cod_supervisor"];?> " size="20"  readonly="readonly" /></td>
        </tr>
        <tr>
         <td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td height="19" class="caja_texto_pe"  >MONITOR(A)</td>
          <td class="caja_texto_pe"  ><select name="c_monitor" id="c_monitor" class="caja_sb" >
            <?php 			
			print "<option value='0' selected>Seleccione Monitor</option>";
			$sql7="select * from tb_monitores order by nom_monitor";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
          </select></td>
          <td colspan="3" class="caja_texto_pe" ><?php echo $reg_mon["nom_monitor"];    ?>
          <input name="i_monitor" type="hidden" class="caja_sb" id="i_monitor" value="<?php echo $reg_mon["cod_monitor"];?> " size="20"  readonly="readonly" /></td>
        </tr>
        <tr>
         	<td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td class="caja_texto_pe"  >AREA</td>
          <td class="caja_texto_pe"><select name="c_area" id="c_area" class="caja_sb" >
            <?php 			
			print "<option value='0' selected>Seleccione Area</option>";
			$sql7="select * from cot_area";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[1]'>$rowper[1]</option>";
			}
			?>
          </select></td>
          <td colspan="3" class="caja_texto_pe"><?php echo $reg_USU["n_area"];    ?>
            <input name="i_area" type="hidden" class="caja_sb" id="i_area" value="<?php echo $reg_USU["n_area"];?> " size="20"  readonly="i_area" /></td>
        </tr>
        <tr>
         <td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td class="caja_texto_pe"  >PERFIL GESCOT</td>
          <td class="caja_texto_pe"><select name="c_perfil" id="c_perfil" class="caja_sb">
            <option value="T">Escoger Perfil</option>
            <?php 						
			$sql7="select * from tb_perfil where id>0";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
          </select></td>
          <td colspan="3" class="caja_texto_pe" ><?php echo  $perfil;  ?>
          <input name="i_perfil" type="hidden" class="caja_sb" id="i_perfil" value="<?php echo $reg_per["id"];?> " size="20"  readonly="readonly" /></td>
        </tr>
        <tr>
         	<td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td class="caja_texto_pe"  >OLA</td>
          <td class="caja_texto_pe"  >
        <select name="c_olas" id="c_olas" class="caja_sb" >
            <option value="T">Escoger Olas</option>
            <?php 						
			$sql8="select * from tb_olas where est='1' order by ord";
		  	$queryresult8 = mysql_query($sql8) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult8)) { 										  
			print "<option value='$rowper[0]'>$rowper[0]</option>";
			}
			?> 
			</select>       </td>
          <td colspan="3" class="caja_texto_pe"  ><?php echo  $reg_USU["ola"];  ?>
          <input name="i_olas" type="hidden" class="caja_sb" id="i_olas" value="<?php echo  $reg_USU["ola"];?> " size="20"  readonly="readonly" /></td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td class="caja_texto_pe"  >N. PC</td>
          <td class="caja_texto_pe"><input name="pc_" type="text" class="caja_sb" id="pc_" value="<?php echo $reg_USU["pc"];    ?>"  /></td>
          <td colspan="3" class="caja_texto_pe" >&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td class="caja_texto_pe"  >N. MONITOR</td>
          <td class="caja_texto_pe" ><input type="text" class="caja_sb" id="pcmonitor" value="<?php echo $reg_USU["monitor"];    ?>"></td>
          <td colspan="3" class="caja_texto_pe" >&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="5" class="texto"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="50" class="caja_texto_pe"  >INFO. ADICIONAL </td>
          <td colspan="4" valign="top" class="caja_texto_pe" ><table width="100%" height="21" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="7%" class="caja_texto_pe" >WIFI</td>
              <td width="20%"  class="caja_texto_pe"><select name="c_wifi" class="caja_sb" id="c_wifi" >
                <option value="0">Escoger</option>
                <option value="ENTREGADO">ENTREGADO</option>
                <option value="NO ENTREGADO">NO ENTREGADO</option>
                            </select></td>
              <td width="7%"  class="caja_texto_pe"><?php echo  $reg_USU["wifi"];  ?>
              <input name="i_wifi" type="hidden" class="caja_sb" id="i_wifi" value="<?php echo  $reg_USU["wifi"];?> " size="20"  readonly="readonly" /></td>
              <td width="12%" class="caja_texto_pe" >AUDIFONOS</td>
              <td width="16%"  class="caja_texto_pe"><select name="c_audifonos" class="caja_sb" id="c_audifonos" >
                <option value="0">Escoger</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
              </select></td>
              <td width="10%"  class="caja_texto_pe"><?php echo  $reg_USU["audifonos"];  ?>
                <input name="i_audifonos" type="hidden" class="caja_sb" id="i_audifonos" value="<?php echo  $reg_USU["audifonos"];?> " size="20"  readonly="readonly" /></td>
              <td width="9%" class="caja_texto_pe" >SILLA</td>
              <td width="9%"  class="caja_texto_pe"><select name="c_sillas" class="caja_sb" id="c_sillas" >
                <option value="T">Escoger</option>
                <option value="1">SI</option>
                <option value="0">NO</option>
                            </select></td>
              <td width="10%"  class="caja_texto_pe"><?php echo  $reg_USU["sillas"];  ?>
                <input name="i_sillas" type="hidden" class="caja_sb" id="i_sillas" value="<?php echo  $reg_USU["sillas"];?> " size="20"  readonly="readonly" /></td>
            </tr>
          </table></td>
        </tr>
        <tr>
           <td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td class="caja_texto_pe"  >ESTADO</td>
          <td class="caja_texto_pe" ><select name="xestado" id="xestado" class="caja_sb" >
            <option value="HABILITADO" selected>HABILITADO</option>
            <option value="DESHABILITADO">DESHABILITADO</option>
          </select></td>
          <td colspan="3" class="caja_texto_pe" ><input type="text" class="caja_sb" id="est" value="<?php echo $reg_USU["estado"];    ?>"> </td>
        </tr>
        <tr>
         <td height="18" colspan="5" class="texto"  >&nbsp;</td>   
        </tr>
        <tr>
          <td valign="top" class="caja_texto_pe"  >NRO DE EMERGENCIA</td>
          <td colspan="4" class="caja_texto_pe" ><textarea cols="60" rows="2" class="caja_sb" id="c_emergencia" ><?php echo $reg_USU["c_emergencia"];    ?></textarea></td>
        </tr>
</table>
<!--
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla_bandeja">
          <?php if ($perfil==0){?>
            <tr class="celdas">
              <td height="18" colspan="10" class="caja_texto_AMA">USUARIO Y PASSWORD DE LA WEB GESCOT</td>
            </tr>
            <tr>
              <td height="18">LOGIN</td>
              <td  class="caja_texto_pe">
                <?php echo  $reg_USU["login"];   ?>              </td>
              <td>PASSWORD</td>
              <td class="aviso">
                <?php echo  $reg_USU["pass"];   ?>              </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
           <?php } ?>
            <tr class="boton">
              <td height="18" class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
              <td class="caja_texto_AMA">&nbsp;</td>
            </tr>
            <tr class="celdas">
              <td width="9%" height="18">GESCOT</td>
              <td width="9%">GENIO</td>
              <td width="9%">GESTEL</td>
              <td width="9%">CMS</td>
              <td width="10%">UNIFICADA</td>
              <td width="10%">MULTICONSULTA</td>
              <td width="10%">PSI</td>
              <td width="10%">ATIS</td>
              <td width="7%">MAPA GIS</td>
              <td width="17%">RED</td>
            </tr>
            <tr>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="login" value="<?php echo  $reg_USU["login"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="USUARIO_GENIO" value="<?php echo  $reg_USU_d["USUARIO_GENIO"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="USUARIO_GESTEL" value="<?php echo  $reg_USU_d["USUARIO_GESTEL"]; ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="USUARIO_CMS" value="<?php echo  $reg_USU_d["USUARIO_CMS"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="USUARIO_WEB_UNIFICADA" value="<?php echo  $reg_USU_d["USUARIO_WEB_UNIFICADA"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input name="text" type="text" class="caja_sb" id="USUARIO_MULTICONSULTA" value="<?php echo  $reg_USU_d["USUARIO_MULTICONSULTA"];  ?>" size="20" /></td>
              <td class="caja_texto_pe"><input name="text2" type="text" class="caja_sb" id="USUARIO_PSI" value="<?php echo  $reg_USU_d["USUARIO_PSI"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input name="text3" type="text" class="caja_sb" id="USUARIO_ATIS" value="<?php echo  $reg_USU_d["USUARIO_ATIS"];  ?>" size="20" /></td>
              <td class="caja_texto_pe"><input name="text8" type="text" class="caja_sb" id="WEB_SIGTP_MAPA_GIG" value="<?php echo  $reg_USU_d["WEB_SIGTP_MAPA_GIG"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="usuario_red" value="<?php echo  $reg_USU_d["usuario_red"];   ?>" size="20" /></td>
            </tr>
            <tr class="celdas">
              <td width="9%" height="18">INTRAWAY</td>
              <td width="9%">SARA</td>
              <td width="9%">CLEAR VIEW</td>
              <td width="9%">REPARTIDOR</td>
              <td width="10%">INCIDENCIAS PSI</td>
              <td width="10%">ASEGURAMIENTO</td>
              <td width="10%">PDM</td>
              <td width="10%">CALCULADORA ARPU</td>
              <td width="7%">ASIGNACIONES</td>
              <td width="17%">&nbsp;</td>
            </tr>
            <tr>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="USUARIO_INTRAWAY" value="<?php echo  $reg_USU_d["USUARIO_INTRAWAY"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="WEB_SARA" value="<?php echo  $reg_USU_d["WEB_SARA"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="CLEAR_VIEW" value="<?php echo  $reg_USU_d["CLEAR_VIEW"];   ?>" size="20"   /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="REPARTIDOR" value="<?php echo  $reg_USU_d["REPARTIDOR"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input type="text" class="caja_sb" id="USUARIO_INCIDENCIAS_PSI" value="<?php echo  $reg_USU_d["WEB_INCIDENCIAS_PSI"];   ?>" size="20"  /></td>
              <td class="caja_texto_pe"><input name="text4" type="text" class="caja_sb" id="WEB_ASEGURAMIENTO" value="<?php echo  $reg_USU_d["WEB_ASEGURAMIENTO"];   ?>" size="20"  /></td>
              <td class="caja_texto_pe"><input name="text5" type="text" class="caja_sb" id="PDM" value="<?php echo  $reg_USU_d["PDM"];   ?>" size="20"  /></td>
              <td class="caja_texto_pe"><input name="text6" type="text" class="caja_sb" id="WEB_ARPU_CALCULADORA" value="<?php echo  $reg_USU_d["WEB_ARPU_CALCULADORA"];   ?>" size="20" /></td>
              <td class="caja_texto_pe"><input name="text7" type="text" class="caja_sb" id="WEB_ASIGNACIONES" value="<?php echo  $reg_USU_d["WEB_ASIGNACIONES"];   ?>" size="20" /></td>
              <td class="caja_texto_pe">&nbsp;</td>
            </tr>
            
            <tr>
              <td height="17" colspan="10" class="caja_texto_db">MOTIVO DE CAMBIO</td>
            </tr>
            <tr>
              <td height="17" colspan="10" class="caja_texto_pe">
              <textarea cols="80" rows="5" class="caja_texto_cb" id="motivo_cambio"></textarea></td>
            </tr>
</table>
-->

</body>
</html>