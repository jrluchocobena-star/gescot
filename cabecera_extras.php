<?PHP
include("conexion_bd.php");

$iduser = $_GET["iduser"];
$idperfil = $_GET["idperfil"];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MODULO DE GESTION ADMINISTRATIVA COT</title>
<script src="js.js"></script>
<script>
function soloNumeros(e,txt)
    {
		//alert(txt)
        // capturamos la tecla pulsada
        var teclaPulsada=window.event ? window.event.keyCode:e.which;
        // capturamos el contenido del input
        var valor=document.getElementById(txt).value;
 
        if(valor.length<10)
        {
            // 13 = tecla enter
            // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
            // punto
            if(teclaPulsada==13)
            {
                return true;
            }
 
            // devolvemos true o false dependiendo de si es numerico o no
            return /\d/.test(String.fromCharCode(teclaPulsada));
        }else{
            return false;
        }
    }
	
function modal(opc) {	
	var dni = document.getElementById("xdni").value;
	var cip = document.getElementById("xcip").value;
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;


	if (opc=="1"){
	//alert("Pagina en construccion...")
	//return
	
	var	pagina_envio="incidencias_mod_gestion_1.php?dni="+dni+"&cip="+cip+"&iduser="+iduser+"&idperfil="+idperfil+"&accion=Registro";
	var atributos="status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no,top=200,left=300,width=900,height=500";
	
	var nombre="";
	}
	
	if (opc=="2"){	 
	var	pagina_envio="mod_programar_extras.php?dni="+dni+"&cip="+cip+"&iduser="+iduser+"&accion=Registro";
	var atributos="status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no,top=100,left=300,width=900,height=550";
	
	var nombre="";
	
	}
	
	if (opc=="3"){	 
	var	pagina_envio="modulo_compensacion.php?dni="+dni+"&cip="+cip+"&iduser="+iduser+"&accion=Registro";
	var atributos="status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no,top=100,left=300,width=800,height=450";
	
	var nombre="";	
	
	}
	
	
	
	if (opc=="4"){	 
	var	pagina_envio="bandejas/detalle_gestion.php?dni="+dni;
	var atributos="status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no,top=100,left=200,width=1200,height=450";
	
	var nombre="";
	
	}
	
	if (opc=="5"){	 
	var	pagina_envio="bandejas/bandeja_general_comp_extras.php?dni="+dni;
	var atributos="status=no,directories=no,menubar=no,toolbar=no,scrollbars=no,location=no,resizable=no,titlebar=no,top=100,left=200,width=1200,height=450";
	var nombre="";
	}
	
	//alert(pagina_envio)
	var win = window.open(pagina_envio,nombre,atributos);	
}

 function mostrar_botonera(xdni,xcip,xcompleto, filas){
	// alert(filas)
	 document.getElementById("d_botonera").style.display="block";  
	 document.getElementById("xdni").value=xdni;
	 document.getElementById("xcip").value=xcip;
	 document.getElementById("xcompleto").value=xcompleto;
	  document.getElementById("tt").value=filas;
	 
	  if (filas != "00:00"){
		 document.getElementById("bt_comp").style.display="block";
		 document.getElementById("bt_info").style.display="block";
	  }else{
		 document.getElementById("bt_comp").style.display="none";
		 document.getElementById("bt_info").style.display="none";
		  
	  }
	 
}

</script>

<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>

<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<? echo $iduser; ?>"/>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<? echo $idperfil; ?>"/>


<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="5" valign="top" bgcolor="#999933" class="txt_pequeño">&nbsp;</td>   
  </tr>
  <tr>
    <td colspan="5" valign="top" class="etiqueta">
    <table width="100%" border="0">
      
      <tr>
      <!--
        <td width="20%" class="caja_texto_pe"><img src="image/usumas.jpg" width="30" height="30" />Nuevo Usuario</td>
        <td width="5%">&nbsp;</td>
        -->
        <td width="25%" class="caja_texto_pe" onclick="javascript:modal(5)">
        <img src="image/ima50.png" width="30" height="30" />Listado de Programaciones</td>
        <td width="5%">&nbsp;</td>
        <td width="20%" class="caja_texto_pe" onclick="javascript:exportar_prog_extra(1)">
        <img src="image/EXCELES.JPG" width="30" height="30" />Reportes</td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="20%">&nbsp;</td>       
      </tr>
     </table>
  </td>
  </tr>
  <form action="#">
   <tr>
    <td colspan="5" valign="top" bgcolor="#999933" class="txt_pequeño">&nbsp;</td>   
  </tr>
   <tr>
     <td valign="top"  class="etiqueta">&nbsp;</td>
     <td valign="top">&nbsp;</td>
     <td valign="top"class="etiqueta" >&nbsp;</td>
     <td colspan="2" valign="top">&nbsp;</td>
   </tr>
   <tr>
    <td width="18%" valign="top"  class="etiqueta">DNI</td>
    <td width="20%" valign="top">
      <input name="dni" type="text" class="caja_text" id="dni" size="15" maxlength="10" onkeypress="return tecla(event,'dni')" />
    </td>
    <td width="6%" valign="top"class="etiqueta" >CIP</td>
    <td width="20%" colspan="2" valign="top"><input name="cip" type="text" class="caja_text" id="cip" size="15" maxlength="10" onkeypress="return soloNumeros(event,'cip')" /></td>
    </tr>
  <tr>
    <td valign="top" class="etiqueta">&nbsp;</td>
    <td colspan="3" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta">NOMBRE COMPLETOS</td>
    <td colspan="3" valign="top"><input name="nombre" type="text" class="caja_text" id="nombre" size="50"  /></td>
     <td width="20%"  onclick="">        
        <a href="javascript:buscar_gestor()" class="caja_text"><img src="image/busca.jpg" width="30" height="30" border="0"  />Buscar</a></td>
  </tr>
  <tr>
    <td valign="top" class="etiqueta">&nbsp;</td>
    <td colspan="3" valign="top">&nbsp;</td>
  </tr>
  <!--
  <tr>
    <td valign="top" class="etiqueta">SUPERVISOR</td>
    <td colspan="3" valign="top"><select name="c_supervisor" id="c_supervisor" class="caja_texto" >
      <? 			
			print "<option value='0' selected>Seleccione Supervisor</option>";
			$sql7="select * from tb_supervisores where est='1'";
		  	$queryresult7 = mysql_query($sql7) or die (mysql_error());
			while ($rowper=mysql_fetch_row($queryresult7)) { 										  
			print "<option value='$rowper[0]'>$rowper[1]</option>";
			}
			?>
    </select></td>
  </tr>
  -->  
  <!--BOTONERA-->
   <tr>    
    <td colspan="6" bgcolor="#999933"  class="txt_pequeño">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="6">
    <br>
    <div id="d_botonera" style="display:none">
    	<table width="100%" class="marco_tabla">
        <tr>
          <td width="18%" class="etiqueta">Nombre Completo</td>
          <td>&nbsp;</td>
          <td width="32%"><input name="xcompleto" type="text" class="caja_texto_sb" id="xcompleto" size="50"  /></td>
          <td width="2%" >&nbsp;</td>
          <td width="24%" ><span class="etiqueta">TIEMPO</span></td>
          <td class="etiqueta">&nbsp;</td>
          <td width="21%" ><input name="tt" type="text" class="caja_texto_sb" id="tt"/></td>
          </tr>          
        <tr>
        	<td class="etiqueta">DNI</td>
            <td>&nbsp;</td>
            <td><input name="xdni" type="text" class="caja_texto_sb" id="xdni"  /></td>
            <td class="etiqueta">&nbsp;</td>
            <td class="etiqueta">CIP</td>
            <td >&nbsp;</td>
            <td><input name="xcip" type="text" class="caja_texto_sb" id="xcip" /></td>
            </tr>
          <tr>
            <td colspan="7" bgcolor="#66CCCC" class="txt_pequeño" >&nbsp;</td>
          </tr>
         </table> 
         <table width="100%" border='0' style="table-layout:fixed">
          <tr>           
            <td width="10px" heigth="20px">  
            <span onclick="javascript:modal(1)" class="boton_c">
            <img src="image/BT3.gif" width="20" height="20" border="0" />INCIDENCIA</span>     
            </td>  
            <!--  
            <td width="10px" heigth="20px">  
            <span onclick="javascript:modal(1)" class="boton_c">
            <img src="image/bookmark_add.png" width="20" height="20" border="0" />VER INCIDENCIAS</span>     
            </td>              
            -->
            <td width="10px" heigth="20px">            
            <span onclick="javascript:modal(2)" class="boton_c">
            <img src="image/icon2.png" width="20" height="20" border="0"  />PROGRAMAR</span>      
            </td>
            <td width="10px" heigth="20px">  
            <span onclick="javascript:modal(3)" class="boton_c" id="bt_comp">            
            <img src="image/BT2.gif" width="20" height="20" border="0" />COMPENSACION</span>   
            </td>           
            <td width="10px" heigth="20px">  
            <span onclick="javascript:modal(4)"  class="boton_c" id="bt_info"> 
            <img src="image/BT6.gif" width="20" height="20" border="0"  />HR.PROGRAMADAS</span>                           
            </td>                       
            </tr>              
        </table>
</div>
        <BR>
    </td>
  </tr>
   <tr>    
    <td colspan="6" bgcolor="#999933"  class="txt_pequeño">&nbsp;</td>
  </tr>
 
  </form>
  <tr>    
    <td colspan="6" ><div id="d_lista_usu" style=" display:none; width:100%; height:300px; overflow: scroll;" ></div></td>
  </tr>
</table>
</body>
</html>