<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
	function mostrar_cuerpo_tabs(opc){  
	
	var iframe = document.getElementById("f_cuerpo_tabs"); 
		
	if (opc=="1"){
		var pag = "ws_registrar_tecnicos_.php";
	}	
	
	if (opc=="2"){
		var pag = "ws_cab_listado_tecnicos.php";
	}
		
	//alert(pag)
	
	document.getElementById("d_cuerpo_tabs").style.display="block";	
	iframe.style.visibility="visible";	
	iframe.src= pag;
	}
</script>
<link rel="stylesheet" href="css_tabs.css">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Untitled Document</title>
</head>

<body>

<div class="w3-container">
  <h2>REGISTRO DE USUARIOS PARA WEB TECNICA 101 </h2>

  <div class="w3-row">
    <a onclick="javascript:mostrar_cuerpo_tabs('1');">
      <div class="w3-third tablink w3-bottombar w3-hover-light-grey w3-padding">Registro Usuarios WT101</div>
    </a>
    <a onclick="javascript:mostrar_cuerpo_tabs('2');">
      <div class="w3-third tablink w3-bottombar w3-hover-light-grey w3-padding">Bandeja Usuarios WT101</div>
    </a>
    <a onclick="javascript:mostrar_cuerpo_tabs('3');">
      <div class="w3-third tablink w3-bottombar w3-hover-light-grey w3-padding">Reporteria</div>
    </a>
  </div>

  <!--	
  <div id="London" class="w3-container city" style="display:none">
    <h2>London</h2>
    <p>London is the capital city of England.</p>
  </div>

  <div id="Paris" class="w3-container city" style="display:none">
    <h2>Paris</h2>
    <p>Paris is the capital of France.</p> 
  </div>

  <div id="Tokyo" class="w3-container city" style="display:none">
    <h2>Tokyo</h2>
    <p>Tokyo is the capital of Japan.</p>
  </div>
  -->
  <br>
  <div id="d_cuerpo_tabs" class="w3-container city" style="display:none">
   <iframe id="f_cuerpo_tabs"  frameborder="0" vspace="0"  hspace="0"  marginwidth="0"  marginheight="0"
            width="100%"  scrolling="Auto"  height="1000" > </iframe>
 </div>
</div>

</body>
</html>
