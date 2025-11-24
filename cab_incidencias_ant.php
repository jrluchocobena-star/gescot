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
	$cad="and substr(fec_reg,1,7)='$xmes'";
	}	

$sql_1="select * from cab_incidencia where tp_incidencia!='MONITOREO Y CAPACITACION COT' $cad 
order by fec_reg desc";
//echo $sql_1;
$res_1 = mysql_query($sql_1);

//echo $idperfil;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

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
<table width="100%">
 <tr>
   <td colspan="5" align="left" class="contador" onclick="javascript:popup_reclamo('3','<? echo $iduser; ?>',
'<? echo $idperfil; ?>','<? echo "Registro"; ?>','','')">MODULO DE INCIDENCIAS ADMINISTRATIVAS - COT</td>
  </tr>
 <tr>
<td align="center" class="caja_texto_pe" width="13%" onclick="javascript:popup_reclamo('3','<? echo $iduser; ?>',
'<? echo $idperfil; ?>','<? echo "Registro"; ?>','','')">
<img src="image/icon1.gif" width="20" height="20" /> REGISTRAR</td>
    <td width="66%">&nbsp;</td>
    <td width="7%"><span class="tabcontent">
      <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
      <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
    </span></td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>    
    </tr>
</table>   
<p>
<? if ($idperfil > 2 or $idperfil==0){ ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="171" class="celdas">MES</td>       
        <td width="318" class="celdas">SUPERVISOR</td>
        <td width="407" class="celdas">PANEL</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td valign="top" >
      </tr>
      <tr>
        <td>
          <select name="xmes1" class="caja_texto1" id="xmes1"  >
            <option value="0"> </option>
            <option value="01">enero</option>
            <option value="02">febrero</option>
            <option value="03">marzo</option>
            <option value="04">abril</option>
            <option value="05">mayo</option>
            <option value="06">junio</option>
            <option value="07">julio</option>
            <option value="08">agosto</option>
            <option value="09">septiembre</option>
            <option value="10">octubre</option>
            <option value="11">noviembre</option>
            <option value="12">diciembre</option>
          </select>
        </td>
       
        <td>               
          
          <select name="c_supervisor" id="c_supervisor" class="caja_texto1">
            <option value="0">Escoger</option>       
            <?
			$sql7="select * from tb_supervisores where est=1";			
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
          </select>        
        </td>
        
        <td ><table width="263" border="0">
          <tr>
            <td width="94" class="caja_texto_pe" onclick="javascript:mostrar_bandejas_incidencias('1');">
            <img src="image/busca.jpg" width="25" height="25" onclick= />Buscar</td>
            <td width="109">&nbsp;</td>            
            <td width="46">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td valign="top" >
      </tr>
      <tr>
        <td colspan="4" class="celdas">&nbsp;</td>
      </tr>
    </table>
    
    <? } ?>
<p>
  <iframe id="f_incidencias"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
            width="100%"  scrolling="Auto"  height="500" > </iframe>
</body>
</html>