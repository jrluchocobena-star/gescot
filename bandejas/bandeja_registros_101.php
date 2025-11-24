<?php

$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];		
$xmes=date("Y-m");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>

<link href="../estilos.css" rel="stylesheet" type="text/css" />


<script type="text/javascript"> 

var XmlHttp = null;   

function createRequest()
{
	try {ajaxc = new ActiveXObject("Msxml2.XMLHTTP");}
	catch (e) {
			try {ajaxc = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (E) {ajaxc = false;}
	}
	if (!ajaxc && typeof XMLHttpRequest!='undefined') {
	   ajaxc = new XMLHttpRequest();
	}
	return ajaxc;
}


function sube_archivo_101() {
	var iduser = document.getElementById("iduser").value;	
	
	
	
	var pagina="subir_registro_101.php?iduser="+iduser;
	//alert(pagina)
	
	document.getElementById("load_2").style.display="block";		
	document.getElementById("load_2").innerHTML = "<img src=\"../image/bprogreso1.gif\" width='300px' height='50px' />";
			
	ajaxc = createRequest();
    ajaxc.open("get", pagina, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 		
		//alert(ajaxc.responseText);		
		//exportar_registro101();
		document.getElementById("load_2").style.display="none";
		document.getElementById("load_2").innerHTML="";		
		
		ver_resultado();
	
		}	
	}
	ajaxc.send(null)
		
	
}

function ver_resultado() {
/*
 	var page="../bandejas/bandeja_consultas_101.php";
	//alert(page);
		
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'INFORMACION DE APLICATIVOS', 
	'top=3,left=0,width=1500px,height=400px,center=0,resize=0,scrolling=0');
*/	
	var pagina3="../bandejas/bandeja_consultas_101.php";
	
	//alert(pagina3)
	
	ajaxc = createRequest();
    ajaxc.open("get", pagina3, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 
			//alert(ajaxc.readyState);		
			document.getElementById("d_resultado_101").style.display		="block";			
			
			var iframe = document.getElementById("f_resultado_101");			
			iframe.style.visibility="visible";	
			iframe.src=pagina3;		
		}	
	}
	ajaxc.send(null)
	
}

function exportar_registro101(){

	var pagina2="../exportar_registro_101.php";
	
	
	ajaxc = createRequest();
    ajaxc.open("get", pagina2, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 		
			
		}	
	}
	ajaxc.send(null)
}

function mostrar_bandeja_101(){
	var iframe = document.getElementById("f_bandeja_101");
	document.getElementById("d_bandeja_101").style.display="block";	
	iframe.style.visibility="visible";	
	iframe.src= "../bandejas/bandeja_registros_101_detalle.php";
}	

function mostrar_usuarios_web101(){
	var iframe = document.getElementById("f_bandeja_101");
	document.getElementById("d_bandeja_101").style.display="block";	
	iframe.style.visibility="visible";	
	iframe.src= "../ws_registrar_web101.php";
}

</script>

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>


<link rel="stylesheet" type="text/css" href="table.css" media="all">
<title></title>
</head>

<body>
<input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="6" valign="top" class="menu_sup">&nbsp;</td>
  </tr>
  <tr>
    <td width="44%" valign="top" class="caja_texto_pe">&nbsp;</td>
    <?php if ($iduser=="156"){?>
    <td width="14%" valign="top" class="caja_texto_pe" style="cursor:pointer"><a href="http://10.226.44.221/asignaciones/ActualizarListaBlancaUSSD.php" target="_blank"> Actualizar USSD 101 <img src="../image/BT1.gif" width="30" height="30" border="0"/></a></td>
    <?php }  ?>
    <td width="12%" valign="top" class="caja_texto_pe" onclick="javascript:mostrar_bandeja_101();" style="cursor:pointer"> Bandeja 101 <img src="../image/ima50.png" width="30" height="30" border="0"/> </td>
    <td width="3%" class="caja_texto_pe"></td>
    <td width="15%" valign="top" class="caja_texto_pe" onclick="javascript:mostrar_usuarios_web101();" style="cursor:pointer"> Usuarios WebTecnica 101 <img src="../image/edificio.jpg" width="30" height="30" border="0"/> </td>
    <td width="12%" class="caja_texto_pe"></td>
  </tr>  
</table>
<P>

<div id="d_bandeja_101" style="display:none">
    <iframe id="f_bandeja_101"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
            width="100%"  scrolling="Auto"  height="1000" > </iframe>
</div>
	
<div id="d_resultado_101" style="display:none"> 
 <iframe id="f_resultado_101"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
 width="100%"  scrolling="Auto"  height="1000" > </iframe>   
</div>

</body>
</html>