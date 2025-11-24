// JavaScript Document

var oXmlHttp = null;   

function createRequest()
{
	try {xmlhttpH = new ActiveXObject("Msxml2.XMLHTTP");}
	catch (e) {
			try {xmlhttpH = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (E) {xmlhttpH = false;}
	}
	if (!xmlhttpH && typeof XMLHttpRequest!='undefined') {
	   xmlhttpH = new XMLHttpRequest();
	}
	return xmlhttpH;
}


function cargar_bandeja(){
	var contenedor_c = document.getElementById("cmdf");				
	var zonal  = document.getElementById("zonal").value;	
	var contrata  = document.getElementById("eecc").value;	
	
	pag_c = "funciones_gaudi.php?zonal="+zonal+"&contrata="+contrata+"&funcion=combo_mdf";

	ajaxc = createRequest();	
					ajaxc.open("GET",pag_c,true);
					ajaxc.onreadystatechange=function() {
						if (ajaxc.readyState==4){
//						contenedor3.style.visibility="visible";	
						contenedor_c.style.display="block";						
//						document.getElementById("boton").style.display="block";	
						contenedor_c.innerHTML = ajaxc.responseText;								
						}					 
					}
			ajaxc.send(null)		
}