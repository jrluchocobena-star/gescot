<?php
$dni		=$_GET["dni"];

$pag_1="bandeja_individual_extras.php?dni=".$dni;

$pag_2="bandeja_individual_comp.php?dni=".$dni;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" href="dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="dhtmlmodal/modalfiles/modal.js"></script>
<script src="../js.js"></script>


<script>
/*
	function  popup_reclamo(opc,id){	
	
	if (opc==1){ // registro de boleta	
	var page="modulo_compensacion.php?id="+id;
	//alert(page);	
	ras=dhtmlmodal.open('MODULO', 'iframe',page,'MODULO DE COMPENSACION', 'width=700px,height=450px,center=1,resize=0,scrolling=0');	
	}
	
	function cerrar_modal(){
		parent.ras.hide();
	}	
	 	
	
}
*/ 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INFORMACION DETALLADA DE <? echo $dni; ?></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td class="boton_4">HORAS PROGRAMADAS</td>
  </tr>
  <tr>
    <td>
    <div id="d_cabecera" style="overflow:scroll">
    
    <iframe id="f_cabecera" src="<? echo $pag_1; ?>"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
            width="100%"  scrolling="Auto"  height="40%" > </iframe>
    </div></td>
  </tr> 
  <!--
  <tr>
    <td><div id="d_detalle" style="display:none"> </div></td>
  </tr>
  -->
  <tr>
    <td class="boton_4">COMPENSACION DE HORAS</td>
  </tr>
  <tr>
    <td>
    <div id="d_detalle" style="overflow:scroll">
    
    <iframe id="f_detalle" src="<? echo $pag_2; ?>"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
            width="100%"  scrolling="Auto"  height="40%" > </iframe>
    </div></td>
  </tr> 
    
</table>

</body>
</html>