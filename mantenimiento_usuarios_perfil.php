<?php
include("conexion_bd.php");
//include("funciones_fechas.php");

$lista=$_GET["lista"];
$iduser=$_GET["iduser"];
$accion=$_GET["accion"];

$dni=$_GET["dni"];

if ($iduser==""){
	if ($cip==""){
	$cad="and a.dni='$dni'";	
	}else{
	$cad="and a.cip='$cip'";	
	}
}else{
	$cad="and a.iduser='$iduser'";	
	}
	
  ///$sql_usu = "SELECT a.*,b.* FROM tb_usuarios a, usuarios_detalle b WHERE a.dni=b.dni $cad GROUP BY a.dni";
  $sql_usu = "SELECT * FROM tb_usuarios a WHERE iduser='$iduser' GROUP BY a.dni";
 // echo $sql_usu;
  $res_USU = mysql_query($sql_usu);											
  $nreg= mysql_num_rows($res_USU);
  $reg_USU=mysql_fetch_array($res_USU);
  
  $sql_USU_D = "SELECT * FROM usuarios_detalle a WHERE dni='$dni' GROUP BY a.dni";
  //echo $sql_usu;
  $res_USU_D = mysql_query($sql_USU_D);											  
  $reg_USU_D  = mysql_fetch_array($res_USU_D);
  
  $i=0;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" readonly />
<title>Documento sin título</title>
<style type="text/css">  
  .boton_3:hover{
    color: #1883ba;
    background-color: #FFFFE1;
  }
</style>
<script language="javascript" src="funciones_js.js"></script>
<link type="text/css" readonly />

<link href="estilos.css" rel="stylesheet" type="text/css" readonly />
</head>

<body>
<p>
  <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
  <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
  
  
  <?php 
		  if($reg_USU["perfil"]=="0"){ $perfil="ADMINISTRADOR";}
  		  if($reg_USU["perfil"]=="1"){ $perfil="OPERADOR";}
		  if($reg_USU["perfil"]=="2"){ $perfil="JEFE";}
  		  if($reg_USU["perfil"]=="3"){ $perfil="SUPERVISOR";}
		  		  
		 
		 ?>
</p>
<!--
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="" align="center" >

<tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>mantenimiento_usuarios_perfil.php</a>"; ?></td>
  </tr>
  <tr>
    <td class="boton_4">LINK APLICATIVOS WEB COT </td>
  </tr>

  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<a href="http://systemcenter/catalogo/" target="_blank" class="cabeceras_grid_color">CATALOGO (IE) </a>
	<a href="https://ehrkb.ihost.com/nimbus/login/telefonica" target="_blank" class="cabeceras_grid_color">CONECTADOS</a>
	<a href="https://itsm-tdp.onbmc.com/arsys/forms/onbmc-s/SHR%3ALandingConsole/Default+Administrator+View/?cacheid=889cd5a8" 
    target="_blank" class="cabeceras_grid_color">REMEDY</a>
	<a href="https://performancemanager5.successfactors.eu/login?company=Telefonica#/login" 
    target="_blank" class="cabeceras_grid_color">SUSESS FACTOR</a> 
	<a href="https://doit.movistar.com.pe/(S(ckokq5z2oq3izlotnmoghmtq))/Interfaces/CreacionTicketsIncidencia/CreacionDeTicketIncidencia.aspx" 
    target="_blank" class="cabeceras_grid_color">&nbsp;DOIT&nbsp;</a> 
	<a href="https://atis-tdp/login_normal.html" 
    target="_blank" class="cabeceras_grid_color" style="width:100px">&nbsp;ATIS&nbsp; </a> 
	<a href="http://10.226.158.199/CANCELACIONES_COT/cab_cancelaciones.php" 
    target="_blank" class="cabeceras_grid_color" style="width:100px">&nbsp;CANCELADAS&nbsp; </a> 
	<a href="http://10.226.44.222/asignaciones/index.php" 
    target="_blank" class="cabeceras_grid_color" style="width:100px">&nbsp;WEB TECNICA&nbsp; </a> 
	<a href="http://www.genio.movistar.com.pe/web/guest/login?p_p_id=58&amp;p_p_lifecycle=0&amp;_58_redirect=%2F" target="_blank" class="cabeceras_grid_color">WEB GENIO</a>
	<a href="https://10.252.64.132/" target="_blank" class="cabeceras_grid_color">WEB PSI</a>
	<a href="http://10.226.44.221/aseguram/index.php" target="_blank" class="cabeceras_grid_color">W. ASEGURAMIENTO</a>
	<a href="http://www.movistar1.com:9571/cmts/login.php" target="_blank" class="cabeceras_grid_color">W. MULTICONSULTA</a>
	<a href="http://crm.medianetworks.pe/IntrawayCRM/pag/login.php" target="_blank" class="cabeceras_grid_color">WEB INTRAWAY</a>
	<a href="http://10.226.125.37:8080/speedy/" target="_blank" class="cabeceras_grid_color">WEB SARA</a>
	</td>
  </tr>
</table>
-->
<br>
<table width="100%" height="470" border="0" cellpadding="0" cellspacing="0" class="" >
    <tr>
      <td colspan="7" class="boton_4">INFORMACION GENERAL DEL TRABAJADOR</td>
    </tr>
    <tr>
      <td height="12" class="TitTablaI" >&nbsp;</td>
      <td colspan="4" >&nbsp;</td>
      <td width="202" rowspan="31" valign="top"><br />
        <table width="100" border="1" align="center" cellpadding="0" cellspacing="0" class="marco_tabla">
          <tr>
            <td height="150" align="center"><strong><img src="image/FOTO.jpg" alt="" width="160" height="160" /></strong></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="141" height="18" class="cabeceras_grid" >NOMBRE COMPLETO</td>
      <td colspan="4" class="cabeceras_grid" ><?php echo  $reg_USU["ncompleto"];   ?></td>
    </tr>
    <tr>
      <td height="12" class="TitTablaI" >&nbsp;</td>
      <td colspan="4" >&nbsp;</td>
    </tr>
    <tr>
      <td height="18" class="cabeceras_grid" >CIP</td>
      <td class="cabeceras_grid" ><?php echo  $reg_USU["cip"];  ?></td>
      <td class="cabeceras_grid">DNI</td>
      <td colspan="2" class="cabeceras_grid"><span class="textos_urgentes"><?php echo  $reg_USU["dni"]; ?></span></td>
    </tr>
    
    <tr>
      <td height="12" colspan="5" class="fdoceldastxt" >&nbsp;</td>
    </tr>
    <tr>
      <td height="18" class="cabeceras_grid" ><img src="image/MAIL.jpg" alt="" width="30" height="30" />E-TRABAJO</td>
      <td width="231" class="cabeceras_grid"><?php echo $reg_USU["correo_w"];   ?></td>
      <td width="133" class="cabeceras_grid"><img src="image/MAIL.jpg" alt="" width="30" height="30" />E-PERSONAL</td>
      <td colspan="2" class="cabeceras_grid"><?php echo $reg_USU["correo_personal"];   ?></td>
    </tr>
    <tr>
      <td height="12" class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr>
      <td height="18" valign="top" class="cabeceras_grid" ><img src="image/CEL.jpg" alt="" width="20" height="30" />CELULAR STAFF </td>
      <td class="cabeceras_grid"><?php echo $reg_USU["celular1"];    ?></td>
      <td valign="top" class="cabeceras_grid" ><span><img src="image/CEL.jpg" alt="" width="20" height="30" />CELULAR PERSONAL </span></td>
      <td colspan="2" class="cabeceras_grid"><?php echo $reg_USU["celular2"];    ?></td>
    </tr>
    <tr>
      <td height="12" class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr>
      <td height="18" class="cabeceras_grid" ><img src="image/TEL.jpg" alt="" width="30" height="30" />ANEXO</td>
      <td class="cabeceras_grid"><?php echo $reg_USU["anexo"];    ?></td>
      <td class="cabeceras_grid" ><img src="image/CUMPL.jpg" alt="" width="30" height="30" />CUMPLEAÑO</td>
      <?php 
	$fec_nac=$reg_USU["fec_nacimiento"];
	$fec_nac = explode("-", $fec_nac);
	$dia=$fec_nac[0]; // porción1
	$mes=$fec_nac[1]; // porción2
	
	if ($mes=="01") { $xmes="ENERO";}
	if ($mes=="02") { $xmes="FEBRERO";}
	if ($mes=="03") { $xmes="MARZO";}
	if ($mes=="04") { $xmes="ABRIL";}
	if ($mes=="05") { $xmes="MAYO";}
	if ($mes=="06") { $xmes="JUNIO";}
	if ($mes=="07") { $xmes="JULIO";}
	if ($mes=="08") { $xmes="AGOSTO";}
	if ($mes=="09") { $xmes="SEPTIEMBRE";}
	if ($mes=="10") { $xmes="OCTUBRE";}
	if ($mes=="11") { $xmes="NOVIEMBRE";}
	if ($mes=="12") { $xmes="DICIEMBRE";}
	
				
			
	?>
      <td class="cabeceras_grid" colspan="2" ><?php echo $reg_USU["fec_nacimiento"];    ?></td>
    </tr>
    <?php 
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
  
  
  ?>
    <tr>
      <td height="12" colspan="5" class="fdoceldastxt" >&nbsp;</td>
    </tr>
    <tr>
      <td height="12" class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td width="208" >&nbsp;</td>
      <td class="TitTablaI" >PISO</td>
    </tr>
    <tr>
      <td height="20" class="cabeceras_grid" ><img src="image/edificio.jpg" alt="" width="30" height="30" />LOCAL</td>
      <td class="cabeceras_grid"><?php echo $reg_loc["nom_local"];    ?></td>
      <td class="cabeceras_grid" ><img src="image/edificio.jpg" alt="" width="30" height="30" />UBICACION</td>
      <td class="cabeceras_grid"><?php echo $reg_loc["dire_local"];    ?></td>
      <td class="cabeceras_grid" width="79" ><?php echo $reg_USU["piso"];    ?></td>
    </tr>
    <tr>
      <td height="13" class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr>
      <td class="cabeceras_grid" ><img src="image/CASA.jpg" width="30" height="30" />DOMICILIO</td>
      <td colspan="2" class="cabeceras_grid"><?php echo $reg_USU["dir_casa"];    ?></td>
      <td colspan="2" class="cabeceras_grid" >&nbsp;</td>
    </tr>
    <tr>
      <td class="cabeceras_grid" ><img src="image/PC.jpg" alt="" width="30" height="30" />PC</td>
      <td class="cabeceras_grid"><?php echo $reg_USU["pc"];    ?></td>
      <td class="cabeceras_grid" ><img src="image/MONITOR.jpg" alt="" width="30" height="30" />MONITOR</td>
      <td colspan="2" class="cabeceras_grid" ><?php echo $reg_USU["monitor"];    ?></td>
    </tr>
    <tr>
      <td class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
	<!--
    <tr>
      <td height="12" colspan="5" class="fdoceldastxt" >&nbsp;</td>
    </tr>
    <tr>
      <td class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
	
    <tr>
      <td class="TitTablaI" >SUPERVISOR(A)</td>
      <td ><?php echo $reg_sup["nom_supervisor"];    ?></td>
      <td class="TitTablaI" >MONITOR(A)</td>
      <td colspan="2" ><?php echo $reg_mon["nom_monitor"];    ?></td>
    </tr>
    <tr>
      <td class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr>
      <td height="12" colspan="5" class="fdoceldastxt" >&nbsp;</td>
    </tr>
	-->
    <tr>
      <td class="cabeceras_grid" ><img src="image/wifi.jpg" alt="" width="30" height="30" />WIFI</td>
      <td class="cabeceras_grid"><?php 
	  if ($reg_USU["wifi"]=="-"){
	  echo "0";    
	  }else{
	  echo $reg_USU["wifi"];    
	  }?></td>
      <td class="cabeceras_grid"><img src="image/audifonos.jpg" alt="" width="30" height="30" />AUDIFONOS</td>
      <td class="cabeceras_grid"colspan="2" ><?php echo $reg_USU["audifonos"]; ?></td>
    </tr>
    <tr>
      <td class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr>
      <td class="cabeceras_grid" ><img src="image/silla.jpg" alt="" width="30" height="30" />SILLA</td>
      <td class="cabeceras_grid"><?php 
	  if ($reg_USU["sillas"]==0){
	  echo "0";    
	  }else{
	  echo $reg_USU["sillas"];    
	  }
	  ?></td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr>
      <td class="TitTablaI" >&nbsp;</td>
      <td >&nbsp;</td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
	<!--
    <tr>
      <td class="TitTablaI" >ESTADO</td>
      <td class="textos_urgentes" ><?php echo  $reg_USU["estado"];   ?></td>
      <td class="TitTablaI" >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
	-->    
</table>  
<p>
  <!--
  <table width="100%" border="0" class="marco_tabla_bandeja">
    <tr>
      <td colspan="2" class="caja_texto_db">INFORMACION DE USUARIOS</td>
    </tr>
    <tr>
      <td width="25%" valign="top" class="caja_textop">GESCOT</td>
      <td width="75%" valign="top" class="caja_sborde"><?php echo  $reg_USU["login"];   ?></td>
    </tr>
    <tr>
      <td valign="top" class="caja_textop">GESTEL</td>
      <td valign="top" class="caja_sborde"><?php echo  $reg_USU["USUARIO_GESTEL"]; ?></td>
    </tr>
    <tr>
      <td valign="top" class="caja_textop">CMS</td>
      <td valign="top"  class="caja_sborde"><?php echo  $reg_USU["USUARIO_CMS"];   ?></td>
    </tr>
    <tr>
      <td valign="top" class="caja_textop">RED</td>
      <td valign="top" class="caja_sborde"><?php echo  $reg_USU["usuario_red"];   ?></td>
    </tr>
    <tr>
      <td valign="top" class="caja_textop">ATIS</td>
      <td valign="top" class="caja_sborde"><?php echo  $reg_USU["USUARIO_ATIS"];  ?></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" class="">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><table width="100%">
        <tr>
          <td colspan="4" class="Et_horarios">APLICATIVOS WEB COT</td>
        </tr>
        <tr>
          <td class="caja_texto_hr">
          <a href="http://www.genio.movistar.com.pe/web/guest/login?p_p_id=58&amp;p_p_lifecycle=0&amp;_58_redirect=%2F" target="_blank" class="casilla_texto">WEB GENIO</a></td>
          <td class=""><?php echo  $reg_USU_D["USUARIO_GENIO"];   ?></td>
          <td class="casilla_texto"><a href="http://10.226.44.221/aseguram/index.php" target="_blank"  >W. ASEGURAMIENTO</a></td>
          <td  class=""><?php echo  $reg_USU_D["WEB_ASEGURAMIENTO"];   ?></td>
        </tr>
        <tr>
          <td class="casilla_texto"><a href="http://10.226.4.239/webunificada/login.php" target="_blank" >W. UNIFICADA</a></td>
          <td class=""><?php echo  $reg_USU_D["USUARIO_WEB_UNIFICADA"];   ?></td>
          <td class="casilla_texto"><a href="http://crm.medianetworks.pe/IntrawayCRM/pag/login.php" target="_blank" >WEB INTRAWAY</a></td>
          <td class=""><?php echo  $reg_USU_D["USUARIO_INTRAWAY"];   ?></td>
        </tr>
        <tr>
          <td class="casilla_texto"><a href="http://www.movistar1.com:9571/cmts/login.php" target="_blank" >W. MULTICONSULTA</a></td>
          <td class=""><?php echo  $reg_USU_D["USUARIO_MULTICONSULTA"];  ?></td>
          <td class="casilla_texto"><a href="http://10.226.125.37:8080/speedy/" target="_blank" >WEB SARA</a></td>
          <td class=""><?php echo  $reg_USU_D["WEB_SARA"];   ?></td>
        </tr>
        <tr>
          <td class="casilla_texto"><a href="https://10.252.64.132/" target="_blank">WEB PSI</a></td>
          <td class=""><?php echo  $reg_USU_D["USUARIO_PSI"];   ?></td>
          <td class="casilla_texto"><a href="http://sigtp/sigtp/viewer.html" target="_blank"  >W. MAPAGIS</a></td>
          <td class=""><?php echo  $reg_USU_D["WEB_SIGTP_MAPA_GIG"];   ?> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"><a href="http://systemcenter/catalogo/" target="_blank" class="caja_texto_pe">CATALOGO (IE) </a>
		  <a href="https://ehrkb.ihost.com/nimbus/login/telefonica" target="_blank" class="caja_texto_pe">CONECTADOS</a>
		  <a href="https://itsm-tdp.onbmc.com/arsys/forms/onbmc-s/SHR%3ALandingConsole/Default+Administrator+View/?cacheid=889cd5a8" 
              target="_blank" class="caja_texto_pe">REMEDY</a><a href="https://performancemanager5.successfactors.eu/login?company=Telefonica#/login" 
              target="_blank" class="caja_texto_pe">SUSESS FACTOR</a>
              <a href="https://doit.movistar.com.pe/(S(ckokq5z2oq3izlotnmoghmtq))/Interfaces/CreacionTicketsIncidencia/CreacionDeTicketIncidencia.aspx" 
              target="_blank" class="caja_texto_pe">&nbsp;DOIT&nbsp;</a>
               <a href="https://atis-tdp/login_normal.html" 
              target="_blank" class="caja_texto_pe" style="width:100px">&nbsp;ATIS&nbsp;        </a>
        <a href="http://10.226.158.199/CANCELACIONES_COT/cab_cancelaciones.php" 
              target="_blank" class="caja_texto_pe" style="width:100px">&nbsp;CANCELADAS&nbsp;        </a>
         <a href="http://10.226.44.222/asignaciones/index.php" 
              target="_blank" class="caja_texto_pe" style="width:100px">&nbsp;WEB TECNICA&nbsp;        </a>              
		 </td>
        </tr>
        <tr>
          <td width="211"><p>&nbsp;</p></td>
          <td width="183">&nbsp;</td>
          <td width="321">&nbsp;</td>
          <td width="245">&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto1">&nbsp;</td>
          <td class="caja_texto1">&nbsp;</td>
          <td class="caja_texto1">&nbsp;</td>
          <td class="caja_texto1">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
 
</td> 
-->
<p>
<table width="100%" border="0">
  <tr>
   <td class="boton_4">INF. USUARIO CON APLICATIVOS </td>
  </tr>
</table>
<div id="lista_usuarios_apli" style="overflow:scroll; width:100%; height:300px">
<?PHP
echo "<table width='50%'>";
			$col="select * from tb_aplicativos where estado='1' order by orden";
			$res_col= mysql_query($col);
			
			while($reg_col = mysql_fetch_row($res_col)){
				echo "<tr>";
				echo "<td class='caja_texto_pe' width='30%'>";	
				echo $reg_col[1]; 	//aplicativo				
				echo "</td>";
				
				$col_2="select dni,dato,aplicativo,est
				from movimientos_maestra where dni='$reg_USU[dni]' AND aplicativo='$reg_col[1]' group by dni";
				//echo $col_2."<h>";			
				$res_2= mysql_query($col_2);
							
				while($reg_2 = mysql_fetch_row($res_2)){	
									
				echo "<td class='caja_texto_pe' valign='top'>";		
				echo "<input name='' type='text' class='caja_sb' id='' value='$reg_2[1]' />";	//dato	
				echo "</td>";	
				
				echo "<td class='caja_texto_pe' valign='top'>";		
				echo "<input name='' type='text' class='caja_sb' id='' value='$reg_2[3] ' />";	//estado	
				echo "</td>";	
				
				
				echo "<td class='caja_texto_pe' valign='top' align='center'>";					
				
					if ($reg_2[1]=="-"){							
					echo "<img src='image/semaforo_r.JPG' width='25' height='25' />";			
					}else{
					echo "<img src='image/semaforo_v.JPG' width='25' height='25' />";	
					}
				
				echo "</td>";
				
				echo "<td class='caja_texto_pe' valign='top' align='center'>";		
				//echo "<input name='' type='text' class='caja_sb' id='' value='$reg_col[6]' />";	//link	
				if ($reg_col[7]=="SI"){
				echo "<a href='$reg_col[6]' target='_blank'> 
				<img src='image/ver.jpg' width='35' height='35' border='0' title='$reg_col[6]' /></a>";
				}else{
				echo "NO WEB";
				}
				echo "</td>";	
				
				}
				/*
				echo "<td class='caja_texto_pe' valign='top' align='center'>";
				echo "<table width='100%' border='0'>";
				echo "<tr>";				
				echo "<td><img src='image/visto1.jpg' width='25' height='25' /></td>";	
				echo "<td><img src='image/eliminar2.jpg' width='20' height='20' /></td>";					
				echo "</table>";
				echo "</td>";
				*/
			echo "</tr>";
			}
echo "</table>";
			
?>
</div>
</body>
</html>