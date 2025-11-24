<?php
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
$pc=$_GET["pc"];
	
	  $server  		= "10.226.4.214";
	  $database 	= "dbi_cot";
	  $user  		= "ic_lcobena";
	  $password 	= "Lc0b3n4#";
	  //$password 	= "asdasdas$";

	  $connection = odbc_connect("Driver={Teradata DataBase ODBC Driver 16.20};DBCNAME=$server;Database=$database;", $user, $password);
	 	
	  if (!$connection){
	  // exit("Connection Failed - ".odbc_error().": error".odbc_errormsg()."\n");  
	   //header("location: http://localhost/cot/relogeo.php");
	  	$swith="0";
	  }else {
			if ($error==28000){
		     echo "Alerta: los datos de conexion erroneos. Verificar clave de conexion";
			}else{
			 include ("conexion_bd.php"); 
			 validar_logeo($iduser);
			 $swith="1";
			}
	 }
	 //echo $swith;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="javascript1.2" type="text/javascript" src="funciones_js.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>


</head>

<body>
<input name="usu_contactos" type="text" class="caja_sb_st" id="usu_contactos" value="<?php echo $iduser; ?>" size="30"/>
<input name="idperfil" type="text" class="caja_sb_st" id="idperfil" value="<?php echo $idperfil; ?>" size="30"/>
<table width="90%" align="center">
  <tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>cab_numero_contactos_tdata.php</a>"; ?></td>
  </tr>
  <tr>
    <td colspan="17" class="caja_texto_db">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="17" class="adaptado">EN ESTE MODULO SE MOSTRARA TODOS LOS NUMEROS TELEFONICOS QUE EL CLIENTE INDICA COMO NUMERO DE CONTACTO, SEA NUMERO FIJO Y/O NUMERO DE CELULAR DE CUALQUIER OPERADOR (CLARO, MOVISTAR, ETC).</td>
  </tr>
  <tr>
    <td width="121" class="cabeceras_grid" ><strong>PEDIDO</strong></td>
    <td width="247" class="cabeceras_grid" ><strong>NUMERO DE DNI /RUC/CEX</strong></td>
    <td width="181" class="cabeceras_grid"><strong>NUMERO CONTACTO</strong></td>
    <td width="158" class="cabeceras_grid"><strong>APE. PATERNO</strong></td>
    <td width="158" class="cabeceras_grid"><strong>APE.MATERNO</strong></td>
    <td colspan="8" class="cabeceras_grid"><strong>PANEL
      <input name="timpo" type="hidden" class="" id="timpo" size="8" />
      <input name="bdatos" type="text" class="" id="bdatos" size="8" readonly />
    </strong></td>
  </tr>
  <tr>
    <td ><input name="pedido" type="text" class="caja_texto_pe" id="pedido" size="20" maxlength="20" /></td>
    <td ><input name="dni" type="text" class="caja_texto_pe" id="dni" size="20" maxlength="20" /></td>
    <td><input name="ncontacto" type="text" class="caja_texto_pe" id="ncontacto" size="20"  /></td>
    <td><input name="ape_pat" type="text" class="caja_texto_pe" id="ape_pat" size="30" /></td>
    <td align="center"><input name="ape_mat" type="text" class="caja_texto_pe" id="ape_mat" size="30"/></td>
	   
  <?php
 // echo $swith;
	  if ($swith=="0"){
	   ?>
	   <td width="83" class="caja_texto_pe" onclick="javascript:buscar_contacto()">
	   <img src="image/buscado.jpg" alt="" width="30" height="30" />
	   Buscar</td>
	  <?php
	  }else{
  
	  $d_hoy	=date("w");
	  $hora 	=date("h:m");
	  
	 
	  if ($d_hoy=="7"){	// si es domingo
  ?>
  	 <td width="83" class="caja_texto_pe" onclick="javascript:buscar_contacto()"><img src="image/busca.jpg" alt="" width="30" height="30" />
	 Buscar</td>
 	
<?php }else{ 
  		if ($d_hoy=="6"){?> 
 	 <td width="83" class="caja_texto_pe" onclick="javascript:buscar_contacto()"><img src="image/buscado.jpg" alt="" width="30" 
	 height="30" /> Buscar</td>
        
 <?php	}else{ ?> 
   	<td width="83" class="caja_texto_pe" onclick="javascript:buscar_contacto_tdata()">
	<img src="image/busca3.jpg" alt="" width="30" height="30" />
	Buscar</td>
   <?php } 
     }
   }?>  
   
   
   
    <td width="100" class="caja_texto_pe" onclick="javascript:nuevo_nro_contacto()"><img src="image/usumas.jpg" width="30" height="30" /> Contacto</td>
    <td width="81" class="caja_texto_pe" ><img src="image/reg3.jpg" width="30" height="30" onclick="javascript:nueva_busqueda()"/>Limpia</td>
  </tr>
  <tr>
    <td colspan="17" class="caja_texto_db" >&nbsp;</td>
  </tr>
</table>
<table width="90%" border="0" align="center">	
  <tr>
    <td>
	<div id="barra_cargando" style="float:block; display:none" align="center">
	</div>
	</td>
  </tr>
  <tr>
    <td><div id="div_lista_contactos" style="width:100%; height:300px;overflow:auto"></div>	</td>
  </tr>
  <tr>
    <td><input name="apuntado" type="hidden" id="apuntado"/>      
    <div id="d_historico_contactos" style="width:100%; height:400px; overflow:auto; display:none" align="center"></div></td>
  </tr>
</table>
<p>
<div id="div_registro_contacto" style="display:none">
<table width="90%" border="0" class="marco_tabla" align="center">
  <tr class="caja_texto_color">
    <td width="9%" class="caja_texto_db" >DNI</td>
    <td width="38%" class="caja_texto_db">APE.PAT</td>
    <td width="38%" class="caja_texto_db">APE.MAT</td>
    <td width="38%" class="caja_texto_db">NOMBRES</td>
    <td width="38%" class="caja_texto_db">TELEFONO</td>
    <td width="45%" class="caja_texto_db">OPERADOR</td>
    <td width="8%" class="caja_texto_db">GUARDAR</td>
  </tr> 
  <tr>
    <td><input name="dni_new" type="text" class="caja_texto_est" id="dni_new"  size="20" maxlength="9"  /></td>
    <td><input name="pat_new" type="text" class="caja_texto_est" id="pat_new" size="30"  /></td>
    <td><input name="mat_new" type="text" class="caja_texto_est" id="mat_new"  size="30"  /></td>
    <td><input name="nom_new" type="text" class="caja_texto_est" id="nom_new"  size="30"  /></td>
    <td><input name="fono_new" type="text" class="caja_texto_est" id="fono_new" size="20" maxlength="9" /></td>    
    <td><select name="oper_new" id="oper_new" class="caja_texto_est" >
      <?php 			
			print "<option value='0' selected>Seleccione Operador</option>";
			$sql7="select * from tb_operadores_moviles";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[1]'>$rowper[1]</option>";
			}
			?>
    </select></td>
    <td class="caja_texto_est"><img src="image/BT4.gif" alt="" width="30" height="30" onclick="javascript:reg_nuevo_contacto_tdata()" /></td>
  </tr>
</table>
</div>



<!--
<div id="d_editar_contactos" style="width:100%; height:100px; display:none">
</div>	-->

</body>
</html>