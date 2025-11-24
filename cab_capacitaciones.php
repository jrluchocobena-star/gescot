<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];	
validar_logeo($iduser);


//$xmes=$_GET["xmes"];	
$xmes='2018-06';

if ($xmes==""){
	$cad="";	
}else{
	$cad=" substr(fec_reg,1,7)='$xmes'";
	}	

$sql_1="select * from cab_capacitacion where $cad 
order by fec_reg desc";
//echo $sql_1;
$res_1 = mysql_query($sql_1);
$reg_1=mysql_fetch_row($res_1);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language='javascript1.2' type='text/javascript'>

function mostrar_incidencia() {	
	var xinc = document.getElementById("pre").value+document.getElementById("xinc").value;
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	
	if ( document.getElementById("xinc").value =="" ){
		alert("Ingrese Numero de incidencia")
		return	
	}else{
	var	pagina_envio="infocapacitaciones.php?xinc="+xinc+"&iduser="+iduser+"&idperfil="+idperfil;
	var atributos="status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no,top=200,left=200,width=700,height=500";
	}
	//alert(pagina_envio);
	document.getElementById("xinc").value="";
	var win = window.open(pagina_envio,"",atributos);	
}

</script>
<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>


<script language='javascript1.2' type='text/javascript' src="funciones_js.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<script language="JavaScript1.2" src="bandejas/table.js"></script>
<script language="JavaScript1.2" src="bandejas/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="bandejas/table.css" media="all">
<title></title>
</head>

<body>
<p>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 
        <tr>
          <td colspan="2" align="center" class="caja_texto_db">RANGO DE FECHAS </td>
          <td width="10%" class="caja_texto_db">MONITOR</td>
          <td width="24%" class="caja_texto_db">PANEL</td>
          <td width="26%" class="caja_texto_db">BUSQUEDA</td>
        </tr>
        <tr>
          <td colspan="2"><input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
          <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/></td>
        </tr>
        <tr>
          <td width="16%" class="caja_texto_pe"><table width="200" border="0" class="caja_texto_pe">
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
                    <option value="05">06</option>
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
          <td width="16%" class="caja_texto_pe"><table width="200" border="0" class="caja_texto_pe">
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
          <td class="caja_texto_pe"><select name="c_monitor" id="c_monitor" class="caja_texto_pe">
            <option value="0">Escoger Monitor</option>
            <?php
			$sql7="select * from tb_monitores where est='1'";			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
          </select></td>
          <td class="caja_texto_pe" ><table width="100%" border="0">
            <tr>
              <td width="61" class="cabeceras_grid" onclick="javascript:mostrar_bandejas_incidencias('2');"><img src="image/busca.jpg" width="25" height="25" onclick= ""/>Buscar</td>
             
              <td width="70" class="cabeceras_grid" onclick="javascript:mant_incidencia('6');" ><img src="image/excel1.jpg" width="25" height="25" />Exportar</td>
              
              <td align="center" class="cabeceras_grid" width="112" onclick="javascript:popup_reclamo('8','<?php echo $reg_1[10]; ?>','<?php echo $iduser; ?>',
'<?php echo $idperfil; ?>','<?php echo "Registro"; ?>','')">
<img src="image/icon1.gif" width="20" height="20" /> REGISTRAR</td>
            </tr>
          </table></td>
          <td class="caja_texto_pe">
		  <table width="90%" border="0"  cellpadding="0" cellspacing="0" >
            <tr>
              <td align="center" valign="top" class="etiqueta_1p">&nbsp;</td>
              <td valign="top" >&nbsp;</td>
              <td valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td width="36%" align="center" valign="top" class="etiqueta_p">COD.CAPACITACION</td>
              <td width="54%" valign="top" class="caja_texto_pe">
              <input name="pre" type="text" class="caja_texto_sb" id="pre" value="CAP-" size="5" 
              maxlength="4" readonly />
              <input name="xinc" type="text" class="caja_sb" id="xinc" size="15" 
              maxlength="15" /></td>
              <td width="10%" valign="top"><img src="image/busca.jpg" width="22" height="22" onclick="javascript:mostrar_incidencia()" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="celdas" colspan="6">&nbsp;</td>
        </tr>
</table>
<p>
  <iframe id="f_incidencias"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
            width="100%"  scrolling="Auto"  height="500" > </iframe>
</body>
</html>