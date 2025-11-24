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
<P>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="caja_texto_pe">
 <tr>
 <td colspan="3" class="caja_texto_db">MODULO DE ASIGNACIONES COT - 101 </td>
 </tr>
  <tr>
    <td width="24%" valign="top">
	<table width="100%" border="0" class="caja_texto_pe">
      <tr>
        <td width="22%" class="caja_sb">ACTIVIDAD</td>
        <td width="78%">
		<select name="select" id="select" class="caja_texto_pe" onchange="javascript:visualizar_parametros(this.value)" >		
          <option value="0">Seleccionar</option>
		  <option value="ASIGNACIONES" selected>ASIGNACIONES</option>
          <option value="CANCELADAS">CANCELADAS</option>
         <!-- <option value="DUPLICADAS">DUPLICADAS</option>-->
          <option value="MIGRACIONES">MIGRACIONES</option>          
          <option value="REASIGNACIONES">REASIGNACIONES 47D</option>
        </select></td>
      </tr>
	  <tr>
        <td class="caja_sb">NRO.PEDIDO</td>
        <td><input name="pedido" type="text" class="caja_texto_pe" id="pedido" size="20" maxlength="20" onkeypress="GoEnter_contactos(event)" />
            <img src="image/busca.jpg" width="20" height="20" onclick="javascript:modal()" /></td>
      </tr>
	 </table>
	<div id="d_parametros_asignaciones" style="display:none">
	<table width="100%" border="0" class="caja_texto_pe">      
      <tr>
        <td class="caja_sb">ORIGEN</td>
        <td valign="top"><select name="t_carga" id="t_carga" class="caja_texto_pe" >
            <option value="0">Seleccionar</option>
            <option value="GESTEL-423">GESTEL</option>
            <option value="CMS">CMS</option>
          </select>
            <img src="image/baja.JPG" width="25" height="25" border="0" onclick="javascript:visualizar_pedido_v1('ASIGNACIONES')" /></td>
      </tr>
      <tr>
        <td class="caja_sb">ZONAL</td>
        <td><select name="zon" id="zon" class="caja_texto_pe" >
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
        </select></td>
      </tr>
      
    </table>
	</div>
	
	<div id="d_parametros_cancelaciones" style="display:none">
	<table width="100%" border="0" class="caja_texto_pe"> 
	<tr>
        <td class="caja_sb">CASUISTICA</td>
        <td><select name="caso" id="caso" class="caja_texto_pe" >
      <option value="PETICIONES">PETICIONES</option>
      <option value="REQUERIMIENTOS">REQUERIMIENTOS</option>
    </select><img src="image/baja.JPG" width="25" height="25" border="0" onclick="javascript:visualizar_pedido_v1('CANCELADAS')" /></td>
      </tr>     
      <tr>
        <td class="caja_sb">TIPO</td>
        <td valign="top"><select name="tipo" id="tipo" class="caja_texto_pe" >
      <option value="CANCELAR">CANCELAR</option>
      <option value="ONLINE">ONLINE</option>
      <option value="TOA">TOA</option>
      <option value="AGENDAR">AGENDAR</option>
      <option value="ALTO VALOR">ALTO VALOR</option>
      <option value="MOVTOTAL">MOVTOTAL</option>
      <option value="CRITICOS">CRITICOS</option>
      <option value="DIRECCION">DIRECCION</option>
      <option value="MAL EMITIDA">MAL EMITIDA</option>
      <option value="NO DESEA">NO DESEA</option>
      <option value="PREDICTIVO">PREDICTIVO</option>
      <option value="TRASLADO">TRASLADO</option>
      <option value="MIGRACIONES">MIGRACIONES</option>
    </select></td>
      </tr>
      
      
    </table>
	</div>
	
	<div id="d_parametros_migraciones" style="display:none">
	<table width="100%" border="0" class="caja_texto_pe"> 
	<tr>
        <td class="caja_sb">Migrar</td>
        <td><select name="migrar_a" id="migrar_a" class="caja_texto_pe" >
      	<option value="CLIENTE COBRE MIGRAR BA + VOZ (CALCULADORA)">MIGRAR COBRE - BA + VOZ</option>
      	<option value="CLIENTE HFC MIGRAR VOZ COBRE (PS: 22789)">MIGRAR HFC - VOZ COBRE</option>
      	<option value="CLIENTE SOLO VOZ COBRE (PS: 22789-22745-22791-2279">MIGRAR SOLO VOZ COBRE</option>	  	  
    	</select>
	<img src="image/baja.JPG" width="25" height="25" border="0" onclick="javascript:visualizar_pedido_v1('MIGRACIONES')" /></td>
      </tr>     
    </table>
	</div>
	
	
		
	</td>
	<td width="1%" >&nbsp;</td>
    <td width="75%" valign="top">
	<div id="d_pedido" style="display:none"></div>
	<div id="d_reasignaciones" style="display:none">
		<table width="100%" border="0" class="caja_texto_pe"> 
		<tr>
		  <td width="11%" valign="top" class="caja_sb">Telefono</td>
		  <td width="41%" valign="top"><input name="fono" type="text" class="caja_texto_pe" id="fono" size="20" maxlength="10"  /></td>
		  <td width="14%"><a id="bt_b1" class="cabeceras_grid" onclick="javascript:muestra_liq()"><img src="image/Search.gif" width="24" height="24" />Buscar</a>		  </td>
		  <td width="15%"><a id="bt_b2" class="cabeceras_grid" onclick="javascript:fin_reasignacion()" style="display:none">
		  <img src="image/visto3.jpg" width="24" height="24" />Guardar</a></td>
		  <td width="19%">&nbsp;</td>
		</tr>
		  <tr>
		  <td colspan="5">
		  <div id="p1" style="display:none">
				<table>  
				<tr>
				  <td valign="top" class="caja_sb">Accion</td>
				  <td valign="top"><select name="c_reasig" id="c_reasig" class="caja_texto_pe" >
					<option value="0">Seleccionar</option>
					<option value="TERMINADO">TERMINADO</option>
					<option value="SE CORTO LA LLAMADA">SE CORTO LA LLAMADA</option>
					<option value="VOLVERA A LLAMAR">VOLVERA A LLAMAR</option>
				  </select></td>
				  <td valign="top">&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>				
				  <tr>
					<td width="14%" valign="top" class="caja_sb">Cod.Comprobacion</td>
						<td width="38%" valign="top"><input name="c_comprobacion" type="text" class="caja_texto_pe" id="c_comprobacion" size="50" maxlength="50"  /></td>
						<td width="20%" valign="top">&nbsp;</td>
						<td width="28%">&nbsp;</td>
					</tr> 
			    </table>
		  </div>		  </td>
		  </tr>
		</table>	
	</div>
	</td>
  </tr>
</table>
<p>
<table width="80%" align="center">
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
		
	<tr>
	<td colspan="20">
	<p>
	<div id="bandeja_asignaciones" style="display:none"> 
	<iframe id="i_bandeja_asignaciones"  
    frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" 
    style="border-collapse:collapse"
    width="100%"  scrolling="Auto"  height="500"> 	
	</iframe>
	</div>
	</td>
	</tr>
</table>

<P>

</body>

