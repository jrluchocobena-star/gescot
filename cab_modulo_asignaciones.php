<?php
include_once("conexion_bd.php");
include_once("funciones_fechas.php");
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		
validar_logeo($iduser);

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

<script language='javascript1.2' type='text/javascript'>

function modal() {	
	var pedido = document.getElementById("pedido").value;
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	
	if ( document.getElementById("pedido").value =="" ){
		alert("Ingrese Numero de pedido")
		return	
	}else{
	var	pagina_envio="info_asignaciones.php?pedido="+pedido+"&iduser="+iduser+"&idperfil="+idperfil;
	var atributos="status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no,top=200,left=200,width=1000,height=200";
	}
	//alert(pagina_envio);
	
	var win = window.open(pagina_envio,"",atributos);	
}


</script>


<link href="estilos.css" rel="stylesheet" type="text/css" />
<title></title>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr>
  <td colspan='8' class='contador'>MODULO DE ASIGNACIONES</td>
</tr>
<tr>
  <td colspan="5">&nbsp;</td>
</tr>
<tr>
  <td colspan="5"><table width="100%" border="0">
    <tr>
      <td width="9%" class="caja_texto_cb">ZONAL </td>
      <td width="20%"  class="caja_texto_cb">
        <select name="zon" id="zon" class="caja_texto_pe" >
          <option value="0">TODAS</option>
          <option value="AMA">AMA|AMAZONAS</option>
          <option value="APU">APU|APURIMAC</option>
          <option value="ARE">ARE|AREQUIPA</option>
          <option value="AYA">AYA|AYACUCHO</option>
          <option value="CAJ">CAJ|CAJAMARCA</option>
          <option value="CHI">CHI|CHICLAYO</option>
          <option value="CTE">CTE|CHIMBOTE</option>
          <option value="CUS">CUS|CUSCO</option>
          <option value="HCV">HCV|HUANCAVELICA</option>
          <option value="HNC">HNC|HUANUCO</option>
          <option value="HUA">HUA|HUANCAYO</option>
          <option value="ICA">ICA|ICA</option>
          <option value="LIM">LIM|LIMA</option>
          <option value="LOR">LOR|LORETO</option>
          <option value="MDD">MDD|MADRE DE DIOS</option>
          <option value="MOQ">MOQ|MOQUEGUA</option>
          <option value="PAS">PAS|PASCO</option>
          <option value="PIU">PIU|PIURA</option>
          <option value="PUN">PUN|PUNO</option>
          <option value="SMT">SMT|SANMARTIN</option>
          <option value="TAC">TAC|TACNA</option>
          <option value="TRU">TRU|TRUJILLO</option>
          <option value="TUM">TUM|TUMBES</option>
          <option value="UCA">UCA|UCAYALI</option>
          <option value="IQU">IQU|IQUITOS</option>
          </select>
        </span></td>
      <td width="6%" class="caja_texto_cb">ORIGEN </td>
      <td width="19%"  class="caja_texto_cb">
        <select name="t_carga" id="t_carga" class="caja_texto_pe" >
          <option value="0">ESCOGER</option>
          <option value="GESTEL-423">GESTEL</option>
          <option value="CMS">CMS</option>
          </select>
        </span></td>
      <td width="4%" class="caja_texto_cb" align="center"><img src="image/upload.JPG" width="30" height="30" onclick="javascript:mostrar_pedido()" /></td>
      <td width="42%">
        <? if ($idperfil!="1"){ ?>
        <table width="80%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
          <tr>
            <td colspan="3" valign="top" class="btn_2">BUSQUEDA</td>
            </tr>
          <tr>
            <td width="2%" valign="top" class="etiqueta_p">&nbsp;</td>
            <td width="27%" valign="top" class="etiqueta_p">NRO.PEDIDO</td>
            <td width="71%">
              <input name="pedido" type="text" class="caja_texto_cb" id="pedido" size="20" maxlength="20" onkeypress="GoEnter_contactos(event)" />
              <img src="image/busca.jpg" width="20" height="20" onclick="javascript:modal()" /></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          </table>
        <? } ?></td>
      </tr>
    </table></td>
</tr>
<tr>
  <td colspan="5"></td>
</tr>
<tr>
  <td colspan="5">&nbsp;</td>
  </tr>
<tr>
  <td><table width="100%" border='0'>
    <tr>      
        <tr>
          <td colspan="10" class="celdas_detalle_guias">&nbsp;</td>
        </tr>
        <? if ($idperfil=="1" ){?>
        <tr>
          <td width="14%" class="caja_texto_pe" onclick="javascript:listar_bandeja_asignaciones_pend('1','<? echo $iduser; ?>','<? echo $idperfil; ?>');"><img src="image/reg2.jpg" width="20" height="20" />PEDIDOS TRABAJADOS</td>
          <td width="1%" >&nbsp;</td>
          <td width="18%" >&nbsp;</td>
          <td width="1%" >&nbsp;</td>
          <td width="13%" >&nbsp;</td>
          <td width="14%" >&nbsp;</td>
          <td width="18%" >&nbsp;</td>
        </tr>
        <? }else{ ?>
        <tr>
          <td width="14%" class="caja_texto_pe" onclick="javascript:listar_bandeja_asignaciones_pend('1','<? echo $iduser; ?>','<? echo $idperfil; ?>');"><img src="image/reg2.jpg" width="20" height="20" />PEDIDOS TRABAJADOS</td>
          <td width="1%" >&nbsp;</td>
          <td width="14%" class="caja_texto_pe" onclick="javascript:listar_bandeja_asignaciones_pend('2','<? echo $iduser; ?>','<? echo $idperfil; ?>');"><img src="image/LISTAS.JPG" width="20" height="20" />PEDIDOS PENDIENTES</td>
          <td width="1%" >&nbsp;</td>
          <td width="14%" class="caja_texto_pe" 
          onclick="javascript:popup_reclamo('9','','<? echo $iduser; ?>',
          '<? echo $idperfil; ?>','<? echo "VISTA 1"; ?>','')">      
		  <img src="image/TECNICO.jpg" width="25" height="25" />
          VISTA 1
          </td>
          <td width="14%" class="caja_texto_pe" 
          onclick="javascript:popup_reclamo('10','','<? echo $iduser; ?>',
          '<? echo $idperfil; ?>','<? echo "VISTA 2"; ?>','')">      
		  <img src="image/Symbol-Error.gif" width="25" height="25" />
          VISTA 2
          </td>          
          <td width="1%" >&nbsp;</td>
          <td width="13%" class="caja_texto_pe" onclick="javascript:exportar_reporte_modulo('<? echo $iduser; ?>','4');"><img src="image/EXCELES.JPG" width="20" height="20" />R.PEDIDOS CARGADOS</td>
          <td width="14%" class="caja_texto_pe" onclick="javascript:exportar_reporte_modulo('<? echo $iduser; ?>','5');"><img src="image/EXCELES.JPG" width="20" height="20" />R.GESTEL 423 DEL DIA</td>
          <td width="21%" >&nbsp;</td>
        </tr>
        <? } ?>     
      </table></td>
    </tr>
  </table></td>
</tr>    
  </table> 
   </td>
</tr> 
</table>
<div id="d_pedido" style="display:none"></div>

<div id="bandeja_asignaciones" style="display:none"> 
	<iframe id="i_bandeja_asignaciones"  
    frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" 
    style="border-collapse:collapse" class="marco_tabla"
    width="100%"  scrolling="Auto"  height="500"> 
	</iframe>
</div>

