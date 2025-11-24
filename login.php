<?php
/*
include("conexion_bd.php");

//$idsess="";
//$idperfil="";


	   $hostname = "localhost";
       $dbName = "cot";
       $username = "root";
       $password = "";
       MYSQL_CONNECT($hostname, $username, $password) OR DIE("no se pudo conectar a la DB");

//echo $idsess;

if (strlen($idsess)>1)
{      
       @mysql_select_db( "$dbName") or die( "No se pudo escoger una DB");
       $query = "update tb_usuarios set idsess=0 where idsess='$idsess'";
	  // echo $query;
       $res = MYSQL_QUERY($query);
 }
 
 if($nologin==3){
	$idsess=trim($_GET["idsess"]);
	$iduser=$_GET["iduser"];
	cerrar_sesion($idsess,$iduser);  
// print "No existe la combinacion usuario/password o la sesion caduco o fue abierta desde otra ubicacion";
 }
 */
//include("conexion_bd.php");
 
$nologin=$_GET["nologin"];
$idsess=trim($_GET["idsess"]);
$iduser=$_GET["iduser"];

/*
 if($_GET["nologin"]=="0"){
	//echo "Entro".trim($_GET["idsess"])."|".$_GET["iduser"];
	
	cerrar_sesion(trim($_GET["idsess"]),$_GET["iduser"]); 
	 
 }
 */
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WEB GESTION COT</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script src="funciones_js.js"></script>

<script type="text/javascript">

function setFormFocus() 
{
	document.getElementById("login").focus();
	mueveReloj()
}

function cancelar(){
	document.getElementById("login").value="";
	document.getElementById("passwd").value="";	
	document.getElementById("login").focus();
}

function acceso(){
	
	var login = document.getElementById("login").value;
	var clave = document.getElementById("clave").value;
	var idsess = document.getElementById("idsess").value;
	
	if (document.getElementById("idsess").value1==""){
		window.location = "mensaje_logeo.php";	
		return
	
	}else{	
				
	var url = "funciones_cot.php?login="+login+"&clave="+clave+"&accion=valida_acceso";	
	
	//alert(url)
	
	var ajaxp = new XMLHttpRequest();
	
	ajaxp.open("GET", url,true);
	ajaxp.onreadystatechange=function() {

		if (ajaxp.readyState==4){
			var resp = ajaxp.responseText;			
			//alert(resp)			
			var resp = resp.split("|");			

				
			var a= resp[0];
			var b=a.replace(/\s+/gi,'');
				
			document.getElementById("idsess").value=b;	
			//alert(resp[0].trim())
			
			//if (resp[0].trim()=="X"){
			if (document.getElementById("idsess").value=="X"){
				alert ("Datos de Acceso Incorrectos");	
				var url="login.php";
				window.location = url;	
				document.getElementById("idsess").value="";	
				//nalert(url)
			}else{					
				var url="index_nuevo.php?idsess="+resp[0]+"&idperfil="+resp[1]+"&iduser="+resp[2]+"&grupo="+resp[3];	
				window.location = url;					
			}
			
		}
	}
	 ajaxp.send(null)	
	}
	
	
	
}

function mueveReloj(){ 
	
	
	
   	momentoActual = new Date() 
   	hora = momentoActual.getHours() 
   	minuto = momentoActual.getMinutes() 
   	segundo = momentoActual.getSeconds() 

   	horaImprimible = hora + " : " + minuto + " : " + segundo 

   	document.form_reloj.reloj.value = horaImprimible 

	if (document.form_reloj.reloj.value=="10 : 0 : 0"){								
			borrar_asig()		
	}
	/*
	if (minuto == 20){
		var idsess = document.getElementById("idsess").value;
		var iduser = document.getElementById("iduser").value;
		//alert("entro")						
		salir(idsess,iduser)
		
		}
		*/
   	setTimeout("mueveReloj()",1000) 
	
} 

function salir(idsess,iduser){
	
	
	var pag1 = "funciones_cot.php?idsess="+idsess+"&iduser="+iduser+"&accion=cerrar_secion";
	
	//alert(pag1);
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 				
			//alert(ajaxc.responseText);
			window.location = "login.php";	
        }
	}
	ajaxc.send(null)

}

function borrar_asig(){
	
	
	var pag1 = "funciones_cot.php?accion=borrar_asig";
	
	//alert(pag1);
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 							
			alert(ajaxc.responseText);
        }
	}
	ajaxc.send(null)

}

</script> 
</head>

<body onload="javascript:setFormFocus()">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla_con_borde" style="border-collapse:collapse">
 <tr>
        <td height="80" colspan="2" bgcolor="#019DF4"><img src="image/3e1b1b71-1b09-4cb2-b7cc-4758a93f64b2.jpg" width="174" height="48" /></td>
      </tr>
       <tr>
        <td height="24" colspan="2" align="right" valign="top" class="caja_sb">
        <form name="form_reloj"> 
        Hora:  <input name="reloj" type="text"  size="10" class="caja_sb"> 
        </form> 
        </td>
  </tr>
   <tr>
     <td class="button">WEB: GESTION COT (GESCOT) v.1.0</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td>    
    <table width="873" border="0" align="right" cellpadding="0" cellspacing="0" class="tabla_con_borde">
      <tr>
        <td width="62">&nbsp;</td>
        <td width="86" class="TitTablaC">USUARIO</td>
        <td width="272"><input name="login" type="text" class="texto_simple2" id="login" size="30" />
          <input name="idsess" type="hidden" class="texto_simple2" id="idsess" size="30" /></td>
        <td width="67" class="TitTablaC">CLAVE</td>
        <td width="234"><input name="clave" type="password" class="texto_simple2" id="clave" size="30"/></td>
        <td width="150"><img src="image/aceptar.jpg" width="74" height="17" onclick="javascript:acceso()" /></td>
      </tr>
      </table>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="90%" border="0">
  <tr>
    <td height="20" colspan="3" valign="top" class="aviso">Si tiene problemas con el IExplorer o Google Chrome, puede utilizar el Firefox(Modzila). Para Descargar hacer <a href="Firefox Setup.exe">click</a> </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p class="aviso">Desea cambiar contraseña....?</p>
    <table width="300" height="30" border="0">
  <tbody>
    <tr>
      <td width="65" align="center"><a href="javascript:mostrar_div_cambiopass();" class="Tpresenta">Si</a></td>
      <td width="61" align="center" class="Tpresenta">No</td>      
    </tr>   
    </tbody>
</table>
    
<p>&nbsp;</p>
<p>&nbsp;</p>
 <div id="cambio_pass" style="display: none">
              <table width="700" border="0">
              <tbody>
                  <tr>
                  <td width="155" class="cabeceras_grid">Motivo</td>
                  <td width="190" class="cabeceras_grid" ><select id="c_motivoclave">                      
                    <option value="RESETEO DE CLAVE">RESETEO DE CLAVE</option>
                    <option value="OLVIDO DE CLAVE">OLVIDO DE CLAVE</option>
                  </select></td>
                  <td width="41" class="cabeceras_grid"></td>
                </tr>
                <tr>
                  <td width="155" class="cabeceras_grid">Ingrese Nueva Contraseña</td>
                  <td width="190" class="cabeceras_grid" ><input name="n_clave" type="password" class="texto_simple2" id="n_clave" size="30"/></td>
                  <td width="41" class="cabeceras_grid"><a href="javascript:cambiar_pass();">Aceptar</a></td>
                </tr>
              </tbody>
            </table>
          </div>
</body>
</html>
