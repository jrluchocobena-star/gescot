<?php
include("conexion_bd.php");
//include("funciones_fechas.php");

$lista=$_GET["lista"];
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
$accion=$_GET["accion"];

$dni=$_GET["dni"];

if ($cip==""){
	$cad="dni='$dni'";	
}else{
	$cad="cip like '%$cip%'";	
}
	
  $sql_usu = "SELECT * from tb_usuarios where $cad GROUP BY dni";
  //echo $sql_usu;
  $res_USU = mysql_query($sql_usu);											
  $nreg= mysql_num_rows($res_USU);
  $reg_USU=mysql_fetch_array($res_USU);
  
  $i=0;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" readonly />
<title>Documento sin título</title>
<script language="javascript" src="funciones_js.js"></script>

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" readonly />
</head>

<body>

<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>


      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="marco_tabla_bandeja" >
       <tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>mantenimiento_usuarios_edit.php</a>"; ?></td>
  </tr>
        <tr>
          <td colspan="7" class="contador">INFORMACION GENERAL DEL TRABAJADORES COT </td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="12" colspan="5" class="caja_texto_sb" >
		  <p>&nbsp;<br>
		  <a href="javascript:ventana_modal('5')" class="caja_text">Ver Historico</a>
	    <a href="javascript:ventana_modal('4')" class="caja_text">Ver Usuarios</a>        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="4" class="caja_texto_sb" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >ID</td>
          <td colspan="4" class="caja_texto_sb" ><?php echo  $reg_USU["iduser"]; ?></td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="18" class="caja_texto_sb" >&nbsp;</td>
          <td colspan="4" >&nbsp;</td>
        </tr>
        <tr>
          <td width="16" class="caja_texto_sb" >&nbsp;</td>
          <td width="163" height="18" class="caja_texto_sb" >DNI</td>
          <td colspan="4" class="caja_texto_sb" >
            <input name="xdni" type="text" class="caja_texto_sb" id="xdni" size="15" maxlength="10" value="<?php echo  $reg_USU["dni"]; ?>"/>          </td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="12" class="caja_texto_sb" >&nbsp;</td>
          <td colspan="4" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="18" class="caja_texto_sb" >CIP</td>
          <td colspan="4" class="caja_texto_sb" ><?php echo  $reg_USU["cip"];  ?></td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="12" class="caja_texto_sb" >&nbsp;</td>
          <td colspan="4" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="18" class="caja_texto_sb" >NOMBRE COMPLETO</td>
          <td colspan="4" class="caja_texto_sb" ><?php echo  $reg_USU["ncompleto"];   ?></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#0099CC">&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="30" class="caja_texto_sb" >GRUPO</td>
          <td class="caja_texto_sb" ><?php echo $reg_USU["grupo"];   ?></td>
          <td class="caja_texto_sb">CARGO</td>
          <td colspan="2" class="caja_texto_sb" ><?php echo $reg_USU["sgrupo"];   ?></td>
        </tr>
		 <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="12" class="caja_texto_sb" >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
		
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="30" class="caja_texto_sb" >E-TRABAJO</td>
          <td class="caja_texto_sb" ><?php echo $reg_USU["correo_w"];   ?></td>
          <td width="146" class="caja_texto_sb">E-PERSONAL</td>
          <td colspan="2" class="caja_texto_sb" ><?php echo $reg_USU["correo_personal"];   ?></td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="12" class="caja_texto_sb" >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="18" class="caja_texto_sb" >CELULAR 1</td>
          <td class="caja_texto_sb" ><?php echo $reg_USU["celular1"];    ?></td>
          <td class="caja_texto_sb" ><span>CELULAR 2</span></td>
          <td colspan="2" class="caja_texto_sb" ><?php echo $reg_USU["celular2"];    ?></td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="12" class="caja_texto_sb" >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="18" class="caja_texto_sb" >ANEXO</td>
          <td class="caja_texto_sb" ><?php echo $reg_USU["anexo"];    ?></td>
          <td class="caja_texto_sb" >CUMPLEAÑO</td>
          <td colspan="2" class="caja_texto_sb" ><?php echo $reg_USU["fec_nacimiento"];    ?></td>
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
  
  $per="select * from tb_perfil where id='$reg_USU[perfil]'";  
 //	echo $loc;
  $res_per = mysql_query($per);											
  $reg_per=mysql_fetch_array($res_per);
  
  
  ?>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="12" class="caja_texto_sb" >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td height="20" class="caja_texto_sb" >LOCAL</td>
          <td width="270" class="caja_texto_sb" ><?php echo $reg_loc["nom_local"];    ?></td>
          <td class="caja_texto_sb" >OLA</td>
          <td width="283" ><span class="caja_texto_sb"><?php echo $reg_USU["ola"];    ?></span></td>
          <td width="58" class="caja_texto_sb" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td height="30" class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >UBICACION</td>
          <td class="caja_texto_sb" ><?php echo $reg_loc["dire_local"];    ?></td>
          <td class="caja_texto_sb" >PISO</td>
          <td colspan="2" class="caja_texto_sb" ><?php echo $reg_USU["piso"];    ?></td>
        </tr>
        <tr>
          <td bgcolor="#0099CC" >&nbsp;</td>
          <td bgcolor="#0099CC">&nbsp;</td>
          <td bgcolor="#0099CC" >&nbsp;</td>
          <td bgcolor="#0099CC" >&nbsp;</td>
          <td colspan="2" bgcolor="#0099CC" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >SUPERVISOR(A)</td>
          <td class="caja_texto_sb" ><?php echo $reg_sup["nom_supervisor"];    ?></td>
          <td class="caja_texto_sb" >MONITOR(A)</td>
          <td colspan="2" class="caja_texto_sb" ><?php echo $reg_mon["nom_monitor"];    ?></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#0099CC">&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >INVENTARIO PC</td>
          <td class="caja_texto_sb" ><?php echo $reg_USU["pc"];    ?></td>
          <td class="caja_texto_sb" >INVENTARIO MONITOR</td>
          <td colspan="2" class="caja_texto_sb" ><?php echo $reg_USU["monitor"];    ?></td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td >&nbsp;</td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >PERFIL</td>
          <td class="caja_texto_sb" ><?php echo  $reg_per[1];  ?></td>
          <td class="caja_texto_sb" >CATEGORIA</td>
          <td colspan="2" class="caja_texto_sb"><?php echo  $reg_USU["cod_cargo"];  ?></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#0099CC">&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >INFO. ADICIONAL </td>
          <td colspan="4" class="caja_texto_sb" ><table width="100%" height="21" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="8%" class="caja_texto_sb">WIFI</td>
              <td width="16%" class="caja_texto_sb"><?php echo  $reg_USU["wifi"];  ?></td>
              <td width="13%" class="caja_texto_sb">AUDIFONOS</td>
              <td width="22%" class="caja_texto_sb"><?php echo  $reg_USU["audifonos"];  ?></td>
              <td width="8%" class="caja_texto_sb">SILLA</td>
              <td width="33%" class="caja_texto_sb"><?php echo  $reg_USU["sillas"];  ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="6" bgcolor="#0099CC">&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >ESTADO</td>
          <td class="caja_texto_sb" ><?php echo  $reg_USU["estado"];   ?></td>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td class="caja_texto_sb" >&nbsp;</td>
          <td class="caja_texto_sb" >NRO. EMERGENCIA</td>
          <td class="caja_texto_sb" ><?php echo  $reg_USU["c_emergencia"];   ?></td>
          <td >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td colspan="2" >&nbsp;</td>
        </tr>
        <tr  class="texto">
          <td colspan="7">&nbsp;</td>
        </tr>
    </table>
 
<p>
<div id="d_historico" style="display:none; overflow:scroll">
 
</div> 
  
</body>
</html>