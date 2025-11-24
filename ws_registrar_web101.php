<?php
include_once("conexion_w101.php");

$iduser=$_GET["iduser"];

$connection_w101	= db_conn_w101();
//echo $iduser;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<link rel="stylesheet" href="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.css" type="text/css" />		
<script type="text/javascript" src="bandejas/dhtmlmodal/windowfiles/dhtmlwindow.js"></script>		
<link rel="stylesheet" href="bandejas/dhtmlmodal/modalfiles/modal.css" type="text/css" />
<script type="text/javascript" src="bandejas/dhtmlmodal/modalfiles/modal.js"></script>

<script>

function  popup_ussd(opc){	
		var iduser 		= document.getElementById("iduser").value;
		var celular 	= document.getElementById("a_celular").value;
		var xcarnet 	= document.getElementById("xcarnet").value;
		var xdni 		= document.getElementById("xdni").value;

	
			var page = "ws_listado_tecnicos.php?iduser="+iduser+"&opc="+opc+"&celular="+celular+"&xcarnet="+xcarnet+"&xdni="+xdni;
			alert(page);			
			ras=dhtmlmodal.open('EmailBox', 'iframe',page,'HISTORICO DE REGISTROS USSD 101', 'top=20,left=200,width=1200px,height=500px,center=0,resize=0,scrolling=0');	

	
} 

function marcaAllCheckBox(opc){   
 //alert(opc)  
	 if (opc=="1"){   // modulo registro ussd
		var n_chek = "check_";
	
		for (i=1 ; i<22 ; i++){
		  var name = n_chek + i;
		 // alert(name)
		  if (document.getElementById("checkbox_t").checked==false){
			document.getElementById(name).checked=false;
		  }else{
			document.getElementById(name).checked=true;
		  }
	   }	
	 }

 	if (opc=="2"){ //modulo consulta ussd
		var n_chek = "c_check_";
	    for (i=14 ; i<33 ; i++){
		  var name = n_chek + i;
		 // alert(name)
		  if (document.getElementById("checkbox_ct").checked==false){
			document.getElementById(name).checked=false;
		  }else{
			document.getElementById(name).checked=true;
		  }
	   }	
	}
 
	 if (opc=="3"){   // modulo registro cdc
		var cdc_chek = "check_cdc_";
	
		for (i=1 ; i<10 ; i++){
		  var name = cdc_chek + i;
		 // alert(name)
		  if (document.getElementById("checkbox_tcdc").checked==false){
			document.getElementById(name).checked=false;
		  }else{
			document.getElementById(name).checked=true;
		  }
	   }	   
	}
	
	if (opc=="4"){ //modulo consulta cdc
		var n_chek = "c_check_";
	    for (i=1 ; i<12 ; i++){
		  var name = n_chek + i;
		 // alert(name)
		  if (document.getElementById("checkbox_ct").checked==false){
			document.getElementById(name).checked=false;
		  }else{
			document.getElementById(name).checked=true;
		  }
	   }	
	}
	
}

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


function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }
		
function mostrar_carnet(nom){
//alert(nom)
	if (nom=="1"){
		document.getElementById("d_concarnet").style.display="block";
	}else{
		document.getElementById("d_concarnet").style.display="none";
	}
	
}

function mostrar_carnet_cdc(nom){
//alert(nom)
	if (nom=="1"){
		document.getElementById("d_concarnet_cdc").style.display="block";
	}else{
		document.getElementById("d_concarnet_cdc").style.display="none";
	}
	
}


function mostrar_combo(valor,n_combo){		
		
		var urlx = "ws_funciones_asignaciones.php?valor="+valor+"&n_combo="+n_combo+"&accion="+n_combo;	
		
		//alert(urlx)
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
					
			if (ajaxc.readyState==4) 
			{				
				//alert(ajaxc.responseText);
				document.getElementById(n_combo).innerHTML = ajaxc.responseText;			
			
			}
		}
		 ajaxc.send(null)	
}

function grabar_registro_tecnicos(){	
		var celular 	= document.getElementById("celular").value;
		var ape_pat 	= document.getElementById("ape_pat").value;
		var ape_mat 	= document.getElementById("ape_mat").value;
		var nombre 		= document.getElementById("nombre").value;
		var dni 		= document.getElementById("dni").value;
		var iduser 		= document.getElementById("iduser").value;
		var c_region 	= document.getElementById("c_xregion").value;
		var c_zonal 	= document.getElementById("c_xzonal").value;
		var c_eecc 		= document.getElementById("c_xeecc").value;
		var c_jefatura 	= document.getElementById("c_xjefatura").value;
		var c_actividad	= "REGISTRO";
		var c_gestion 	= document.getElementById("c_gestion").value;
		var c_estado 	= document.getElementById("c_estado").value;
		//var c_obs 		= document.getElementById("c_obs").value;
		//var c_tratec 	= document.getElementById("c_tratec").value;
		//var c_tracon 	= document.getElementById("c_tracon").value;
		//var c_pcg 		= document.getElementById("c_pcg").value;
		//var c_toa 		= document.getElementById("c_toa").value;
		var detalle 	= document.getElementById("detalle").value;
		var solicitado 	= document.getElementById("solicitado").value;
		var accion		= "grabar_registro_tecnico";
	
	
		if (document.getElementById("celular").value=="" && document.getElementById("dni").value==""){
		 alert("Importante: Campos Prioritarios En Blanco")
		 return
		}else{

		if(document.getElementById("check_1").checked==true) { check_1="S";  	} else {  check_1="N";  }
		if(document.getElementById("check_2").checked==true) { check_2="S";  	} else {  check_2="N";  }
		if(document.getElementById("check_3").checked==true) { check_3="S";  	} else {  check_3="N";  }
		if(document.getElementById("check_4").checked==true) { check_4="S";  	} else {  check_4="N";  }
		if(document.getElementById("check_5").checked==true) { check_5="S";  	} else {  check_5="N";  }
		if(document.getElementById("check_6").checked==true) { check_6="S";  	} else {  check_6="N";  }
		if(document.getElementById("check_7").checked==true) { check_7="S";  	} else {  check_7="N";  }
		if(document.getElementById("check_8").checked==true) { check_8="S";  	} else {  check_8="N";  }
		if(document.getElementById("check_9").checked==true) { check_9="S";  	} else {  check_9="N";  }
		if(document.getElementById("check_10").checked==true) { check_10="S";   } else {  check_10="N";  }
		if(document.getElementById("check_11").checked==true) { check_11="S";   } else {  check_11="N";  }
		if(document.getElementById("check_12").checked==true) { check_12="S";   } else {  check_12="N";  }
		if(document.getElementById("check_13").checked==true) { check_13="S";   } else {  check_13="N";  }
		if(document.getElementById("check_14").checked==true) { check_14="S";   } else {  check_14="N";  }
		if(document.getElementById("check_15").checked==true) { check_15="S";   } else {  check_15="N";  }
		if(document.getElementById("check_16").checked==true) { check_16="S";   } else {  check_16="N";  }
		if(document.getElementById("check_17").checked==true) { check_17="S";   } else {  check_17="N";  }
		if(document.getElementById("check_18").checked==true) { check_18="S";   } else {  check_18="N";  }
		if(document.getElementById("check_19").checked==true) { check_19="S";   } else {  check_19="N";  }
		if(document.getElementById("check_20").checked==true) { check_20="S";   } else {  check_20="N";  }
		if(document.getElementById("check_21").checked==true) { check_21="S";   } else {  check_21="N";  }
		
			
		if (document.getElementById("t_carnet").value=="1"){
			var carnet = document.getElementById("c_carnet").value + document.getElementById("n_carnet").value;		
		}else{
			var carnet = document.getElementById("dni").value;
		}
			
		var page = "ws_funciones_asignaciones.php?celular="+celular+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&nombre="+nombre+"&dni="+dni+"&carnet="+carnet
		+"&c_region="+c_region+"&c_zonal="+c_zonal+"&c_eecc="+c_eecc+"&c_jefatura="+c_jefatura+"&c_gestion="+c_gestion+"&c_estado="+c_estado
		+"&c_actividad="+c_actividad+"&iduser="+iduser+"&detalle="+detalle+"&solicitado="+solicitado+"&c_toa="+check_21
		+"&check_1="+check_1+"&check_2="+check_2+"&check_3="+check_3+"&check_4="+check_4+"&check_5="+check_5+"&check_6="+check_6+"&check_7="+check_7+"&check_8="
		+check_8+"&check_9="+check_9+"&check_10="+check_10+"&check_11="+check_11+"&check_12="+check_12+"&check_13="+check_13+"&check_14="+check_14+"&check_15="+check_15
		+"&check_16="+check_16+"&check_17="+check_17+"&check_18="+check_18+"&check_19="+check_19+"&check_20="+check_20+"&check_21="+check_21+"&accion="+accion;
		
		//alert(page)	
		
		
		ajaxc=createRequest();
		ajaxc.open("GET", page,true);
		ajaxc.onreadystatechange=function() {
					
			if (ajaxc.readyState==4) 
			{	
				alert(ajaxc.responseText)
				alert("Se registro correctamente");
				//mostrar_lista_tecnicos('1');
			}
		}
		 ajaxc.send(null)
		 
		 		document.getElementById("cel").value="";
				document.getElementById("ape_pat").value="";
				document.getElementById("ape_mat").value="";
				document.getElementById("nombre").value="";
				document.getElementById("t_carnet").value="0";
				document.getElementById("n_carnet").value="";
				document.getElementById("dni").value="";				
				document.getElementById("c_xregion").value="0";
				document.getElementById("c_xzonal").value="0";
				document.getElementById("c_xeecc").value="0";
				document.getElementById("c_xjefatura").value="0";
				document.getElementById("c_carnet").value="0";
				document.getElementById("c_gestion").value="";
				document.getElementById("c_estado").value="";
				document.getElementById("detalle").value="";
				document.getElementById("c_tratec").value="";
				document.getElementById("c_tracon").value="";
				document.getElementById("c_pcg").value="";
				document.getElementById("c_toa").value="";
				document.getElementById("detalle").value="";
				document.getElementById("bt_registrar_tecnico").style.display="none"; 
		}
}

function grabar_registro_tecnicos(){	
		var celular 	= document.getElementById("celular").value;
		var ape_pat 	= document.getElementById("ape_pat").value;
		var ape_mat 	= document.getElementById("ape_mat").value;
		var nombre 		= document.getElementById("nombre").value;
		var dni 		= document.getElementById("dni").value;
		var iduser 		= document.getElementById("iduser").value;
		var c_region 	= document.getElementById("c_xregion").value;
		var c_zonal 	= document.getElementById("c_xzonal").value;
		var c_eecc 		= document.getElementById("c_xeecc").value;
		var c_jefatura 	= document.getElementById("c_xjefatura").value;
		var c_actividad	= "REGISTRO";
		var c_gestion 	= document.getElementById("c_gestion").value;
		var c_estado 	= document.getElementById("c_estado").value;
		//var c_obs 		= document.getElementById("c_obs").value;
		//var c_tratec 	= document.getElementById("c_tratec").value;
		//var c_tracon 	= document.getElementById("c_tracon").value;
		//var c_pcg 		= document.getElementById("c_pcg").value;
		//var c_toa 		= document.getElementById("c_toa").value;
		var detalle 	= document.getElementById("detalle").value;
		var solicitado 	= document.getElementById("solicitado").value;
		var accion		= "grabar_registro_tecnico";
	
	
		if (document.getElementById("celular").value=="" && document.getElementById("dni").value==""){
		 alert("Importante: Campos Prioritarios En Blanco")
		 return
		}else{

		if(document.getElementById("check_1").checked==true) { check_1="S";  	} else {  check_1="N";  }
		if(document.getElementById("check_2").checked==true) { check_2="S";  	} else {  check_2="N";  }
		if(document.getElementById("check_3").checked==true) { check_3="S";  	} else {  check_3="N";  }
		if(document.getElementById("check_4").checked==true) { check_4="S";  	} else {  check_4="N";  }
		if(document.getElementById("check_5").checked==true) { check_5="S";  	} else {  check_5="N";  }
		if(document.getElementById("check_6").checked==true) { check_6="S";  	} else {  check_6="N";  }
		if(document.getElementById("check_7").checked==true) { check_7="S";  	} else {  check_7="N";  }
		if(document.getElementById("check_8").checked==true) { check_8="S";  	} else {  check_8="N";  }
		if(document.getElementById("check_9").checked==true) { check_9="S";  	} else {  check_9="N";  }
		if(document.getElementById("check_10").checked==true) { check_10="S";   } else {  check_10="N";  }
		if(document.getElementById("check_11").checked==true) { check_11="S";   } else {  check_11="N";  }
		if(document.getElementById("check_12").checked==true) { check_12="S";   } else {  check_12="N";  }
		if(document.getElementById("check_13").checked==true) { check_13="S";   } else {  check_13="N";  }
		if(document.getElementById("check_14").checked==true) { check_14="S";   } else {  check_14="N";  }
		if(document.getElementById("check_15").checked==true) { check_15="S";   } else {  check_15="N";  }
		if(document.getElementById("check_16").checked==true) { check_16="S";   } else {  check_16="N";  }
		if(document.getElementById("check_17").checked==true) { check_17="S";   } else {  check_17="N";  }
		if(document.getElementById("check_18").checked==true) { check_18="S";   } else {  check_18="N";  }
		if(document.getElementById("check_19").checked==true) { check_19="S";   } else {  check_19="N";  }
		if(document.getElementById("check_20").checked==true) { check_20="S";   } else {  check_20="N";  }
		if(document.getElementById("check_21").checked==true) { check_21="S";   } else {  check_21="N";  }
		
			
		if (document.getElementById("t_carnet").value=="1"){
			var carnet = document.getElementById("c_carnet").value + document.getElementById("n_carnet").value;		
		}else{
			var carnet = document.getElementById("dni").value;
		}
			
		var page = "ws_funciones_asignaciones.php?celular="+celular+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&nombre="+nombre+"&dni="+dni+"&carnet="+carnet
		+"&c_region="+c_region+"&c_zonal="+c_zonal+"&c_eecc="+c_eecc+"&c_jefatura="+c_jefatura+"&c_gestion="+c_gestion+"&c_estado="+c_estado
		+"&c_actividad="+c_actividad+"&iduser="+iduser+"&detalle="+detalle+"&solicitado="+solicitado+"&c_toa="+check_21
		+"&check_1="+check_1+"&check_2="+check_2+"&check_3="+check_3+"&check_4="+check_4+"&check_5="+check_5+"&check_6="+check_6+"&check_7="+check_7+"&check_8="
		+check_8+"&check_9="+check_9+"&check_10="+check_10+"&check_11="+check_11+"&check_12="+check_12+"&check_13="+check_13+"&check_14="+check_14+"&check_15="+check_15
		+"&check_16="+check_16+"&check_17="+check_17+"&check_18="+check_18+"&check_19="+check_19+"&check_20="+check_20+"&check_21="+check_21+"&accion="+accion;
		
		//alert(page)	
		
		
		ajaxc=createRequest();
		ajaxc.open("GET", page,true);
		ajaxc.onreadystatechange=function() {
					
			if (ajaxc.readyState==4) 
			{	
				alert(ajaxc.responseText)
				alert("Se registro correctamente");
				//mostrar_lista_tecnicos('1');
			}
		}
		 ajaxc.send(null)
		 
		 		document.getElementById("cel").value="";
				document.getElementById("ape_pat").value="";
				document.getElementById("ape_mat").value="";
				document.getElementById("nombre").value="";
				document.getElementById("t_carnet").value="0";
				document.getElementById("n_carnet").value="";
				document.getElementById("dni").value="";				
				document.getElementById("c_xregion").value="0";
				document.getElementById("c_xzonal").value="0";
				document.getElementById("c_xeecc").value="0";
				document.getElementById("c_xjefatura").value="0";
				document.getElementById("c_carnet").value="0";
				document.getElementById("c_gestion").value="";
				document.getElementById("c_estado").value="";
				document.getElementById("detalle").value="";
				document.getElementById("c_tratec").value="";
				document.getElementById("c_tracon").value="";
				document.getElementById("c_pcg").value="";
				document.getElementById("c_toa").value="";
				document.getElementById("detalle").value="";
				document.getElementById("bt_registrar_tecnico").style.display="none"; 
		}
}


function validar_registro_tecnico(){		
		var celular 	= document.getElementById("celu").value;
		var accion		= "validar_registro_tecnico";
		var dni 		= document.getElementById("dni").value;
		
		
		if (document.getElementById("celu").value=="" && document.getElementById("dni").value==""){ // se valida si los campos cel y dni estan vacios	
			alert("Necesita Ingresar Numero de Celular")	
			return		
		}else{			
			
			if (celular.charAt(0)!="9"){ // se valida si primer digito es 9
				alert("El primer digito debe de ser 9")
				return	
			}else{
		
				var urlx = "ws_funciones_asignaciones.php?celular="+celular+"&dni="+dni+"&accion="+accion;	
				
				//alert(urlx)
				ajaxc=createRequest();
				ajaxc.open("GET", urlx,true);
				ajaxc.onreadystatechange=function() {
							
					if (ajaxc.readyState==4) 
					{				
						var resp = ajaxc.responseText;	
						//alert(resp)
						var resp=resp.split("|");			
						var est=resp[0];
						var msn=resp[1];
						
						document.getElementById("mensajes_movimientos").innerHTML = msn;	
						
						if (est=="4" || est=="3"){	
							grabar_registro_tecnicos();
							
						}else{
							return
						}
					}
				}
				 ajaxc.send(null)	
			 }
		}
}

function mostrar_lista_tecnicos(opc){		
		var iduser 		= document.getElementById("iduser").value;
		var celular 	= document.getElementById("a_cel").value;

		if (document.getElementById("a_cel").value==""){
			alert("Dato de Celular en blanco")
			return
		}else{		
			var urlx = "ws_listado_tecnicos.php?iduser="+iduser+"&opc="+opc+"&celular="+celular;	
			
			//alert(urlx)
	
			ajaxc=createRequest();
			ajaxc.open("GET", urlx,true);
			ajaxc.onreadystatechange=function() {
						
				if (ajaxc.readyState==4) 
				{				
					//alert(ajaxc.responseText)			
					document.getElementById("bandeja_tecnicos").innerHTML = ajaxc.responseText;		
				}
			}
			 ajaxc.send(null)	
		}
}



function mostrar_div_gestion(opc){
	//alert(opc)
	var iduser 		= document.getElementById("iduser").value;
	
	if (opc=="REGISTRO"){		
		document.getElementById("bt_registrar_tecnico").style.display="none"; 
		document.getElementById("div_registro_celular").style.display="block";  
//		document.getElementById("div_consulta").style.display="none"; 		  	
		document.getElementById("celular").value = document.getElementById("a_cel").value;
	}
	
	if (opc=="ACTUALIZACION"){
		document.getElementById("div_registro_celular").style.display="none";  
		//document.getElementById("div_consulta").style.display="block";  	
	}
	
	
	if (opc=="CARGA"){
	
	var msn="Desea ejecutar la carga..?";
	
	if (confirm(msn)){
					alert("Inicio de proceso de Carga")
					
					///window.location.href = "http://10.226.44.221/asignaciones/ActualizarListaBlancaUSSD.php";
					
					var accion 		= "cargamasivausuarios";
					
					var urlx = "ws_funciones_asignaciones.php?iduser="+iduser+"&accion="+accion;	
					
					//alert(urlx)
					ajaxc=createRequest();
					ajaxc.open("GET", urlx,true);
					ajaxc.onreadystatechange=function() {
								
						if (ajaxc.readyState==4) 
						{				
							alert(ajaxc.responseText);				
						}
					}
					 ajaxc.send(null)	
					
				}
	}
	
}


function mostrar_info(celular,iduser,xcarnet,xdni){		
		
		var accion 		= "mostrar_info";
		
		var urlx1 = "ws_funciones_asignaciones.php?iduser="+iduser+"&celular="+celular+"&xcarnet="+xcarnet+"&xdni="+xdni
		+"&accion="+accion;		
		
		//alert(urlx1)	
		
		ajaxc=createRequest();
		ajaxc.open("GET", urlx1,true);
		ajaxc.onreadystatechange=function() {
					
			if (ajaxc.readyState==4) {								
				//alert(ajaxc.responseText)
				document.getElementById("div_consulta").style.display	="block";
				document.getElementById("div_data_registro").style.display	="block";
				document.getElementById("div_data_registro").innerHTML 		= ajaxc.responseText;	
				//mostrar_lista_tecnicos('1');				
			}		
		}						
	 ajaxc.send(null)	
	 
	
	 
}



function validar_celular(){	
		var iduser 		= document.getElementById("iduser").value;
		var celular 	= document.getElementById("a_celular").value;
		var xcarnet 	= document.getElementById("xcarnet").value;
		var xdni 	= document.getElementById("xdni").value;
		var accion 		= "validar_celular";
		//var accion 		= "mostrar_info";
		document.getElementById("div_data_registro").style.display	="none";
		document.getElementById("div_data_registro").innerHTML 		= "";	
				
		if (document.getElementById("a_celular").value=="" && document.getElementById("xcarnet").value=="" && 
		document.getElementById("xdni").value=="" && document.getElementById("xnombres").value==""){
		alert("Importante: Dato de celular en blanco")
		document.getElementById("div_registro_celular").style.display="none";  
		document.getElementById("div_data_registro").style.display="none";  
		return
		}else{
		
					
			var urlx = "ws_funciones_asignaciones.php?iduser="+iduser+"&celular="+celular+"&xcarnet="+xcarnet+"&xdni="+xdni
			+"&accion="+accion;		
			//alert(urlx)
			
			ajaxc=createRequest();
			ajaxc.open("GET", urlx,true);
			ajaxc.onreadystatechange=function() {
						
				if (ajaxc.readyState==4) {			
					var resp = ajaxc.responseText;	
					//alert(resp)
																		
					if (ajaxc.responseText==0){
						alert("Nro de celular no se encuentra registrado")
						document.getElementById("bt_registrar_tecnico").style.display="block";
						document.getElementById("div_registro_celular").style.display="none";		
						return			
					}else{
						//alert("Nro de celular se encuentra registrado")
						document.getElementById("bt_registrar_tecnico").style.display="none";	
						mostrar_info(celular,iduser,xcarnet,xdni);						
						 document.getElementById("xcarnet").value="";
						 document.getElementById("xdni").value="";
						 document.getElementById("a_cel").value="";
						//mostrar_lista_tecnicos('1');
					}					
				}			
			}	
			 ajaxc.send(null)	
		}
}


function volver(opc){
	
	if (opc=="1"){
		document.getElementById("div_registro_celular").style.display="none";  
		document.getElementById("div_consulta").style.display="block";  	
		document.getElementById("div_data_registro").style.display="none";  	
	}
	
	if (opc=="2"){
		document.getElementById("div_registro_cdc").style.display="none";  
		document.getElementById("div_consulta").style.display="block";  	
	}
	
}


function eliminar_tecnico(){		
		var iduser 		= document.getElementById("iduser").value;
		var celular 	= document.getElementById("a_celular").value;
		var accion 		= "eliminar_tecnico";
		
		
		var urlx = "ws_funciones_asignaciones.php?iduser="+iduser+"&celular="+celular+"&accion="+accion;		
		
		alert(urlx)
		
		
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
					
			if (ajaxc.readyState==4) 
			{			
				var resp = ajaxc.responseText;
				alert(resp)				
				alert("Se ingresa solicitud de baja")
					
			}
		}
		 ajaxc.send(null)	
		
}


function mostrar_div_ussd(valor){

	if (valor=="1"){
		document.getElementById("div_registro_ussd").style.display="block"; 
		document.getElementById("div_upload").style.display="none"; 		
		document.getElementById("div_cab_registro_cdc").style.display="none";
		document.getElementById("div_data_registro").style.display	="none";
		document.getElementById("usuario").value="";
	}

	if (valor=="2"){
    	document.getElementById("div_cab_registro_cdc").style.display="block";
		document.getElementById("div_registro_ussd").style.display="none";  		
		document.getElementById("div_data_registro").style.display	="none";
		document.getElementById("div_upload").style.display="none";
		document.getElementById("a_cel").value="";
	}
	
	if (valor=="4"){
    	document.getElementById("div_upload").style.display="block";
		document.getElementById("div_cab_registro_cdc").style.display="none";
		document.getElementById("div_registro_ussd").style.display="none";  		
		document.getElementById("div_data_registro").style.display	="none";
		document.getElementById("a_cel").value="";
	}

}
/*************************************************************/
function validar_cdc(){	
		var iduser 		= document.getElementById("iduser").value;
		var usuario 		= document.getElementById("usuario").value;
		
		/*
		if(document.getElementById("usuario").value.length==9){
		var usuario 	= "51" + document.getElementById("usuario").value;
		}else{
		var usuario 	= document.getElementById("usuario").value;
		}
		*/
		if (document.getElementById("dni_1").value==""){
			var dni 	= document.getElementById("dni_1").value;
		}else{		
			if(document.getElementById("dni_1").value.length<8){
			var dni 	= "0" + document.getElementById("dni_1").value;
			}else{
			var dni 	= document.getElementById("dni_1").value;
			}
		}
		
		var carnet 	= document.getElementById("carnet_1").value;
		var accion 		= "validar_cdc";
		//var accion 		= "mostrar_info";
		//document.getElementById("div_registro_cdc").style.display	="none";
		//document.getElementById("div_registro_cdc").innerHTML 		= "";	
				
		if (document.getElementById("usuario").value=="" && document.getElementById("dni_1").value=="" && document.getElementById("carnet_1").value==""){
		alert("Importante: Debe ingresar usuario")
		document.getElementById("div_registro_cdc").style.display="none";  
		return
		}else{
		
					
			var urlx = "ws_funciones_asignaciones.php?iduser="+iduser+"&usuario="+usuario+"&dni="+dni+"&carnet="+carnet
			+"&accion="+accion;		
			//alert(urlx)			
			
			ajaxc=createRequest();
			ajaxc.open("GET", urlx,true);
			ajaxc.onreadystatechange=function() {
						
				if (ajaxc.readyState==4) {			
					var resp = ajaxc.responseText;	
					//alert(resp)
																		
					if (ajaxc.responseText==0){
						alert("Usuario no se encuentra registrado")
						document.getElementById("div_registro_cdc").style.display	="block";						
						document.getElementById("div_data_registro").style.display	="none";
						document.getElementById("usuario_cdc").value = usuario;
						return			
					}else{
						//alert("Nro de celular se encuentra registrado")
						document.getElementById("bt_registrar_tecnico").style.display="none";
						document.getElementById("div_registro_cdc").style.display	="none";						
						mostrar_info_cdc(usuario,iduser,dni,carnet);
						//mostrar_lista_tecnicos('1');
						document.getElementById("dni_1").value="";
						document.getElementById("carnet_1").value="";
						document.getElementById("usuario").value="";
					}					
				}			
			}	
			 ajaxc.send(null)	
		}
}


function mostrar_info_cdc(usuario,iduser,dni,carnet){			
		
		
		var accion 		= "mostrar_info_cdc";
		
		var urlx1 = "ws_funciones_asignaciones.php?iduser="+iduser+"&usuario="+usuario+"&dni="+dni+"&carnet="+carnet+"&accion="+accion;		
		
	
	//	alert(urlx1)	
		
		ajaxc=createRequest();
		ajaxc.open("GET", urlx1,true);
		ajaxc.onreadystatechange=function() {
					
			if (ajaxc.readyState==4) {								
				//alert(ajaxc.responseText)
				document.getElementById("div_cab_registro_cdc").style.display	="block";
				document.getElementById("div_data_registro").style.display	="block";
				document.getElementById("div_data_registro").innerHTML 		= ajaxc.responseText;	
				//mostrar_lista_tecnicos('1');				
			}		
		}						
	 ajaxc.send(null)	
}

function grabar_registro_tecnicos_cdc(){	
		var usuario 	= document.getElementById("usuario_cdc").value;
		var ape_pat 	= document.getElementById("ape_pat_cdc").value;
		var ape_mat 	= document.getElementById("ape_mat_cdc").value;
		var nombre 		= document.getElementById("nombre_cdc").value;
		var dni 		= document.getElementById("dni_cdc").value;
		var iduser 		= document.getElementById("iduser").value;		
		var c_actividad	= "REGISTRO";
		var c_estado 	= document.getElementById("c_estado_cdc").value;	
		var detalle 	= document.getElementById("detalle_cdc").value;
		var usu_modelo 	= document.getElementById("usu_modelo").value;
		var accion		= "grabar_registro_tecnico_cdc";
	
	
		if (document.getElementById("usuario").value=="" && document.getElementById("dni_cdc").value==""){
		 alert("Importante: Campos Prioritarios En Blanco")
		 return
		}else{

		if(document.getElementById("check_1").checked==true) { check_1="1211";  	} else {  check_1="";  }
		if(document.getElementById("check_2").checked==true) { check_2="1212";  	} else {  check_2="";  }
		if(document.getElementById("check_3").checked==true) { check_3="1213";  	} else {  check_3="";  }
		if(document.getElementById("check_4").checked==true) { check_4="1214";  	} else {  check_4="";  }
		if(document.getElementById("check_5").checked==true) { check_5="1215";  	} else {  check_5="";  }
		if(document.getElementById("check_6").checked==true) { check_6="1216";  	} else {  check_6="";  }
		if(document.getElementById("check_7").checked==true) { check_7="1217";  	} else {  check_7="";  }
		if(document.getElementById("check_8").checked==true) { check_8="1218";  	} else {  check_8="";  }
		if(document.getElementById("check_9").checked==true) { check_9="1219";  	} else {  check_9="";  }
					
		if (document.getElementById("t_carnet_cdc").value=="1"){
			var carnet = document.getElementById("c_carnet_cdc").value + document.getElementById("n_carnet_cdc").value;		
		}else{
			var carnet = document.getElementById("dni_cdc").value;
		}
			
		var page = "ws_funciones_asignaciones.php?usuario="+usuario+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&nombre="+nombre+"&dni="+dni+"&carnet="+carnet
		+"&c_estado="+c_estado+"&c_actividad="+c_actividad+"&iduser="+iduser+"&detalle="+detalle+"&usu_modelo="+usu_modelo+"&check_1="+check_1+"&check_2="+check_2+"&check_3="+check_3+"&check_4="+check_4+"&check_5="+check_5+"&check_6="+check_6+"&check_7="+check_7+"&check_8="
		+check_8+"&check_9="+check_9+"&accion="+accion;
		
		alert(page)	
		
		
		ajaxc=createRequest();
		ajaxc.open("GET", page,true);
		ajaxc.onreadystatechange=function() {
					
			if (ajaxc.readyState==4) 
			{	
				alert(ajaxc.responseText)
				alert("Se registro correctamente");
				//mostrar_lista_tecnicos('1');
			}
		}
		 ajaxc.send(null)
		 
		 		document.getElementById("usuario").value="";
				document.getElementById("ape_pat_cdc").value="";
				document.getElementById("ape_mat_cdc").value="";
				document.getElementById("nombre_cdc").value="";
				document.getElementById("t_carnet_cdc").value="0";
				document.getElementById("n_carnet_cdc").value="";
				document.getElementById("dni_cdc").value="";				
				document.getElementById("c_carnet_cdc").value="0";
				document.getElementById("c_estado_cdc").value="";
				document.getElementById("detalle_cdc").value="";
		}
}



function sube_archivo_masivo(opc) {
	var iduser = document.getElementById("iduser").value;	
	//alert("entro")
	var pagina_envio="subir_archivo_masivo_wtecnica.php?iduser="+iduser+"&opc="+opc;
	
	ajaxc = createRequest();
    ajaxc.open("get", pagina_envio, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 		
		//alert(ajaxc.responseText);
		alert("Se Cargaron los registros")
		
        }
	}
	ajaxc.send(null)
}


</script>

<style type="text/css">
<!--
.btn-3d {
  padding: .6rem 1rem;
  border: 1px solid #995309;
  border-radius: 4px;
  background-color: #d9750b;
  color: #fff;

  font-size: 1.5rem;
  text-shadow: 0 -1px 0 rgba(0,0,0,.5);
  box-shadow: 0 1px 0 rgba(255,255,255,.5) inset,
    0 1px 3px rgba(0,0,0,.2);
  background-image: -webkit-gradient(linear,left top,left bottom,color-stop(10%,#f90),to(#e76a00));
  background-image: linear-gradient(#f90 10%,#e76a00 100%);
}

.btn-3d:hover, .btn-3d:focus {
  background-color: #e0811b;
  background-image: -webkit-gradient(linear,left top,left bottom,color-stop(10%,#f0a100),to(#f70));
  background-image: linear-gradient(#f0a100 10%,#f70 100%);
}

.btn-3d:active {
  background-color: #cf6a00;
  box-shadow: 0 2px 3px 0 rgba(0,0,0,.2) inset;
  background-image: -webkit-gradient(linear,left top,left bottom,color-stop(10%,#f0a100),to(#f70));
  background-image: linear-gradient(#f0a100 10%,#f70 100%);
}

.redondeadonorelieve {
  border-radius: 5px;
  border: 1px solid #39c;
  font-size:10px;
  font-family:Verdana, Arial, Helvetica, sans-serif  
}

 .outlinenone {
	font-size:12x;
    font-family:Verdana, Arial, Helvetica, sans-serif; 
    outline: none;
    background-color: #dfe;
    border: 0;
 	
 }
.celda_fila {
  border: 1px dotted #295396;
  font-size:12px;
  background-color: #CFEDF8;
  font-family:Verdana, Arial, Helvetica, sans-serif  
}


</style>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<input name="iduser" type="hidden" class="caja_sb" id="iduser" value="<?php echo $iduser; ?>" />
<br>

<div id="div_cab_registro_cdc" style="display:block">
  <table width="70%" border="0" cellpadding="0" cellspacing="0" class="marco_tabla">
    <tr>
      <td colspan="10" valign="top" class="contador">MODULO DE GESTION DE WEB ASIGNACIONES 101 </td>
    </tr>
    <tr>
      <td colspan="10" valign="top" class="caja_sb">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="caja_sb">USUARIO</td>
      <td valign="top"><input name="usuario" type="text" class="caja_texto_pe" id="usuario" /></td>
      <td width="4%" valign="top" class="caja_sb">DNI</td>
      <td width="18%" valign="top"><input name="dni_1" id="dni_1" type="text" class="caja_texto_pe"  onkeypress="return justNumbers(event);" maxlength="8" /></td>
      <td width="7%" valign="top" class="caja_sb">CARNET</td>
      <td valign="top"><input name="carnet_1" type="text" class="caja_texto_pe" id="carnet_1" /></td>
	  <td colspan="3" valign="top">&nbsp;</td>
      <td width="13%" valign="top" class="TitTablaC">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="caja_sb">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td colspan="3" valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
	  <td colspan="3" valign="top">&nbsp;</td>
      <td valign="top" class="TitTablaC">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="10" valign="top" class="caja_sb"><label></label>
          <table width="40%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="26%" class="caja_texto_pe" onclick="javascript:validar_cdc()" align="center"><img src="image/busca1.jpg" width="30" height="30" /> BUSCAR </td>
			   <td width="33%"  class="TitTablaC">&nbsp;</td>
             <!-- <td width="33%" class="caja_texto_pe"onclick="javascript:popup_ussd('1')" align="center"><img src="image/BT6.gif" width="30" height="30" /> MOVIMIENTOS </td>-->
              <td id="bt_registrar_tecnico"  width="41%" class="caja_texto_pe" onclick="javascript:mostrar_div_gestion('REGISTRO')" align="center" style="display:none"><img src="image/BT3.gif" width="30" height="30" /> REGISTRO </td>
            </tr>
        </table></td>		
    </tr>
    <tr>
      <td colspan='12' valign="top" class="TitTablaC">&nbsp;</td>
    </tr>
  </table>
</div>

<br>
<div id="div_data_registro" style="display:none">
</div>
<br>
<div id="div_registro_cdc" style="display:none">
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="marco_tabla"> 
  
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td class="TitTablaC">&nbsp;</td>
    <td colspan="4" class="TitTablaC"><table width="82%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="115" class="caja_texto_pe" align="center" onclick="javascript:volver('2')" style="color:#0000FF">Cancelar</td>
        <td width="93" align="center" class="caja_texto_pe" onclick="javascript:grabar_registro_tecnicos_cdc()" style="color:#0000FF">Guardar</td>
        <!--<td width="122" class="box-blue" align="center" onclick="javascript:mostrar_lista_tecnicos('1')" style="color:#0000FF">
		  <img src="images/traz_registroBN.png" width="25" height="25" />Lista</td>-->
        <td width="756">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="5" valign="top">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">USUARIO </td>
    <td colspan="3">
      <input name="usuario_cdc" type="text" class="caja_texto_pe" id="usuario_cdc" onkeypress="return justNumbers(event);" maxlength="8" />
    </span></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_sb">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="14%" class="TitTablaC">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">DNI</td>
    <td colspan="2" class="caja_texto_pe"><input name="dni_cdc" type="text" class="caja_texto_pe" id="dni_cdc" onkeypress="return justNumbers(event);" maxlength="8" /></td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">PATERNO</td>
    <td colspan="2" class="caja_texto_pe"><input name="ape_pat_cdc" type="text" class="caja_texto_pe"  id="ape_pat_cdc" size="50" maxlength="50" style="text-transform:uppercase;" 
	value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe"><span class="TitTablaB">MATERNO</span></td>
    <td colspan="2" class="caja_texto_pe"><input name="ape_mat_cdc" type="text" id="ape_mat_cdc"  class="caja_texto_pe" size="50" maxlength="50" style="text-transform:uppercase;" 
	value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe"><span class="TitTablaB">NOMBRES:</span></td>
    <td colspan="2" class="caja_texto_pe"><input name="nombre_cdc" type="text" class="caja_texto_pe" id="nombre_cdc" size="50" maxlength="50" style="text-transform:uppercase;" 
	value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  <tr>
    <td width="4%" valign="top">&nbsp;</td>
    <td width="19%" valign="top" class="caja_texto_pe">CARNET</td>
    <td width="31%" class="caja_texto_pe">
	<select name="t_carnet_cdc" class="caja_texto_pe" id="t_carnet_cdc" onchange="javascript:mostrar_carnet_cdc(this.value)" >
      <option value="0">Seleccione</option>
      <option value="1">CON CARNET</option>
      <option value="2">SIN CARNET</option>
    </select>	
	</td>
    <td width="32%" class="caja_texto_pe">
	<div id="d_concarnet_cdc" style="display:none">
	<select id="c_carnet_cdc" name="c_carnet_cdc" class="caja_texto_pe">
      <option value="0">...</option>
      <option value="AB">COBRA</option>
      <option value="LA">LARI</option>
      <option value="CA">EZENTIS</option>
        </select>
      <input name="n_carnet_cdc" type="text" id="n_carnet_cdc" onkeypress="return justNumbers(event);" size="8" maxlength="4" class="caja_texto_pe" />
	</div>	</td>
    <td valign="top">	</td>
    </tr>
  

  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe"><span class="TitTablaB">ESTADO</span></td>
    <td colspan="2" valign="top" class="caja_texto_pe"><select name="c_estado_cdc" class="caja_texto_pe" id="c_estado_cdc" onchange="javascript:mostrar_carnet(this.value)" >
      <option value="A" selected="selected">ACTIVADO</option>
      <option value="D">DESACTIVADO</option>
    </select></td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">OBSERVACIONES</td>
    <td colspan="2" valign="top" class="caja_texto_pe"><textarea name="detalle_cdc" cols="50" rows="4" class="caja_texto_pe" id="detalle_cdc"></textarea></td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_texto_pe">USUARIO MODELO </td>
    <td colspan="2" valign="top" class="caja_texto_pe"><input name="usu_modelo" type="text" id="usu_modelo"  size="20" maxlength="20" class="caja_texto_pe" /></td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="caja_sb">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
    <td valign="top" class="TitTablaB">&nbsp;</td>
    </tr>
  
  <tr>
    <td colspan="5">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">            
      <tr>
        <td width="4%" class="TitTablaB">&nbsp;</td>
        <td width="96%" class="TitTablaB">	
		<!--	
		<table width="40%" border="0" cellpadding="1" cellspacing="1">
          <tr>
            <td class="caja_texto_AMA">OPCIONES DEL MENU - WEB 101 </td>
			<td class='box-blue' align='center'>TODOS<br><input type='checkbox' name='' id=''  /> </td>
			<td class='caja_texto_AMA' align='center'>TODOS
			<br><input type='checkbox' name='checkbox_tcdc' id='checkbox_tcdc'  onclick="javascript:marcaAllCheckBox('3');"  /> </td>
          </tr>
          <tr>
            <td>1211 - CONSULTA HISTORICA</td>
            <td align="center"><input type="checkbox" name="check_cdc_1"  id="check_cdc_1" /></td>
          </tr>
          <tr>
            <td>1212 - PRUEBA CVIEW SECUENCIAL </td>
            <td align="center"><input type="checkbox" name="check_cdc_2" id="check_cdc_2" value="" /></td>
          </tr>
          <tr>
            <td>1213 - REG CAMBIO DE PAR ADSL </td>
            <td align="center"><input type="checkbox" name="check_cdc_3" id="check_cdc_3" value="" /></td>
          </tr>
          <tr>
            <td width="78%">1214 - ATENCION TRAT.TECNICAS </td>
            <td width="22%" align="center"><input type="checkbox" name="check_cdc_4" id="check_cdc_4" value="" /></td>
          </tr>
          <tr>
            <td>1215 - REPORTE TRAT.TECNICAS </td>
            <td align="center"><input type="checkbox" name="check_cdc_5" id="check_cdc_5" value="" /></td>
          </tr>
          <tr>
            <td>1216 - CONSULTA TRAT.TECNICAS </td>
            <td align="center"><input type="checkbox" name="check_cdc_6" id="check_cdc_6" value="" /></td>
          </tr>
          <tr>
            <td>1217 - TABLERO SEG. POR MOTIVOS </td>
            <td align="center"><input type="checkbox" name="check_cdc_7" id="check_cdc_7" value="" /></td>
          </tr>
          <tr>
            <td>1218 -REPORTE PENDIENTES RESUMEN </td>
            <td align="center"><input type="checkbox" name="check_cdc_8" id="check_cdc_8" value="" /></td>
          </tr>
          <tr>
            <td>1219 - REPORTE HISTORICO </td>
            <td align="center"><input type="checkbox" name="check_cdc_9" id="check_cdc_9" value="" /></td>
          </tr>
          
          
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
        </table>		
		-->
		</td>
		<!--
        <td colspan="8" class="TitTablaB" valign="top">
		<div id="bandeja_tecnicos"></div></td>
		-->
        </tr>
      <tr>
        <td colspan="3" class="TitTablaB">&nbsp;</td>
        </tr>
    </table></td>
  </tr> 
</table>
</div>

</body>
</html>
