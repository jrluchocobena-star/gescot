<?php 
include("conexion_bd.php");
$iduser=$_GET["iduser"];
validar_logeo($iduser);

$nombre_423="d:/data_cot/Gestel423/glpl494_".date('Y-m-d').".txt";




//echo $nombre_47d;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js"></script>
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
	var pagina_envio="subir_archivo_maestra.php?iduser="+iduser;
	
	ajaxc = createRequest();
    ajaxc.open("get", pagina_envio, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 		
		//alert(ajaxc.responseText);<strong></strong>
		alert("Se Cargaron los registros a la maestra")
		
        }
	}
	ajaxc.send(null)
}
	
</script>
</head>

<body>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<p>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="caja_texto_pe" >

<tr>
  <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>panel_control.php</a>"; ?></td>
</tr>

  <tr>
    <td colspan="4" class="caja_texto_db">PROCESOS DE CARGA</td>
  </tr>
  <tr>
    <td width="3%" class="TitTablaI">&nbsp;</td>
    <td width="83%" class="TitTablaI">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><table width="100%" border="0" >
      <tr>
        <td width="152" class="cabeceras_grid" align="center">ORIGEN</td>
        <td width="285" class="cabeceras_grid" align="center">RUTA</td>
        <td width="111" class="cabeceras_grid" align="center">ULTIMA FECHA CARGA</td>
        <td width="89" class="cabeceras_grid" align="center"># ARCHIVOS</td>
        <td width="71" class="cabeceras_grid" align="center">&nbsp;</td>
        <td width="174" class="cabeceras_grid" align="center">ESTADO</td>
        <td width="87" class="cabeceras_grid" align="center"> MANUAL</td>
      </tr>
      <!-- CMS-->
      
      <tr>
        <?
			
			  //$ultimo_archivo_1 = leer_ult_archivo("A:/ASIGNACIONES/");
			  //$archivo_1	  = "A:/ASIGNACIONES/".$ultimo_archivo_1;	
			  $ultimo_archivo_1 = leer_ult_archivo("D:/COMPARTIDO/DATA/CMS/");
			  $archivo_1	  	= "D:/COMPARTIDO/DATA/CMS/".$ultimo_archivo_1;	
			  $archivo_cms		=	 $archivo_1.".csv";	
			  

			  $total_imagenes_1 = count(glob('D:/COMPARTIDO/DATA/CMS/{*.txt,*.gif,*.png,*.csv}',GLOB_BRACE));
			 
			  $c1	  	="SELECT COUNT(*) FROM carga_pedidos_total where origen='cms'";
			 // echo $c1;
			  $res_c1 	= mysql_query($c1) or die(mysql_error($c1));	
			  $reg_c1	= mysql_fetch_row($res_c1);
			  
			  $c_reg1="select count(*) from tb_cms";		  
			  $res_c_reg1 	= mysql_query($c_reg1) or die(mysql_error($c_reg1));	
			  $reg_c_reg1	= mysql_fetch_row($res_c_reg1);
			  
			  $hoy = date("Y-m-d");
			  
			  $f_carga_cms=date("Y m d H:i:s", filemtime($archivo_cms));
			  $f_carga = substr($f_carga_cms,0,4)."-".substr($f_carga_cms,5,2)."-".substr($f_carga_cms,8,2);
				  
			    
			
		  ?>
        <!- ORIGEN ->
        <td align="center" class="caja_sb">CMS</td>
        <!- RUTA ->
        <td class="caja_sb"><? echo $archivo_cms;?></td>
        <!- ULTIMA FECHA DE CARGA ->
        <td align="center" class="caja_sb"><?
				  if (file_exists($archivo_cms)) {
						$f_carga_cms=date("Y m d H:i:s", filemtime($archivo_cms));
						echo $f_carga_cms;
				} 
		  	  ?></td>
        <!- # CARGAS ->
        <td align="center" class="caja_sb"><? echo $total_imagenes_1." Files" ." | ".$reg_c_reg1[0]." registros"; ?></td>
        <td align="center" class="caja_sb">&nbsp;</td>
        <td align="center" class="caja_sb"><?  		  
		  if ($f_carga==$hoy){
			   if ($reg_c_reg1[0]>0){
				echo "<img src='image/vis.jpg' width='20' height='20' />Carga Ok";  
			  }else{
				echo "<img src='image/eliminar1.jpg' width='20' height='20' />No Cargo archivo";    
			  }
		  }else{			  
			  echo "<img src='image/eliminar1.jpg' width='20' height='20' />El archivo no es de la fecha de hoy";
			
		  }
			 
		  
		  ?></td>
        <td align="center" class="caja_sb"><img src="image/GIF_1.gif" width="30" height="30" onclick="javascript:proceso_manual('pc_cms')" /></td>
      </tr>
      <!-GESTEL 47D->
      <? 
			  
			  $zon="TRU";
              $dia=date('Y-m-d');		
			  $nombre_47d="d:/compartido/data/gestel_47d/GESTEL_47D_".$zon."_".$dia.".txt";
			  //echo $nombre_47d;
			  
			  		  
			  $hoy=date("Y-m-d");
			  $c_47d="select count(*) from gestel_47d where substr(fec_carga,1,10)='$hoy' and origen='TRU'";
			  //echo $c_47d;
			  $res_c_47d	= mysql_query($c_47d) or die(mysql_error($c_47d));	
			  $reg_c_47d	= mysql_fetch_row($res_c_47d);
			  
			  $total_imagenes_2 = count(glob('d:/compartido/data/gestel_47d/{*.txt,*.gif,*.png,*.csv}',GLOB_BRACE));			   
			   
			  ?>
      
      <tr>
        <!- ORIGEN ->
        <td align="center" class="caja_sb">GESTEL - 47D</td>
        <!- RUTA ->
        <td class="caja_sb"><? echo "D:/COMPARTIDO/DATA/GESTEL_47D/"; ?></td>
        <!- ULTIMA FECHA DE CARGA ->
        <td align="center" class="caja_sb"><?
				//echo $nombre_47d;
				if (file_exists($nombre_47d)) {
				$f_carga_47d=date("Y m d H:i:s", filemtime($nombre_47d));				
				echo $f_carga_47d;			
				}			
				?></td>
        <!- # CARGAS ->
        <td align="center" class="caja_sb"><? echo $total_imagenes_2." Files"; ?></td>
        <td align="center" class="caja_sb"><img id="b_G47D" src="image/up.JPG" width="40" height="25" onclick="javascript:mostrar_datos_carga('<? echo "G47D" ?>')" />
              <input name="sw_G47D" type="hidden" class="casilla_texto" id="sw_G47D" value="3"/></td>
        <td align="center" class="caja_sb"><? 
		 
			  if ($reg_c_47d[0]>0){
				echo "<img src='image/vis.jpg' width='20' height='20' />Carga Ok";  
			  }else{
				echo "<img src='image/eliminar1.jpg' width='20' height='20' />No Cargo archivo";    
			  }
		  
		  ?></td>
        <td align="center" class="caja_sb"><img src="image/GIF_1.gif" width="30" height="30" onclick="javascript:proceso_manual('gestel_47D')" /></td>
      </tr>
      <tr>
        <td colspan="7" align="center"><div id="G47D"></div></td>
      </tr>
      <!-- GESTEL 423-->
      <?			
				  $ultimo_archivo_2 = leer_ult_archivo("D:/data_cot/Gestel423/");
				  $archivo_2	  = "D:/DATA_COT/GESTEL423/".$ultimo_archivo_2;	
				  
				 //;
				 
				  //echo "D:/DATA_COT/GESTEL423/";
				  
			  ?>
      <tr>
        <!- ORIGEN ->
        <td align="center" class="caja_sb">GESTEL - 423</td>
        <!- RUTA ->
        <td class="caja_sb"><?  echo $archivo_2.".txt"	?></td>
        <td align="center" class="caja_sb"><? 
				  if (file_exists($nombre_423)) {
						$f_carga_423=date("Y m d H:i:s", filemtime($nombre_423));
						echo $f_carga_423;
				  }
		  			?></td>
        <? 
			$total_imagenes_3 = count(glob('D:/DATA_COT/GESTEL423/{*.txt,*.gif,*.png}',GLOB_BRACE));
//			echo $total_imagenes_3." Files";
		  ?>
              <? 
			  $c2	  	=" SELECT COUNT(*) FROM carga_pedidos_total where origen='GESTEL-423'";
			  //echo $c2;
			  $res_c2 	= mysql_query($c2) or die(mysql_error($c2));	
			  $reg_c2	= mysql_fetch_row($res_c2);
			  
		  	  $c_reg2="select count(*) from tb_gestel_423";
		  
			  $res_c_reg2 	= mysql_query($c_reg2) or die(mysql_error($c_reg2));	
			  $reg_c_reg2	= mysql_fetch_row($res_c_reg2);
			  
			  $hoy = date("Y-m-d");
			  
			  $f_carga_423 = substr($f_carga_423,0,4)."-".substr($f_carga_423,5,2)."-".substr($f_carga_423,8,2);
		
		  if ($reg_c_reg2[0]>1){ 	 		  
			  echo "<td align='center' class='caja_sb'>"; 
			  echo $total_imagenes_3." Files"." | " ."<a class='caja_sb'>$reg_c_reg2[0] registros</a>";
			  echo "</td>";
		  }else{
			  echo "<td align='center' class='caja_sb'>"; 
			  echo $total_imagenes_3." Files"." | " ."<a class='aviso'>$reg_c_reg2[0] registros</a>";
			  echo "</td>";		  
		  }
		  ?>
        <td align="center" class="caja_sb"><img id="b_G423" src="image/up.JPG" width="40" height="25" onclick="javascript:mostrar_datos_carga('<? echo "G423" ?>')" />
              <input name="sw_G423" type="hidden" class="casilla_texto" id="sw_G423" value="3"/></td>
        <td align="center" class="caja_sb"><? 
			  
			  if ($f_carga_423==$hoy){
				   if ($reg_c_reg2[0]>0){
					echo "<img src='image/vis.jpg' width='20' height='20' />Carga Ok";  
				  }else{
					echo "<img src='image/eliminar1.jpg' width='20' height='20' />No Cargo archivo";    
				  }
			  }else{			  
				  echo "<img src='image/eliminar1.jpg' width='20' height='20' />El archivo no es de la fecha de hoy";
				
			  }
		  
		  ?></td>
        <td align="center" class="caja_sb"><img src="image/GIF_1.gif" width="30" height="30" onclick="javascript:proceso_manual('gestel_423')" /></td>
      </tr>
      <tr>
        <td colspan="7"  align="center"><div id="G423" style="display:none"></div></td>
      </tr>
    </table></td>
  </tr>
  <!--
  <tr>
    <td colspan="4" class="enc_grid">INPUT</td>
  </tr>
  <tr>
    <td class="TitTablaI">&nbsp;</td>
    <td class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="TitTablaI"><img src="image/GIF_1.gif" width="50" height="50" /></td>
    <td class="TitTablaI">CARGA MANUAL DE PEDIDOS PENDIENTES ASIGNACIONES</td>
    <td><span class="TitTablaI">GESTEL OPC. 423</span></td>
    <td class="clsDataArea">Este proceso se ejecuta manualmente, siempre y cuando el archivo del dia, se encuentra alojado en el compartido.</td>
  </tr>
  <tr>
    <td class="TitTablaI">&nbsp;</td>
    <td class="TitTablaI">&nbsp;</td>
    <td class="TitTablaI">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td class="TitTablaI"><img src="image/GIF_1.gif" alt="" width="50" height="50" /></td>
    <td class="TitTablaI">CARGA MANUAL DE PEDIDOS PENDIENTES CMS</td>
    <td class="TitTablaI">CMS OPC.</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="6%">&nbsp;</td>
    <td width="46%">&nbsp;</td>
    <td width="19%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
  </tr>
  -->
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="30%" height="17" valign="top" class="caja_sb">&nbsp;</td>
        <td width="41%">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="caja_texto_pe">
  <tr>
    <td colspan="9" class="caja_texto_db">REPORTES</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" valign="top" class="TitTablaI">&nbsp;</td>
    <td width="10%" valign="top" class="caja_texto_pe">ANO</td>
    <td width="5%" valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">MES</td>
    <td valign="top">&nbsp;</td>
    <td align="center" class="caja_texto_pe">REPORTE</td>
    <td valign="top">&nbsp;</td>
    <td width="6%" rowspan="3" align="center" valign="middle"><img src="image/baja.JPG" width="40" height="40" onclick="reporte_general()"/></td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td width="10%" valign="top"><select name="xano" class="caja_texto_est" id="xano" >
      <option value="0">ESCOGER..</option>
      <option value="2018">2018</option>
      <option value="2019">2019</option>
      <option value="2020">2020</option>
    </select></td>
    <td valign="top" class="TitTablaI">&nbsp;</td>
    <td width="11%" valign="top"><select name="xmes" class="caja_texto_est" id="xmes">
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
    <td width="3%" valign="top" class="TitTablaI">&nbsp;</td>
    <td width="37%" valign="top">
	<select name="xreporte" class="caja_texto_est" id="xreporte" onchange="javascript:validar_opc('1')" >
      <option value="0">ESCOGER...</option>
      <option value="423">1) GESTEL 423 - ASIG.PENDIENTES-ACUMULADO DEL MES</option>
      <!--<option value="423P">GESTEL 423 - ASIG.PENDIENTES-PROV</option>-->
      <option value="47D">2) GESTEL 47D - REASIGNACIONES ACUMULADO DEL MES</option>
      <option value="CONSULTAS_CONTACTOS">3) MOVIMIENTO DE CONSULTA DE CONTACTOS</option>
      <option value="CONSULTAS_MAESTRA">4) REPORTE DE MAESTRA DE USUARIOS COT</option>
      <option value="INCIDENCIAS COT">5) INCIDENCIAS ADMINISTRATIVAS PERSONAL COT</option>-->
      <!-- 
	  <option value="INCIDENCIAS SISTEMAS">5) INCIDENCIAS DE SISTEMAS</option>
      option value="CAPACITACION">6) REPORTE DE CAPACITACIONES COT</option>-->
      <option value="ATENCION VIA CORREO">6) ATENCION VIA CORREO(MODEM AVERIADOS)</option>
      <option value="ASIGNACIONES TRABAJADAS">7) REPORTE DE ASIGNACIONES TRABAJADAS</option>
      <!--<option value="HORAS PROGRAMADAS">8) REPORTE DE PROGRAMACION DE HORAS EXTRAS</option>-->
    </select></td>
    <td width="4%" align="center">&nbsp;</td>
    <td width="23%" valign="top"><div id="n_archivo" style="display:none">
      <input name="text" type="text" class="caja_sb" id="archivo2"  size="60" />
      <img src="image/dowload.jpg"width="40" height="40" onclick="javascript:abrir_exp('1')"/></div></td>
  </tr>
</table>
<br>

<? if ($idperfil=="0"){ ?>

<table width="80%" class="caja_texto_pe" align="center">
 <tr>
    <td colspan="3" class="caja_texto_db">SUBIR ARCHIVO MAESTRA ACTUALIZADA</td>
  </tr>
 
  <tr>
    <td width="25%" valign="top" class="caja_sb">1.- MAESTRA </td>
    <td width="31%" valign="top" class="textos_urgentes"><span class="caja_sb">
	<a href="javascript:sube_archivo_maestra()"><img src="image/adjuntar.JPG" alt="" width="30" height="30" border="0" /></a></span></td>
    <td width="44%" valign="top" class="textos_urgentes">&nbsp;</td>
  </tr>
 
   <tr>
     <td colspan="3" valign="top">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top" class="caja_sb">1.- CANCELADAS </td>
     <td valign="top" class="textos_urgentes"><span class="caja_sb"><a href="javascript:proceso_carga_varios('1')"><img src="image/adjuntar.JPG" alt="" width="30" height="30" border="0" /></a></span></td>
     <td valign="top" class="textos_urgentes">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top" class="caja_sb">&nbsp;</td>
     <td valign="top" class="textos_urgentes">&nbsp;</td>
     <td valign="top" class="textos_urgentes">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top" class="caja_sb">2.- MIGRACIONES </td>
     <td valign="top" class="textos_urgentes"><span class="caja_sb"><a href="javascript:proceso_carga_varios('2')"><img src="image/adjuntar.JPG" alt="" width="30" height="30" border="0" /></a></span></td>
     <td valign="top" class="textos_urgentes">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top" class="caja_sb">&nbsp;</td>
     <td valign="top" class="textos_urgentes">&nbsp;</td>
     <td valign="top" class="textos_urgentes">&nbsp;</td>
   </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla_bandeja">
  <tr>
    <td colspan="2" class="enc_grid">RESETEO DE TABLAS ASIGNACIONES</td>
  </tr>
  <tr>
    <td width="37%" class="fdoceldastxt">RESETEAR TABLAS GESTEL Y CMS</td>
    <td width="63%"><img src="image/act.jpg" width="25" height="30" onclick="javascript:resetear_tablas();" /></td>
  </tr>
</table>
&nbsp;
<table width="100%" border="0" cellpadding="1" cellspacing="1" class="marco_tabla_bandeja">

  <tr>
    <td class="enc_grid">SUBIR ARCHIVOS DE BO-LIQUIDACION</td>
  </tr>
  <tr>
    <td><input name="archivo" type="file" class="etiqueta" id="archivo" value="" size="60"/>
   <a class="boton_3" onclick="javascript:sube_archivo()">Subir</a></td>
  </tr>

  <tr>
    <td class="enc_grid">SUBIR ARCHIVO BANDEJA VERDES </td>
  </tr>
  <tr>
    <td>
 <form action="subir_archivo.php" method="post" enctype="multipart/form-data">  
 <input type="file" name="archivo" id="archivo" ></input>
 <input type="submit" value="Subir archivo"></input>
 </form> </td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="1" cellspacing="1" class="marco_tabla_bandeja">

  <tr>
    <td class="enc_grid">SUBIR ARCHIVOS DE BO-LIQUIDACION</td>
  </tr>
  <tr>
    <td><input name="archivo" type="file" class="etiqueta" id="archivo" value="" size="60"/>
   <a class="boton_3" onclick="javascript:sube_archivo()">Subir</a></td>
  </tr>

 
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>


<? } ?>
</body>
</html>