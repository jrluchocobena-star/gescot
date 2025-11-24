<!DOCTYPE html>
<script language="javascript" src="../funciones_js.js"></script>

<script type="text/javascript">

function sube_archivo() {
	//alert("entro")
	var pagina_envio="subir_archivo.php";
	$("#miform").attr("action", pagina_envio);
    //$("#miform").submit();
}

function sube_archivo_maestra() {
	var iduser = document.getElementById("iduser").value;	
	//alert("entro")
	var pagina_envio="../subir_archivo_maestra.php?iduser="+iduser;
	
	ajaxc = createRequest();
    ajaxc.open("get", pagina_envio, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 		
		alert(ajaxc.responseText);
		//alert("Se Cargaron los registros a la maestra")
		
        }
	}
	ajaxc.send(null)
}
	
</script>


<html>
<head>
  <title>Subir Archivo Maestra COT</title>
<link href="../estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<P>
<P>
<!--
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td class="cabeceras_grid">Modulo de Carga de Usuarios COT</td>
  </tr>
  <tr>
    <td class="cabeceras_grid">  
	<?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
  <form method="POST" action="upload_3.php" enctype="multipart/form-data">
    <div>
      <span>Seleccionar Maestra:</span>
      <input type="file" name="uploadedFile" />
    </div>
 
    <input type="submit" name="uploadBtn" value="Subir" />
  </form>
	</td>
  </tr>
</table>
-->

<p>
<table width="100%" border="0"  cellpadding="0" cellspacing="0" class="caja_texto_pe">
  <tr>
    <td colspan="8" class="cabeceras_grid">REPORTES</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td ><input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
    <input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td width="3%" valign="top" class="TitTablaI">&nbsp;</td>
    <td width="15%" valign="top" class="caja_texto_pe">ANO</td>
    <td width="3%" valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">MES</td>
    <td valign="top">&nbsp;</td>
    <td align="left" class="caja_texto_pe">REPORTE</td>
    <td valign="top">&nbsp;</td>
    <td width="9%" rowspan="3" align="center" valign="middle"><img src="../image/baja.JPG" width="30" height="30" onClick="reporte_general()"/></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td width="15%" valign="top"><select name="xano" class="caja_texto_est" id="xano" >
      <option value="0">ESCOGER..</option>
      <option value="2018">2018</option>
      <option value="2019">2019</option>
      <option value="2020">2020</option>
    </select></td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td width="18%" valign="top"><select name="xmes" class="caja_texto_est" id="xmes">
      <option value="0">ESCOGER...</option>
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
    </select></td>
    <td width="2%" valign="top" class="TitTablaI">&nbsp;</td>
    <td width="43%" valign="top">
	<select name="xreporte" class="caja_texto_est" id="xreporte" onChange="javascript:validar_opc('1')" >
      <option value="0">ESCOGER...</option>
      <option value="423">1) GESTEL 423 - ASIG.PENDIENTES-ACUMULADO DEL MES</option>
      <!--<option value="423P">GESTEL 423 - ASIG.PENDIENTES-PROV</option>-->
      <option value="47D">2) GESTEL 47D - REASIGNACIONES ACUMULADO DEL MES</option>
      <option value="CONSULTAS_CONTACTOS">3) REPORTE DE CONTACTABILIDAD</option>
      <option value="CONSULTAS_MAESTRA">4) REPORTE DE MAESTRA DE USUARIOS COT</option>
      <option value="INCIDENCIAS COT">5) INCIDENCIAS ADMINISTRATIVAS PERSONAL COT</option>-->
      <!-- 
	  <option value="INCIDENCIAS SISTEMAS">5) INCIDENCIAS DE SISTEMAS</option>
      option value="CAPACITACION">6) REPORTE DE CAPACITACIONES COT</option>-->
      <option value="ATENCION VIA CORREO">6) ATENCION VIA CORREO(MODEM AVERIADOS)</option>
      <option value="ASIGNACIONES TRABAJADAS">7) REPORTE DE ASIGNACIONES TRABAJADAS</option>
      <!--<option value="HORAS PROGRAMADAS">8) REPORTE DE PROGRAMACION DE HORAS EXTRAS</option>-->
    </select></td>
    <td width="7%" align="center">&nbsp;</td>
  </tr>
</table>
<p>
<table width="100%" class="caja_texto_pe">
  <tr>
    <td colspan="3" class="cabeceras_grid">SUBIR ARCHIVO MAESTRA ACTUALIZADA</td>
  </tr>
  <tr>
    <td width="25%" valign="top" class="caja_sb">1.- CARGA MASIVA DE LA MAESTRA COT </td>
    <td width="7%" valign="top" class="textos_urgentes"><span class="caja_sb"> <a href="javascript:sube_archivo_maestra()"><img src="../image/upload1.jpg" alt="" width="30" height="30" border="0" /></a></span></td>
    <td width="68%" valign="top" class="caja_texto_pe"><p>Pasos a seguir:</p>
    <p>1.- Colocar el archivo en la carpeta compartida \\10.226.5.114\\FS-Principal\\Dir_Marketing\\Ger_Consumo_de_Terminales_y_Banda_Ancha\\Jefatura_de_Terminales\\000Cot\\zz_InputsExternos\\WebGescot\\Input_Maestra\\maestra_cot_102020.csv</p>
    <p>2.- Verificar que la informacion del archivo coincida con las columnas correspondientes.</p>
    <p>3.-Darle click al boton <img src="../image/upload1.jpg" alt="" width="20" height="20" border="0" /></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>