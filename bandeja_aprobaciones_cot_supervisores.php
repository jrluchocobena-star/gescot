<?php
include("conexion_bd.php");
$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

//echo $idperfil;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<!--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
<script language="javascript" src="	funciones_js.js"></script> 
<script language="JavaScript" src="calendar1.js"></script>


<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<script language="JavaScript1.2" src="bandejas/table.js"></script>
<script language="JavaScript1.2" src="bandejas/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="bandejas/table.css" media="all">

</head>

<body>	

<input name="arr_escogidos" type="hidden" class="casilla_texto" id="arr_escogidos" /><br>
<input name="arr_hor" type="hidden" class="casilla_texto" id="arr_hor" />
<input name="cip" type="hidden" class="casilla_texto" id="cip" value="<?php echo $reg[3];?>" />
<input name="dni" type="hidden" class="casilla_texto" id="dni" value="<?php echo $reg[4];?>" />
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser;?>" />
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil;?>" />
<input name="tp_incidencia" type="hidden" class="casilla_texto" id="tp_incidencia" value="<?php echo "MONITOREO Y CAPACITACION COT";?>" />
<input name="c_inc" type="hidden" class="casilla_texto" id="c_inc" value="<?php echo $franqueo;?>" />
<input name="chk_escogidos" type="hidden" class="caja_texto_sb" id="chk_escogidos" />
<input name="tt_c" type="hidden" class="caja_texto_sb" id="tt_c" />
<input name="chk_escogidos_" type="hidden" class="caja_texto_sb" id="chk_escogidos_" />

	
	
<!--	
<table width="100%" border="0"> 
	<tr>
    <td colspan="17" class="texto_sb"><?php echo "Formulario: <a class='texto_sb'>bandeja_aprobaciones_cot_supervisores.php</a>"; ?></td>
  </tr>
</table>
-->
 <table width="80%" border="0">
    <tr>
      
      <td class="caja_texto_pe" width="10%" >
      <a onclick="javascript:aprobar_incidencias_sup('1')" style="display:none" id="bt_aprobar">
      <img src="image/bookmark_add.png" width="30" height="30" />Aprobar</a>
      </td>
      
       <td class="caja_texto_pe" width="10%" >
      <a onclick="javascript:mostrar_motivo()" style="display:none" id="bt_rechazar"> 
      <img src="image/anula2.jpg" width="32" height="32" />Rechazar</a>
      </td>
      <td class="caja_texto_pe" width="10%" >
      <a onclick="javascript:aprobar_incidencias_sup('3')" style="display:none" id="bt_cancelar"> 
      <img src="image/anula1.jpg" width="32" height="32" />Cancelar</a>
      </td> 
     
      <td width="11%" class="caja_texto_pe" ><a class="caja_texto_pe" onclick="javascript:cerrar_win('3')"> 
      <img src="image/SAL.jpg" width="30" height="30" />Salir</a></td>
      <td width="8%">&nbsp;</td>
      <td width="51%">
          <div id="div_noaprobados" style="display: none">  
              <a> MOTIVO: </a>
            <select name="c_rechazados" size="1" class="caja_texto_pe" id="c_rechazados">            
                <option value="Excede el tiempo definido">Excede el tiempo definido</option>
                <option value="Mal registro">Mal registro</option>
                <option value="Error en las fechas">Error en las fechas</option>
                <option value="Duplicidad">Duplicidad</option>
              </select>
              <a class="botonera" onclick="javascript:aprobar_incidencias_sup('2');">Aceptar</a>
          </div>
      </td>
    </tr>
</table>
<p> 
<table width="80%" border="0">
        <tr class="caja_texto_pe">
          <td width="12%" class="caja_sb">ESTADO</td>
          <td width="20%"><select name="est" size="1" class="caja_texto_pe" id="est" 
          onchange="javascript:mostrar_bt(this.value,'<?php echo $idperfil; ?>')" >            
            <option value="0">PENDIENTE</option>
            <option value="2">RECHAZADO</option>
            <option value="1">APROBADO</option>
			<option value="3">CANCELADO</option>
          </select></td>
          <td width="34%" class="caja_sb">SUPERVISOR</td>
          <td width="17%">


          <select name="cb_supervisor" id="cb_supervisor" class="caja_texto_pe" >
          
          <?php
            print "<option value='0' selected>SELECCIONE...</option>";
			  /*
            $query = "SELECT usuarios.* FROM (
              select cod_supervisor,nom_supervisor AS nombre from tb_supervisores where est='1'
              UNION
              select c_supervisor AS cod_supervisor, ncompleto AS nombre from tb_soportes_cot where estado ='1'
            ) usuarios
            ORDER BY nombre ASC";
			*/
			 $query = "select * from tb_usuarios where estado='HABILITADO' and perfil='3'"; 
			  
           	 $rs = mysql_query($query) or die (mysql_error());
              while ($row=mysql_fetch_row($rs)) { 					  
                echo "<option value='$row[0]'>$row[1]</option>";
            }
          ?>
          </select>
          </td>
			  <td class="caja_sb">GESTOR</td>
        <td colspan="2">
        <select name="cb_gestor" id="cb_gestor" class="caja_texto_pe" >
          <?php 			
          $cond="";
          if ($idperfil==1){
             $cond = " and a.iduser=".$iduser;
          }else{
			  $cond = "";
		  }
			print "<option value='0' selected>Seleccione Gestor</option>";
			$sql1="select cip,dni,ncompleto from tb_usuarios 
			where estado='HABILITADO' $cond order by ncompleto";
			echo $sql1;
		  	$queryresult1 = mysql_query($sql1) or die (mysql_error());
			while ($rowper1=mysql_fetch_row($queryresult1)) { 										  
			print "<option value='$rowper1[1]'>$rowper1[2] - $rowper1[1]</option>";
			}
			?>
          </select></td>
			
        </td>
          <td width="17%" class="caja_texto_db" align="center" onclick="javascript:mostrar_bandeja_aprobaciones();">
		  &nbsp;<a >&nbsp;BUSCAR&nbsp; </a>
		  </td>
			
</tr>
</table>

<form name="f1">
        <div id="d_bandeja_incidencias_cot"></div>
</form>

<script>
document.getElementById('cb_supervisor').addEventListener('change', function (e) {
  e.preventDefault();

  var supervisor = this.value;

  var xhr = new XMLHttpRequest();
  var url = 'funciones_cot.php?accion=obtenerGestores&supervisor='+supervisor;
	
  xhr.open('GET', url, true);

  xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
          // La solicitud fue exitosa, puedes manejar la respuesta aquí
          //console.log(xhr.responseText);
          var cbGestorElement = document.getElementById("cb_gestor");

          // Imprime el resultado en el elemento
          cbGestorElement.innerHTML = xhr.responseText;
      }
  };

  xhr.send(); // No es necesario enviar parámetros con el método GET

  

});

</script>

</body>
</html>
