<?php
include("conexion_bd.php");
$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
//validar_logeo($iduser);

  	  $server  		= "10.226.4.214";
	  $database 	= "dbi_cot";
	  $user  		= "ic_lcobena";
	  $password 	= "Lc0b3n4#";

	  //$connection = odbc_connect("Driver={Teradata DataBase ODBC Driver 16.20};DBCNAME=$server;Database=$database;", $user, $password);
	
	  //echo $connection;
	
	 // if (!$connection){
	               // exit("Connection Failed - ".odbc_error().": error".odbc_errormsg()."\n");  
	               //header("location: http://localhost/cot/relogeo.php");
	  // echo "";
	  //	$swith="0";
	  //} 
	 // else {
	                 // echo "Conectado a TERADATA OK";
	 	 //include ("conexion_bd.php"); 
		// validar_logeo($iduser);
		// $swith="1";
	//  }
	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script src="./js/jquery-3.5.1.min.js"></script>
<script language="javascript" src="funciones_js.js"></script>

</head>

<body>
<input name="iduser" type="text" class="caja_sb_st" id="iduser" value="<?php echo $iduser; ?>" size="30"/>

<table width="90%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
  <tr >
    <td width="12%" height="18" class="cabeceras_grid">DNI</td>
    <td colspan="3" class="cabeceras_grid"><span class="caja_texto_pe">
      <input name="dni" id="dni" type="text" class="caja_texto_cb"  onkeypress="busca_dni(event);" size="20" maxlength="8" />
    (8 digitos) </span></td>
    <td width="17%" class="caja_texto_pe"><a><img src="image/Symbol-Error.gif" width="30" height="30" onclick="javascript:cerrar_ventana_maestra()" />Cerrar</a></td>
    <td width="21%" class="caja_texto_pe"><a class="caja_texto_pe">
      <?php if ($swith=="0"){ ?>
      <img src="image/busca3.jpg" width="30" height="30" onclick="javascript:buscar_reniec('1')" />BUSCAR</a>
      <?php }else{ ?>
      <img src="image/busca1.jpg" width="30" height="30" onclick="javascript:buscar_reniec('1')" />BUSCAR</a>
      <?php } ?></td>
    <td width="23%" class="caja_texto_pe"><a id="bt_grabar_usu" style="display:none" class="caja_texto_pe"> <img src="image/vis.jpg" alt="" width="30" height="30" onclick="javascript:registrar_usuario()" />GUARDAR</a></td>
  </tr>
</table>

<table width="90%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
  <tr>
    <td height="29" colspan="7"><div id="datos_reniec"></div></td>
  </tr>
  <tr>
    <td width="29%" class="cabeceras_grid">CIP</td>
    <td width="24%" class="cabeceras_grid">LOGIN</td>
    <td width="17%" class="cabeceras_grid">CLAVE</td>
    <td width="30%" class="cabeceras_grid">PERFIL</td>
    
  </tr>  
  <tr>
    <td class="caja_texto_pe"><input name="cip" id="cip" type="text" class="caja_texto_cb"  onkeypress="return justNumbers(event);" size="20" maxlength="9" />
(9digitos)</td>
    <td class="caja_texto_pe"><input name="login" type="text" class="caja_texto_cb" id="login" size="20" /></td>
    <td class="caja_texto_pe"><input name="clave" type="text" class="caja_texto_cb" id="clave" size="20" /></td>
    <td class="caja_texto_pe">
	<select name="perfil" id="perfil" class="caja_texto_cb" >
      <?php 			
			print "<option value='0' selected>Seleccione Perfil</option>";
			$sql7="select * from tb_cargos";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[2]</option>";
			}
			?>
    </select></td>
	  
 </tr>
 <tr>
 
	<td class="cabeceras_grid">GRUPO</td>
    <td class="cabeceras_grid">SUPERVISOR</td>
    <td class="cabeceras_grid">&nbsp;</td>
	<td class="cabeceras_grid">&nbsp;</td>
</tr>
	
<tr>
	 <td class="caja_texto_pe">
	<!--
	<select name="grupo" class="caja_texto_cb" id="grupo">
      <option value="0">Escoger</option>
      <option value="COT-TDP">COT-TDP</option>
      <option value="TDP">TDP</option>
      <option value="ATENTO">ATENTO</option>
      <option value="EECC">EECC</option>
    </select>
		-->
	<select name="grupo" class="caja_texto_cb" id="grupo">
      <option value="0">Escoger</option>
      <option value="BACK-OFFICE">BACK-OFFICE</option>
      <option value="STC">STC</option>
      <option value="ROBOT">ROBOT</option>
      <option value="INDRA">INDRA</option>
	  <option value="ATENTO">ATENTO</option>
	  <option value="OTROS">OTROS</option>
    </select>
	</td>
    <td class="caja_texto_pe"><select name="super" id="super" class="caja_texto_cb" >
      <?php
                                    print "<option value='0' selected>Seleccione Supervisor</option>";
                                    $sql7 = "SELECT * FROM tb_usuarios WHERE perfil='3' AND estado='habilitado'";
                                    $queryresult7 = mysql_query($sql7) or die(mysql_error());
                                    while ($rowper = mysql_fetch_row($queryresult7)) {
                                        print "<option value='$rowper[0]'>$rowper[1]</option>";
                                    }
                                    ?>
    </select></td>
    <td class="caja_texto_pe">&nbsp;</td>
  </tr>
</table>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
</body>
</html>
