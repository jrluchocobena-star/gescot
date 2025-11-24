// JavaScript Document

$(document).ready(function () {
  
  var perfil = $('select[name="perfil"]');

$(perfil).change(function (){
	
	var superv = $('select[name="super"]');

switch(perfil.val()){
	
	case '2': //JEFE   
    superv.fadeOut("slow");	  
	break;
	
	case '3': //SUPERVISOR
	superv.fadeOut("slow");	
	break;
	
	default :
	superv.fadeIn("slow");	  
	break;
	
}
	
});
});

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

function logeo(e)
{ //e is event object passed from function invocation
	
	var characterCode;
	
	
	if(e && e.which)
	{ //if which property of event object is supported (NN4)
		e = e
		characterCode = e.which //character code is contained in NN4's which property
	}
	else
	{
		e = event
		characterCode = e.keyCode //character code is contained in IE's keyCode property
	}
	if(characterCode == 13)
	{ 
		
		acceso();	
	}
	else
	{
		return true;
	}
}


/*
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
			var resp=resp.split("|");			

			document.getElementById("idsess").value=resp[0];
			//document.getElementById("idperfil").value=resp[1];

			if (resp[0]=="00"){
				//alert("entro")
				alert ("Datos de Acceso Incorrectos");	
				return;
			}else{						
					var url="index.php?idsess="+resp[0]+"&idperfil="+resp[1]+"&iduser="+resp[2];	
					alert(url)
					window.location = url;				
				
			}
		}
	}
	 ajaxp.send(null)	
	}
			
}
*/

function salir(idsess,iduser){
	
	
	var pag1 = "funciones_cot.php?idsess="+idsess+"&iduser="+iduser+"&accion=cerrar_secion";
	
	//alert(pag1);
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 				
			//alert(ajaxc.responseText);
			window.location = "http://10.226.158.199/COT/login.php";	
        }
	}
	ajaxc.send(null)

}

/********************NUMEROS DE CONTACTO********************/
function GoEnter_contactos(e)
{ //e is event object passed from function invocation
	
	var characterCode;
	
	//alert(e);
	if(e && e.which)
	{ //if which property of event object is supported (NN4)
		e = e
		characterCode = e.which //character code is contained in NN4's which property
	}
	else
	{
		e = event
		characterCode = e.keyCode //character code is contained in IE's keyCode property
	}
	if(characterCode == 13)
	{ //if generated character code is equal to ascii 13 (if enter key)
	//alert("entro")
		mostrar_datos_contacto('2')		
	
	}
	else
	{
		return true;
	}
}


function mostrar_datos_contacto(opc){
	var dni = document.getElementById("dni").value;	
	var usuario = document.getElementById("usu_contactos").value;
	var idperfil = parent.document.getElementById("idperfil").value;
	var ape_pat = document.getElementById("ape_pat").value;	
	var ape_mat = document.getElementById("ape_mat").value;	
	var ncontacto = document.getElementById("ncontacto").value;		
	var pedido = document.getElementById("pedido").value;	
	
	//var iframe = document.getElementById("f_inferior");
	
	if (document.getElementById("usu_contactos").value=="" || document.getElementById("usu_contactos").value==" " || 
	document.getElementById("usu_contactos").value=="undefined"){
		alert("UD.  NO ESTA LOGEADO.... VUELVA A INGRESAR")		
		var win=null;
		win=window.open("login.php",true);	
		return
	}else{
		if (document.getElementById("dni").value=="" && document.getElementById("ncontacto").value==""
		&& document.getElementById("pedido").value==""){		
			var opc="1";
		}else{
			if (document.getElementById("ncontacto").value=="" && document.getElementById("pedido").value==""){
				var opc="2";
			}else{
				if (document.getElementById("ncontacto").value==""){
				var opc="3";
				}else{
				var opc="4";
				}
			}
		}
				
		if (document.getElementById("ape_pat").value=="" && document.getElementById("ape_mat").value=="" 
		&& document.getElementById("dni").value=="" && document.getElementById("ncontacto").value=="" && 
		document.getElementById("pedido").value==""){	
		alert ("Debe ingresar al menos 1 criterio de busqueda");
		document.getElementById("div_lista_contactos").style.display="none"; 
		//document.getElementById("d_editar_contactos").style.display="none";  
		return
		}
		
						
		var pag1 = "detalle_num_contacto.php?dni="+dni+"&opc="+opc+"&pedido="+pedido+"&usuario="+usuario+"&idperfil="+idperfil+"&ncontacto="+ncontacto+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat;	
		
			//alert(pag1);
			
			
			
			ajaxc = createRequest();
			ajaxc.open("get", pag1, true);
			ajaxc.onreadystatechange = function () {
				
				if (ajaxc.readyState == 4) { 	
				//alert(ajaxc.responseText);
				document.getElementById("div_lista_contactos").style.display="block";  
				document.getElementById("div_lista_contactos").innerHTML=ajaxc.responseText;
				document.getElementById("barra_cargando").style.display="none";
				
				
				}
			}
			ajaxc.send(null)
	}
	
}

function menu(opc){	
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var pc = document.getElementById("pc").value;		
	var iframe = document.getElementById("f_modulos");
	
	
	//document.getElementById("d_cambio_contra").style.display="none ";
	
	if (iduser=="" || iduser==" " || iduser=="undefined"){
		alert("UD.  NO ESTA LOGEADO.... VUELVA A INGRESAR")				
		salir('',iduser)		
	}else{	
		
		if (opc=="0"){		 
			 var pag="mantenimiento_usuarios_perfil.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;	 
		}
		
		if (opc=="1"){		 
			 var pag="cab_numero_contactos.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 
		}
		
		if (opc=="2"){		 
			//var pag="modulo_asignaciones.php?iduser="+iduser+"&idperfil="+idperfil;			 		  		
			var pag="cab_modulo_asignaciones.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;		
		}
		
		if (opc=="3"){		 
			 //var pag="panel_control.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;		
			 var pag="cargas/select_archivo.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 
		}
		
		if (opc=="4"){		 
		 var pag="cab_criterios.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;	 	  
		}
		
		if (opc=="5"){		 
		// var pag="registro_incidencias.php?iduser="+iduser+"&idperfil="+idperfil;	 
		 var pag="cab_incidencias.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;	 
		
		}
		
		if (opc=="6"){		 
		 var pag="cab_tecnico.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;	 	  
		}
		
		if (opc=="7"){
			var pag="mantenimiento_usuarios_perfil.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 
			//document.getElementById("d_cambio_contra").style.display="block"; 	  
		}
		
		if (opc=="8"){
			var pag="bandejas/bandeja_general_usuarios.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 		
		}
		
		if (opc=="9"){
			var pag="cab_modulo_beoliquidaciones.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 		
		}
		
		if (opc=="10"){
			var pag="registro_modem_averiados.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 		
		}
		
		if (opc=="11"){
			var pag="cabecera_extras.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 		
		}
		
		if (opc=="12"){
			var pag="cab_capacitaciones.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 		
		}
		
		if (opc=="13"){
			var pag="modulo_gestion_usuarios_cot.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 		
		}
		
		if (opc=="14"){
			var pag="cab_consultas_inc.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 		
		}
		
		if (opc=="15"){		 
			//var pag="modulo_asignaciones.php?iduser="+iduser+"&idperfil="+idperfil;			 		  		
			var pag="cab_modulo_asignaciones_v1.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;		
		}
		
		if (opc=="16"){		 
			 var pag="cab_numero_contactos_tdata.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;		
			 //alert(iduser+"|"+idperfil+"|"+pc)
		}
		
		if (opc=="17"){		 
			 var pag="BANDEJAS/bandeja_registros_101.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;			 
		}
		
		if (opc=="18"){		 
		 var pag="cab_maestracot.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;	 	  
		}
		
		if (opc=="19"){		 
		 var pag="modulo_mantenimientos.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;	 	  
		}
		
		if (opc=="20"){		 
		 var pag="cabecera_usuarios.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;	 	  
		}
		
		if (opc=="21"){		 
		 var pag="panel_manuales.php?iduser="+iduser+"&idperfil="+idperfil;	 	  
		}

		if (opc=="22"){
			var pag="carga_horarios.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;
		}
		if (opc=="23"){
			var pag="importar_dni/form_cargar_dni.php?iduser="+iduser+"&idperfil="+idperfil+"&pc="+pc;
		}
		//alert(pag)
		
		document.getElementById("d_modulos").style.display="block";	
		iframe.style.visibility="visible";	
		iframe.src= pag;
	}
}

//----1------/
function asignar_pedido(iduser){	
	
	document.getElementById("d_pedido").innerHTML="";
	
	var pag = "funciones_cot.php?&iduser="+iduser+"&accion=asignar_pedido";	
	
	//alert(pag)
	
	ajaxp=createRequest();	
	ajaxp.open("GET", pag,true);
	ajaxp.onreadystatechange=function() {

		if (ajaxp.readyState==4){
			var resp = ajaxp.responseText;			
					
			//alert(resp)				
			document.getElementById("d_pedido").innerHTML=ajaxc.responseText;					
			document.getElementById("d_pedido").style.display="block";
			document.getElementById("bandejas_asignaciones").style.display="none";									
			document.getElementById("list_1").style.display="none";
			document.getElementById("list_2").style.display="none";
			document.getElementById("bt_asigna_pedido_on").style.display="none";
			document.getElementById("bt_asigna_pedido_off").style.display="block";	
			document.getElementById("regla_criterios").style.display="none";		
			
		}
	}
	 ajaxp.send(null)	
	 
	
}



function validar_pedido(peticion,fec_reg,iduser,origen,pedido){	
	
	var msn2="Desea atender el pedido "+peticion;
	if (confirm(msn2)){
		
		var pag1 = "funciones_cot.php?peticion="+peticion+"&iduser="+iduser+"&accion=validar_pedido";		
		//alert(pag1)
		
		ajaxp= new createRequest();	
		ajaxp.open("GET", pag1,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp = ajaxp.responseText;			
					//alert(resp)
				if (resp=="OCUPADO"){	
					var msn="El pedido "+ peticion + " se encuentra en proceso"
					alert(msn)	
					return										
				}else{					
					//return
					aceptar_asignacion(peticion,fec_reg,iduser,origen,pedido)	
					//
					popup_reclamo('1',peticion,fec_reg,iduser,origen,pedido)
				}				
															
			}		
		}
		 ajaxp.send(null)
	 }else{		
	rechazar_pedido(peticion,pedido,iduser,'RECHAZO ANTES DE ATENDER');
	return;			
	}				 
}


//----2------/
function aceptar_asignacion(peticion,fec_reg,iduser,origen,pedido){			
		
		
		var pag = "funciones_cot.php?peticion="+peticion+"&fec_reg="+fec_reg+"&origen="+origen+"&pedido="+pedido+"&iduser="+iduser+"&accion=aceptar_asignacion";		
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;	
				//alert(resp1)															
			}		
		}
		 ajaxp.send(null)	
	 
}


//----3------/
function grabar_asignacion(peticion){
	var obs = document.getElementById("obs").value;	
	var iduser = document.getElementById("iduser").value;	
	var exc = document.getElementById("exc").value;
	var pedido = document.getElementById("pedido").value;
	
	if (document.getElementById("obs").value==""){
		alert("Debe ingresar una observacion")
		return
	}else{
			
	var pag1 = "funciones_cot.php?peticion="+peticion+"&exc="+exc+"&pedido="+pedido+"&obs="+obs+"&iduser="+iduser+"&accion=grabar_asignacion";
	
	//alert(pag1);
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
//			var msn2="Desea eliminar? ";
//			if (confirm(msn2)){	
			//contar_pedidos(pedido,iduser);	
			var msn="PEDIDO N°."+peticion+" REGISTRADO";
			alert(msn);
			cerrar_win('2');				
			parent.location.reload();
        }
	}
	ajaxc.send(null)	
	
	}
	
}

function openCity(cityName,frame,iduser,opc) {
    var i;
    var x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none"; 
    }	
	
	  
	document.getElementById(cityName).style.display = "block"; 
	
	conteo_pedidos_operador(iduser);
	
	if (opc=='3'){
		var pag="bandeja_operador.php?&iduser="+iduser+"&opc="+opc;				
		    	
	}else{
		var pag="bandejas/bandeja_general_asignaciones.php?&iduser="+iduser+"&opc="+opc;		    
	}
	//alert(pag);	
	
	document.getElementById(frame).src= pag;
	document.getElementById(frame).style.visibility="visible";	
}


function menu_asig(opc){
	var iduser = document.getElementById("iduser").value;
	
	//alert(opc)
	if (opc=="1"){	
	document.getElementById("d_pedido").style.display="block";	
	document.getElementById("d_gestion").style.display="none";	
	document.getElementById("lista_diario").style.display="none";	
	document.getElementById("bandejas_asignaciones").style.display="none";	
		document.getElementById("dcab_criterios").style.display="none";
	//listar_pedidos(iduser);
	}
	
	if (opc=="2"){	
	document.getElementById("LIST_1").style.display="none";
	document.getElementById("LIST_2").style.display="none";	
	document.getElementById("d_pedido").style.display="none";	
	document.getElementById("d_gestion").style.display="none";	
	document.getElementById("lista_diario").style.display="none";	
	document.getElementById("bandejas_asignaciones").style.display="block";
	document.getElementById("dcab_criterios").style.display="none";
	}
	
	
	if (opc=="3"){	
	listar_pedidos(iduser)
	document.getElementById("d_pedido").style.display="none";	
	document.getElementById("d_gestion").style.display="none";	
	document.getElementById("bandejas_asignaciones").style.display="none";	
	document.getElementById("dcab_criterios").style.display="none";
	}
	
	if (opc=="4"){		
	document.getElementById("dcab_criterios").style.display="block";	
	document.getElementById("fcab_criterios").src="cab_criterios_asi.php?iduser="+iduser;
	
	document.getElementById("d_gestion").style.display="none";	
	document.getElementById("lista_diario").style.display="none";	
	document.getElementById("bandejas_asignaciones").style.display="none";	
	}
	
}

function contar_pedidos(pedido,iduser){	
			
	var pag1 = "funciones_cot.php?pedido="+pedido+"&iduser="+iduser+"&accion=contador_pedidos";
	
	//alert(pag1);
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			var resp = ajaxc.responseText;	
			//alert (resp);
			var resp = resp.split("|");		
			document.getElementById("contador1").value=resp[0];
			document.getElementById("contador2").value=resp[1];
			
//			}
        }
	}
	ajaxc.send(null)	
}

function conteo_pedidos_operador(iduser){	
			
	var pag1 = "funciones_cot.php?iduser="+iduser+"&accion=conteo_pedidos_operador";
	
	//alert(pag1);
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  	
			//alert(ajaxc.responseText)  	
			}        
	}
	ajaxc.send(null)	
}

function listar_pedidos(iduser){	
	
	var pag1 = "funciones_cot.php?iduser="+iduser+"&accion=listar_pedidos";
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			document.getElementById("lista_diario").innerHTML=ajaxc.responseText;	
			document.getElementById("lista_diario").style.display="block";
			}        
	}
	ajaxc.send(null)	
}

function rechazar_pedido(peticion,pedido,iduser,obs){	
	
	var pag1 = "funciones_cot.php?peticion="+peticion+"&pedido="+pedido+"&obs="+obs+"&iduser="+iduser+"&accion=rechazar_pedido";
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			//mostrar_contadores();
			}        
	}
	ajaxc.send(null)	
}

	


function nueva_busqueda(){
	document.getElementById("ape_pat").value="";
	document.getElementById("ape_mat").value="";	
	document.getElementById("dni").value="";
	document.getElementById("pedido").value="";
	document.getElementById("ncontacto").value="";	
	document.getElementById("d_historico_contactos").style.display="none";
	document.getElementById("div_lista_contactos").style.display="none";
	document.getElementById("div_registro_contacto").style.display="none";	
	document.getElementById("dni").focus();	
	
}

function asignar_reglas(user,v_combo,i,ncombo,dni){
	
	var txt=ncombo+i;
	//alert(txt)
	
	var pag1 = "funciones_cot.php?user="+user+"&criterio="+v_combo+"&ncombo="+ncombo+"&dni="+dni+"&accion=asignar_reglas";
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			document.getElementById(txt).value=v_combo;		
			}        
	}
	ajaxc.send(null)	
	
	}

function exportar_gestel_423(accion){	
	
	var page="exportar_gestel_423.php?accion="+accion;
//	alert(page)
	if (accion=="exportar_archivo"){
		document.getElementById("bt_exp").style.display="none";
		document.getElementById("bt_baj").style.display="block";
	}else{
		document.getElementById("bt_exp").style.display="bloc";
		document.getElementById("bt_baj").style.display="none";
	}
	window.open(page);	
		
}



function mostrar_lista_usuarios(opcion){	
	
	var cip = document.getElementById("xcip").value;	
	var area = document.getElementById("c_supervisor").value;
	var dni = document.getElementById("xdni").value;	
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var ncompleto = document.getElementById("xcompleto").value;	
	//alert(opc)
	if (area=="0" && ncompleto=="" && cip=="" && dni==""){
		var pag1 = "bandeja_usuarios.php?cip="+cip+"&area="+area+"&dni="+dni+"&ncompleto="+ncompleto+"&iduser="+iduser+"&idperfil="+idperfil;
	}else{		
		if (cip=="0" && ncompleto==""){
			if (opcion=="1"){
				document.getElementById("bt_editar").style.display="block";		
				document.getElementById("botonera_edit").style.display="block";		
				document.getElementById("bt_busca").style.display="block";
				var pag1 = "mantenimiento_usuarios_edit.php?cip="+cip+"&area="+area+"&dni="+dni
				+"&ncompleto="+ncompleto+"&iduser="+iduser+"&idperfil="+idperfil;
			}
			if (opcion=="2"){	
				document.getElementById("bt_busca").style.display="block";
				document.getElementById("botonera_edit").style.display="none";					
				document.getElementById("bt_editar").style.display="none";		
				var pag1 = "mantenimiento_usuarios_horiz.php?cip="+cip+"&area="+area+"&dni="+dni
				+"&ncompleto="+ncompleto+"&iduser="+iduser+"&idperfil="+idperfil;	
			}			
		}else{
			var pag1 = "bandeja_usuarios.php?cip="+cip+"&area="+area+"&dni="+dni+"&ncompleto="+ncompleto+"&iduser="+iduser+"&idperfil="+idperfil;
		}		
		
	}
	
	//alert(pag1)
	
	
	document.getElementById("bandeja_criterios").style.display="block";
	document.getElementById("lista_criterios").style.visibility="visible";
	document.getElementById("lista_criterios").src= pag1;

	document.getElementById("d_reg_usuario").style.display="none";	
	document.getElementById("d_datos_usuarios").style.display="none";	
	
	
	
}

function mostrar_edicion_maestra(opcion){	
	//alert(opcion)
	var cip = document.getElementById("xcip").value;	
	var area = document.getElementById("c_supervisor").value;
	var dni = document.getElementById("xdni").value;	
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var ncompleto = document.getElementById("xcompleto").value;	
	//alert(opc)
	
	if (opcion=="1"){
				parent.document.getElementById("bt_editar").style.display="none";				
				document.getElementById("bt_busca").style.display="block";								
				var pag2 = "mantenimiento_usuarios_edit.php?cip="+cip+"&area="+area+"&dni="+dni
				+"&ncompleto="+ncompleto+"&iduser="+iduser+"&idperfil="+idperfil;
	}
	if (opcion=="2"){	
				document.getElementById("bt_busca").style.display="block";			
				document.getElementById("bt_editar").style.display="block";			
				var pag2 = "mantenimiento_usuarios_horiz.php?cip="+cip+"&area="+area+"&dni="+dni
				+"&ncompleto="+ncompleto+"&iduser="+iduser+"&idperfil="+idperfil;						
	
	}	
	
	
	document.getElementById("bandeja_criterios").style.display="block";
	document.getElementById("lista_criterios").style.visibility="visible";
	document.getElementById("lista_criterios").src= pag2;

	document.getElementById("d_reg_usuario").style.display="none";	
	document.getElementById("d_datos_usuarios").style.display="none";	
		
}


function mostrar_lista_usuarios_asi(){
	var cip = document.getElementById("xcip").value;		
	var dni = document.getElementById("xdni").value;	
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	
	
	
	var pag1 = "usuarios_asignaciones.php?cip="+cip+"&dni="+dni+"&iduser="+iduser+"&idperfil="+idperfil;
	document.getElementById("bandeja_criterios").style.display="block";
	document.getElementById("lista_criterios").src= pag1;
	document.getElementById("lista_criterios").style.visibility="visible";	
	
	
	
}

function mostrar_datos_usuarios(dni){		
	var pag2 = "mantenimiento_usuarios.php?dni="+dni;
	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag2, true);
    ajaxc1.onreadystatechange = function () {
		
        if (ajaxc1.readyState == 4) {
			//alert(ajaxc1.responseText)  	
			parent.document.getElementById("d_datos_usuarios").style.display="block";
			parent.document.getElementById("d_datos_usuarios").innerHTML=ajaxc1.responseText;								
			parent.document.getElementById("WEB_SIGTP_MAPA_GIG").focus();
			}        
	}
	ajaxc1.send(null)	
	
}


function actualizar_datos_usu(dni){	
	var USUARIO_GESTEL = document.getElementById("USUARIO_GESTEL").value;	
	var USUARIO_MULTICONSULTA = document.getElementById("USUARIO_MULTICONSULTA").value;	
	var USUARIO_INTRAWAY = document.getElementById("USUARIO_INTRAWAY").value;
	var USUARIO_WEB_UNIFICADA = document.getElementById("USUARIO_WEB_UNIFICADA").value;	
	var USUARIO_PSI = document.getElementById("USUARIO_PSI").value;	
	var USUARIO_ATIS = document.getElementById("USUARIO_ATIS").value;
	var USUARIO_CMS = document.getElementById("USUARIO_CMS").value;	
	var PERFIL = document.getElementById("PERFIL").value;	
	var USUARIO_INCIDENCIAS_PSI = document.getElementById("USUARIO_INCIDENCIAS_PSI").value;	
	var CLEAR_VIEW = document.getElementById("CLEAR_VIEW").value;
	var REPARTIDOR = document.getElementById("REPARTIDOR").value;	
	var PDM = document.getElementById("PDM").value;	
	var WEB_SARA = document.getElementById("WEB_SARA").value;	
	var WEB_ASEGURAMIENTO = document.getElementById("WEB_ASEGURAMIENTO").value;
	var WEB_ARPU_CALCULADORA = document.getElementById("WEB_ARPU_CALCULADORA").value;	
	var USUARIO_GENIO = document.getElementById("USUARIO_GENIO").value;	
	var WEB_ASIGNACIONES = document.getElementById("WEB_ASIGNACIONES").value;
	var WEB_SIGTP_MAPA_GIG = document.getElementById("WEB_SIGTP_MAPA_GIG").value;	
	
	var pag2 = "funciones_cot.php?dni="+dni+"&USUARIO_GESTEL="+USUARIO_GESTEL+"&USUARIO_MULTICONSULTA="+USUARIO_MULTICONSULTA+"&USUARIO_INTRAWAY="+USUARIO_INTRAWAY+"&USUARIO_WEB_UNIFICADA="+USUARIO_WEB_UNIFICADA+"&USUARIO_PSI="+USUARIO_PSI+"&USUARIO_ATIS="+USUARIO_ATIS+"&USUARIO_CMS="+USUARIO_CMS+"&USUARIO_INCIDENCIAS_PSI="+USUARIO_INCIDENCIAS_PSI+"&CLEAR_VIEW="+CLEAR_VIEW+"&PERFIL="+PERFIL+"&PDM="+PDM+"&REPARTIDOR="+REPARTIDOR+"&WEB_SARA="+WEB_SARA+"&WEB_ASEGURAMIENTO="+WEB_ASEGURAMIENTO+"&WEB_ARPU_CALCULADORA="+WEB_ARPU_CALCULADORA+"&USUARIO_GENIO="+USUARIO_GENIO+"&WEB_ASIGNACIONES="+WEB_ASIGNACIONES+"&WEB_SIGTP_MAPA_GIG="+WEB_SIGTP_MAPA_GIG+"&accion=actualizar_datos_usu";
	//alert(pag2)	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag2, true);
    ajaxc1.onreadystatechange = function () {
		
        if (ajaxc1.readyState == 4) {
			//alert(ajaxc1.responseText)  		
			alert("SE ACTUALIZARON LOS DATOS CORRECTAMENTE")				
			
			}        
	}
	ajaxc1.send(null)	
	
}


function nuevo_usuario(){	
document.getElementById("d_reg_usuario").style.display="block";
document.getElementById("bandeja_criterios").style.display="none";	
document.getElementById("d_datos_usuarios").style.display="none";

}




function registrar_usuario(){	
	var dni = document.getElementById("dni").value;	
	var iduser = document.getElementById("iduser").value;	
	var cip = document.getElementById("cip").value;
	var perfil = document.getElementById("perfil").value;	
	var ape_pat = document.getElementById("APE_PAT").value;
	var ape_mat = document.getElementById("APE_MAT").value;
	var grupo = document.getElementById("grupo").value;
	var fec_nac = document.getElementById("fec_nacimiento").value;
	var nombres = document.getElementById("NOMBRES").value;	
	var ncompleto = document.getElementById("APE_PAT").value + " " + document.getElementById("APE_MAT").value+" , "+document.getElementById("NOMBRES").value;	
	var login = document.getElementById("login").value;		
	var clave = document.getElementById("clave").value;		
	var ola = document.getElementById("ola").value;	
    var sup = document.getElementById("super").value;		
	
	if (document.getElementById("dni").value=="" || ncompleto=="" || document.getElementById("login").value==""
	 && document.getElementById("clave").value=="" || document.getElementById("cip").value=="" ||
	 document.getElementById("grupo").value=="0" ||  document.getElementById("perfil").value=="0"){	
		alert("Datos Vacios");
		return	
	}
	
	switch(perfil){
	
	case '2': //JEFE   
 
	break;
	
	case '3': //SUPERVISOR

	break;
	
	default :
	
	if(sup == ''){
	alert("El campo de Supervisor no puedo ir vacio");
    return false;	
	}
	
	break;
	
    }
	
	
	
	var pag2 = "funciones_cot.php?dni="+dni+"&iduser="+iduser+"&perfil="+perfil+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&nombres="+nombres+"&clave="+clave
	+"&cip="+cip+"&grupo="+grupo+"&fec_nac="+fec_nac+"&ncompleto="+ncompleto+"&login="+login+"&ola="+ola+"&sup="+sup+"&accion=registrar_usuario";
	//alert(pag2)	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag2, true);
    ajaxc1.onreadystatechange = function () {
		
        if (ajaxc1.readyState == 4) {
			alert(ajaxc1.responseText)  	
			document.getElementById("bt_grabar_usu").style.display="none";	
			parent.modal.hide();
			parent.location.reload();	
			}   
	}
	ajaxc1.send(null)	
			
}


function actualizar_datos_usu_horiz(){	
	
	/*
	var USUARIO_GESTEL = document.getElementById("USUARIO_GESTEL").value;		
	var USUARIO_MULTICONSULTA = document.getElementById("USUARIO_MULTICONSULTA").value;	
	var USUARIO_INTRAWAY = document.getElementById("USUARIO_INTRAWAY").value;
	var USUARIO_WEB_UNIFICADA = document.getElementById("USUARIO_WEB_UNIFICADA").value;	
	var USUARIO_PSI = document.getElementById("USUARIO_PSI").value;	
	var USUARIO_ATIS = document.getElementById("USUARIO_ATIS").value;
	var USUARIO_CMS = document.getElementById("USUARIO_CMS").value;			
	var USUARIO_INCIDENCIAS_PSI = document.getElementById("USUARIO_INCIDENCIAS_PSI").value;	
	var CLEAR_VIEW = document.getElementById("CLEAR_VIEW").value;
	var REPARTIDOR = document.getElementById("REPARTIDOR").value;	
	var PDM = document.getElementById("PDM").value;	
	var WEB_SARA = document.getElementById("WEB_SARA").value;	
	var WEB_ASEGURAMIENTO = document.getElementById("WEB_ASEGURAMIENTO").value;
	var WEB_ARPU_CALCULADORA = document.getElementById("WEB_ARPU_CALCULADORA").value;	
	var USUARIO_GENIO = document.getElementById("USUARIO_GENIO").value;	
	var WEB_ASIGNACIONES = document.getElementById("WEB_ASIGNACIONES").value;
	var WEB_SIGTP_MAPA_GIG = document.getElementById("WEB_SIGTP_MAPA_GIG").value;
	var usuario_red= document.getElementById("usuario_red").value;

	*/
	var iduser = document.getElementById("iduser").value;
	var id_g = document.getElementById("id_g").value;
	var dni = document.getElementById("n_dni").value;
	var cip = document.getElementById("cip").value;
	var motivo_act = document.getElementById("motivo_act").value;
	var PERFIL = document.getElementById("idperfil").value;
	var correo_p = document.getElementById("correo_p").value;	
	var correo_w = document.getElementById("correo_w").value;	
	var celular1 = document.getElementById("celular1").value;	
	var celular2 = document.getElementById("celular2").value;	
	var anexo = document.getElementById("anexo").value;	
	var pc = document.getElementById("pc_").value;	
	var pcmonitor = document.getElementById("pcmonitor").value;	
	var c_emergencia = document.getElementById("c_emergencia").value;
	var fec_nac = document.getElementById("fec_nac").value;	
	var motivo_cambio= document.getElementById("motivo_cambio").value;
	var c_area= document.getElementById("c_area").value;
	var xestado= document.getElementById("xestado").value;
	var ape_pat = document.getElementById("ape_pat").value;
	var ape_mat = document.getElementById("ape_mat").value;
	var nombres = document.getElementById("nombres").value;		
	var ncompleto = document.getElementById("ape_pat").value + " " + document.getElementById("ape_mat").value+" , "+document.getElementById("nombres").value;	

		
	if (document.getElementById("motivo_cambio").value==""){
		alert("OBLIGATORIO: Debe ingresar el motivo de la actualizacion de informacion")				
		return
		
	}else{
		
	
	
	if (document.getElementById("c_local").value=="0"){
		if (document.getElementById("i_local").value==""){
			alert("OBLIGATORIO: Local Vacio")				
			return
		}else{
			var local= document.getElementById("i_local").value;
		}
		
	}else{
		var local = document.getElementById("c_local").value;
	}	
	
	if (document.getElementById("c_grupo").value=="0"){
		var grupo= document.getElementById("i_grupo").value;
	}else{
		var grupo = document.getElementById("c_grupo").value;
	}	
	
	if (document.getElementById("c_cargocot").value=="0"){
		
		if (document.getElementById("i_cargocot").value==""){
			alert("OBLIGATORIO: Cargo Vacio")				
			return
		}else{
			var sgrupo= document.getElementById("i_cargocot").value;
		}
	}else{
		var sgrupo = document.getElementById("c_cargocot").value;
	}	
	
	if (document.getElementById("c_supervisor").value=="0"){
		var supervisor= document.getElementById("i_supervisor").value;
	}else{
		var supervisor = document.getElementById("c_supervisor").value;
	}
	
	if (document.getElementById("c_monitor").value=="0"){
		var monitor= document.getElementById("i_monitor").value;
	}else{
		var monitor = document.getElementById("c_monitor").value;
	}
	
	if (document.getElementById("c_area").value=="0"){
		var area= document.getElementById("i_area").value;
	}else{
		var area = document.getElementById("c_area").value;
	}
	
	
	if (document.getElementById("c_perfil").value=="T"){
		var perfil= document.getElementById("i_perfil").value;
	}else{
		var perfil = document.getElementById("c_perfil").value;
	}
	
	if (document.getElementById("c_olas").value=="T"){
		var olas= document.getElementById("i_olas").value;
	}else{
		var olas = document.getElementById("c_olas").value;
	}
	
	if (document.getElementById("c_wifi").value=="0"){
		var c_wifi= document.getElementById("i_wifi").value;
	}else{
		var c_wifi = document.getElementById("c_wifi").value;
	}
	if (document.getElementById("c_audifonos").value=="0"){
		var c_audifonos= document.getElementById("i_audifonos").value;
	}else{
		var c_audifonos = document.getElementById("c_audifonos").value;
	}
	if (document.getElementById("c_sillas").value=="T"){
		var c_sillas= document.getElementById("i_sillas").value;
	}else{
		var c_sillas = document.getElementById("c_sillas").value;
	}
	
	
	//alert(perfil)
	/*
	var pag2 = "funciones_cot.php?dni="+dni+"&id_g="+id_g+"&cip="+cip+"&USUARIO_GESTEL="+USUARIO_GESTEL+"&USUARIO_MULTICONSULTA="+USUARIO_MULTICONSULTA+"&USUARIO_INTRAWAY="+USUARIO_INTRAWAY+"&USUARIO_WEB_UNIFICADA="+USUARIO_WEB_UNIFICADA+"&USUARIO_PSI="+USUARIO_PSI+"&USUARIO_ATIS="+USUARIO_ATIS+"&USUARIO_CMS="+USUARIO_CMS+"&USUARIO_INCIDENCIAS_PSI="+USUARIO_INCIDENCIAS_PSI+"&CLEAR_VIEW="+CLEAR_VIEW+"&perfil="+perfil+"&PDM="+PDM+"&REPARTIDOR="+REPARTIDOR+"&WEB_SARA="+WEB_SARA+"&WEB_ASEGURAMIENTO="+WEB_ASEGURAMIENTO+"&WEB_ARPU_CALCULADORA="+WEB_ARPU_CALCULADORA+"&USUARIO_GENIO="+USUARIO_GENIO+"&supervisor="+supervisor+"&monitor="+monitor+"&WEB_ASIGNACIONES="+WEB_ASIGNACIONES+"&correo_p="+correo_p+"&correo_w="+correo_w+"&celular1="+celular1+"&celular2="+celular2+"&anexo="+anexo+"&c_emergencia="+c_emergencia+"&fec_nac="+fec_nac+"&pc="+pc+"&pcmonitor="+pcmonitor+"&iduser="+iduser+"&area="+area+"&ncompleto="+ncompleto+"&xestado="+xestado+"&local="+local+"&olas="+olas+"&usuario_red="+usuario_red+"&motivo_cambio="+motivo_cambio+"&WEB_SIGTP_MAPA_GIG="+WEB_SIGTP_MAPA_GIG+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&nombres="+nombres+"&accion=actualizar_datos_usu_horiz";
	*/
	var pag2 = "funciones_cot.php?dni="+dni+"&id_g="+id_g+"&cip="+cip+"&correo_p="+correo_p+"&correo_w="+correo_w+"&celular1="+celular1+"&celular2="+celular2+"&anexo="+anexo+"&c_emergencia="+c_emergencia+"&fec_nac="+fec_nac+"&pc="+pc+"&pcmonitor="+pcmonitor+"&iduser="+iduser+"&area="+area+"&ncompleto="+ncompleto+"&xestado="+xestado+"&local="+local+"&olas="+olas+"&motivo_cambio="+motivo_cambio+"&perfil="+perfil+"&grupo="+grupo+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&supervisor="+supervisor+"&monitor="+monitor+"&nombres="+nombres+"&motivo_act="+motivo_act+"&c_wifi="+c_wifi+"&c_audifonos="+c_audifonos+"&c_sillas="+c_sillas+"&sgrupo="+sgrupo+"&accion=actualizar_datos_usu_horiz";
	
	//alert(pag2)	
	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag2, true);
    ajaxc1.onreadystatechange = function () {
		
        if (ajaxc1.readyState == 4) {
			//alert(ajaxc1.responseText)  				
			alert("SE ACTUALIZARON LOS DATOS CORRECTAMENTE")
			
			var pag1 = "bandeja_usuarios.php?cip="+cip+"&area="+area+"&dni="+dni+"&ncompleto="+ncompleto;
			parent.document.getElementById("lista_criterios").src= pag1;
			/*
			var pag1 = "bandeja_usuarios.php";					
			var pag1 = "mantenimiento_usuarios_perfil.php?dni="+dni;
			
			*/
			
			
			}        
	}
	ajaxc1.send(null)	
	}
	
	/*
	document.getElementById("xcip").value="";
	document.getElementById("xdni").value="";
	document.getElementById("xcompleto").value="";	
	document.getElementById("c_supervisor").value="";
	*/
}

function carga_combo(nom_combo,valor1){		
		
		var valor1= valor1;
		var valor1=valor1.split("|");
		var valor1=valor1[0];
		
		//alert(document.getElementById("c_mot_gru").value)
		
		/*
		if (document.getElementById("c_mot_gru").value=="PERMISO"){ //mostrar boton compensacion
			
			document.getElementById("bt_compensacion").style.display="block";
		}else{
			document.getElementById("bt_compensacion").style.display="none"; 
		}
		*/
		
		if (document.getElementById("c_mot_gru").value=="INCIDENCIAS DE SISTEMAS"){			
			document.getElementById("div_msn_incsis").style.display="block";
			document.getElementById("div_doid").style.display="block";
		}else{
			document.getElementById("div_msn_incsis").style.display="none"; 
			document.getElementById("div_doid").style.display="none";
		}
		
		
		var urlx = "funciones_cot.php?valor1="+valor1+"&combo="+nom_combo+"&accion=carga_combo";	
		
		
		//alert(urlx)
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			//alert(ajaxc.responseText);
			if (ajaxc.readyState==4) 
			{				
				document.getElementById(nom_combo).innerHTML = ajaxc.responseText;			
			
			}
		}
		 ajaxc.send(null)	
	
	/*	 
	if (valor1=="INCIDENCIAS DE SISTEMAS"){
		document.getElementById("d_doid").style.display="block";	
		document.getElementById("d_numero_afe").style.display="block";	
	}else{
		document.getElementById("d_doid").style.display="none";	
		document.getElementById("d_numero_afe").style.display="none";	
	}	 
	*/
	
	
	
	
	/*
	 document.getElementById("input1").value="";
 	 document.getElementById("input2").value="";
 	 document.getElementById("input3").value="";
 	 document.getElementById("h_ini").value="0";
	 document.getElementById("c_mot_inc").value="0";
	 document.getElementById("modo").value="0";
	 document.getElementById("h_fin").value="0";
	 document.getElementById("tiempo").value="0";
	 document.getElementById("f_dias").style.display="none";
 	 document.getElementById("f_horas").style.display="none";
	 */
}


function grabar_incidencia(opc){
var iduser = document.getElementById("iduser").value;	
var idperfil = document.getElementById("idperfil").value;	
var tp_incidencia = document.getElementById("tp_incidencia").value;	

var obs = document.getElementById("obs").value;	

	if (opc=="1"){
		var trabajador = document.getElementById("gestor").value;
		
		if (document.getElementById("gestor").value=="0"){
		alert("DEBE INGRESAR DATOS DEL TRABAJADOR")	
		return
		}
	}else{	
		var trabajador = document.getElementById("cip").value + "-" + document.getElementById("dni").value;
	}

if (document.getElementById("iduser").value==""){
	alert("VUELVA A LOGEARSE...")	
	window.open='http://10.226.158.199/cot/login.php';
	return
}

var tiempo = document.getElementById("tiempo").value;	

var c_doid = document.getElementById("c_doid").value;	
var nro = document.getElementById("nro").value;

if (document.getElementById("modo").value=="0"){
		var fec1 = document.getElementById("input1").value;	
		var fec2 = document.getElementById("input2").value;	
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
		
		var modo = "D";	
}else{
	var modo = document.getElementById("modo").value;	
	
	if (document.getElementById("modo").value=="D"){
		var fec1 = document.getElementById("input1").value;	
		var fec2 = document.getElementById("input2").value;	
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
	
	}else{
		
		var fec1 = document.getElementById("input3").value;	
		var fec2 = document.getElementById("input3").value;	
		
		var h_ini = document.getElementById("h_ini").value +":"+ document.getElementById("mm_ini").value;	
		var h_fin = document.getElementById("h_fin").value +":"+ document.getElementById("mm_fin").value;	
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
		
	}
}


if (document.getElementById("tiempo").value=="0"){
	alert("ERROR: TIEMPO NO INGRESADO");
	return	
}


if (document.getElementById("tp_incidencia").value=="0"){
	alert("DEBE ESCOGER UN TIPO INCIDENCIA");
	return	
}

if (document.getElementById("combo_mot").value=="0"){
	alert("DEBE ESCOGER MOTIVO");
	return	
}


if (document.getElementById("obs").value==""){
	alert("DEBE INGRESAR UNA OBSERVACION");
	return	
}
/*
if (idperfil=="5" || idperfil=="0"){
	var num_part = document.getElementById("num_part").value;			
}else{
	var num_part = "";			
	}
*/

var c_mot_inc = document.getElementById("combo_mot").value;	
/*
var pag1 = "funciones_cot.php?iduser="+iduser+"&trabajador="+trabajador+"&tp_incidencia="+tp_incidencia+"&c_mot_inc="+c_mot_inc+"&num_part="+num_part+"&fec_ini="+fec1+"&modo="+modo+"&tiempo="+tiempo+"&fec_fin="+fec2+"&obs="+obs+"&accion=grabar_incidencia";
*/

var pag1 = "funciones_cot.php?iduser="+iduser+"&trabajador="+trabajador+"&tp_incidencia="+tp_incidencia+"&c_mot_inc="+c_mot_inc+"&c_doid="+c_doid+"&nro="+nro+"&fec_ini="+xfec_ini+"&modo="+modo+"&opc="+opc+"&tiempo="+tiempo+"&fec_fin="+xfec_fin+"&obs="+obs+"&accion=grabar_incidencia";


//alert(pag1)

	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag1, true);
    ajaxc1.onreadystatechange = function () {
		
		//alert(ajaxc1.responseText)  	
		
        if (ajaxc1.readyState == 4) {	
																		
			alert(ajaxc1.responseText)	
			parent.ras.hide();
			parent.location.reload();		
			}        
	}
	ajaxc1.send(null)
		
		var cri1="";
		var cc="bandejas/bandeja_general_incidencias.php?iduser="+iduser+"&idperfil="+idperfil+"&cri1="+cri1;			
		parent.document.getElementById("f_incidencias").src=cc;
				
						
			document.getElementById("d_edit_incidencia").style.display="none";		
			document.getElementById("tecnico").value="";
			document.getElementById("tp_incidencia").value="";
			document.getElementById("combo_mot").value="";
			document.getElementById("input1").value="";
			document.getElementById("input2").value="";
			document.getElementById("obs").value="";
					
					
			
}

function grabar_capacitacion(){
var iduser = document.getElementById("iduser").value;	
var idperfil = document.getElementById("idperfil").value;	
var tp_incidencia = document.getElementById("tp_incidencia").value;	

var obs = document.getElementById("obs").value;	
var trabajador = document.getElementById("cip").value+"-"+document.getElementById("dni").value;
var tiempo = document.getElementById("tiempo").value;	
var modo = document.getElementById("modo").value;	
var c_inc = document.getElementById("c_inc").value;	
var c_mot_inc = document.getElementById("combo_mot").value;	
var dni_escogidos = document.getElementById("arr_escogidos").value;	
var nro_escogidos = document.getElementById("chk_escogidos").value;	
var s_tipo = document.getElementById("tp_capa").value;	
var tema = document.getElementById("tema").value;	

if (document.getElementById("modo").value=="0"){
		var fec1 = document.getElementById("input1").value;	
		var fec2 = document.getElementById("input2").value;	
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
		
	
}else{
	if (document.getElementById("modo").value=="D"){
		var fec1 = document.getElementById("input1").value;	
		var fec2 = document.getElementById("input2").value;	
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
	
	}else{
		
		var fec1 = document.getElementById("input3").value;	
		var fec2 = document.getElementById("input3").value;	
		
		var h_ini = document.getElementById("h_ini").value +":"+ document.getElementById("mm_ini").value;	
		var h_fin = document.getElementById("h_fin").value +":"+ document.getElementById("mm_fin").value;	
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
		
	}
}



if (document.getElementById("tp_incidencia").value=="0"){
	alert("DEBE ESCOGER UN TIPO INCIDENCIA");
	return	
}

if (document.getElementById("combo_mot").value=="0"){
	alert("DEBE ESCOGER MOTIVO");
	return	
}


if (document.getElementById("obs").value==""){
	alert("DEBE INGRESAR UNA OBSERVACION");
	return	
}
if (document.getElementById("c_incx").value=="INC-1"){
	alert("ERROR EN EL CORRELATIVO");
	return	
}

/*
if (idperfil=="5" || idperfil=="0"){
	var num_part = document.getElementById("num_part").value;			
}else{
	var num_part = "";			
	}

var pag1 = "funciones_cot.php?iduser="+iduser+"&trabajador="+trabajador+"&tp_incidencia="+tp_incidencia+"&c_mot_inc="+c_mot_inc+"&num_part="+num_part+"&fec_ini="+fec1+"&modo="+modo+"&tiempo="+tiempo+"&fec_fin="+fec2+"&obs="+obs+"&accion=grabar_incidencia";
*/

var pag1 = "../funciones_cot.php?iduser="+iduser+"&trabajador="+trabajador+"&tp_incidencia="+tp_incidencia+"&c_mot_inc="+c_mot_inc+"&c_inc="+c_inc+"&fec_ini="+xfec_ini+"&modo="+modo+"&dni_escogidos="+dni_escogidos+"&nro_escogidos="+nro_escogidos+"&tiempo="+tiempo+"&s_tipo="+s_tipo+"&tema="+tema+"&fec_fin="+xfec_fin+"&obs="+obs+"&accion=grabar_capacitacion";


//alert(pag1)

	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag1, true);
    ajaxc1.onreadystatechange = function () {
		
		//alert(ajaxc1.responseText)  	
		
        if (ajaxc1.readyState == 4) {																	
			alert("Se registro exitosamente")	
			parent.ras.hide();
			parent.location.reload();
			}        
	}
	ajaxc1.send(null)
		/*
		var cri1="";
		var cc="bandejas/bandeja_general_incidencias.php?iduser="+iduser+"&idperfil="+idperfil+"&cri1="+cri1;			
		parent.document.getElementById("f_incidencias").src=cc;
				
						
			document.getElementById("d_edit_incidencia").style.display="none";		
			document.getElementById("tecnico").value="";
			document.getElementById("tp_incidencia").value="";
			document.getElementById("combo_mot").value="";
			document.getElementById("input1").value="";
			document.getElementById("input2").value="";
			document.getElementById("obs").value="";
		*/			
					
			
}



function mant_incidencia(opc){
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	
	if (opc=="1"){				
	
	document.getElementById("cab_incidencia").style.display="none";
	document.getElementById("cab_capacitacion").style.display="none";			
	document.getElementById("d_edit_incidencia").style.display="none";
	
	document.getElementById("d_nuevo_incidencia").style.display="block";
	document.getElementById("d_bandeja_incidencias").style.display="block";
		
	var pag1="bandeja_incidencias_sup.php?iduser="+iduser+"&idperfil="+idperfil;
	//alert(idperfil)
	
	document.getElementById("f_bandeja_incidencias").src=pag1;	
	document.getElementById("bt_buscar_incidencia").style.display="block";	
	document.getElementById("bt_grabar_incidencia").style.display="block";		
	
	}

	if (opc=="2"){
	//alert("entro2")
	document.getElementById("d_nuevo_incidencia").style.display="none";		
	document.getElementById("d_nuevo_incidencia").style.display="none";
	document.getElementById("d_edit_incidencia").style.display="none";		
	document.getElementById("cab_capacitacion").style.display="none";	
	

	
	document.getElementById("cab_incidencia").style.display="block";	
	document.getElementById("d_bandeja_incidencias").style.display="block";	
	document.getElementById("bt_buscar_incidencia").style.display="block";	
			
	var pag="bandeja_incidencias.php?iduser="+iduser;
	//alert(pag)
	document.getElementById("f_bandeja_incidencias").src=pag;
	
	}
	
	
	
	if (opc=="3"){
	var cip = document.getElementById("xcip").value;	
	var supervisor = document.getElementById("c_supervisor").value;
	var fec_ini = document.getElementById("input3").value;
	var fec_fin = document.getElementById("input4").value;
			
	var pag="bandejas/bandeja_incidencias_sup.php?iduser="+iduser+"&idperfil="+idperfil;
	//alert(idperfil)
	document.getElementById("d_bandeja_incidencias").style.display="block";
	document.getElementById("f_bandeja_incidencias").src=pag;
	
	
	}
	
	if (opc=="4"){
		document.getElementById("xcip").value="";
		document.getElementById("c_supervisor").value="0";
		document.getElementById("input3").value="";
		document.getElementById("input4").value="";
	}
	
	if (opc=="5"){	
	var cri1 = document.getElementById("xmes1").value;	
	var cri2 = document.getElementById("c_supervisor").value;
	
	var url="reporte_incidencias.php?iduser="+iduser+"&cri2="+cri2+"&cri1="+cri1+"&idperfil="+idperfil;
	
	
	win=window.open(url,true);
	}
	
	if (opc=="6"){
		//var cri1 = document.getElementById("xmes2").value;	
		var fec_i = document.getElementById("an_i").value+"-"+document.getElementById("mes_i").value+"-"+document.getElementById("dia_i").value;	
		var fec_f = document.getElementById("an_f").value+"-"+document.getElementById("mes_f").value+"-"+document.getElementById("dia_f").value;
		
		var cri2 = document.getElementById("c_monitor").value;
			
		
		
			var url="reporte_capacitaciones.php?iduser="+iduser+"&cri2="+cri2+"&fec_i="+fec_i+"&fec_f="+fec_f+"&idperfil="+idperfil;
			win=window.open(url,true);		
		
	
		//alert(url)
	}
	
	if (opc=="7"){ 	
	document.getElementById("cab_capacitacion").style.display="block";	
	
	document.getElementById("cab_incidencia").style.display="none";		
	document.getElementById("d_nuevo_incidencia").style.display="none";		
	document.getElementById("d_nuevo_incidencia").style.display="none";
	parent.document.getElementById("d_edit_incidencia").style.display="none";
	
	document.getElementById("d_bandeja_incidencias").style.display="block";
	document.getElementById("bt_buscar_incidencia").style.display="block";
	
	
	
			
	var pag="bandeja_incidencias.php?iduser="+iduser;
	//alert(pag)
	document.getElementById("f_bandeja_incidencias").src=pag;
	
	}
	
	if (opc=="8"){
	var cip = document.getElementById("xcip2").value;	
	var supervisor = document.getElementById("c_monitor").value;
	var xmes = document.getElementById("xmes2").value;
			
	var pag="bandeja_incidencias_capa.php?iduser="+iduser+"&cip="+cip+"&supervisor="+supervisor+"&xmes="+xmes+"&idperfil="+idperfil;
	//alert(pag)
	document.getElementById("d_bandeja_incidencias").style.display="block";
	document.getElementById("f_bandeja_incidencias").src=pag;
	
	}
	
	if (opc=="9"){	
	/*
	var cri1 = document.getElementById("xmes1").value;	
	var cri2 = document.getElementById("c_supervisor").value;
	
	
	var url="reporte_beoliquidaciones.php?iduser="+iduser+"&cri2="+cri2+"&cri1="+cri1+"&idperfil="+idperfil;
	*/
	var url="reporte_beoliquidaciones.php";
	win=window.open(url,true);
	}
	
	
}


function borrar_incidencia(id){
		var iduser = document.getElementById("iduser").value;		
		var urlx = "funciones_cot.php?id="+id+"&iduser="+iduser+"&accion=borrar_incidencia";	
		
		
		//alert(urlx)
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			//alert(ajaxc.responseText);
			if (ajaxc.readyState==4) 
			{			
				alert("Registro Eliminado")
				//parent.document.location.reload();
				var pag="bandeja_incidencias.php?iduser="+iduser;	
				parent.document.getElementById("f_bandeja_incidencias").src=pag;
				
			
			}
		}
		 ajaxc.send(null)	
		 
}




function blanquea_criterio(){	
				document.getElementById("lista_criterios").src="";	
				document.getElementById("lista_criterios").style.visibility="none";
				document.getElementById("bt_editar").style.display="none";					
				document.getElementById("xcip").value="";
				document.getElementById("xdni").value="";
				document.getElementById("xcompleto").value="";
				document.getElementById("c_supervisor").value="0";
				
}

function edit_incidencia(campo1,campo2,campo3,campo4,campo5,campo6,campo7){	
	if (campo7=="HORAS EXTRAS"){
		//alert("entro")
		parent.document.getElementById("ejecutado").style.display="block";
		parent.document.getElementById("ejec").style.display="block";
	}else{
		parent.document.getElementById("ejecutado").style.display="none";	
		parent.document.getElementById("ejec").style.display="none";
	}
	
	//alert(campo7)
	parent.document.getElementById("d_edit_incidencia").style.display="block";			
	parent.document.getElementById("xcip_").value=campo1;
	parent.document.getElementById("fec_ini").value=campo3;	
	parent.document.getElementById("fec_fin").value=campo4;	
	parent.document.getElementById("xobs").value=campo5;
	parent.document.getElementById("xid").value=campo6;	
	parent.document.getElementById("xcip_").focus();
	document.getElementById(campo7).checked=true;
	
	
}

function act_incidencias(){
	var c_inc=document.getElementById("c_inc").value;	
	var iduser=document.getElementById("iduser").value;	
	var idperfil=document.getElementById("idperfil").value;	
	var fec_ini=document.getElementById("fec_ini").value;
	var fec_fin=document.getElementById("fec_fin").value;
	var obs=document.getElementById("obs_2").value;
	var tiempo=document.getElementById("tiempo_1").value;
	//var ejecutado=document.getElementById("ejecutado").value;
	
	
	if (document.getElementById("ejecutado").checked==true){
		ejecutado=1;
	}else{
		ejecutado=0;
	}
	
	var pag1 = "funciones_cot.php?iduser="+iduser+"&c_inc="+c_inc+"&fec_ini="+fec_ini+"&tiempo="+tiempo+"&ejecutado="+ejecutado+"&fec_fin="+fec_fin
	+"&obs="+obs+"&accion=act_incidencia";
	
	//alert(pag1)
	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag1, true);
    ajaxc1.onreadystatechange = function () {
		//alert(ajaxc1.responseText)  	
        if (ajaxc1.readyState == 4) {	
			var msn="Se actualizo la incidencia "+c_inc+"correctamente"
			alert(msn)					
			parent.ras.hide();
			//parent.location.reload();			
			}        
	}
	ajaxc1.send(null)
	
	//document.getElementById("d_edit_incidencia").style.display="none";

}


function listar_tecnicos(){
	var iduser=document.getElementById("iduser").value;		
	var tecnico=document.getElementById("xtecnico").value;
	var cip=document.getElementById("xcip").value;
	var dni=document.getElementById("xdni").value;
	
	var pag1 = "lista_tecnicos.php?iduser="+iduser+"&tecnico="+tecnico+"&cip="+cip+"&dni="+dni;
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			document.getElementById("d_lista_tecnicos").innerHTML=ajaxc.responseText;	
			document.getElementById("d_lista_tecnicos").style.display="block";
			}        
	}
	ajaxc.send(null)	
}





	
function mostrar_edicion(dni){
	var iduser=document.getElementById("iduser").value;	
	var idperfil=document.getElementById("idperfil").idperfil;	
	
	var pag="mantenimiento_usuarios_edit.php?iduser="+iduser+"&dni="+dni+"&idperfil="+idperfil;
	//alert(pag)	
	parent.document.getElementById("lista_criterios").src=pag;	
	parent.document.getElementById("bt_busca").style.display="block";
	parent.document.getElementById("xdni").value=dni;
	parent.document.getElementById("xcompleto").value="";
	parent.document.getElementById("xcip").value="";
	parent.document.getElementById("bt_editar").style.display="block";
	parent.document.getElementById("botonera_edit").style.display="block";
	
}

function cambiar_contra(){
	//document.getElementById("d_cambio_contra").style.display="block";
	
}

function cambio_contra(iduser){

	var contra1=document.getElementById("contra1").value;	
	var contra2 = document.getElementById("contra2").value;	
	
	if (contra1!=contra2){
		alert("La contraseñas deben ser iguales");	
		return
	}
	
	var url = "funciones_cot.php?contra1="+contra1+"&iduser="+iduser+"&accion=cambio_contra";	
	//alert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			alert("Se cambio la contraseña satisfactoriamente")
			document.getElementById("contra1").value="";
			document.getElementById("contra2").value="";
			//document.getElementById("d_cambio_contra").style.display="none";			
			}        
	}
	
	ajaxc.send(null)	
	
}

function cerra_cambio_contra(){
	//document.getElementById("d_cambio_contra").style.display="none";	
	
	}


function editar_contacto(id,dni,fijo,cel1,cel2,cel3,cel4,op1,op2,op3,op4){	
	document.getElementById("d_editar_contactos").style.display="block";	
	document.getElementById("id").value=id;
	document.getElementById("xdni").value=dni;
	document.getElementById("xfijo").value=fijo;
	document.getElementById("xcel1").value=cel1;
	document.getElementById("xcel2").value=cel2;
	document.getElementById("xcel3").value=cel3;
	document.getElementById("xcel4").value=cel4;	
	document.getElementById("xop1").value=op1;	
	document.getElementById("xop2").value=op2;	
	document.getElementById("xop3").value=op3;	
	document.getElementById("xop4").value=op4;	
	historico_contactos(dni);
}

/*
function act_contacto_(){
	var iduser=document.getElementById("iduser").value;	
	var id=document.getElementById("id").value;	
	var xdni=document.getElementById("xdni").value;	
	var xfijo=document.getElementById("xfijo").value;	
	var xcel1=document.getElementById("xcel1").value;	
	var xcel2=document.getElementById("xcel2").value;	
	var xcel3=document.getElementById("xcel3").value;	
	var xcel4=document.getElementById("xcel4").value;	
	
	if(document.getElementById("oper_1").value=="0"){
		var ope_1=document.getElementById("xop1").value;			
	}else{
		var ope_1=document.getElementById("oper_1").value;	
	}

	if(document.getElementById("oper_2").value=="0"){
		var ope_2=document.getElementById("xop2").value;			
	}else{
		var ope_2=document.getElementById("oper_2").value;	
	}

	if(document.getElementById("oper_3").value=="0"){
		var ope_3=document.getElementById("xop3").value;			
	}else{
		var ope_3=document.getElementById("oper_3").value;	
	}

	if(document.getElementById("oper_4").value=="0"){
		var ope_4=document.getElementById("xop4").value;			
	}else{
		var ope_4=document.getElementById("oper_4").value;	
	}
		
	var url = "funciones_cot.php?iduser="+iduser+"&id="+id+"&xdni="+xdni+"&xfijo="+xfijo+"&xcel1="+xcel1+"&xcel2="+xcel2+"&xcel3="+xcel3+"&xcel4="+xcel4+"&ope_1="+ope_1
	+"&ope_2="+ope_2+"&ope_3="+ope_3+"&ope_4="+ope_4+"&accion=act_contacto";
	
	//salert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			alert("Se actualizo correctamente")//						
			cerrar_win('2')	;						
			}        
	}
	
	ajaxc.send(null)	

	
	
}
*/

function gestion_contacto(id,campo1,campo2,campo3,campo4){
	var tipo = "c_tipo" + id;  
	//alert(tipo)
	var c_tipo=document.getElementById(tipo).value;
	
	var pag="funciones_cot.php?id="+id+"&campo1="+campo1+"&campo2="+campo2+"&campo3="+campo3+"&campo4="+campo4;
	
	//alert(c_tipo)
	
	if (c_tipo=="T"){
		alert("Debe escoger la accion")		
		return
	
	}
	
	if (c_tipo=="Actualizar"){		
		act_contacto(id,campo4,campo1)			
	}
	
	if (c_tipo=="Eliminar"){
		eliminar_contacto(id,campo2,campo3)	
	}
	
}

function act_contacto(id,campo,campo2){
	var iduser=document.getElementById("iduser").value;	
	var dni=document.getElementById("xdni").value;
	var ncontacto=document.getElementById(campo2).value;	
	var opera = "oper_"+id;
	//alert(oper)
	var operador=document.getElementById(opera).value;	

	
	var url = "funciones_cot.php?iduser="+iduser+"&id="+campo+"&operador="+operador+"&dni="+dni
	+"&ncontacto="+ncontacto+"&accion=act_contacto";
	
	//alert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			alert(ajaxc.responseText)  	
			alert("Se actualizo correctamente")//						
			mostrar_datos_contacto('1');				
			}        
	}
	
	ajaxc.send(null)		
}

function eliminar_contacto(id,dni,contacto){
		var iduser = document.getElementById("iduser").value;		
		var urlx = "funciones_cot.php?id="+id+"&dni="+dni+"&iduser="+iduser+"&contacto="+contacto+"&accion=eliminar_contacto";	
		
		
		//alert(urlx)
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			
			if (ajaxc.readyState==4) 			
			{			
				//alert(ajaxc.responseText);
				alert("Registro Eliminado")
				mostrar_datos_contacto('1');							
			}
		}
		 ajaxc.send(null)	
		 
}


function reg_nuevo_numero(){
	var iduser=document.getElementById("iduser").value;	
	var dni=document.getElementById("xdni").value;
	var ncontacto=document.getElementById("n_numero").value;	
	var operador=document.getElementById("n_operador").value;	
	
	if (document.getElementById("n_numero").value==""){
		alert("Debe ingresar numero de contacto")
		return
	}

	
	var url = "funciones_cot.php?iduser="+iduser+"&operador="+operador+"&dni="+dni+"&ncontacto="+ncontacto+"&accion=reg_nuevo_numero";
	
	//alert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			alert("Se registro correctamente")
			mostrar_datos_contacto('1');
			}        
	}
	
	ajaxc.send(null)	
	
}


function historico_contactos(){		

	var dni=document.getElementById("xdni").value;

	var url = "historico_contactos.php?dni="+dni;
	var msn = "DATOS DNI : " + dni;
	//alert(msn) 		
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText) 	
			document.getElementById("d_historico_contactos").style.display="block";		
			document.getElementById("d_historico_contactos").innerHTML=ajaxc.responseText;	
			//document.getElementById("d_historico_contactos").value=ajaxc.responseText;
			}        
	}
	ajaxc.send(null)	
	
	
}	


/***************************************/

function reporte_general(){
	var iduser=document.getElementById("iduser").value;	
	var idperfil=document.getElementById("idperfil").value;		
	var xmes = document.getElementById("xmes").value;
	var xano = document.getElementById("xano").value;	
	var xreporte = document.getElementById("xreporte").value;
	
	if  (document.getElementById("xano").value=="0"){
		alert("Debe escoger el año")
		return
	}
/*
	if  (document.getElementById("xmes").value=="0"){
		alert("Debe escoger el mes")
		return
	}
*/	
	
	if  (document.getElementById("xreporte").value=="0"){
		alert("Debe escoger el tipo de reporte")
		return
	}
	
	
	var win=null;
	
	if (xreporte=="423"){
	var url="reporte_gestel_423_criterio.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	if (xreporte=="423P"){
	var url="reporte_gestel_423_criterio_prov.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	if (xreporte=="47D"){
	var url="reporte_gestel_47D_criterios.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	if (xreporte=="CONSULTAS_CONTACTOS"){
	var url="../reportes_consulta_contactos.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	if (xreporte=="CONSULTAS_MAESTRA"){
	var url="reporte_maestra_usuarios.php?iduser="+iduser;
	}
	
	if (xreporte=="INCIDENCIAS COT"){
	var url="reporte_incidencias_nuevo_mes.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	if (xreporte=="ATENCION VIA CORREO"){
	var url="reporte_modem_ave.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	if (xreporte=="ASIGNACIONES TRABAJADAS"){
	var url="reportes_pedidos.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	if (xreporte=="HORAS PROGRAMADAS"){
	var url="reportes_prog_extras.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	if (xreporte=="CAPACITACION"){
	var url="reporte_capacitacion_pormes.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	
	/*
	if (xreporte=="INCIDENCIAS COT"){
	var url="reporte_incidencias_sis.php?iduser="+iduser+"&xmes="+xmes+"&xano="+xano+"&idperfil="+idperfil;
	}
	*/
	
	//alert(url)
	
	win=window.open(url,true);	
}


function exportar_reporte_modulo(iduser,opc){		
	var win=null;
	
	if (opc=='1'){
	var url="../reportes_pedidos.php?iduser="+iduser+"&opc="+opc;
	//alert(url)	
	win=window.open(url,true);	
	}	
	
	if (opc=='2'){
	var url="reporte_incidencias.php?iduser="+iduser;
	//alert(url)	
	win=window.open(url,true);	
	
	}	
	
	if (opc=='3'){
	var xmes = document.getElementById("xmes").value;	
	var xreporte = document.getElementById("xreporte").value;	
	
	var url="exportar_cot.php?iduser="+iduser+"&xmes="+xmes+"&xreporte="+xreporte;	
	//exportar_varios(iduser,'1');
	}	
	
	//alert(url)	
	
	if (opc=='4'){
	var f = new Date();
	var xmes =(f.getMonth() +1);

	var url="reporte_pedidos_total.php?iduser="+iduser+"&xmes="+xmes;	
	//alert(url);
	//exportar_varios(iduser,'1');
	}	
	
	if (opc=='5'){
	var url="reporte_gestel_423.php?iduser="+iduser;	
	//alert(url);
	//exportar_varios(iduser,'1');
	}	
	
	win=window.open(url,true);
}	


function  popup_reclamo(tipo,val1,val2,val3,val4,val5){	
	
	if (tipo==1){ // registro de boleta
	
	var page="f_atencion.php?peticion="+val1+"&fec_reg="+val2+"&origen="+val4+"&iduser="+val3+"&pedido="+val5
	+"&tipo="+tipo+"&accion=aceptar_asignacion";
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Detalle', 'top=20,left=500,width=600px,height=360px,center=0,resize=0,scrolling=0');	
	}
	
	if (tipo==2){ // registro de boleta
	
	var page="detalle_num_contacto.php?id="+val1+"&dni="+val2+"&origen="+val4+"&iduser="+val3+"&ccliente="+val5;
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Actualizacion de Informacion Del Cliente', 
	'top=20,left=100,width=1100px,height=500px,center=0,resize=0,scrolling=0');	
	
	historico_contactos(val2);
	
	}
	 
	if (tipo==3){ // registro incidencia
	var iduser		= document.getElementById("iduser").value;	
	var idperfil	= document.getElementById("idperfil").value;
	
	var page="cab_registro_incidenciascot_n1.php?iduser="+val1+"&idperfil="+val2+"&accion="+val3+"&d="+val4+"&e="+val5;
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Registro de Incidencias COT', 
	'width=1300px,height=800px,top=10px,left=50px,resize=0,scrolling=1');	
	}
	
 
 	if (tipo==4){ // edit incidencia
	
	var page="../incidencias_mod_gestion.php?iduser="+val1+"&idperfil="+val2+"&accion="+val3+"&c_inc="+val4+"&ejec="+val5;
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Editar Incidencias COT', 'width=500px,height=300px,center=30,resize=0,scrolling=0');	
	}
	
	if (tipo==5){ // registro de boleta
	
	var page="../f_atencion.php?peticion="+val1+"&iduser="+val2+"&tipo="+tipo+"&accion=Informacion";
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Detalle', 'width=550px,height=300px,center=1,resize=0,scrolling=0');	
	}
	
	if (tipo==6){ // aceptar_pedido_bl
	
	var iduser		= document.getElementById("iduser").value;	
	var c_multig 	= val1
	var fec_cli 	= val4
	var fec_carga 	= val3
	var fec_atento 	= val5	
	var c_cliente 	= val2
	
	var page="f_atencion_bl.php?c_multig="+c_multig+"&iduser="+iduser+"&tipo="+tipo+"&c_cliente="+c_cliente+"&fec_cli="+fec_cli
	+"&fec_atento="+fec_atento;
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'BEO LIQUIDACION', 'width=730px,height=500px,top=20,left=400,resize=0,scrolling=0');	
	
	/******************/
	
	
	aceptar_asignacion_bl(c_multig,c_cliente,iduser,fec_cli,fec_atento,fec_carga)
	}
	
	if (tipo==7){ // 
	
	var page="../f_atencion_bl.php?c_multig="+val1+"&iduser="+val2+"&tipo="+tipo+"&accion=Informacion";
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Detalle', 'width=550px,height=300px,top=20,left=400,resize=0,scrolling=0');	
	}
	
	if (tipo==8){ // 
	
	var page="bandejas/lista_capacitacion.php?c_multig="+val1+"&iduser="+val2+"&tipo="+tipo+"&accion=Informacion";
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Detalle', 'width=1200px,height=500px,top=20,left=100,resize=0,scrolling=0');	
	}
	
	if (tipo==9){ // 
	document.getElementById("i_bandeja_asignaciones").src= "";
	document.getElementById("bandeja_asignaciones").style.display="none";	
	
	var page="panel_asignaciones.php?c_multig="+val1+"&iduser="+val2+"&tipo="+tipo+"&accion=Informacion";
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Detalle', 'width=1200px,height=500px,top=20,left=100,resize=0,scrolling=0');	
	}
	
	if (tipo==10){ // 
	document.getElementById("i_bandeja_asignaciones").src= "";
	document.getElementById("bandeja_asignaciones").style.display="none";
	
	
	var page="cab_vista_2.php?c_multig="+val1+"&iduser="+val2+"&tipo="+tipo+"&accion=Informacion";
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Detalle', 'width=1300px,height=600px,top=20,left=10,resize=0,scrolling=0');	
	}
	
	if (tipo==11){ // 
	
	var page="f_migraciones.php?peticion="+val1+"&fec_reg="+val2+"&origen="+val4+"&iduser="+val3+"&pedido="+val5
	+"&tipo="+tipo+"&accion=aceptar_asignacion";
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'F_MIGRACIONES', 'top=20,left=500,width=600px,height=450px,center=0,resize=0,scrolling=0');	
	}
	
	if (tipo==12){ // registro incidencia
	
	var page="cab_registro_incidenciascot.php?iduser="+val1+"&idperfil="+val2+"&accion="+val3+"&d="+val4+"&e="+val5;
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'Registro de Incidencias COT', 
	'width=1500px,height=600px,top=10px,left=50px,resize=0,scrolling=0');	
	}
	
	if (tipo==13){ // 
	
	var page="listado_incidencias.php?dni="+val1+"&iduser="+val2;
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'BandejaIncidencias COT', 
	'width=1000px,height=500px,top=10px,left=50px,resize=0,scrolling=0,center=1');	
	}
	
} 

function cerrar_win(opc){
	
	if (opc=="0"){	
	parent.ras.hide();	
	}
		
	if (opc=="1"){
		var peticion=document.getElementById("peticion").value;	
		var pedido=document.getElementById("pedido").value;	
		var iduser=document.getElementById("iduser").value;	
		//parent.document.location.reload();
		rechazar_pedido(peticion,pedido,iduser,'RECHAZO DESPUES DE ACEPTAR EL PEDIDO');
		parent.ras.hide();
	}
	
	if (opc=="2"){
	var iduser=parent.document.getElementById("iduser").value;	  		
	//parent.location.reload(true);
	parent.ras.hide();
	
	}
	
	if (opc=="3"){
	var iduser=document.getElementById("iduser").value;	  		
	parent.location.reload(true);	
	parent.ras.hide();
	
	}
	
	if (opc=="4"){
	var iduser=document.getElementById("iduser").value;	  		
	//parent.location.reload(true);	
	parent.ras.hide();
	
	}
	
	if (opc=="5"){	
		var c_multig=document.getElementById("c_multig").value;	
		var c_cliente=document.getElementById("c_cliente").value;	
		var iduser=document.getElementById("iduser").value;	
		rechazar_pedido_bl(c_multig,c_cliente,iduser,'RECHAZO DESPUES DE ACEPTAR EL PEDIDO');
		parent.ras.hide();
	}
	
	if (opc=="6"){
	var iduser=document.getElementById("iduser").value;	  		
	//parent.location.reload(true);	
	parent.ras.hide();
	
	}
	
	if (opc=="7"){
	var iduser=document.getElementById("iduser").value;	  		
	//parent.location.reload(true);	
	parent.ras.hide();
	
	}
	
	if (opc=="8"){
		var peticion=document.getElementById("peticion").value;			
		var iduser=document.getElementById("iduser").value;	
		//parent.document.location.reload();
		rechazar_pedido_migracion(peticion,iduser,'RECHAZO DESPUES DE ACEPTAR EL PEDIDO');
		parent.ras.hide();
	}
	
	if (opc=="9"){
		var cod_incidencia=document.getElementById("c_incidencia").value;		
		
		borrar_incidencia_temp(cod_incidencia);
		parent.ras.hide();
	}
		
}

function listar_bandeja_asignaciones(iduser){	
	
	var pag1 = "bandejas/bandeja_general_asignaciones.php?iduser="+iduser;
	
	document.getElementById("i_bandeja_asignaciones").src="";
	document.getElementById("bandeja_asignaciones").style.display="block";
	//document.getElementById("i_bandeja_asignaciones").style.visibility="visible";		
	document.getElementById("i_bandeja_asignaciones").src= pag1;

}


function listar_bandeja_asignaciones_pend(opc,iduser,idperfil){	

	document.getElementById("i_bandeja_asignaciones").src="";
	
	if (opc=="1"){		
	var pag2 = "bandejas/bandeja_general_asignaciones.php?iduser="+iduser+"&idperfil="+idperfil;
	}
	if (opc=="2"){		
	var pag2 = "bandejas/bandeja_general_asignaciones_pend.php?iduser="+iduser+"&idperfil="+idperfil;
	}
	if (opc=="3"){		
	var pag2 = "panel_asignaciones.php?iduser="+iduser;
	}
	
	//alert(pag2)
	document.getElementById("i_bandeja_asignaciones").src= pag2;
	document.getElementById("bandeja_asignaciones").style.display="block";
//	document.getElementById("i_bandeja_asignaciones").style.visibility="visible";		
	

}

function buscar_contacto(){
	
	var dni = document.getElementById("dni").value;	
	var idperfil = parent.document.getElementById("idperfil").value;
	var pc_asig = parent.document.getElementById("pc").value;
	var ape_pat = document.getElementById("ape_pat").value;	
	var ape_mat = document.getElementById("ape_mat").value;	
	var ncontacto = document.getElementById("ncontacto").value;	
	var pedido = document.getElementById("pedido").value;	
	document.getElementById("bdatos").value="local";
	//var iframe = document.getElementById("f_inferior");
		
	
		
	if (document.getElementById("usu_contactos").value==""){
		alert("UD.  NO ESTA LOGEADO.... VUELVA A INGRESAR")		
		var win=null;
		win=window.open("login.php",true);	
	}else{	
								
				if (document.getElementById("dni").value=="" && document.getElementById("ncontacto").value=="" && 
				document.getElementById("ape_pat").value==""  && document.getElementById("ape_mat").value==""
				&& document.getElementById("pedido").value==""){	
					alert("DATOS VACIOS...")
					return
				}else{
				//alert("entro")			
					
				var pag2 = "funciones_cot.php?dni="+dni+"&idperfil="+idperfil+"&pc_asig="+pc_asig+"&pedido="+pedido
				+"&ncontacto="+ncontacto+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&accion=validar_contacto";
				
				//alert(pag2);
				
					document.getElementById("barra_cargando").style.display="block";		
					document.getElementById("barra_cargando").innerHTML = "<img src=\"loading3.gif\" width='300' height='200' />";
					document.getElementById("div_lista_contactos").style.display="none";	
				
				ajaxc = createRequest();
				ajaxc.open("get", pag2, true);
				ajaxc.onreadystatechange = function () {
					
					if (ajaxc.readyState == 4) {  
						var msn  = ajaxc.responseText;           
						//alert(msn)
						if (msn=="NO"){				
							return
							alert("Usuario no se encuentra registrado en la Base de Datos");					
						}else{				
							mostrar_datos_contacto('1');	
							
						}
								
					}
				}
				ajaxc.send(null)
			}		 
		}
	}


function mostrar_pedido(){		
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	var zon = document.getElementById("zon").value;
	var origen = document.getElementById("t_carga").value; 

		
		if (document.getElementById("t_carga").value=="0"){
				alert("Debe escojer el origen de la carga")
				return
		}
		

		
	
	var url = "modulo_asignaciones.php?iduser="+iduser+"&idperfil="+idperfil+"&origen="+origen+"&zon="+zon;
	
	//alert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText) 	
			document.getElementById("d_pedido").style.display="block";		
			document.getElementById("d_pedido").innerHTML=ajaxc.responseText;	
			//document.getElementById("d_historico_contactos").value=ajaxc.responseText;
			//mostrar_contadores();
			}        
	}
	ajaxc.send(null)	
	
	
}	



function mostrar_contadores(){	

	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	
	
	var url1 = "f_contadores.php?iduser="+iduser+"&idperfil="+idperfil;
	//alert(url1)

	ajaxc1 = createRequest();
    ajaxc1.open("get", url1, true);
    ajaxc1.onreadystatechange = function () {
		
        if (ajaxc1.readyState == 4) {
			//alert(ajaxc.responseText) 	
			document.getElementById("d_contadores").style.display="block";		
			document.getElementById("d_contadores").innerHTML=ajaxc1.responseText;	
			//document.getElementById("d_historico_contactos").value=ajaxc.responseText;
			}        
	}
	ajaxc1.send(null)	
	
	
}	

function mostrar_modo(valor_c){
	if (valor_c=="D"){
		document.getElementById("f_dias").style.display="block";	
		document.getElementById("f_horas").style.display="none";			
		
	}
	if (valor_c=="H"){
		document.getElementById("f_horas").style.display="block";	
		document.getElementById("f_dias").style.display="none";	
	}	
	
}

function mostrar_modo2(valor_c){
	document.getElementById("f_dias").style.display="none";	
	document.getElementById("f_horas").style.display="none";	
	
	if (valor_c=="40" || valor_c=="23" || valor_c=="22" || valor_c=="30" || valor_c=="21" || valor_c=="50"){
		document.getElementById("f_dias").style.display="block";	
		document.getElementById("f_horas").style.display="none";	
		document.getElementById("modo").value="0";
		document.getElementById("modo").disabled=true;		
		
	}else{
		document.getElementById("f_horas").style.display="none";	
		document.getElementById("f_dias").style.display="none";	
		document.getElementById("modo").value="0";
		document.getElementById("modo").disabled=false;
	}
	 
}

function validar_horas(h_fin){
	var h_ini = document.getElementById("h_ini").value;
	
	if (h_fin < h_ini) {
		alert("La hora debe ser mayor que la hora inicial")
		}
	
}

function calcular_tiempos(){
	var modo = document.getElementById("modo").value;
	
	if (document.getElementById("modo").value=="0"){	
		var fec1 = document.getElementById("input1").value;
		var fec2 = document.getElementById("input2").value;
		var fec = "";
		document.getElementById("exc").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var fec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];
		
		/*
		if (fec_fin > fec_ini){		
		}else{
			alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
		}
		*/

}else{
		if (document.getElementById("modo").value=="D"){
		var fec1 = document.getElementById("input1").value;
		var fec2 = document.getElementById("input2").value;
		var fec = "";
		document.getElementById("exc").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var fec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];
		
		
		if (fec_fin >= fec_ini){
			/*
			alert(fec1[1])
			alert(fec2[1])
			
			if (fec2[1]> fec1[1]){
				
			}else{
				alert("ALERTA: ERROR CON EL FORMATO DE HORAS")
				return	
			}
			*/
		}else{
			alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
			return
		}

		
		}
		if (modo=="H"){
		var fec = document.getElementById("input3").value;
		var hor_ini = document.getElementById("h_ini").value + ":" + document.getElementById("mm_ini").value;
		var hor_fin = document.getElementById("h_fin").value + ":" + document.getElementById("mm_fin").value;
		document.getElementById("exc").value="HH:MM";	
		}
		
	}
	
	if (document.getElementById("modo").value=="D" || document.getElementById("modo").value=="0"){
		if (document.getElementById("input1").value=="" || document.getElementById("input2").value==""){
			document.getElementById("bt_aceptar").style.display="none";	
			alert("ERROR: NO HA INGRESADO FECHAS")
			return
		}else{
			//document.getElementById("bt_aceptar").style.display="block";	
		}		
	}else{
		if (document.getElementById("input3").value=="" || 
		document.getElementById("h_ini").value=="0" || document.getElementById("h_fin").value=="0"
		){
			document.getElementById("bt_aceptar").style.display="none";	
			alert("ERROR: NO HA INGRESADO HORAS COMPLETAS")
			return
		}else{
			//document.getElementById("bt_aceptar").style.display="block";	
		}		
	}
	
	
	
	
	var pag4 = "funciones_cot.php?fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&fec="+fec+"&modo="+modo+"&hor_ini="+hor_ini
	+"&hor_fin="+hor_fin+"&accion=calcular_tiempo";
	
	//alert(pag4);
	
	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			var msn  = ajaxc.responseText;           
			//alert(msn)
			document.getElementById("tiempo").value = msn;
        }
	}
	ajaxc.send(null)
	
	
	}
	
function GoEnter_calculos(e)
{ //e is event object passed from function invocation
	
	var characterCode;
	
	//alert(e);
	if(e && e.which)
	{ //if which property of event object is supported (NN4)
		e = e
		characterCode = e.which //character code is contained in NN4's which property
	}
	else
	{
		e = event
		characterCode = e.keyCode //character code is contained in IE's keyCode property
	}
	if(characterCode == 13)
	{ //if generated character code is equal to ascii 13 (if enter key)
	//alert("entro")
		calcular_tiempos('2')		
	
	}
	else
	{
		return true;
	}
}

function mostrar_bandejas_incidencias(opc){
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	
	var fec_i = document.getElementById("an_i").value+"/"+document.getElementById("mes_i").value+"/"+document.getElementById("dia_i").value;	
	var fec_f = document.getElementById("an_f").value+"/"+document.getElementById("mes_f").value+"/"+document.getElementById("dia_f").value;
	

	if (opc=="1"){
	var cri1 = document.getElementById("xmes1").value;
	var cri2 = document.getElementById("c_supervisor").value;
	
	var pag="bandejas/bandeja_general_incidencias.php?iduser="+iduser+"&cri2="+cri2+"&fec_i="+fec_i+"&fec_f="+fec_f+"&idperfil="+idperfil+"&opc="+opc;
	}
	
	if (opc=="2"){
	//var cri1 = document.getElementById("xmes2").value;
	var cri2 = document.getElementById("c_monitor").value;
	
	var pag="bandejas/bandeja_general_capacitaciones.php?iduser="+iduser+"&cri2="+cri2+"&fec_i="+fec_i+"&fec_f="+fec_f+"&idperfil="+idperfil+"&opc="+opc;
	}
		
		/*
		if (idperfil=="0"){
		var monitor = document.getElementById("c_monitor").value;
		var supervisor = document.getElementById("c_supervisor").value;
		
		var pag="bandejas/bandeja_general_incidencias.php?iduser="+iduser+"&monitor="+monitor+"&supervisor="+supervisor+"&xmes="+xmes+"&idperfil="+idperfil;
		}
	*/
	
	
	//alert(pag)
	
	
	document.getElementById("f_incidencias").style.display="block";
	document.getElementById("f_incidencias").src=pag;	

}

function calcular_tiempos_1(){
	var fec1 = document.getElementById("fec_ini").value;
	var fec2 = document.getElementById("fec_fin").value;
	var modo = "";

	var pag4 = "funciones_cot.php?fec_ini="+fec1+"&fec_fin="+fec2+"&modo="+modo+"&accion=calcular_tiempo";	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			var msn  = ajaxc.responseText;           
			//alert(msn)
			document.getElementById("tiempo_1").value = msn;
        }
	}
	ajaxc.send(null)
}

function mostrar_datos_carga(origen){	
		//alert(origen)
	document.getElementById("sw_G47D").value = document.getElementById("sw_G47D").value - 1;
	document.getElementById("sw_G423").value = document.getElementById("sw_G423").value - 1;
	
	if (origen=="G47D"){		
		
		if (document.getElementById("sw_G47D").value=="0"){			
			document.getElementById("G47D").style.display="none";	
			document.getElementById("b_G47D").src="image/up.JPG";			
			document.getElementById("sw_G47D").value="0";
		}else{			
			document.getElementById("G47D").style.display="block";	
			document.getElementById("b_G47D").src="image/down.JPG";					
			document.getElementById("sw_G47D").value="1";
		}
	}else{
				
		if (document.getElementById("sw_G423").value=="0"){			
			document.getElementById("G423").style.display="none";	
			document.getElementById("b_G423").src="image/up.JPG";			
			document.getElementById("sw_G423").value="0";
		}else{			
			document.getElementById("G423").style.display="block";	
			document.getElementById("b_G423").src="image/down.JPG";					
			document.getElementById("sw_G423").value="1";
		}
		
	}
	
	var pag4 = "funciones_cot.php?origen="+origen+"&accion=mostrar_datos_carga";	
	//alert(pag4)
	ajaxc = createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 			
			document.getElementById(origen).innerHTML	=	ajaxc.responseText;	
        }
	}
	ajaxc.send(null)
}


function resetear_tablas(){

	var pag4 = "funciones_cot.php?accion=resetear_tablas";	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
		//alert(ajaxc.responseText)
			var msn  = ajaxc.responseText;           
			alert("Reseteo OK")			
        }
	}
	ajaxc.send(null)
}

function mostrar_pedido_bl(){		
	document.getElementById("bt_asig").style.display="none";
		
		
	
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	var tiempo = document.getElementById("t_carga").value;
	//var tiempo="";

	var url = "modulo_beoliquidaciones.php?iduser="+iduser+"&idperfil="+idperfil+"&tiempo="+tiempo;

	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText) 
			document.getElementById("d_pedido_bl").style.display="block";					
			document.getElementById("d_pedido_bl").innerHTML=ajaxc.responseText;				
			//document.getElementById("d_historico_contactos").value=ajaxc.responseText;
			//separar_pedido_bl(c_multig,c_cliente,iduser,fec_cli,fec_atento,tiempo,c_req)	
			listar_bandeja_asignaciones_pend_bl('1',iduser,'')		
			}        
	}
	ajaxc.send(null)	
	
	
}
/*
function grabar_asignacion_bl(c_multig){
	var obs = document.getElementById("obs").value;	
	var iduser = document.getElementById("iduser").value;	
	var exc = document.getElementById("exc").value;
	var c_cliente = document.getElementById("c_cliente").value;
	
	if (document.getElementById("exc").value=="0"){
		alert("Debe escojer acciones")
		return
	}else{
			
	var pag1 = "funciones_cot.php?c_multig="+c_multig+"&exc="+exc+"&c_cliente="+c_cliente+"&obs="+obs+"&iduser="+iduser+"&accion=grabar_asignacion_bl";
	
	//alert(pag1);
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
//			var msn2="Desea eliminar? ";
//			if (confirm(msn2)){	
			//contar_pedidos(pedido,iduser);	
			var msn="PEDIDO N°."+c_multig+" REGISTRADO";
			//alert(msn);
			cerrar_win('2');				
			parent.location.reload();
        }
	}
	ajaxc.send(null)	
	
	}
	
}

function aceptar_asignacion_bl(c_multig,c_cliente,iduser,fec_cli,fec_atento,fec_carga){			
		
		
		var pag = "funciones_cot.php?c_multig="+c_multig+"&c_cliente="+c_cliente+"&iduser="+iduser
		+"&fec_cli="+fec_cli+"&fec_atento="+fec_atento+"&fec_carga="+fec_carga+"&accion=aceptar_asignacion_bl";		
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;	
				//alert(resp1)															
			}		
		}
		 ajaxp.send(null)	
	 
}
*/

function rechazar_pedido_bl(c_multig,c_cliente,iduser,obs){	
	
	var pag1 = "funciones_cot.php?c_multig="+c_multig+"&c_cliente="+c_cliente+"&obs="+obs+"&iduser="+iduser+"&accion=rechazar_pedido_bl";
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			//mostrar_contadores();			
			}        
	}
	ajaxc.send(null)	
}

function listar_bandeja_asignaciones_pend_bl(opc,iduser,idperfil){	
	
	if (opc=="1"){		
	var pag2 = "bandejas/bandeja_general_beoliquidaciones.php?iduser="+iduser;
	}
	if (opc=="2"){		
	var pag2 = "bandejas/bandeja_general_beoliquidaciones_pend.php?iduser="+iduser;
	}
	if (opc=="3"){		
	var pag2 = "f_contadores1.php?iduser="+iduser;
	}

	document.getElementById("i_bandeja_asignaciones").src="";
	document.getElementById("bandeja_asignaciones").style.display="block";
	document.getElementById("i_bandeja_asignaciones").style.visibility="visible";		
	document.getElementById("i_bandeja_asignaciones").src= pag2;

}

function aceptar_asignacion_bl(c_multig,iduser,fec_cli,fec_atento,fec_carga,c_cliente){						
				
		var pag = "funciones_cot.php?c_multig="+c_multig+"&c_cliente="+c_cliente+"&iduser="+iduser
		+"&fec_cli="+fec_cli+"&fec_atento="+fec_atento+"&fec_carga="+fec_carga+"&accion=aceptar_asignacion_bl";		
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;	
				//cerrar_win('2');	
				var msn="Requerimiento N. "+c_multig+" Atendido";
				alert(msn)				
				listar_bandeja_asignaciones_pend_bl('1',iduser,'')	
				document.getElementById("bt_acep").style.display="none";					
				document.getElementById("bt_asig").style.display="block";	
							
			}		
		}
		 ajaxp.send(null)	
	 
}

function separar_pedido_bl(c_multig,c_cliente,iduser,fec_cli,fec_atento,fec_carga){			
		
		
		var pag = "funciones_cot.php?c_multig="+c_multig+"&c_cliente="+c_cliente+"&iduser="+iduser
		+"&fec_cli="+fec_cli+"&fec_atento="+fec_atento+"&fec_carga="+fec_carga+"&accion=separar_pedido_bl";		
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;	
				var msn="Requerimiento N. "+c_multig+" Separado";
				alert(msn)		
				listar_bandeja_asignaciones_pend_bl('1',iduser,'')															
			}		
		}
		 ajaxp.send(null)	
	 
}

function registro_modem(){	
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	var c_averia = document.getElementById("c_averia").value;
	var tipo = document.getElementById("tipo").value;
	var medio = document.getElementById("medio").value;
	
	if (document.getElementById("c_averia").value==""){
		alert("Codigo de Averia Vacio")
		return
	}

	/*
	if (document.getElementById("tipo").value=="0"){
		alert("Escoja tipo")
		return
	}
	*/
	document.getElementById("d_bandeja_modem_ave").style.display="none";	
	
	var pag1 = "funciones_cot.php?iduser="+iduser+"&idperfil="+idperfil+"&c_averia="+c_averia+"&medio="+medio+"&tipo="+tipo+"&accion=registrar_modem";
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			//mostrar_contadores();			
				
			if (ajaxc.responseText==1){ // nuevo
			//alert("nuevo")
				document.getElementById("bt_sep").style.display						="none";	
				document.getElementById("d_detalle_pedidos_decos").style.display	="block";
				document.getElementById("d_bandeja_pedidos_decos").style.display	="none";				
			}else{		
				//alert("CASO YA SE ENCUENTRA EN PROCESO DE ATENCION")
				document.getElementById("bt_sep").style.display						="block";	
				document.getElementById("d_detalle_pedidos_decos").style.display	="none";
				document.getElementById("d_bandeja_pedidos_decos").style.display	="block";
				document.getElementById("d_bandeja_pedidos_decos").innerHTML		=ajaxc.responseText;
			}
			//document.getElementById("d_bandeja_pedidos_decos").innerHTML		=ajaxc.responseText;	
			}        
	}
	ajaxc.send(null)	
}

function act_pedido_modem(){		
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	var c_averia = document.getElementById("c_averia").value;
	var dpto = document.getElementById("dpto").value;
	var contrata = document.getElementById("contrata").value;
	var est = document.getElementById("est").value;
	/*
	var mot_averia = document.getElementById("mot_averia").value;
	var contrata = document.getElementById("contrata").value;
	var estado = document.getElementById("estado").value;
	var obs_reg = document.getElementById("obs_reg").value;
	var obs_ate = document.getElementById("obs_ate").value;
	*/
	
	if (document.getElementById("dpto").value=="0"){
		alert("ESCOJA DEPARTAMENTO")
		return
	}
	
	if (document.getElementById("contrata").value=="0"){
		alert("ESCOJA CONTRATA")
		return
	}
	
	var pag2 = "funciones_cot.php?iduser="+iduser+"&c_averia="+c_averia+"&dpto="+dpto+"&contrata="+contrata+"&est="+est
	+"&accion=actualiza_pedido_modem";
	
	//alert(pag2)	
	document.getElementById("d_bandeja_modem_ave").style.display="none";	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag2, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			//mostrar_contadores();	
			var msn="Se registro la averia "+c_averia+" Exitosamente";
			alert(msn)
			document.getElementById("d_bandeja_pedidos_decos").style.display	="block";
			document.getElementById("d_bandeja_pedidos_decos").innerHTML		=ajaxc.responseText;	
			
			document.getElementById("bt_sep").style.display						="block";
			document.getElementById("d_detalle_pedidos_decos").style.display	="none";		
							
			document.getElementById("c_averia").value	="";
			document.getElementById("dpto").value		="0";
			document.getElementById("tipo").value		="0";
			document.getElementById("contrata").value	="0";
			document.getElementById("est").value		="0";			    
		}		
	}
		
	
	ajaxc.send(null)	
}

function rechazar_modem(){	
	var c_averia = document.getElementById("c_averia").value;
	var iduser = document.getElementById("iduser").value;
	
	var pag1 = "funciones_cot.php?iduser="+iduser+"&c_averia="+c_averia+"&accion=rechazar_modem";
	
	//alert(pag2)	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			alert(ajaxc.responseText)  	
			document.getElementById("bt_sep").style.display						="block";
			document.getElementById("d_detalle_pedidos_decos").style.display	="none";
			document.getElementById("c_averia").value	="";
			document.getElementById("tipo").value		="0";
		}
	}
	ajaxc.send(null)
}

function bandeja_modem_ave(){
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;
	
	var pag="bandejas/bandeja_pedidos_modem_ave.php?iduser="+iduser+"&idperfil="+idperfil;
	//alert(pag)
	document.getElementById("d_detalle_pedidos_decos").style.display	="none";
	document.getElementById("d_bandeja_pedidos_decos").style.display	="none";
	document.getElementById("d_bandeja_modem_ave").style.display="block";		
	document.getElementById("i_bandeja_modem_ave").src= pag;	
	
}

function cerrar_ventana(){
	parent.window.close();
}


function proceso_manual(pm){	

	//alert(pm)

	if (pm=="pc_cms"){
	var pag1 = "carga_cms_nuevo.php";
	var proceso="carga CMS";
	}
	
	if (pm=="gestel_47D"){
	var pag1 = "carga_gestel_47D.php";
	var proceso="carga 47D";
	}
	
	if (pm=="gestel_423"){
	var pag1 = "carga_gestel_423_nuevo.php";
	var proceso="carga 423";
	}
	//alert(pag2)	
	if (pm=="devueltas_tecnicas"){
	var pag1 = "carga_devueltas_tecnicas.php";
	var proceso="carga_devueltas_tecnicas";
	}
	
	if (pm=="contactos"){
	var pag1 = "importar_data_contactos_nuevo.php";
	var proceso="carga_tabla_contactos";
	}
	
	//alert(pag1)
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
		//alert(ajaxc.responseText)  
        if (ajaxc.readyState == 4) {
				
			var msn = "Proceso "+proceso+" Terminado";
			alert(msn)			
		}
	}
	ajaxc.send(null)		
}

function mostra_historico_usuarios(){	
	document.getElementById("d_historico").style.display	="block";	
}

function eliminar_extra(id,tipo){
	var iduser = document.getElementById("iduser").value;	
			
	var pag1 = "../funciones_cot.php?id="+id+"&tipo="+tipo+"&iduser="+iduser+"&accion=eliminar_extra";
	
	//alert(pag1);
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
			if (ajaxc.readyState == 4) {  
				//alert(ajaxc.responseText);
				var msn2="Desea eliminar? ";
				if (confirm(msn2)){	
				alert("Registro Eliminado");
				parent.location.reload();
			}
		}
	}
	ajaxc.send(null)		
}

function nuevo_nro_contacto(){
	document.getElementById("div_registro_contacto").style.display		="block";
	document.getElementById("n_dni").value = document.getElementById("dni").value;	
	document.getElementById("xape_pat").value="";	
	document.getElementById("xape_mat").value="";	
	document.getElementById("nombres").value="";	
	document.getElementById("n_referencia").value="";
	document.getElementById("n_oper").value="";	
	document.getElementById("div_lista_contactos").style.display		="none";
	document.getElementById("d_historico_contactos").style.display		="none";	
	document.getElementById("div_actualizar_contacto").style.display	="none";		
	
}
	
function act_nro_contacto(){
	document.getElementById("div_consulta_contacto").style.display		="block";	
	document.getElementById("div_registro_contacto").style.display		="none";	
	document.getElementById("div_actualizar_contacto").style.display	="block";	
	document.getElementById("n_numero").focus();
	}
	
	
function escojer_gestor(){
	
	var i = 1; 
	var con= 0;
	var acceso = '';	
	
	
	for (i=1; i<10000; i++){
					var cor="check"+i;
					//alert(cor)
					
					if (document.getElementById(cor).checked){
						con = con + 1;
						//alert(document.getElementById(cor).value)						
						acceso = acceso + "|" + document.getElementById(cor).value;
						
						document.getElementById("chk_escogidos_").value = "Escogidos : " + con +" elementos  "; 
						document.getElementById("chk_escogidos").value  = con; 
						document.getElementById("arr_escogidos").value  = acceso; 	
						
						//var hor = hor.substring(1, 1000); 				
					}					
	}	
}

function escojer_gestor_inc(){
	
	var i = 0; 
	var con= 0;
	var acceso = '';
	var hor = '';
	
	
	for (i=1; i<100000; i++){
					var cor="check"+i;
					//alert(cor)
					
					if (document.getElementById(cor).checked){
						
						
						//alert(document.getElementById(cor).value)
											
						acceso = acceso + "|" + document.getElementById(cor).value;
						hor = hor + "," + document.getElementById(cor).value;
						//alert(acceso)	
						
						con = con + 1;
						document.getElementById("chk_escogidos_").value = "Escogidos : " + con +" elementos  "; 
						document.getElementById("chk_escogidos").value  = con; 
						document.getElementById("arr_escogidos").value  = acceso; 	
						document.getElementById("arr_hor").value  = acceso;
						var hor = hor.substring(1, 1000); 
						
					}					
	}	
}


function escojer_inc(){
	
	var i = 1; 
	var con= 0;
	var acceso = '';
	var hor = '';
	
	
	for (i=1; i<10000; i++){
					var cor="check"+i;
					//alert(cor)
					
					if (document.getElementById(cor).checked){
						con = con + 1;
						//alert(document.getElementById(cor).value)						
						acceso = acceso + "|" + document.getElementById(cor).value;
						hor = hor + "," + document.getElementById(cor).value;
						//alert(acceso)	
						document.getElementById("chk_escogidos_").value = "Escogidos : " + con +" elementos  "; 
						document.getElementById("chk_escogidos").value  = con; 
						document.getElementById("arr_escogidos").value  = acceso; 	
						document.getElementById("arr_hor").value  = hor;
						//var hor = hor.substring(1, 1000); 				
					}					
	}	
}


function ventana_modal(opcion){
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	
	
	if (opcion==1){
	var c_inc = document.getElementById("c_inc").value;
	
	var page		="bandejas/lista_capacitacion.php?iduser="+iduser+"&c_inc="+c_inc;
	var atributos 	="width=950px,height=400px,top=60px,left=10px,center=0,resize=0,scrolling=0";
	var titulo 		="LISTADO DE GESTORES COT";
	//alert(page);
	}
	
	if (opcion==2){
	var page		="bandejas/lista_gestores.php?iduser="+iduser;
	var atributos 	="width=1300px,height=500px,top=60px,left=10px,center=0,resize=0,scrolling=0";
	var titulo 		="LISTADO DE GESTORES COT";
	//alert(page);
	}
	
	if (opcion==3){		
	var page		="registro_usuarios_maestracot.php?iduser="+iduser;
	var atributos 	="width=1500px,height=500px,top=60px,left=10px,center=0,resize=0,scrolling=0";
	var titulo 		="REGISTRO DE USUARIOS MAESTRA COT";
	//alert(page);
	}
	
	if (opcion==4){
	var dni = document.getElementById("xdni").value;
	
	var page		="gestion_maestra_cot.php?dni="+dni+"&iduser="+iduser+"&caso=3";
	var atributos 	="width=1000px,height=500px,top=60px,left=10px,center=0,resize=0,scrolling=0";
	var titulo 		="INFORMACION DE USUARIOS";
	//alert(page);
	}
	
	if (opcion==5){
		
	var dni = document.getElementById("xdni").value;
	
	var page		="gestion_maestra_cot.php?dni="+dni+"&iduser="+iduser+"&caso=2";
	var atributos 	="width=1000px,height=500px,top=60px,left=10px,center=0,resize=0,scrolling=0";
	var titulo 		="HISTORICO DE USUARIOS MAESTRA COT";
	
	}
	
	if (opcion==6){
	var dni = document.getElementById("n_dni").value;
	
	var page		="gestion_maestra_cot.php?dni="+dni+"&iduser="+iduser+"&caso=4";
	var atributos 	="width=1500px,height=700px,top=20px,left=50px,center=0,resize=0,scrolling=0";
	var titulo 		="HISTORICO DE USUARIOS MAESTRA COT";
	//alert(page);
	}
	
	
	if (opcion==7){
		
	var page		="bandeja_aprobaciones_cot_supervisores.php?iduser="+iduser+"&idperfil="+idperfil;
	var atributos 	="width=1500px,height=700px,top=20px,left=50px,center=0,resize=0,scrolling=0";
	var titulo 		="BANDEJA INCIDENCIAS POR APROBAR";
	//alert(page);
	
	//alert("Nota: En Manteminiento hasta el dia Lunes");
	//return
	}
	
	if (opcion==9){ //horarios
		
	var page		="bandejas/bandeja_general_horarios_cot.php?iduser="+iduser;
	var atributos 	="width=1500px,height=700px,center=1,resize=0,scrolling=0";
	var titulo 		="BANDEJA INCIDENCIAS POR APROBAR - SUPERVISORES";
	//alert(page);
	}
	
	if (opcion==8){ //compensaciones
		
	/*var page		="modulo_compensacion.php";
	var atributos 	="width=800px,height=600px,center=1,resize=0,scrolling=0";
	var titulo 		="BANDEJA INCIDENCIAS POR APROBAR - SUPERVISORES";
	//
	*/
	
	alert("Nota: En Manteminiento hasta nuevo aviso");
	return
	
	}
	
	
	modal=dhtmlmodal.open('EmailBox', 'iframe',page,titulo,atributos);	
	
	
}

function agregar_part(){
	var iduser = document.getElementById("iduser").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;	
	
	if (nro_escogidos < 0){
	alert("No ha escogido elementos")	
	return	
	}else{
	
		var pag="../funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos
		+"&nro_escogidos="+nro_escogidos+"&accion=agregar_part";
		//alert(pag)
		
		ajaxc = createRequest();
		ajaxc.open("get", pag, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				//alert(ajaxc.responseText);	
				var msn ="Se agregaron " + nro_escogidos + " gestores";
				//alert(msn)
				document.getElementById("lista_participantes").style.display	="none";	
				document.getElementById("registro_cap").style.display	="block";
				document.getElementById("add_part").style.display	="none";
				document.getElementById("grabar_inc").style.display	="block";
				document.getElementById("c_inc").value	= ajaxc.responseText; 
				document.getElementById("c_incx").value	= document.getElementById("c_inc").value; 
				parent.modal.hide();
						
			}
		}
		ajaxc.send(null)	
	}
}

function carga_combo_gu(nom_combo,valor1,tabla,valor2){						
		
		var valor1= valor1;
		var valor1=valor1.split("|");
		var valor1=valor1[0];
		
		var urlx = "funciones_cot.php?valor1="+valor1+"&combo="+nom_combo+"&valor2="+valor2
		+"&tabla="+tabla+"&accion=carga_combo_gu";	
		
		
		//alert(urlx)
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			//alert(ajaxc.responseText);
			if (ajaxc.readyState==4) 
			{	
				document.getElementById("cb_tpregistro").style.display		= "block";
				document.getElementById("d_motivos_gu").style.display		= "block  ";			
				document.getElementById("d_motivos_gu").innerHTML = ajaxc.responseText;			
			
			}
		}
		 ajaxc.send(null)	
		 		 
	mostrar_coordinado(nom_combo1,valor1)	 		 
}

function reg_nuevo_contacto(){
	var iduser=document.getElementById("iduser").value;	
	var dni=document.getElementById("n_dni").value;
	var ape_pat=document.getElementById("xape_pat").value;	
	var ape_mat=document.getElementById("xape_mat").value;	
	var nombres=document.getElementById("nombres").value;	
	var num_contacto=document.getElementById("n_referencia").value;
	var operador=document.getElementById("n_oper").value;	
	
	if (document.getElementById("n_referencia").value==""){
		alert("Debe ingresar numero de referencia")
		return
	}

	if (document.getElementById("n_dni").value==""){
		alert("Debe ingresar dni")
		return
	}
		
	var urlx = "funciones_cot.php?iduser="+iduser+"&operador="+operador+"&num_contacto="+num_contacto
	+"&dni="+dni+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&nombres="+nombres+"&accion=reg_nuevo_contacto";
	
	alert(urlx)
	
	ajaxc = createRequest();
    ajaxc.open("get", urlx, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			alert(ajaxc.responseText)  				
			document.getElementById("dni").value =dni;
			mostrar_datos_contacto('1');
			}        
	}
	
	ajaxc.send(null)
	
	
	document.getElementById("div_registro_contacto").style.display		= "none ";
}

function mostrar_cambios(opc){	
	
	document.getElementById("opc").value=opc;	
	
	if (opc=="1"){
		document.getElementById("d_supervisor").style.display	= "block";
		document.getElementById("d_monitor").style.display		= "none ";
		document.getElementById("d_olas").style.display			= "none";	
		document.getElementById("d_locales").style.display		= "none";		
	}
	
	if (opc=="2"){
		document.getElementById("d_supervisor").style.display	= "none";
		document.getElementById("d_monitor").style.display		= "block ";
		document.getElementById("d_locales").style.display		= "none";
		document.getElementById("d_olas").style.display			= "none";		
	}
	
	if (opc=="3"){
		document.getElementById("d_supervisor").style.display	= "none";
		document.getElementById("d_monitor").style.display		= "none ";
		document.getElementById("d_olas").style.display			= "none";	
		document.getElementById("d_locales").style.display		= "block";		
	}
	
	if (opc=="4"){
		document.getElementById("d_supervisor").style.display	= "none";
		document.getElementById("d_monitor").style.display		= "none ";
		document.getElementById("d_locales").style.display		= "none";	
		document.getElementById("d_olas").style.display			= "block";		
	}
	
	
}


function grabar_cambios(){
	
	var iduser = document.getElementById("iduser").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;	
	var opc = document.getElementById("opc").value;		
	
	if (document.getElementById("opc").value=="1"){
			var combo = document.getElementById("c_supervisor").value;	
	}
	if (document.getElementById("opc").value=="2"){
			var combo = document.getElementById("c_monitor").value;	
	}
	if (document.getElementById("opc").value=="3"){
			var combo = document.getElementById("c_local").value;	
	}
	
	if (document.getElementById("opc").value=="4"){
			var combo = document.getElementById("c_olas").value;	
	}
	
	
	if (nro_escogidos <= 0){
	alert("No ha escogido elementos")	
	return	
	}else{
	
		var pag="../funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos
		+"&nro_escogidos="+nro_escogidos+"&combo="+combo+"&opc="+opc+"&accion=grabar_cambios";
		//alert(pag)
		
		ajaxc = createRequest();
		ajaxc.open("get", pag, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				alert(ajaxc.responseText);	
				//var msn ="Se agregaron " + nro_escogidos + " gestores";
				alert("Se actualizaron correctamente")				
				document.getElementById("c_inc").value	= ajaxc.responseText; 				
				parent.modal.hide();
				
				if (document.getElementById("opc").value=="1"){
						document.getElementById("d_supervisor").style.display	= "none ";
				}
				if (document.getElementById("opc").value=="2"){
						document.getElementById("d_monitor").style.display		= "none ";
				}
				if (document.getElementById("opc").value=="3"){
						document.getElementById("d_local").style.display		= "none ";
				}
						
			}
		}
		ajaxc.send(null)	
	}
}

function grabar_cambios2(){
	
	var iduser = document.getElementById("iduser").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;	
	var opc = document.getElementById("opc").value;		
	
	if (document.getElementById("opc").value=="1"){
			var combo = document.getElementById("c_supervisor").value;	
	}
	if (document.getElementById("opc").value=="2"){
			var combo = document.getElementById("c_monitor").value;	
	}
	if (document.getElementById("opc").value=="3"){
			var combo = document.getElementById("c_local").value;	
	}
	
	if (document.getElementById("opc").value=="4"){
			var combo = document.getElementById("c_olas").value;	
	}
	
	
	if (nro_escogidos <= 0){
	alert("No ha escogido elementos")	
	return	
	}else{
	
		var pag="../funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos
		+"&nro_escogidos="+nro_escogidos+"&combo="+combo+"&opc="+opc+"&accion=grabar_cambios2";
		//alert(pag)
		
		ajaxc = createRequest();
		ajaxc.open("get", pag, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				//alert(ajaxc.responseText);	
				//var msn ="Se agregaron " + nro_escogidos + " gestores";
				alert("Se actualizaron correctamente")				
				document.getElementById("c_inc").value	= ajaxc.responseText; 				
				parent.modal.hide();
				
				if (document.getElementById("opc").value=="1"){
						document.getElementById("d_supervisor").style.display	= "none ";
				}
				if (document.getElementById("opc").value=="2"){
						document.getElementById("d_monitor").style.display		= "none ";
				}
				if (document.getElementById("opc").value=="3"){
						document.getElementById("d_local").style.display		= "none ";
				}
						
			}
		}
		ajaxc.send(null)	
	}
}

function grabar_incidencia_prueba(opc){
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var tp_incidencia = document.getElementById("tp_incidencia").value;	

	

	if (opc=="1"){
		var trabajador = document.getElementById("gestor").value;
		
		if (document.getElementById("gestor").value=="0"){
		alert("DEBE INGRESAR DATOS DEL TRABAJADOR")	
		return
		}
	}else{	
		var trabajador = document.getElementById("cip").value + "-" + document.getElementById("dni").value;
	}
	
	if (document.getElementById("iduser").value==""){
	alert("VUELVA A LOGEARSE...")	
	window.open='http://10.226.158.199/cot/login.php';
	return
	}


	if (document.getElementById("tiempo").value=="0"){
		alert("ERROR: TIEMPO NO INGRESADO");
		return	
	}


	if (document.getElementById("tp_incidencia").value=="0"){
		alert("DEBE ESCOGER UN TIPO INCIDENCIA");
		return	
	}

	if (document.getElementById("combo_mot").value=="0"){
		alert("DEBE ESCOGER MOTIVO");
		return	
	}


	if (document.getElementById("obs").value==""){
		alert("DEBE INGRESAR UNA OBSERVACION");
		return	
	}


	
	var c_doid = document.getElementById("c_doid").value;	
	var nro = document.getElementById("nro").value;

	if (document.getElementById("modo").value=="0"){
			var fec1 = document.getElementById("input1").value;	
			var fec2 = document.getElementById("input2").value;	
			
			var fec1  = fec1.split(" ");
			var fec1x  = fec1[0];
			var xfec_ini = fec1x.split("-");
			var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
			
			var fec2  = fec2.split(" ");
			var fec2x  = fec2[0];
			var xfec_fin = fec2x.split("-");
			var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
			
			var modo = "D";	
	}else{
		var modo = document.getElementById("modo").value;	
		
		if (document.getElementById("modo").value=="D"){
			var fec1 = document.getElementById("input1").value;	
			var fec2 = document.getElementById("input2").value;	
			
			var fec1  = fec1.split(" ");
			var fec1x  = fec1[0];
			var xfec_ini = fec1x.split("-");
			var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
			
			var fec2  = fec2.split(" ");
			var fec2x  = fec2[0];
			var xfec_fin = fec2x.split("-");
			var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
		
		}else{
			
			var fec1 = document.getElementById("input3").value;	
			var fec2 = document.getElementById("input3").value;	
			
			var h_ini = document.getElementById("h_ini").value +":"+ document.getElementById("mm_ini").value;	
			var h_fin = document.getElementById("h_fin").value +":"+ document.getElementById("mm_fin").value;	
			
			var fec1  = fec1.split(" ");
			var fec1x  = fec1[0];
			var xfec_ini = fec1x.split("-");
			var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
			
			var fec2  = fec2.split(" ");
			var fec2x  = fec2[0];
			var xfec_fin = fec2x.split("-");
			var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
			
		}
	}


	var tiempo = document.getElementById("tiempo").value;		
	var c_mot_inc = document.getElementById("combo_mot").value;	
	var obs = document.getElementById("obs").value;	
	
	var pag1 = "funciones_cot.php?iduser="+iduser+"&trabajador="+trabajador+"&tp_incidencia="+tp_incidencia+"&c_mot_inc="+c_mot_inc+"&c_doid="+c_doid+"&nro="+nro+"&fec_ini="+xfec_ini+"&modo="+modo+"&opc="+opc+"&tiempo="+tiempo+"&fec_fin="+xfec_fin+"&obs="+obs+"&accion=grabar_incidencia_prueba";


	alert(pag1)

	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag1, true);
    ajaxc1.onreadystatechange = function () {		
				
        if (ajaxc1.readyState == 4) {																	
			alert(ajaxc1.responseText)  	
			//alert("Se registro exitosamente")	
			//parent.ras.hide();
			//parent.location.reload();		
			}        
	}
	ajaxc1.send(null)
			
}

function mostrar_combo_gestores(nom_combo,valor1){		
		
		var valor1= valor1;
		var valor1=valor1.split("|");
		var valor1=valor1[0];
		
		var urlx = "funciones_cot.php?valor1="+valor1+"&combo="+nom_combo+"&accion=carga_combo_gestores";			
		
		//alert(urlx)
		
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			//alert(ajaxc.responseText);
			if (ajaxc.readyState==4) 
			{				
				document.getElementById("d_gestores").innerHTML = ajaxc.responseText;			
			
			}
		}
		 ajaxc.send(null)			 
}

function buscar_gestores_asig(){
	var c_supervisor = document.getElementById("c_supervisor").value;	
	var fec = document.getElementById("input1").value;	
	var h_ini = document.getElementById("h_ini").value;	
	var origen = document.getElementById("origen").value;	
	var gestores = document.getElementById("gestores").value;	
	
	var urlx = "funciones_cot.php?c_supervisor="+c_supervisor+"&gestores="+gestores+"&fec="+fec
	+"&h_ini="+h_ini+"&origen="+origen+"&accion=buscar_gestores_asig";	
	
	//alert(urlx)	
	
	ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			
			if (ajaxc.readyState==4) 
			{				
			//alert(ajaxc.responseText);
				document.getElementById("div_bandeja_asignaciones").innerHTML = ajaxc.responseText;			
			
			}
		}
		 ajaxc.send(null)
	
}

function mostrar_combo_gu(nom_combo,valor1,tabla){		
		
		var valor1= valor1;
		var valor1=valor1.split("|");
		var valor1=valor1[0];
		
		var urlx = "funciones_cot.php?valor1="+valor1+"&combo="+nom_combo+"&tabla="+tabla+"&accion=carga_combo_gestores";			
		
		//alert(urlx)
		
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			//alert(ajaxc.responseText);
			if (ajaxc.readyState==4) 
			{	
				document.getElementById("d_gestores").style.display		= "block ";			
				document.getElementById("d_gestores").innerHTML = ajaxc.responseText;			
			
			}
		}
		 ajaxc.send(null)			 
}
function mostrar_coordinado(nom_combo,valor1){	
	//var valor1 = document.getElementById("cb_solicitud").value;	
	
	var ur_1 = "funciones_cot.php?valor1="+valor1+"&combo="+nom_combo+"&accion=mostrar_coordinado";			
		
		//alert(urlx)
		
		ajaxc1=createRequest();
		ajaxc1.open("GET", ur_1,true);
		ajaxc1.onreadystatechange=function() {
			//alert(ajaxc.responseText);
			if (ajaxc1.readyState==4) 
			{				
				document.getElementById("d_coordinado").style.display		= "block ";
				document.getElementById("d_coordinado").innerHTML 			= ajaxc1.responseText;			
			
			}
		}
		 ajaxc1.send(null)		
}


function grabar_gestion_usu(){
	var iduser = document.getElementById("iduser").value;
	var gestor = document.getElementById("cb_gestor").value;	
	var solicitud = document.getElementById("cb_solicitud").value;	
	var fec = document.getElementById("input1").value;	
	var cmotivos = document.getElementById("c_motivos_gu").value;	
	var n_req = document.getElementById("n_req").value;	
	var coordinado = document.getElementById("c_coordinado").value;	
	var tpregistro = document.getElementById("cb_tpregistro").value;	
	var obs = document.getElementById("obs").value;	
	
	if (document.getElementById("n_req").value==""){
		alert("Debes ingresar el numero")
		return
	}
	
	var urlx = "funciones_cot.php?gestor="+gestor+"&solicitud="+solicitud+"&n_req="+n_req+"&fec="+fec+"&iduser="+iduser
	+"&tpregistro="+tpregistro+"&cmotivos="+cmotivos+"&obs="+obs+"&coordinado="+coordinado+"&accion=grabar_gestion_usu";	
	
	//alert(urlx)	
	
	
	ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			
			if (ajaxc.readyState==4) 
			{				
			//alert(ajaxc.responseText);
				//document.getElementById("d_gestores").innerHTML = ajaxc.responseText;	
				alert("Se registro correctamente")
				document.getElementById("input1").value="";
				document.getElementById("cb_gestor").value="0";
				document.getElementById("n_req").value="";
				document.getElementById("d_coordinado").style.display="none";
				document.getElementById("cb_tpregistro").style.display="none";
				document.getElementById("d_motivos_gu").style.display="none";
				mostrar_frame_gu();		
			
			}
		}
		 ajaxc.send(null)	
	
}

function mostrar_frame_gu(){	
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var iframe_gu = document.getElementById("f_gestion_usuarios");
	var pag_gu="bandejas/bandeja_seguimiento_gu.php?iduser="+iduser+"&idperfil="+idperfil;			 		
	
	//alert(pag)
	document.getElementById("d_gestion_usuarios").style.display="block";	
	iframe_gu.style.visibility="visible";	
	iframe_gu.src= pag_gu;
	
}

function tecla(e)
{ //e is event object passed from function invocation
	
	var characterCode;
	
	
	if(e && e.which)
	{ //if which property of event object is supported (NN4)
		e = e
		characterCode = e.which //character code is contained in NN4's which property
	}
	else
	{
		e = event
		characterCode = e.keyCode //character code is contained in IE's keyCode property
	}
	

		
	if (document.getElementById("obs").value=="" ||  document.getElementById("obs").value==" "){
		document.getElementById("bt_aceptar_gu").style.display="none";
	}else{
		document.getElementById("bt_aceptar_gu").style.display="block";
	}
	/*
	if(characterCode == 13)
	{ 
		
		acceso();	
	}else{
		return true;
	}
	*/
	
}

function ver_div_incidencias(){
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	
	if 	(document.getElementById("c_inc").value==""){
		var c_inc = document.getElementById("c_inc").value;
	}else{
		var c_inc = document.getElementById("c_i").value + document.getElementById("c_inc").value;
	}
	
	if (idperfil!=1){
		document.getElementById("btn_compensa").style.display="block";
	} else {
		document.getElementById("btn_compensa").style.display="none";
	}
	
	var supervisor = document.getElementById("cb_supervisor").value;
	var gestor = document.getElementById("cb_gestor").value;
	var u_reg = document.getElementById("cb_reg").value;
	
	var fec_i = document.getElementById("an_i").value+"/"+document.getElementById("mes_i").value+"/"+document.getElementById("dia_i").value;
	
	var fec_f = document.getElementById("an_f").value+"/"+document.getElementById("mes_f").value+"/"+document.getElementById("dia_f").value;

	var estado = document.getElementById("select_estado_incidencia").value
	
	console.log(iduser);
	console.log(idperfil);
	console.log(u_reg);
	console.log(c_inc);
	console.log(gestor);
	console.log(fec_i);
	console.log(fec_f);
	
	var pag_inc = "grid_incidencias.php?iduser="+iduser+"&idperfil="+idperfil+"&u_reg="+u_reg+"&c_inc="+c_inc+"&gestor="+gestor+"&fec_i="+fec_i+"&fec_f="+fec_f+"&estado="+estado+"&supervisor="+supervisor;	
	
	//alert (pag_inc)
	document.getElementById("f_lista_incidencias").style.visibility="visible";	
	document.getElementById("f_lista_incidencias").src	= pag_inc;
	
}


function limpiar_inc(){
	document.getElementById("c_inc").value="";
	document.getElementById("cb_gestor").value="0";
	document.getElementById("cb_reg").value="0";
	document.getElementById("an_i").value="0000";
	document.getElementById("mes_i").value="0";
	document.getElementById("dia_i").value="0";
	document.getElementById("an_f").value="0000";
	document.getElementById("mes_f").value="0";
	document.getElementById("dia_f").value="0";
	document.getElementById("f_lista_incidencias").style.visibility="hidden";	
	document.getElementById("d_incidencias_1").style.display="none";
	document.getElementById("div_editar_incidencia").style.display="none";	
}

function mostrar_rep_inc(opc){
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
		
	if 	(document.getElementById("c_inc").value==""){
		var c_inc = document.getElementById("c_inc").value;
	}else{
		var c_inc = document.getElementById("c_i").value + document.getElementById("c_inc").value;
	}
	
	var gestor = document.getElementById("cb_gestor").value;
	var u_reg = document.getElementById("cb_reg").value;
	
	var fec_i = document.getElementById("an_i").value+"/"+document.getElementById("mes_i").value+"/"+document.getElementById("dia_i").value;
	
	var fec_f = document.getElementById("an_f").value+"/"+document.getElementById("mes_f").value+"/"+document.getElementById("dia_f").value;
	
	
	
	
	if (opc=="1"){
		
		if (u_reg=="0"){
		var pag_inc1 = "grid_inc_1.php?iduser="+iduser+"&idperfil="+idperfil+"&c_inc="+c_inc+"&gestor="+gestor
		+"&fec_i="+fec_i+"&fec_f="+fec_f;		
		}else{
		alert("Este criterio no funciona para esta vista")
		}	
	
	}
	
	if (opc=="2"){
		
	var pag_inc1 = "grid_inc_2.php?iduser="+iduser+"&idperfil="+idperfil+"&c_inc="+c_inc+"&gestor="+gestor+"&fec_i="+fec_i+"&fec_f="+fec_f;	
	//document.getElementById("dni_").focus();
	}
	
	//alert (pag_inc1)
	
	document.getElementById("div_editar_incidencia").style.display="none";		
	document.getElementById("d_incidencias_1").style.display="block";		
	document.getElementById("f_incidencias_1").src	= pag_inc1;
	
}
	
function ver_incidencia(c0,c1,c2,c3,c4,c5,c6,c7,c8,c9){
	
	var msn = "Incidencia : " + c1;
	
	alert(msn)
	
	document.getElementById(c5).style.background="#F9ED9C";	
	
	parent.document.getElementById("div_editar_incidencia").style.display="block";
	parent.document.getElementById("d_incidencias_1").style.display="none";
	parent.document.getElementById("x_obs").value=c0;
	
	if (c9=="0"){
		var est="PENDIENTE DE APROBAR";
	}
	
	if (c9=="1"){
		var est="APROBADO";
	}
	
	if (c9=="2"){
		var est="RECHAZADO";
	}
	

	
	if (c0!="INCIDENCIAS DE SISTEMAS"){
	parent.document.getElementById("x_inc").value=c1;
	parent.document.getElementById("x_ges").value=c7;
	parent.document.getElementById("x_fecr").value=c6;
	parent.document.getElementById("x_fec1").value=c2;
	parent.document.getElementById("x_fec2").value=c3;
	parent.document.getElementById("x_obs").value=c4;	
	parent.document.getElementById("x_registrado").value=c8;
	parent.document.getElementById("x_estado_inc").value=est;	
	}else{
	parent.document.getElementById("x_inc").value=c1;
	parent.document.getElementById("x_ges").value="-";
	parent.document.getElementById("x_fecr").value=c6;
	parent.document.getElementById("x_fec1").value=c2;
	parent.document.getElementById("x_fec2").value=c3;
	parent.document.getElementById("x_obs").value=c4;
	parent.document.getElementById("x_registrado").value=c8;	
	parent.document.getElementById("x_estado_inc").value=est;	
	}
	
	parent.document.getElementById("x_inc").focus();
	
}

function grabar_edicion_incidencia(){
	var c_inc=document.getElementById("x_inc").value;	
	var iduser=document.getElementById("iduser").value;	
	var idperfil=document.getElementById("idperfil").value;	
	var fec_ini=document.getElementById("x_fec1").value;
	var fec_fin=document.getElementById("x_fec2").value;
	var tp_inc=document.getElementById("x_tp").value;
	var obs=document.getElementById("x_obs").value;
	
	

	var pagx1 = "funciones_cot.php?iduser="+iduser+"&c_inc="+c_inc+"&fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&tp_inc="+tp_inc
	+"&obs="+obs+"&accion=grabar_edicion_incidencia";
	
	//alert(pagx1)
	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pagx1, true);
    ajaxc1.onreadystatechange = function () {
		 	
        if (ajaxc1.readyState == 4) {
			//alert(ajaxc1.responseText) 	
			var msn="Se actualizo la incidencia "+c_inc+"correctamente";
			alert(msn)
			document.getElementById("div_editar_incidencia").style.display="none";	
			ver_div_incidencias()
			}        
	}
	ajaxc1.send(null)
	
}

function eliminar_incidencia(c_inc,inc,xdni){
		var iduser = document.getElementById("iduser").value;		
		var urlx = "funciones_cot.php?c_inc="+c_inc+"&iduser="+iduser+"&accion=eliminar_incidencia";	
		
	var msn2="Desea Eliminar la incidencia "+inc+" para el dni "+xdni+" ?";
	if (confirm(msn2)){	
		//alert(urlx)
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			
			if (ajaxc.readyState==4) 			
			{			
				//alert(ajaxc.responseText);				
				alert("Registro Eliminado")
				document.getElementById("d_incidencias_1").style.display="none";
				document.getElementById("div_editar_incidencia").style.display="none";	
				ver_div_incidencias()			
			}
		}
		 ajaxc.send(null)	
	}
}

function reporte_inc(opc){
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;
	
			
	if 	(document.getElementById("c_inc").value==""){
		var c_inc = document.getElementById("c_inc").value;
	}else{
		var c_inc = document.getElementById("c_i").value + document.getElementById("c_inc").value;
	}
	var supervisor = document.getElementById("cb_supervisor").value;
	var gestor = document.getElementById("cb_gestor").value;
	var u_reg = document.getElementById("cb_reg").value;
	
	var fec_i = document.getElementById("an_i").value+"/"+document.getElementById("mes_i").value+"/"+document.getElementById("dia_i").value;
	
	var fec_f = document.getElementById("an_f").value+"/"+document.getElementById("mes_f").value+"/"+document.getElementById("dia_f").value;

	var estado = document.getElementById("select_estado_incidencia").value;
	
	if (opc=="1"){
	var url = "reporte_incidencias_nuevo_v1.php?iduser="+iduser+"&idperfil="+idperfil+"&u_reg="+u_reg+"&c_inc="+c_inc+"&gestor="+gestor+"&fec_i="+fec_i+"&fec_f="+fec_f + "&estado=" + estado + "&supervisor=" + supervisor;			
	}

	if (opc=="2"){
	var url = "reporte_inc_1.php?iduser="+iduser+"&idperfil="+idperfil+"&c_inc="+c_inc+"&u_reg="+u_reg+"&gestor="+gestor+"&fec_i="+fec_i+"&fec_f="+fec_f;			
	}

	if (opc=="3"){
	var url = "reporte_inc_2.php?iduser="+iduser+"&idperfil="+idperfil+"&c_inc="+c_inc+"&u_reg="+u_reg+"&gestor="+gestor+"&fec_i="+fec_i+"&fec_f="+fec_f;			
	}
	
		
	win=window.open(url,true);

	
}
function reporte_devueltas(){
	var url="reporte_devoluciones_tecnicas.php";
	win=window.open(url,true);	
}

function MIexcel(){
	
	var IEx='';//is IE
	var Hoja;
	var Libro;
	var Vcols;
	var ObjetoXLS;//Objeto excel
	
	IEx=document.all?1:0; //is IE confirm
	
	if(IEx==1){
	ObjetoXLS = new ActiveXObject("Excel.Application");
	RUTA = "D://COMPARTIDO/DATA/DEVUELTAS/out/INC_PROB.xls";
	Libro = ObjetoXLS.Workbooks.OPEN(RUTA,false,false);
	Hoja = Libro.Worksheets(2);
	Hoja.Application.Visible = true;
	
	
	//Mostrar excel una vez ejecutado
	ExcelAp.visible = true;
	//Abrir un archivo específico
	var excBook = ExcelAp.Workbooks.open("D:/COMPARTIDO/DATA/DEVUELTAS/out/INC_PROB.xls"); 
	
	//ObjetoXLS = new ActiveXObject('Excel.Application');
	//Libro = ObjetoXLS.Workbooks.Add; //Libro
	//Hoja = Libro.Worksheets(2); //Hoja
	//Hoja.Activate(); //Activar la hoja
	//ObjetoXLS.ActiveSheet.Cells(2,2).Value = 'Hola';
	//ObjetoXLS.Application.Visible = true;
	}else{//Crear un complemento para firefox
	alert('Esto solo es compatible para iexplorer');
	}
}

function mostrar_vista_2(){
	var xano = document.getElementById("xano").value;	
	var xmes = document.getElementById("xmes").value;	
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;	

	
	var urlx = "vista_asignaciones_1.php?xano="+xano+"&xmes="+xmes+"&iduser="+iduser
	+"&idperfil="+idperfil;	
	
	//alert(urlx)	
	
	ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			
			if (ajaxc.readyState==4) 
			{				
			//alert(ajaxc.responseText);
				document.getElementById("div_vista_2").innerHTML = ajaxc.responseText;			
			
			}
		}
		 ajaxc.send(null)	
}

/**********************************************/

function proceso_carga_varios(opc){		
	
	var codigo="";
	
	if (opc=="1"){
	var url = "carga_canceladas_manual.php";	
	}
	
	if (opc=="2"){
	var url = "carga_migraciones.php";	
	}
	
	

	//alert(url)

	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			alert(ajaxc.responseText) 
			alert("Proceso Terminado")			
			}        
	}
	ajaxc.send(null)	
	
	
}

function visualizar_parametros(valor){
	//alert(valor)
	if (valor=="ASIGNACIONES"){
		document.getElementById("d_parametros_asignaciones").style.display="block";	
		document.getElementById("d_parametros_cancelaciones").style.display="none";	
		document.getElementById("d_parametros_migraciones").style.display="none";	
		document.getElementById("d_reasignaciones").style.display="none";
	}
	
	
	if (valor=="CANCELADAS"){
		document.getElementById("d_parametros_asignaciones").style.display="none";	
		document.getElementById("d_parametros_cancelaciones").style.display="block";
		document.getElementById("d_parametros_migraciones").style.display="none";			
		document.getElementById("d_reasignaciones").style.display="none";
	}
	if (valor=="MIGRACIONES"){
		document.getElementById("d_parametros_asignaciones").style.display="none";	
		document.getElementById("d_parametros_cancelaciones").style.display="NONE";
		document.getElementById("d_parametros_migraciones").style.display="block";	
		document.getElementById("d_reasignaciones").style.display="none";	
	}
	if (valor=="REASIGNACIONES"){
		document.getElementById("d_reasignaciones").style.display="block";	
		document.getElementById("d_parametros_asignaciones").style.display="none";	
		document.getElementById("d_parametros_cancelaciones").style.display="none";
		document.getElementById("d_parametros_migraciones").style.display="none";	
		document.getElementById("d_pedido").style.display="none";	
	}
	
}

function separar_cancelada(){
	document.getElementById("d_gestion_canceladas").style.display="block";
	
	
	var accion="separar_pedido_cancelada";
	var codigo = document.getElementById("pet_req").value;
	var f_carga = document.getElementById("f_carga").value;
	var f_legado = document.getElementById("f_legado").value;
	var iduser = document.getElementById("iduser").value;
	
	var url = "funciones_cot.php?iduser="+iduser+"&codigo="+codigo+"&f_carga="+f_carga+"&accion="+accion+"&f_legado="+f_legado;
	
	//alert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText) 	
			}        
	}
	ajaxc.send(null)	
}

function visualizar_pedido_v1(actividad){		
	var iduser = document.getElementById("iduser").value;
	var idperfil = document.getElementById("idperfil").value;
	var zon = document.getElementById("zon").value;
	
	
	if (actividad=="ASIGNACIONES"){
		var combo1 = document.getElementById("t_carga").value; 
		var combo2 = document.getElementById("zon").value;
		
		if (document.getElementById("t_carga").value=="0"){
				alert("Debe escojer el origen de la carga")
				return
		}
		
	}
	
	if (actividad=="MIGRACIONES"){
		var combo1 = document.getElementById("migrar_a").value; 
		var combo2 = '';
		
		if (document.getElementById("migrar_a").value=="0"){
				alert("Debe escojer la migracion")
				return
		}
		
	}
	
	if (actividad=="CANCELADAS"){
		var combo1 = document.getElementById("caso").value; 
		var combo2 = document.getElementById("tipo").value;
		
		if (document.getElementById("caso").value=="0"){
				alert("Debe escojer la casuistica")
				return
		}
		
	}
	
	
	var url = "modulo_asignaciones_v1.php?iduser="+iduser+"&idperfil="+idperfil+"&combo1="+combo1+"&combo2="+combo2+"&actividad="+actividad;
	
	//alert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText) 	
			document.getElementById("d_pedido").style.display="block";		
			document.getElementById("d_pedido").innerHTML=ajaxc.responseText;	
			//document.getElementById("d_historico_contactos").value=ajaxc.responseText;
			//mostrar_contadores();
			//document.getElementById("bt_pedir").style.display="block";		

			}        
	}
	ajaxc.send(null)	
	
	
}

function aceptar_pedido_canceladas(id){	
	
		var c_tipo = document.getElementById("c_tipo").value;	
		var iduser = document.getElementById("iduser").value;
		var codigo = document.getElementById("pet_req").value;
		
		
		if (document.getElementById("c_tipo").value==""){
			 alert("Campo Tipo Vacio")	
			 return
		}else{
			var pag = "funciones_cot.php?codigo="+codigo+"&c_tipo="+c_tipo+"&id="+id+"&iduser="+iduser+"&accion=aceptar_pedido_canceladas";		
			
			//alert(pag)
			
			ajaxc=createRequest();	
			ajaxc.open("GET", pag,true);
			ajaxc.onreadystatechange=function() {
		
				if (ajaxc.readyState==4){				
					var resp = ajaxc.responseText;		
					alert(resp)
					alert("OK")					
					document.getElementById("d_gestion_canceladas").style.display="none";	
					//document.getElementById("bt_pedir").style.display="none";
											
				}		
			}
			 ajaxc.send(null)
		}
}


/*********************************************************************************************************/

function buscar_contacto_tdata(){
	var dni = document.getElementById("dni").value;	
	var idperfil = parent.document.getElementById("idperfil").value;
	var iduser = parent.document.getElementById("iduser").value;
	var pc_asig = parent.document.getElementById("pc").value;
	var ape_pat = document.getElementById("ape_pat").value;	
	var ape_mat = document.getElementById("ape_mat").value;	
	var ncontacto = document.getElementById("ncontacto").value;	
	var pedido = document.getElementById("pedido").value;	
	document.getElementById("bdatos").value="TDATA";	
	
	var d = new Date();
	document.getElementById("timpo").value = d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
	//var iframe = document.getElementById("f_inferior");
	document.getElementById("div_lista_contactos").style.display="none"; 
	document.getElementById("d_historico_contactos").style.display="none"; 
	
	if (document.getElementById("usu_contactos").value==""){
		alert("UD.  NO ESTA LOGEADO.... VUELVA A INGRESAR")		
		var win=null;
		win=window.open("login.php",true);	
	}else{
		if (document.getElementById("dni").value=="" && document.getElementById("ncontacto").value=="" && 
		document.getElementById("ape_pat").value==""  && document.getElementById("ape_mat").value==""
		&& document.getElementById("pedido").value==""){	
			alert("DATOS VACIOS...")
			return
		}else{
		
			document.getElementById("barra_cargando").style.display="block";		
			document.getElementById("barra_cargando").innerHTML = "<img src=\"loading3.gif\" width='300' height='200' />";
			document.getElementById("div_lista_contactos").style.display="none";	
			
		if (document.getElementById("dni").value==""){
				var bd ="TERADATA";
		}else{
				var bd ="MYSQL";
		}
		
			
		var pag2 = "funciones_cot.php?dni="+dni+"&idperfil="+idperfil+"&pc_asig="+pc_asig+"&pedido="+pedido
		+"&ncontacto="+ncontacto+"&ape_pat="+ape_pat+"&bd="+bd+"&ape_mat="+ape_mat+"&iduser="+iduser+"&accion=validar_contacto_tdata";
		
		//alert(pag2);
			
		
		ajaxc = createRequest();
		ajaxc.open("get", pag2, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				var msn  = ajaxc.responseText;           
				//alert(msn)
				if (msn=="NO"){				
					return
					alert("Usuario no se encuentra registrado en la Base de Datos");					
				}else{				
					mostrar_datos_contacto_tdata('1');	
					
				}
						
			}
		}
		ajaxc.send(null)
		}
	}
}


function mostrar_datos_contacto_tdata(opc){
	var dni = document.getElementById("dni").value;	
	var iduser = document.getElementById("usu_contactos").value;
	var idperfil = parent.document.getElementById("idperfil").value;	
	var ape_pat = document.getElementById("ape_pat").value;	
	var ape_mat = document.getElementById("ape_mat").value;	
	var ncontacto = document.getElementById("ncontacto").value;		
	var pedido = document.getElementById("pedido").value;	
	
	//var iframe = document.getElementById("f_inferior");
	
	if (document.getElementById("usu_contactos").value=="" || document.getElementById("usu_contactos").value==" " || 
	document.getElementById("usu_contactos").value=="undefined"){
		alert("UD.  NO ESTA LOGEADO.... VUELVA A INGRESAR")		
		var win=null;
		win=window.open("login.php",true);	
		return
	}else{
		if (document.getElementById("dni").value=="" && document.getElementById("ncontacto").value==""
		&& document.getElementById("pedido").value==""){		
			var opc="1"; // nombres
		}else{
			if (document.getElementById("ncontacto").value=="" && document.getElementById("pedido").value==""){
				var opc="2";//dni
			}else{
				if (document.getElementById("ncontacto").value==""){
				var opc="3"; // pedido
				}else{
				var opc="4"; // telefono
				}
			}
		}
				
		if (document.getElementById("ape_pat").value=="" && document.getElementById("ape_mat").value=="" 
		&& document.getElementById("dni").value=="" && document.getElementById("ncontacto").value=="" && 
		document.getElementById("pedido").value==""){	
		alert ("Debe ingresar al menos 1 criterio de busqueda");
		document.getElementById("div_lista_contactos").style.display="none"; 
		//document.getElementById("d_editar_contactos").style.display="none";  
		return
		}else{			
			
		}
		
		var pag1 = "detalle_num_contacto_tdata.php?dni="+dni+"&opc="+opc+"&pedido="+pedido+"&idperfil="+idperfil
		+"&ncontacto="+ncontacto+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&iduser="+iduser;	
		
			//alert(pag1);
			
			
			
			ajaxc = createRequest();
			ajaxc.open("get", pag1, true);
			ajaxc.onreadystatechange = function () {
				//alert(ajaxc.responseText);
				if (ajaxc.readyState == 4) { 		
				document.getElementById("div_lista_contactos").style.display="block";  
				document.getElementById("div_lista_contactos").innerHTML=ajaxc.responseText;
				document.getElementById("barra_cargando").innerHTML="";
				
				}
			}
			ajaxc.send(null)
	}
	
}

function reg_nuevo_contacto_tdata(){	
	var iduser		=document.getElementById("usu_contactos").value;	
	var dni			=document.getElementById("dni_new").value;
	var ape_pat		=document.getElementById("pat_new").value;	
	var ape_mat		=document.getElementById("mat_new").value;	
	var nombres		=document.getElementById("nom_new").value;	
	var num_contacto=document.getElementById("fono_new").value;
	var operador	=document.getElementById("oper_new").value;	
	
	if (document.getElementById("fono_new").value==""){
		alert("Debe ingresar numero de referencia")
		return
	}

	if (document.getElementById("dni_new").value==""){
		alert("Debe ingresar dni")
		return
	}
		
	var page = "funciones_cot.php?iduser="+iduser+"&operador="+operador+"&num_contacto="+num_contacto
	+"&dni="+dni+"&ape_pat="+ape_pat+"&ape_mat="+ape_mat+"&nombres="+nombres+"&accion=reg_nuevo_contacto";
	
	//alert(page)
	
	
	ajaxc = createRequest();
    ajaxc.open("get", page, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			alert(ajaxc.responseText)  							
			mostrar_datos_contacto_tdata('1');
			}        
	}
	
	ajaxc.send(null)
	
	
	document.getElementById("div_registro_contacto").style.display		= "none ";
	
}

function historico_contactos_tdata(){		

	var dni=document.getElementById("xdni").value;

	var url = "historico_contactos.php?dni="+dni;
	var msn = "DATOS DNI : " + dni;
	
	//alert(url) 		
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText) 	
			document.getElementById("d_historico_contactos").style.display="block";		
			document.getElementById("d_historico_contactos").innerHTML=ajaxc.responseText;	
			//document.getElementById("d_historico_contactos").value=ajaxc.responseText;
			}        
	}
	ajaxc.send(null)	
	
	
}	

function validar_pedido_migracion(peticion,fec_reg,iduser,origen,pedido){	
	
	var msn2="Desea atender el Telefono "+peticion;
	if (confirm(msn2)){
		
		var pag1 = "funciones_cot.php?peticion="+peticion+"&iduser="+iduser+"&accion=validar_pedido_migracion";		
		//alert(pag1)
		
		ajaxp= new createRequest();	
		ajaxp.open("GET", pag1,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp = ajaxp.responseText;			
					//alert(resp)
				if (resp=="OCUPADO"){	
					var msn="El Telefono "+ peticion + " se encuentra en proceso"
					alert(msn)	
					return										
				}else{					
					//return
					aceptar_migracion(peticion,fec_reg,iduser)	
					//
					popup_reclamo('11',peticion,fec_reg,iduser,origen,pedido)
				}				
															
			}		
		}
		 ajaxp.send(null)
	 }else{		
	rechazar_pedido_migracion(peticion,iduser,'RECHAZO ANTES DE ATENDER');
	return;			
	}				 
}

function aceptar_migracion(peticion,fec_reg,iduser){			
		
		
		var pag = "funciones_cot.php?peticion="+peticion+"&fec_reg="+fec_reg+"&iduser="+iduser+"&accion=aceptar_migracion";		
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;	
				//alert(resp1)															
			}		
		}
		 ajaxp.send(null)	
	 
}


function mostrar_combo_mig(valor){
		
		var pag = "funciones_cot.php?valor="+valor+"&accion=mostrar_combo_mig";
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;					
				document.getElementById("d_combo_mig").style.display="block";		
				document.getElementById("d_combo_mig").innerHTML=ajaxp.responseText;	
			}		
		}
		 ajaxp.send(null)	
}

function grabar_migracion(telefono){
	var obs = document.getElementById("obs").value;	
	var iduser = document.getElementById("iduser").value;		
	var estado = document.getElementById("estado").value;
	var f_leg = document.getElementById("f_leg").value;
	
	if (document.getElementById("obs").value==""){
		alert("Debe ingresar una observacion")
		return
	}else{
		
		if (document.getElementById("estado").value=="ATENDIDO"){			
			var exc 	= "";
			var precio  = document.getElementById("precio").value;
			var c_atis  = document.getElementById("c_atis").value;
			var up 		= document.getElementById("up").value;
						
		}else{
			var exc 	= document.getElementById("exc").value;			
			var precio  = "";
			var c_atis  = "";
			var up 		= "";
		}
		
		var pag1 = "funciones_cot.php?telefono="+telefono+"&exc="+exc+"&estado="+estado+"&f_leg="+f_leg+"&precio="+precio+"&c_atis="+c_atis+"&up="+up+"&obs="+obs
		+"&iduser="+iduser+"&accion=grabar_migracion";
		
	   
	 // alert(pag1);
	   
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
		//	alert(ajaxc.responseText)
			var msn="Telefono N°."+telefono+" REGISTRADO";
			alert(msn);
			cerrar_win('2');				
			parent.location.reload();
        }
	}
	ajaxc.send(null)	
	
	
	}
	
}

function rechazar_pedido_migracion(peticion,iduser,obs){	
	
	var pag1 = "funciones_cot.php?peticion="+peticion+"&obs="+obs+"&iduser="+iduser+"&accion=rechazar_pedido_migracion";
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			//mostrar_contadores();
			}        
	}
	ajaxc.send(null)	
}

function guardar_arch(tipo){		
	var archivo_origen=document.getElementById("archivo").value;
	var carpeta_destino=document.getElementById("ruta_destino").value;
	
	
	//var pag="funciones_cot.php?archivo_origen="+archivo_origen+"&carpeta_destino="+carpeta_destino+"&tipo="+tipo+"&accion=guardar_archivo";		
	var pag="ws_subir_archivo.php?archivo_origen="+archivo_origen+"&carpeta_destino="+carpeta_destino;		

	//alert(pag)
	
	ajax = createRequest();	
					ajax.open("GET",pag,true);
					ajax.onreadystatechange=function() {
						if (ajax.readyState==4){
						var resx=ajax.responseText;							
						//document.getElementById("datos_planta").innerHTML = resx;
						alert (resx)
						}					 
					}

	ajax.send(null)			
	
}	

function validar_reasignacion(peticion,fec_reg,iduser,origen,pedido){	
	
		var pag1 = "funciones_cot.php?peticion="+peticion+"&iduser="+iduser+"&accion=validar_pedido";		
		//alert(pag1)
		
		ajaxp= new createRequest();	
		ajaxp.open("GET", pag1,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp = ajaxp.responseText;			
					//alert(resp)
				if (resp=="OCUPADO"){	
					var msn="El pedido "+ peticion + " se encuentra en proceso"
					alert(msn)	
					return										
				}else{					
					//return
					aceptar_asignacion(peticion,fec_reg,iduser,origen,pedido)	
					//
					popup_reclamo('1',peticion,fec_reg,iduser,origen,pedido)
				}				
															
			}		
		}
		 ajaxp.send(null)	 
}


function muestra_liq() {	
	document.getElementById("p1").style.display="block";	
	document.getElementById("bt_b2").style.display="block";	
	document.getElementById("bt_b1").style.display="none";	
	
	var iduser=document.getElementById("iduser").value;
	var telefono=document.getElementById("fono").value;
	var accion = "grabar_reasignacion"; 
	
	var pag="funciones_cot.php?telefono="+telefono+"&iduser="+iduser+"&accion="+accion;		

	//alert(pag)
	
	ajax = createRequest();	
					ajax.open("GET",pag,true);
					ajax.onreadystatechange=function() {
						if (ajax.readyState==4){
						var resx=ajax.responseText;							
						//document.getElementById("datos_planta").innerHTML = resx;
						//alert (resx)
						}					 
					}

	ajax.send(null)			
	
	
}


function fin_reasignacion() {	
	document.getElementById("p1").style.display="none";	
	document.getElementById("bt_b2").style.display="none";	
	document.getElementById("bt_b1").style.display="block";	
	
	var iduser=document.getElementById("iduser").value;
	var telefono=document.getElementById("fono").value;
	var c_reasig=document.getElementById("c_reasig").value;
	var c_comprobacion=document.getElementById("c_comprobacion").value;
	var accion = "fin_reasignacion"; 
	
	var pag="funciones_cot.php?telefono="+telefono+"&iduser="+iduser+"&c_comprobacion="+c_comprobacion+"&c_reasig="+c_reasig+"&accion="+accion;		

	//alert(pag)
	
	ajax = createRequest();	
					ajax.open("GET",pag,true);
					ajax.onreadystatechange=function() {
						if (ajax.readyState==4){
						var resx=ajax.responseText;							
						//document.getElementById("datos_planta").innerHTML = resx;
						alert (resx)
						}					 
					}

	ajax.send(null)			
	
	
}


function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }
		
		
function busca_dni(e)
{ //e is event object passed from function invocation
	
	
	var characterCode;
	
	/*
		var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
		
	*/
	if(e && e.which)
	{ //if which property of event object is supported (NN4)
		e = e
		characterCode = e.which //character code is contained in NN4's which property
	}
	else
	{
		e = event
		characterCode = e.keyCode //character code is contained in IE's keyCode property
	}
	
	if(characterCode == 13)
	{ 		
		buscar_reniec();	
	}
	else
	{
		return true;
	}
}

function buscar_reniec(opc) {	
	
	var dni=document.getElementById("dni").value;
	var iduser=document.getElementById("iduser").value;	
	if (document.getElementById("dni").value==""){
		alert("Campos Vacios")
		document.getElementById("datos_reniec").style.display="none";	
		return
		
	}else{
	
	
	if (opc=="0"){
		var accion = "detalle_maestra_reniec_tdata"; 		
	}else if (opc=='1'){
		var accion = "detalle_maestra_reniec_gescot"; 
	}else if(opc=='2'){
		var accion = "detalle_maestra_tb_dni"; 
	}
	
	var pag="funciones_cot.php?dni="+dni+"&iduser="+iduser+"&accion="+accion;		

	//alert(pag)
	
	ajax = createRequest();	
					ajax.open("GET",pag,true);
					ajax.onreadystatechange=function() {
						if (ajax.readyState==4){
						var resx=ajax.responseText;		
						document.getElementById("datos_reniec").style.display="block";	
						document.getElementById("datos_reniec").innerHTML = resx;
						document.getElementById("bt_grabar_usu").style.display="block";	
						//alert (resx)
						}					 
					}

	ajax.send(null)			
	}
}	

function grabar_movimientos_usuarios() {	
	
	
	var iduser=document.getElementById("iduser").value;
	var xid_ant=document.getElementById("xid_ant").value;
	var xdni_mov=document.getElementById("xdni_mov").value;
	var xcip_mov=document.getElementById("xcip_mov").value;
	var xusu_mov=document.getElementById("xusu_mov").value;
	var xapli_mov=document.getElementById("xapli_mov").value;
	var xfec_mov=document.getElementById("an_i").value+"-"+document.getElementById("mes_i").value+"-"+document.getElementById("dia_i").value;
	var accion = "grabar_movimientos_usuarios"; 
	
	//alert(xfec_mov)
	
	
	if (document.getElementById("an_i").value=="0000" || document.getElementById("dia_i").value=="00"){
		alert("Error: Valor de la fecha Vacia");
		return			
	}else{
		if (xusu_mov=="" || xusu_mov=="-" || xusu_mov=="X"){
			alert("Error: El dato del usuarios esta vacio");
			return			
		}else{
			var pag="funciones_cot.php?iduser="+iduser+"&xdni_mov="+xdni_mov+"&xcip_mov="+xcip_mov+"&xid_ant="+xid_ant+"&xusu_mov="+xusu_mov+"&xapli_mov="+xapli_mov
			+"&xfec_mov="+xfec_mov+"&accion="+accion;		
		
			//alert(pag)
			
			ajax = createRequest();	
							ajax.open("GET",pag,true);
							ajax.onreadystatechange=function() {
								if (ajax.readyState==4){
								var resx=ajax.responseText;							
								//document.getElementById("datos_planta").innerHTML = resx;
								alert(resx)
								document.getElementById("div_edicion_usuarios").style.display="NONE";
								//parent.ras.hide();
								parent.ras.reload()
								}					 
							}
		
			ajax.send(null)			
		}	
	}
}



function mostrar_registro_incidenciacot(valor) {	
	
	var iduser=document.getElementById("iduser").value;

	if (valor=="1"){			
	document.getElementById("div_registro_incidencias").style.display="block";
	document.getElementById("lista_participantes").style.display="none";
	//document.getElementById("botones_gru").style.display="none";
	document.getElementById("registro_gestores").style.display="none";
	document.getElementById("div_modulo_masivo").style.display="none";
	}
	
	/*
	if (valor=="2"){	
	document.getElementById("div_registro_incidencias").style.display="none";
	var page		="bandejas/modulo_incidencia_grupal.php?iduser="+iduser;
	var atributos 	="width=1300px,height=500px,top=60px,left=10px,center=0,resize=0,scrolling=0";
	var titulo 		="REGISTRO DE INCIDENCIAS GRUPALES";
	modal=dhtmlmodal.open('EmailBox', 'iframe',page,titulo,atributos);		
	}
	*/
	if (valor=="2"){	
	document.getElementById("lista_participantes").style.display="block";
	document.getElementById("div_modulo_masivo").style.display="none";
	}
	
	
	if (valor=="3"){	
	document.getElementById("lista_participantes").style.display="none";	
	document.getElementById("div_modulo_masivo").style.display="block";
	}

	if (valor=="4"){
		document.getElementById("lista_participantes").style.display="none";	
		document.getElementById("div_modulo_masivo").style.display="none";	
		document.getElementById("div_modulo_masivo_excel").style.display="block";
	}
	
}

function agregar_gestores(){
	var iduser = document.getElementById("iduser").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;	
	

	//alert(document.getElementById("arr_escogidos").value)
	
	if (document.getElementById("arr_escogidos").value==""){
	alert("No ha escogido elementos")	
	return	
	}else{
		document.getElementById("lista_participantes").style.display	="none";
		
		var pag="funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos
		+"&nro_escogidos="+nro_escogidos+"&accion=agregar_gestores";
		//alert(pag)
		
		ajaxc = createRequest();
		ajaxc.open("get", pag, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				//alert(ajaxc.responseText);	
				var msn ="Se agregaron " + nro_escogidos + " gestores";
				//alert(msn)
				document.getElementById("registro_gestores").style.display	= "block";
				document.getElementById("c_inc").value						= ajaxc.responseText; 
				document.getElementById("c_incidencia").value				= ajaxc.responseText; 
				//Fdocument.getElementById("bt_aceptar_gru").style.display		= "block";
				mostrar_horarios_gestores();						
			}
		}
		ajaxc.send(null)	
	}
	
}

function mostrar_modo_gru(valor_c){
	
	document.getElementById("tiempo_gru").value="";
	document.getElementById("exc_gru").value="";
	
	if (valor_c=="D"){
		
		document.getElementById("f_dias_gru").style.display="block";	
		document.getElementById("f_horas_gru").style.display="none";	
		document.getElementById("f_horas_gru_lactancia").style.display="none";	
			
						
			if (document.getElementById("combo_mot").value=="800"){
				document.getElementById("inputg2").style.display="none"; 
				document.getElementById("b_cal2").style.display="none"; 
			}else{
				if (document.getElementById("combo_mot").value=="41"){
				document.getElementById("f_horas_gru").style.display="none";	
				document.getElementById("f_dias_gru").style.display="block";		
				}else{
				document.getElementById("inputg2").style.display="block"; 
				document.getElementById("b_cal2").style.display="block"; 
				}		
			
			}
				
	   }
		
	   if (valor_c=="H"){
			if(document.getElementById("combo_mot").value=="41"){
				document.getElementById("f_horas_gru_lactancia").style.display="block";	
				document.getElementById("f_horas_gru").style.display="none";	
				document.getElementById("f_dias_gru").style.display="none";	
			}else{
				document.getElementById("f_horas_gru").style.display="block";	
				document.getElementById("f_dias_gru").style.display="none";	
			}
	}	
		
		
		document.getElementById("bt_aceptar_gru").style.display="block";			
		
}

function mostrar_modo_mas(valor_c){
	document.getElementById("tiempo_mas").value="";
	document.getElementById("exc_mas").value="";
	
	if (valor_c=="D"){
		document.getElementById("f_dias_mas").style.display="block";	
		document.getElementById("f_horas_mas").style.display="none";			
		
	}
	if (valor_c=="H"){
		document.getElementById("f_horas_mas").style.display="block";	
		document.getElementById("f_dias_mas").style.display="none";	
	}	
	
}

function calcular_tiempos_gru(){
	var modo = document.getElementById("modo_gru").value;
	
	if (document.getElementById("modo_gru").value=="0"){	
		var fec1 = document.getElementById("inputg1").value;
		var fec2 = document.getElementById("inputg2").value;
		var fec = "";
		document.getElementById("exc_gru").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var fec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];
		
		/*
		if (fec_fin > fec_ini){		
		}else{
			alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
		}
		*/

	}else{
		if (document.getElementById("modo_gru").value=="D"){
		var fec1 = document.getElementById("inputg1").value;
		var fec2 = document.getElementById("inputg2").value;
		var fec = "";
		document.getElementById("exc_gru").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var fec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];
		
		
		if (fec_fin >= fec_ini){
			/*
			alert(fec1[1])
			alert(fec2[1])
			
			if (fec2[1]> fec1[1]){
				
			}else{
				alert("ALERTA: ERROR CON EL FORMATO DE HORAS")
				return	
			}
			*/
		}else{
			alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
			return
		}

		
		}
		if (modo=="H"){
		var fec = document.getElementById("inputg3").value;
		var hor_ini = document.getElementById("h_ini_gru").value + ":" + document.getElementById("mm_ini_gru").value;
		var hor_fin = document.getElementById("h_fin_gru").value + ":" + document.getElementById("mm_fin_gru").value;
		document.getElementById("exc_gru").value="HH:MM";	
		}
		
	}
	
	if (document.getElementById("modo_gru").value=="D" || document.getElementById("modo_gru").value=="0"){
		if (document.getElementById("inputg1").value=="" || document.getElementById("inputg2").value==""){
			document.getElementById("bt_aceptar_gru").style.display="none";	
			alert("ERROR: NO HA INGRESADO FECHAS")
			return
		}else{
			//document.getElementById("bt_aceptar").style.display="block";	
		}		
	}else{
		if (document.getElementById("inputg3").value=="" || 
		document.getElementById("h_ini_gru").value=="0" || document.getElementById("h_fin_gru").value=="0"
		){
			document.getElementById("bt_aceptar_gru").style.display="none";	
			alert("ERROR: NO HA INGRESADO HORAS COMPLETAS")
			return
		}else{
			//document.getElementById("bt_aceptar").style.display="block";	
		}		
	}
	
	
	
	
	var pag4 = "funciones_cot.php?fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&fec="+fec+"&modo="+modo+"&hor_ini="+hor_ini
	+"&hor_fin="+hor_fin+"&accion=calcular_tiempo";
	
	//alert(pag4);
	
	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			var msn  = ajaxc.responseText;           
			//alert(msn)
			document.getElementById("tiempo_gru").value = msn;
        }
	}
	ajaxc.send(null)
	
	
	}
	
function validar_horas_gru(h_fin){
	var h_ini = document.getElementById("h_ini_gru").value;
	
	if (h_fin < h_ini) {
		alert("La hora debe ser mayor que la hora inicial")
		}
	
}



function grabar_incidencia_grupal(){
	
	var iduser = document.getElementById("iduser").value;	
	var c_incidencia = document.getElementById("c_incidencia").value;	
	var tp_incidencia = document.getElementById("tp_incidencia").value;	
	var c_mot_gru = document.getElementById("c_mot_gru").value;	
	var c_mot_inc_gru = document.getElementById("combo_mot").value;	
	var modo_gru = document.getElementById("modo_gru").value;	
	var tiempo_gru = document.getElementById("tiempo_gru").value;	
	var obs_gru = document.getElementById("obs_gru").value;	
	var c_doid_gru = document.getElementById("c_doid_gru").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	var s_arr_hor = document.getElementById("arr_hor").value;	
	var arr_hor = s_arr_hor.substring(1,1000);
	
	if (nro_escogidos==""){
	alert("No ha escogido elementos")	
	return	
	}else{
		
		  if (document.getElementById("c_incidencia").value=="" || document.getElementById("c_incidencia").value=="INC-1"){
			alert("EL CODIGO DE INCIDENCIA ESTA VACIO O TIENE UN DATO ERRONEO(INC-1)")	
			return	
	      }else{
			
				if (document.getElementById("modo_gru").value=="0"){
				var fec1 = document.getElementById("inputg1").value;	
				var fec2 = document.getElementById("inputg2").value;	
				
				var fec1  = fec1.split(" ");
				var fec1x  = fec1[0];
				var xfec_ini = fec1x.split("-");
				var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
				
				var fec2  = fec2.split(" ");
				var fec2x  = fec2[0];
				var xfec_fin = fec2x.split("-");
				var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
						
					
				}else{
					if (document.getElementById("modo_gru").value=="D"){
						var fec1 = document.getElementById("inputg1").value;	
						var fec2 = document.getElementById("inputg2").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
					
					}else{
						
						var fec1 = document.getElementById("inputg3").value;	
						var fec2 = document.getElementById("inputg3").value;	
						
						var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
						var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
						
					}
				}

		
		var pag="funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos+"&c_incidencia="+c_incidencia+"&c_mot_gru="+c_mot_gru
		+"&c_mot_inc_gru="+c_mot_inc_gru+"&modo_gru="+modo_gru+"&tiempo_gru="+tiempo_gru+"&obs_gru="+obs_gru+"&arr_hor="+arr_hor
		+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&c_doid_gru="+c_doid_gru+"&nro_escogidos="+nro_escogidos+"&accion=grabar_incidencia_grupal";
		alert(pag)
		
		ajaxc = createRequest();
		ajaxc.open("get", pag, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				alert(ajaxc.responseText);	
				
				document.getElementById("d_horario_gestor").style.display="block";		
				document.getElementById("d_horario_gestor").innerHTML=ajaxc.responseText;	
				
				
				//var msn ="Se agregaron " + nro_escogidos + " gestores";
				/*
				document.getElementById("lista_participantes").style.display="none";					
				alert("Se actualizaron correctamente")				
				parent.ras.hide();				
				*/			

			}
		}
		ajaxc.send(null)
		
		}
	}
}


function calcular_tiempos_mas(){
	var modo = document.getElementById("modo_mas").value;
	
	if (document.getElementById("modo_mas").value=="0"){	
		var fec1 = document.getElementById("inputm1").value;
		var fec2 = document.getElementById("inputm2").value;
		var fec = "";
		document.getElementById("exc_mas").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var fec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];
		
		/*
		if (fec_fin > fec_ini){		
		}else{
			alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
		}
		*/

	}else{
		if (document.getElementById("modo_mas").value=="D"){
		var fec1 = document.getElementById("inputm1").value;
		var fec2 = document.getElementById("inputm2").value;
		var fec = "";
		document.getElementById("exc_mas").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
		
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var fec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];
		
		
		if (fec_fin >= fec_ini){
			/*
			alert(fec1[1])
			alert(fec2[1])
			
			if (fec2[1]> fec1[1]){
				
			}else{
				alert("ALERTA: ERROR CON EL FORMATO DE HORAS")
				return	
			}
			*/
		}else{
			alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
			return
		}

		
		}
		if (modo=="H"){
		var fec = document.getElementById("inputm3").value;
		var hor_ini = document.getElementById("h_ini_mas").value + ":" + document.getElementById("mm_ini_mas").value;
		var hor_fin = document.getElementById("h_fin_mas").value + ":" + document.getElementById("mm_fin_mas").value;
		document.getElementById("exc_mas").value="HH:MM";	
		}
		
	}
	
	if (document.getElementById("modo_mas").value=="D" || document.getElementById("modo_mas").value=="0"){
		if (document.getElementById("inputm1").value=="" || document.getElementById("inputm2").value==""){
			document.getElementById("bt_grabar_mas").style.display="none";	
			alert("ERROR: NO HA INGRESADO FECHAS")
			return
		}else{
			document.getElementById("bt_grabar_mas").style.display="block";	
		}		
	}else{
		if (document.getElementById("inputm3").value=="" || 
		document.getElementById("h_ini_mas").value=="0" || document.getElementById("h_fin_mas").value=="0"
		){
			document.getElementById("bt_grabar_mas").style.display="none";	
			alert("ERROR: NO HA INGRESADO HORAS COMPLETAS")
			return
		}else{
			document.getElementById("bt_grabar_mas").style.display="block";	
		}		
	}
	
	
	
	
	var pag4 = "funciones_cot.php?fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&fec="+fec+"&modo="+modo+"&hor_ini="+hor_ini
	+"&hor_fin="+hor_fin+"&accion=calcular_tiempo";
	
	//alert(pag4);
	
	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			var msn  = ajaxc.responseText;           
			//alert(msn)
			document.getElementById("tiempo_mas").value = msn;
        }
	}
	ajaxc.send(null)
	
	
	}
	
function validar_horas_mas(h_fin){
	var h_ini = document.getElementById("h_ini_mas").value;
	
	if (h_fin < h_ini) {
		alert("La hora debe ser mayor que la hora inicial")
		}
	
}

function grabar_incidencia_masiva(){
	
	var iduser = document.getElementById("iduser").value;	
	//var c_incidencia = document.getElementById("c_incidencia_mas").value;	
	var tp_incidencia = document.getElementById("tp_incidencia").value;	
	var c_supervisor = document.getElementById("c_supervisor_m").value;	
	var c_mot_mas = "AVERIA MASIVA";	
	var c_mot_inc_mas =document.getElementById("c_mot_gru").value;	
	var modo_mas = document.getElementById("modo_mas").value;	
	var tiempo_mas = document.getElementById("tiempo_mas").value;	
	var obs_mas = document.getElementById("obs_mas").value;	
	var c_doid_mas = document.getElementById("c_doid_mas").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	
	
	
	  
				if (document.getElementById("modo_mas").value=="0"){
				var fec1 = document.getElementById("inputm1").value;	
				var fec2 = document.getElementById("inputm2").value;	
				
				var fec1  = fec1.split(" ");
				var fec1x  = fec1[0];
				var xfec_ini = fec1x.split("-");
				var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
				
				var fec2  = fec2.split(" ");
				var fec2x  = fec2[0];
				var xfec_fin = fec2x.split("-");
				var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
						
					
				}else{
					if (document.getElementById("modo_mas").value=="D"){
						var fec1 = document.getElementById("inputm1").value;	
						var fec2 = document.getElementById("inputm2").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
					
					}else{
						
						var fec1 = document.getElementById("inputm3").value;	
						var fec2 = document.getElementById("inputm3").value;	
						
						var h_ini = document.getElementById("h_ini_mas").value +":"+ document.getElementById("mm_ini_mas").value;	
						var h_fin = document.getElementById("h_fin_mas").value +":"+ document.getElementById("mm_fin_mas").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
						
					}
		
		
		var pag="funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos+"&c_mot_mas="+c_mot_mas
		+"&c_mot_inc_mas="+c_mot_inc_mas+"&modo_mas="+modo_mas+"&tiempo_mas="+tiempo_mas+"&obs_mas="+obs_mas+"&c_supervisor="+c_supervisor
		+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&c_doid_mas="+c_doid_mas+"&nro_escogidos="+nro_escogidos+"&accion=grabar_incidencia_masiva_nuevo";
		//alert(pag)
		
		ajaxc = createRequest();
		ajaxc.open("get", pag, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				alert(ajaxc.responseText);	
				//var msn ="Se agregaron " + nro_escogidos + " gestores";
				//alert("Se actualizaron correctamente")				
//				document.getElementById("c_inc").value	= ajaxc.responseText; 				
				cerrar_win('3')			
				
			}
		}
		ajaxc.send(null)
		
	}
	
}

function cerrar_ventana_maestra(){
	parent.location.reload(true);	
	parent.modal.hide();
	
}
	
function seleccionar_incidencia_todo(){
   for (i=0;i<document.f1.elements.length;i++)   	   
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=1
		 document.getElementById("chk_escogidos").value  = i; 
		 document.getElementById("chk_escogidos_").value = "Escogidos : " + i +" elementos  "; 
		escojer_gestor_inc()
}	

function deseleccionar_incidencia_todo(){
   for (i=0;i<document.f1.elements.length;i++){
      if(document.f1.elements[i].type == "checkbox")
         document.f1.elements[i].checked=0
		 document.getElementById("chk_escogidos").value  = 0; 
		 document.getElementById("chk_escogidos_").value = "Escogidos : 0 elementos  "; 
		 document.getElementById("arr_escogidos").value  = "";
		
   }
}
	
	
function mostrar_bandeja_gestores(valor){
		var iduser  = document.getElementById("iduser").value;	
		var idperfil = document.getElementById("idperfil").value;	
		
		var pag = "funciones_cot.php?valor="+valor+"&iduser="+iduser+"&idperfil="+idperfil
		+"&accion=listar_bandeja_gestores";
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;					
				document.getElementById("d_bandeja_gestores_cot").style.display="block";		
				document.getElementById("d_bandeja_gestores_cot").innerHTML=ajaxp.responseText;	
				document.getElementById("add_gestores").style.display="block";		
			}		
		}
		 ajaxp.send(null)	
}	


function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toString();
       //letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	   letras = " áéíóúabcdefghijklmnopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNOPQRSTUVWXYZ";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){ // SOLO LETRAS
                tecla_especial = true;
                break;
            }
			
			if((key > 47 && key < 58) || key == 8 || key == 13 || key == 6 ){ // SOLO NUMEROS
			  return true; 
			 }
			 
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
		
	/*	
		key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial){
alert('Tecla no aceptada');
        return false;
      }
	*/
 }
	
function mostrar_horarios_gestores(){
	
	var hor_gestores = document.getElementById("arr_hor").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;	
	
	var pag1="funciones_cot.php?hor_gestores="+hor_gestores+"&nro_escogidos="+nro_escogidos+"&accion=mostrar_horarios_gestores";
		//alert(pag1)
		
		ajaxc1 = createRequest();
		ajaxc1.open("get", pag1, true);
		ajaxc1.onreadystatechange = function () {
			
			if (ajaxc1.readyState == 4) {  
				//alert(ajaxc1.responseText);
				document.getElementById("d_horario_gestor").style.display="block";						
				document.getElementById("d_horario_gestor").innerHTML=ajaxc1.responseText;	
			}
		}
		ajaxc1.send(null)	
	
}

/*
function mostrar_horarios_gestores_resp(){
	
	var hor_gestores = document.getElementById("arr_hor").value;	

	var pag2="funciones_cot.php?hor_gestores="+hor_gestores+"&accion=mostrar_horarios_gestores_resp";
		alert(pag2)
		
		ajaxc2 = createRequest();
		ajaxc2.open("get", pag2, true);
		ajaxc2.onreadystatechange = function () {
			
			if (ajaxc2.readyState == 4) {  
				//alert(ajaxc1.responseText);
				document.getElementById("d_horario_gestor").style.display	="block";						
				document.getElementById("d_horario_gestor").innerHTML		=ajaxc2.responseText;	
			}
		}
		ajaxc2.send(null)	
	
}
*/

function validar_horarios_gestores(){
	
	//alert(document.getElementById("modalidad").value)
	
	if (document.getElementById("chk_escogidos").value==""){
	alert("Error: No ha escogido elementos")	
	return	
	}else{
		
		  if (document.getElementById("c_incidencia").value=="" || document.getElementById("c_incidencia").value=="INC-1"){
			alert("Error: EL CODIGO DE INCIDENCIA ESTA VACIO O TIENE UN DATO ERRONEO(INC-1)")	
			return	
	      }else{
			  			
				if (document.getElementById("modalidad").value=="D"){    //DIAS
					
					
						var fec_i = document.getElementById("inputg1").value;	
						var fec_f = document.getElementById("inputg2").value;
						
						var fec_i  = fec_i.split(" ");
						var fec_ix  = fec_i[0];
						var fec_ix = fec_ix.split("-");
						var fec1 = fec_ix[2]+"-"+fec_ix[1]+"-"+fec_ix[0];
						
						var fec_f  = fec_f.split(" ");
						var fec_fx  = fec_f[0];
						var fec_fx = fec_fx.split("-");
						var fec2 = fec_fx[2]+"-"+fec_fx[1]+"-"+fec_fx[0];
						
						
						if (fec1=="" && fec2==""){
							alert("Fechas Vacias")
							return
						}else{
							if (fec1=="" || fec2==""){
								alert("Una de las fechas esta vacia")
								return
							
							}else{		
								/*
								alert(fec1)
								alert(fec2)
								*/
								if (fec1 > fec2){
									alert("Error: La fecha Inicial es mayor que la fecha Final")
									return									
								}else{
									var fec1  = fec1.split(" ");
									var fec1x  = fec1[0];
									var xfec_ini = fec1x.split("-");
									var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
									
									var fec2  = fec2.split(" ");
									var fec2x  = fec2[0];
									var xfec_fin = fec2x.split("-");
									var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
									
									
								}
							}
						}
						
				}else{  // HORAS
						
						
						var fec_i = document.getElementById("inputg3").value;	
						var fec_f = document.getElementById("inputg3").value;
						
						var fec_i  = fec_i.split(" ");
						var fec_ix  = fec_i[0];
						var fec_ix = fec_ix.split("-");
						var fec1 = fec_ix[2]+"-"+fec_ix[1]+"-"+fec_ix[0];
						
						var fec_f  = fec_f.split(" ");
						var fec_fx  = fec_f[0];
						var fec_fx = fec_fx.split("-");
						var fec2 = fec_fx[2]+"-"+fec_fx[1]+"-"+fec_fx[0];
						
						
						
					var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
					var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
						
						
										
						if (document.getElementById("inputg3").value=="" && h_ini=="0:00" && h_fin=="0:00"){
							alert("Error: Fecha y Horas Vacias");
							return
						}else{
							if (document.getElementById("inputg3").value==""){
								alert("Error: Fecha Vacia");
								return
							}else{
								if (h_ini=="0:00" && h_fin=="0:00"){
									alert("Error: Horas Vacias")
									return
								}else{
									if (document.getElementById("h_ini_gru").value=="0" || document.getElementById("h_fin_gru").value=="0"){
										alert("Error: Campo de Horas Vacias")
										return
									}else{											
											
											if (h_ini >= h_fin){
												alert("Error: Hora inicial es mayor que la hora final");	
											}else{
												var fec1  = fec1.split(" ");
												var fec1x  = fec1[0];
												var xfec_ini = fec1x.split("-");
												var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
												
												var fec2  = fec2.split(" ");
												var fec2x  = fec2[0];
												var xfec_fin = fec2x.split("-");
												var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;
												
												
												
											}											
									}								
								}
							}
						}
			 	}// cerrar modalidad
				
				validar_horarios_incidencias()
		} 
	}		
}


function validar_horarios_incidencias(){
	var c_incidencia = document.getElementById("c_incidencia").value;	
	var modo_gru = document.getElementById("modalidad").value;		
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	var s_arr_hor = document.getElementById("arr_hor").value;	
	var arr_hor = s_arr_hor.substring(1,1000);
	
		
				if (document.getElementById("modalidad").value=="0"){
				var fec1 = document.getElementById("inputg1").value;	
				var fec2 = document.getElementById("inputg2").value;	
				
				var fec1  = fec1.split(" ");
				var fec1x  = fec1[0];
				var xfec_ini = fec1x.split("-");
				var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
				
				var fec2  = fec2.split(" ");
				var fec2x  = fec2[0];
				var xfec_fin = fec2x.split("-");
				var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
						
					
				}else{
					if (document.getElementById("modalidad").value=="D"){
						var fec1 = document.getElementById("inputg1").value;	
						var fec2 = document.getElementById("inputg2").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
					
					}else{
						
						var fec1 = document.getElementById("inputg3").value;	
						var fec2 = document.getElementById("inputg3").value;	
						
						var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
						var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
						
						
						
						if (xfec_ini==xfec_fin){
							alert("Error: Horas Iguales")	
							return
						}
					}
				}

		
		var pag_val="funciones_cot.php?dni_escogidos="+dni_escogidos+"&modo_gru="+modo_gru+"&arr_hor="+arr_hor
		+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&nro_escogidos="+nro_escogidos+
		"&accion=validar_horarios_incidencias";
		//alert(pag_val)
		
		ajaxc_val = createRequest();
		ajaxc_val.open("get", pag_val, true);
		ajaxc_val.onreadystatechange = function () {
			
			if (ajaxc_val.readyState == 4) {  
				var resp_val 	= ajaxc_val.responseText;
				var resp_val	= resp_val.split("|");
				var error 		=  resp_val[0];
				var mensaje =  resp_val[1];
				
				//alert(ajaxc_val.responseText)
				/*
					if (error==0){
					alert(mensaje)
					return
				}else{				
					grabar_horarios_gestores_resp();
					msn_alerta("1",c_incidencia,resp_val[1])	
				}
				*/

					grabar_horarios_gestores_resp();
					msn_alerta("1",c_incidencia,resp_val[1])	

			}
		}
		ajaxc_val.send(null)
}

function grabar_horarios_gestores_resp(){
	var iduser = document.getElementById("iduser").value;	
	var c_incidencia = document.getElementById("c_incidencia").value;	
	var tp_incidencia = document.getElementById("tp_incidencia").value;	
	var c_mot_gru = document.getElementById("c_mot_gru").value;	
	var c_mot_inc_gru = document.getElementById("combo_mot").value;	
	var modo_gru = document.getElementById("modalidad").value;	
	var tiempo_gru = document.getElementById("tiempo_gru").value;	
	var obs_gru = document.getElementById("obs_gru").value;	
	var c_doid_gru = document.getElementById("c_doid_gru").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	var s_arr_hor = document.getElementById("arr_hor").value;	
	var arr_hor = s_arr_hor.substring(1,1000);
	
	
			  document.getElementById("load").style.display="block";		
			  document.getElementById("load").innerHTML = "<img src=\"loading3.gif\" width='300' height='200' />";
			  document.getElementById("registro_gestores").style.display="none";			
			
				if (document.getElementById("modalidad").value=="0"){
				var fec1 = document.getElementById("inputg1").value;	
				var fec2 = document.getElementById("inputg2").value;	
				
				var fec1  = fec1.split(" ");
				var fec1x  = fec1[0];
				var xfec_ini = fec1x.split("-");
				var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
				
				var fec2  = fec2.split(" ");
				var fec2x  = fec2[0];
				var xfec_fin = fec2x.split("-");
				var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
						
					
				}else{
					if (document.getElementById("modalidad").value=="D"){
						var fec1 = document.getElementById("inputg1").value;	
						var fec2 = document.getElementById("inputg2").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
					
					}else{
						
						var fec1 = document.getElementById("inputg3").value;	
						var fec2 = document.getElementById("inputg3").value;	
						
						var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
						var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
						
					}
				}

		
		var pag_tru="funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos+"&c_incidencia="+c_incidencia+"&c_mot_gru="+c_mot_gru
		+"&c_mot_inc_gru="+c_mot_inc_gru+"&modo_gru="+modo_gru+"&tiempo_gru="+tiempo_gru+"&obs_gru="+obs_gru+"&arr_hor="+arr_hor
		+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&c_doid_gru="+c_doid_gru+"&nro_escogidos="+nro_escogidos+
		"&accion=grabar_horarios_gestores_resp";
		//alert(pag_tru)
		
		ajaxc_tru = createRequest();
		ajaxc_tru.open("get", pag_tru, true);
		ajaxc_tru.onreadystatechange = function () {
			
			if (ajaxc_tru.readyState == 4) {  		
					//alert(ajaxc_tru.readyState)
					
					document.getElementById("registro_gestores").style.display="block";
					document.getElementById("d_horario_gestor").style.display="block";		
					document.getElementById("d_horario_gestor").innerHTML=ajaxc_tru.responseText;	
					//calcular_tiempos_gru()
					document.getElementById("load").innerHTML = "";								
				
			}
		}
		ajaxc_tru.send(null)		
	
}

function msn_alerta(modulo,valor_1,valor_2){	
	
	if (modulo=="1"){ // registro de boleta
		var iduser 		= document.getElementById("iduser").value;	
		var idperfil 	= document.getElementById("idperfil").value;	
		var texto_ini	= valor_1;
		var texto_int	= valor_2;
		var texto_fin	= "";
		var estado		= "1";
		
		var p_modulo="alertas.php?texto_ini="+texto_ini+"&texto_int="+texto_int+"&valor_2="+texto_fin+"&iduser="+iduser+"&idperfil="+idperfil+"&estado="+estado;
		//alert(p_modulo);	
		alerta 	=	dhtmlmodal.open('EmailBox', 'iframe',p_modulo,'INCIDENCIAS COT', 'top=30,left=200,width=600px,height=360px,center=1,resize=0,scrolling=0');	
	}
}

function cerrar_alertas(opc){
	
	if (opc=="0"){
	parent.alerta.hide();	
	parent.parent.ras.hide();		
	}
}


function carga_combo_modo(nom_combo,valor1){		
		
		var valor_combo= valor1;
		var valor_combo=valor_combo.split("|");
		var valor_combo=valor_combo[0];
		
		
		
		var urlx = "funciones_cot.php?valor_combo="+valor_combo+"&combo="+nom_combo+"&accion=carga_combo_modo";	
		//alert(urlx)
		
		ajaxc=createRequest();
		ajaxc.open("GET", urlx,true);
		ajaxc.onreadystatechange=function() {
			
			if (ajaxc.readyState==4) 
			{	
				//alert(ajaxc.responseText);			
				document.getElementById(nom_combo).innerHTML = ajaxc.responseText;
				
				 document.getElementById("input1").value="";
				 document.getElementById("input2").value="";
				 document.getElementById("input3").value="";
				 document.getElementById("h_ini").value="0";
				 document.getElementById("c_mot_inc").value="0";
				 document.getElementById("modo").value="0";
				 document.getElementById("h_fin").value="0";
				 document.getElementById("tiempo").value="0";
				 document.getElementById("f_dias").style.display="none";
				 document.getElementById("f_horas").style.display="none";			
			
			}
		}
		 ajaxc.send(null)	

}


function mostrar_bandeja_incidencias(valor){
		
		var pag = "funciones_cot.php?valor="+valor+"&accion=listar_bandeja_incidencias";
		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;					
				document.getElementById("d_bandeja_incidencias_cot").style.display="block";		
				document.getElementById("d_bandeja_incidencias_cot").innerHTML=ajaxp.responseText;	
				document.getElementById("add_gestores").style.display="block";		
			}		
		}
		 ajaxp.send(null)	
}	



function mostrar_bandeja_incidencias_sup(valor){
		
		var pag = "bandeja_incidencias_cot_supervisores.php?valor="+valor;		
		//alert(pag)
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;					
				document.getElementById("d_bandeja_incidencias_cot").style.display="block";		
				document.getElementById("d_bandeja_incidencias_cot").innerHTML=ajaxp.responseText;					
			}		
		}
		 ajaxp.send(null)	
}	


function aprobar_incidencias(estado){
	var inc_escogidas = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	
	
	var pag = "funciones_cot.php?iduser="+iduser+"&inc_escogidas="+inc_escogidas+"&nro_escogidos="+nro_escogidos
	+"&estado="+estado+"&accion=aprobar_incidencias";
		
		//alert(pag)
			document.getElementById("d_bandeja_incidencias_cot").style.display="none";	
			document.getElementById("load").style.display="block";		
			document.getElementById("load").innerHTML = "<img src=\"loading3.gif\" width='300' height='200' />";
			
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;	
				document.getElementById("load").innerHTML = "";	
								
					var c_supervisor = document.getElementById("c_supervisor").value;	
					mostrar_bandeja_incidencias(c_supervisor);
				
				if (estado =="1") {
					var nestado="Aprobo";
				}else{
					var nestado="Rechazo";
				}
				var msn = " Se " + nestado + " Correctamente las incidencias";
				alert(msn)	
			}		
		}
		 ajaxp.send(null)	
		
		 
}


function aprobar_incidencias_sup(estado){
	var inc_escogidas = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	
	//alert(nro_escogidos)
	
	if (nro_escogidos==""){
	alert("No a escogido valores de la lista")
	return	
	}
	
	var pag = "funciones_cot.php?iduser="+iduser+"&inc_escogidas="+inc_escogidas+"&nro_escogidos="+nro_escogidos+"&idperfil="+idperfil
	+"&estado="+estado+"&accion=aprobar_incidencias";
		
		//alert(pag)
			document.getElementById("d_bandeja_incidencias_cot").style.display="none";	
			
			document.getElementById("load").style.display="block";		
			document.getElementById("load").innerHTML = "<img src=\"loading3.gif\" width='300' height='200' />";
			
		
		ajaxp=createRequest();	
		ajaxp.open("GET", pag,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;	
				//alert(resp1)
				
				document.getElementById("load").innerHTML = "";	
				
				mostrar_bandeja_aprobaciones();
				
			
				
				/*
				document.getElementById("d_bandeja_incidencias_cot").style.display="block";		
				document.getElementById("d_bandeja_incidencias_cot").innerHTML=ajaxp.responseText;
				
				if (estado =="1") {
					var nestado="Aprobo";
				}else{
					var nestado="Rechazo";
				}
				var msn = " Se " + nestado + " Correctamente las incidencias";
				alert(msn)	
				*/
			}		
		}
		 ajaxp.send(null)	
		
		 
}


/*********************/

function validar_horarios_gestores_p(){
	
	//alert(document.getElementById("modalidad").value)
	
	if (document.getElementById("chk_escogidos").value==""){
	alert("Error: No ha escogido elementos")	
	return	
	}else{
		
		  if (document.getElementById("c_incidencia").value=="" || document.getElementById("c_incidencia").value=="INC-1"){
			alert("Error: EL CODIGO DE INCIDENCIA ESTA VACIO O TIENE UN DATO ERRONEO(INC-1)")	
			return	
	      }else{
			  			
				if (document.getElementById("modalidad").value=="D"){    //DIAS
					
					
						var fec_i = document.getElementById("inputg1").value;	
						var fec_f = document.getElementById("inputg2").value;
						
						var fec_i  = fec_i.split(" ");
						var fec_ix  = fec_i[0];
						var fec_ix = fec_ix.split("-");
						var fec1 = fec_ix[2]+"-"+fec_ix[1]+"-"+fec_ix[0];
						
						var fec_f  = fec_f.split(" ");
						var fec_fx  = fec_f[0];
						var fec_fx = fec_fx.split("-");
						var fec2 = fec_fx[2]+"-"+fec_fx[1]+"-"+fec_fx[0];
						
						
						if (fec1=="" && fec2==""){
							alert("Fechas Vacias")
							return
						}else{
							if (fec1=="" || fec2==""){
								alert("Una de las fechas esta vacia")
								return
							
							}else{		
								/*
								alert(fec1)
								alert(fec2)
								*/
								if (fec1 > fec2){
									alert("Error: La fecha Inicial es mayor que la fecha Final")
									return									
								}else{
									var fec1  = fec1.split(" ");
									var fec1x  = fec1[0];
									var xfec_ini = fec1x.split("-");
									var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
									
									var fec2  = fec2.split(" ");
									var fec2x  = fec2[0];
									var xfec_fin = fec2x.split("-");
									var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
									
									
								}
							}
						}
						
				}else{  // HORAS
						
						
						var fec_i = document.getElementById("inputg3").value;	
						var fec_f = document.getElementById("inputg3").value;
						
						var fec_i  = fec_i.split(" ");
						var fec_ix  = fec_i[0];
						var fec_ix = fec_ix.split("-");
						var fec1 = fec_ix[2]+"-"+fec_ix[1]+"-"+fec_ix[0];
						
						var fec_f  = fec_f.split(" ");
						var fec_fx  = fec_f[0];
						var fec_fx = fec_fx.split("-");
						var fec2 = fec_fx[2]+"-"+fec_fx[1]+"-"+fec_fx[0];
						
						
						
					var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
					var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
						
						
										
						if (document.getElementById("inputg3").value=="" && h_ini=="0:00" && h_fin=="0:00"){
							alert("Error: Fecha y Horas Vacias");
							return
						}else{
							if (document.getElementById("inputg3").value==""){
								alert("Error: Fecha Vacia");
								return
							}else{
								if (h_ini=="0:00" && h_fin=="0:00"){
									alert("Error: Horas Vacias")
									return
								}else{
									if (document.getElementById("h_ini_gru").value=="0" || document.getElementById("h_fin_gru").value=="0"){
										alert("Error: Campo de Horas Vacias")
										return
									}else{											
											
											if (h_ini >= h_fin){
												alert("Error: Hora inicial es mayor que la hora final");	
											}else{
												var fec1  = fec1.split(" ");
												var fec1x  = fec1[0];
												var xfec_ini = fec1x.split("-");
												var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
												
												var fec2  = fec2.split(" ");
												var fec2x  = fec2[0];
												var xfec_fin = fec2x.split("-");
												var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;
												
												
												
											}											
									}								
								}
							}
						}
			 	}// cerrar modalidad
				
				validar_horarios_incidencias_p()
		} 
	}		
}

function grabar_incidencias_cot(){
	
	var iduser = document.getElementById("iduser").value;		
	var tp_incidencia = document.getElementById("tp_incidencia").value;	
	var c_mot_gru = document.getElementById("c_mot_gru").value;	
	var c_mot_inc_gru = document.getElementById("combo_mot").value;	
	var tiempo_gru = document.getElementById("tiempo_gru").value;	
	var obs_gru = document.getElementById("obs_gru").value;	
	var c_doid_gru = document.getElementById("c_doid_gru").value;	
	var modo_gru = document.getElementById("modalidad").value;		
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	var s_arr_hor = document.getElementById("arr_hor").value;	
	var arr_hor = s_arr_hor.substring(1,1000);
	
				if (document.getElementById("tp_incidencia").value=="PERMISO"){
					if (document.getElementById("modalidad").value=="D"){
						var fec_i_c = document.getElementById("input_i_c").value;
						
						var fec_i_c  = fec_i_c.split(" ");
						var fec_i_c  = fec_i_c[0];
						var xfec_i_comp = fec_i_c.split("-");
						var fec_ini_comp = xfec_i_comp[2]+"-"+xfec_i_comp[1]+"-"+xfec_i_comp[0];
						
						var fec_f_c  = fec_f_c.split(" ");
						var fec_f_c  = fec_f_c[0];
						var xfec_f_comp = fec_f_c.split("-");
						var fec_fin_comp = xfec_f_comp[2]+"-"+xfec_f_comp[1]+"-"+xfec_f_comp[0];
						
					}else{
						var fec_c = document.getElementById("input_h_c").value;
						var h_ini = document.getElementById("h_ini_comp").value +":"+ document.getElementById("mm_ini_comp").value;	
						var h_fin = document.getElementById("h_fin_comp").value +":"+ document.getElementById("mm_fin_comp").value;	
								
						var fec_c  = fec_c.split(" ");
						var fec_c  = fec_c[0];
						var xfec_comp = fec_c.split("-");
						var fec_comp = xfec_comp[2]+"-"+xfec_comp[1]+"-"+xfec_comp[0] +" "+ h_ini;
					}
					
				}
				
				if (document.getElementById("modalidad").value=="0"){
				var fec1 = document.getElementById("inputg1").value;	
				var fec2 = document.getElementById("inputg2").value;	
				
				var fec1  = fec1.split(" ");
				var fec1x  = fec1[0];
				var xfec_ini = fec1x.split("-");
				var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
				
				var fec2  = fec2.split(" ");
				var fec2x  = fec2[0];
				var xfec_fin = fec2x.split("-");
				var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
						
					
				}else{
					if (document.getElementById("modalidad").value=="D"){
						var fec1 = document.getElementById("inputg1").value;	
						var fec2 = document.getElementById("inputg2").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
					
					}else{
						
						var fec1 = document.getElementById("inputg3").value;	
						var fec2 = document.getElementById("inputg3").value;	
						
						var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
						var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
						
						
						
						if (xfec_ini==xfec_fin){
							alert("Error: Horas Iguales")	
							return
						}
					}
				}

		
		var pag_val="funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos+"&c_mot_gru="+c_mot_gru
		+"&c_mot_inc_gru="+c_mot_inc_gru+"&modo_gru="+modo_gru+"&tiempo_gru="+tiempo_gru+"&obs_gru="+obs_gru+"&arr_hor="+arr_hor
		+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&c_doid_gru="+c_doid_gru+"&nro_escogidos="+nro_escogidos+
		"&accion=grabar_incidencias_cot";
		//alert(pag_val)
		
		ajaxc_val = createRequest();
		ajaxc_val.open("get", pag_val, true);
		ajaxc_val.onreadystatechange = function () {
			
			if (ajaxc_val.readyState == 4) {  
				var resp_val 	= ajaxc_val.responseText;
				var resp_val	= resp_val.split("|");
				var c_incidencia=  resp_val[0];				
				var mensaje 	=  resp_val[1];
				
				//alert(ajaxc_val.responseText);
				/*
					if (error==0){
					alert(mensaje)
					return
				}else{				
					grabar_horarios_gestores_resp();
					msn_alerta("1",c_incidencia,resp_val[1])	
				}
				*/

					//grabar_horarios_gestores_resp();
					msn_alerta("1",c_incidencia,resp_val[1])	

			}
		}
		ajaxc_val.send(null)
}

function validar_marchablanca(){
	var combo2 = document.getElementById("combo_mot").value;	
	
	if (combo2=="800"){
		alert("Esta opcion se encuentra deshabilitada");
		document.getElementById("inputg2").value="";
		return
	}
	
}

function agregar_gestores_inc(){
	
	var iduser = document.getElementById("iduser").value;	
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;	
	

	//alert(document.getElementById("arr_escogidos").value)
	
	if (document.getElementById("arr_escogidos").value==""){
	alert("No ha escogido elementos")	
	return	
	}else{
		document.getElementById("lista_participantes").style.display	="none";
		document.getElementById("registro_gestores").style.display	= "block";
		mostrar_horarios_gestores();
		/*
		
		var pag="funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos
		+"&nro_escogidos="+nro_escogidos+"&accion=agregar_gestores_inc";
		//alert(pag)
		
		ajaxc = createRequest();
		ajaxc.open("get", pag, true);
		ajaxc.onreadystatechange = function () {
			
			if (ajaxc.readyState == 4) {  
				//alert(ajaxc.responseText);	
				var msn ="Se agregaron " + nro_escogidos + " gestores";
				//alert(msn)
				document.getElementById("registro_gestores").style.display	= "block";
				document.getElementById("c_inc").value						= ajaxc.responseText; 
				document.getElementById("c_incidencia").value				= ajaxc.responseText; 
				//Fdocument.getElementById("bt_aceptar_gru").style.display		= "block";
				mostrar_horarios_gestores();						
			}
		}
		ajaxc.send(null)
		*/	
	}
	
	
}


function borrar_incidencia_temp(c_incidencia){		
	var iduser = document.getElementById("iduser").value;
	
	
	var url = "funciones_cot.php?iduser="+iduser+"&c_incidencia="+c_incidencia+"&accion=borrar_incidencia_temp";
	
	//alert(url)
	
	ajaxc = createRequest();
    ajaxc.open("get", url, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText) 	
			
			}        
	}
	ajaxc.send(null)	
	
	
}	


function mostrar_compensaciones(){	
alert("En Construccion")
}

function mostrar_bandeja_aprobaciones(){
		var  iduser = document.getElementById("iduser").value;
		var  est = document.getElementById("est").value;
		var  usu_reg = document.getElementById("usu_reg").value;
		
		if (document.getElementById("usu_reg").value=="0"){
			alert("Debe escoger un supervisor")
			return
		}
		
		var pag = "funciones_cot.php?iduser="+iduser+"&est="+est+"&usu_reg="+usu_reg+"&accion=mostrar_bandeja_aprobaciones";
		
		//alert(pag)
		
		ajaxp_apro=createRequest();	
		ajaxp_apro.open("GET", pag,true);
		ajaxp_apro.onreadystatechange=function() {
	
			if (ajaxp_apro.readyState==4){
				var resp1 = ajaxp_apro.responseText;					
				document.getElementById("d_bandeja_incidencias_cot").style.display="block";		
				document.getElementById("d_bandeja_incidencias_cot").innerHTML=ajaxp_apro.responseText;	
				//document.getElementById("add_gestores").style.display="block";		
			}		
		}
		 ajaxp_apro.send(null)	
}	


function mostrar_bt(valor){
	
	//alert(valor)
	
	if (valor=="1"){ //aprobado
		document.getElementById("bt_aprobar").style.display="NONE";	
		document.getElementById("bt_rechazar").style.display="BLOCK";	
	}
	
	if (valor=="2"){//rechazado
		document.getElementById("bt_aprobar").style.display="BLOCK";	
		document.getElementById("bt_rechazar").style.display="NONE";		
	}
	
	if (valor=="0"){//pendiente
		document.getElementById("bt_aprobar").style.display="BLOCK";	
		document.getElementById("bt_rechazar").style.display="BLOCK";		
	}
}

function grabar_actualizacion_maestra(){
	var  iduser = document.getElementById("iduser").value;
	var  dni = document.getElementById("n_dni").value;
	var t_usuario_arpu_calculadora= document.getElementById("t_usuario_arpu_calculadora").value;
	var t_usuario_atis= document.getElementById("t_usuario_atis").value;
	var t_usuario_clear_view= document.getElementById("t_usuario_clear_view").value;
	var t_usuario_cms= document.getElementById("t_usuario_cms").value;
	var t_usuario_genesys= document.getElementById("t_usuario_genesys").value;
	var t_usuario_genio= document.getElementById("t_usuario_genio").value;
	var t_usuario_gescot= document.getElementById("t_usuario_gescot").value;
	var t_usuario_gestel= document.getElementById("t_usuario_gestel").value;
	var t_usuario_incidencias_psi= document.getElementById("t_usuario_incidencias_psi").value;
	var t_usuario_intraway= document.getElementById("t_usuario_intraway").value;
	var t_usuario_multiconsulta= document.getElementById("t_usuario_multiconsulta").value;
	var t_usuario_pdm= document.getElementById("t_usuario_pdm").value;
	var t_usuario_psi= document.getElementById("t_usuario_psi").value;
	var t_usuario_red= document.getElementById("t_usuario_red").value;
	var t_usuario_toa= document.getElementById("t_usuario_toa").value;
	var t_usuario_web_aseguramiento= document.getElementById("t_usuario_web_aseguramiento").value;
	var t_usuario_web_asignaciones= document.getElementById("t_usuario_web_asignaciones").value;
	var t_usuario_web_sara= document.getElementById("t_usuario_web_sara").value;
	var t_usuario_web_sigtp_mapa_gig= document.getElementById("t_usuario_web_sigtp_mapa_gig").value;
	var t_usuario_web_unificada= document.getElementById("t_usuario_web_unificada").value;
	var accion = "grabar_movimiento_maestra";
	
	var url = "funciones_cot.php?iduser="+iduser+"&t_usuario_arpu_calculadora="+t_usuario_arpu_calculadora+"&t_usuario_atis="+t_usuario_atis+"&t_usuario_clear_view="+t_usuario_clear_view+"&t_usuario_cms="+t_usuario_cms+"&t_usuario_genesys="+t_usuario_genesys+"&t_usuario_genio="+t_usuario_genio+"&t_usuario_gescot="+t_usuario_gescot+"&t_usuario_gestel="+t_usuario_gestel+"&t_usuario_incidencias_psi="+t_usuario_incidencias_psi+"&t_usuario_intraway="+t_usuario_intraway+"&t_usuario_multiconsulta="+t_usuario_multiconsulta+"&t_usuario_pdm="+t_usuario_pdm+"&t_usuario_psi="+t_usuario_psi+"&t_usuario_red="+t_usuario_red+"&t_usuario_toa="+t_usuario_toa+"&t_usuario_web_aseguramiento="+t_usuario_web_aseguramiento+"&t_usuario_web_asignaciones="+t_usuario_web_asignaciones+"&t_usuario_web_sara="+t_usuario_web_sara+"&t_usuario_web_sigtp_mapa_gig="+t_usuario_web_sigtp_mapa_gig+"&t_usuario_web_unificada="+t_usuario_web_unificada
+"&accion="+accion;
	
	alert(url)
	ajaxp=createRequest();	
		ajaxp.open("GET", url,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp1 = ajaxp.responseText;					
				alert(resp1)
			}		
		}
		 ajaxp.send(null)	
		 
}


function actualizar_contacto_tdata(dni,telefono,peticion,v_combo){		
	var iduser = document.getElementById("iduser").value;
	var accion ="act_contacto_tdata" ;
	
	if (document.getElementById("iduser").value=="" || document.getElementById("iduser").value==" " || 
	document.getElementById("iduser").value=="undefined"){
		alert("UD.  NO ESTA LOGEADO.... VUELVA A INGRESAR")		
		var win=null;
		win=window.open("login.php",true);	
		return
	}else{
	
	
		var msn="Desea actualizar informacion..?";
		if (confirm(msn)){			
			var url = "funciones_cot.php?dni="+dni+"&iduser="+iduser+"&telefono="+telefono+"&v_combo="+v_combo+"&peticion="+peticion+"&accion="+accion;
			
			//alert(url) 		
			
			ajaxc = createRequest();
			ajaxc.open("get", url, true);
			ajaxc.onreadystatechange = function () {
				
				if (ajaxc.readyState == 4) {
					alert(ajaxc.responseText) 
					if (document.getElementById("bdatos").value=="TDATA"){
						buscar_contacto_tdata();
					}else{
						buscar_contacto();
					}
				}        
			}
			ajaxc.send(null)	
		}else{
			return	
		}
	}
}	


/****************************11/12/2019*************************************************************************************************/

function grabar_incidencias_cot_nuevo(){
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var tp_incidencia = document.getElementById("tp_incidencia").value;	
	var c_mot_gru = document.getElementById("c_mot_gru").value;	
	var c_mot_inc_gru = document.getElementById("combo_mot").value;	
	var tiempo_gru = document.getElementById("tiempo_gru").value;	
	var obs_gru = document.getElementById("obs_gru").value;	
	var c_doid_gru = document.getElementById("c_doid_gru").value;	
	var modo_gru = document.getElementById("modalidad").value;		
	var dni_escogidos = document.getElementById("arr_escogidos").value;	
	var nro_escogidos = document.getElementById("chk_escogidos").value;		
	var s_arr_hor = document.getElementById("arr_hor").value;	
	var arr_hor = s_arr_hor.substring(1,1000);
	
	
	
	if (document.getElementById("obs_gru").value==""){
		alert("Error: El campo de observacion se encuentra vacio")	
		return
	}else{
		if (document.getElementById("tp_incidencia").value=="0"){
			alert("Error: Tipo de incidencia sin esojer")	
			return
		}else{
			if (document.getElementById("modalidad").value=="0"){
			alert("Error: Tipo de modalidad sin esojer")	
			return
		}else{		
					if (document.getElementById("modalidad").value=="D"){
						var fec1 = document.getElementById("inputg1").value;	
						var fec2 = document.getElementById("inputg2").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
						
						
							if (document.getElementById("combo_mot").value=="800"){
									if (document.getElementById("inputg1").value==""){
										alert("Error: Fechas Vacias")
										return
									}
							}else{
									if (document.getElementById("inputg1").value=="" && document.getElementById("inputg2").value==""){
										alert("Error: Fechas Vacias")
										return
									}else{								
										if (document.getElementById("inputg1").value==""){
											alert("Error: Fechas Inicio Vacia")
											return
										}
										if (document.getElementById("inputg2").value==""){
											alert("Error: Fechas Fin Vacia")
											return
										}
							}
						}
					
					}else{
						
						var fec1 = document.getElementById("inputg3").value;	
						var fec2 = document.getElementById("inputg3").value;

						if(document.getElementById("combo_mot").value == "41"){
							document.getElementById('form2');
							var fec1 = document.getElementById("inputg1_lac").value;	
							var fec2 = document.getElementById("inputg2_lac").value;
						}
						
						var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
						var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	

						if(document.getElementById("combo_mot").value == "41"){
							var h_ini = document.getElementById("h_ini_gru_lac").value +":"+ document.getElementById("mm_ini_gru_lac").value;	
							var h_fin = document.getElementById("h_fin_gru_lac").value +":"+ document.getElementById("mm_fin_gru_lac").value;	
						}
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
						
						if(document.getElementById("combo_mot").value == "41"){
							if (document.getElementById("inputg1_lac").value==""){
								alert("Error: Fecha Inicio Vacia")
									return
							}
							if (document.getElementById("inputg2_lac").value==""){
								alert("Error: Fecha Fin Vacia")
									return
							}
						}else{
							if (document.getElementById("inputg3").value==""){
								alert("Error: Fecha Vacia")
									return
							}
						}
						
						if (h_ini=="0:00" && h_fin=="0:00"){
							alert("Error: Datos de Horas Vacios")
							return
						}else{
							if (xfec_ini==xfec_fin){
								alert("Error: Horas Iguales")	
								return
							}
						}
				}
				

		
		var pag_val="funciones_cot.php?iduser="+iduser+"&dni_escogidos="+dni_escogidos+"&c_mot_gru="+c_mot_gru
		+"&c_mot_inc_gru="+c_mot_inc_gru+"&modo_gru="+modo_gru+"&tiempo_gru="+tiempo_gru+"&obs_gru="+obs_gru
		+"&arr_hor="+arr_hor+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&c_doid_gru="+c_doid_gru
		+"&nro_escogidos="+nro_escogidos+"&idperfil="+idperfil+"&accion=grabar_incidencias_cot_oficial";
		
		//alert(pag_val)
		
		ajaxc_val = createRequest();
		ajaxc_val.open("get", pag_val, true);
		ajaxc_val.onreadystatechange = function () {
			if (ajaxc_val.readyState == 4) {  
				

				if(isJson(ajaxc_val.responseText)){
					errores = JSON.parse(ajaxc_val.responseText);
					var item = ''
					$.each(errores, function (index, value) { 
						 item += `<li>${value.incidencia}</li>`;
					});
					var lista = `<ul>${item}</ul>`;
					Swal.fire({
						title: 'Traslape!',
						icon: 'error',
						html: lista
					})
					return;
				}
				
				
				//alert(ajaxc_val.responseText);
				
				var resp_val 	= ajaxc_val.responseText;
				var resp_val	= resp_val.split("|");
				var c_incidencia=  resp_val[0];	
				
				
				var arr_mensaje	= resp_val[1].split("-");				
				var mensaje 	= arr_mensaje[1];	
				
				var error = arr_mensaje[0];
				var error = error.replace(/\s+/gi,'');
			
				
				//alert(error)
				
				if (error=="2"){
					alert(mensaje)
					return
				}else{				
					//grabar_horarios_gestores_resp();					
					msn_alerta_nueva("1",c_incidencia,arr_mensaje[1],c_mot_inc_gru)	
				}
				
			 //msn_alerta_nueva("1",c_incidencia,resp_val[1])	

			}
		}
		ajaxc_val.send(null)
	
		}
	}
  }
}

function mostrar_compensacion(){
	document.getElementById("form_compensacion").style.display="block";	
	document.getElementById("form_resultado_incidencia").style.display="none";	
}




function listar_compensaciones_inc(){	
	var iduser = document.getElementById("iduser").value;	
	var c_incidencia = document.getElementById("c_incidencia").value;	
	var accion ="listar_compensaciones_inc" ;			
	
		
	var pag1 = "funciones_cot.php?c_incidencia="+c_incidencia+"&iduser="+iduser+"&accion="+accion;
	//alert(pag1)	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {
			//alert(ajaxc.responseText)  	
			document.getElementById("d_listado_compensaciones").innerHTML=ajaxc.responseText;	
			document.getElementById("d_listado_compensaciones").style.display="block";
			}        
	}
	ajaxc.send(null)	
}


function calc_tiempo_comp(){	
		var tt_acumulado_perm = document.getElementById("tt_acumulado").value;
		var tt_acu_comp = document.getElementById("tt_acu_comp").value;
		var tt_comp_tot = document.getElementById("tt_comp_tot").value;
		
		var fec_ini_comp = document.getElementById("inputg3").value;
		var xfec_fin = fec_ini_comp.split("-");
		var fec_ini_comp = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
					
		var fec_ini_inc = document.getElementById("fec_ini_inc").value;
		var fec_ini_inc  = fec_ini_inc.split(" ");
		var fec_ini_inc  = fec_ini_inc[0];
		
		var xfec_ini_inc = document.getElementById("fec_ini_inc").value;
		var xfec_fin_inc = document.getElementById("fec_fin_inc").value;
		
		var accion="calc_tiempo_comp";				
		// VALIDAR FECHAS DE INCIDENCIA Y FECHA DE COMPENSACION
		
		
				var fec1 = document.getElementById("inputg3").value;	
							var fec2 = document.getElementById("inputg3").value;	
							
							var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
							var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
							
							var fec1  = fec1.split(" ");
							var fec1x  = fec1[0];
							var xfec_ini = fec1x.split("-");
							var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
							
							var fec2  = fec2.split(" ");
							var fec2x  = fec2[0];
							var xfec_fin = fec2x.split("-");
							var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
							
							/*
							alert(h_ini)
							alert(h_fin)
							*/
							if (h_ini=="0:00" || h_fin=="0:00"){
								alert("Error: Fechas Vacias");	
									return
							}else{
								if (h_fin<h_ini){
								alert("La hora final debe ser mayor que la hora inicial")
								return
								}else{
									if (h_fin==h_ini){
									alert("Error: Horas Iguales");	
									return
									}
								}
							}
				//}
		console.log(xfec_ini,'ss');
		
	var pag1 = "funciones_cot.php?fec_ini="+ xfec_ini +"&fec_fin="+xfec_fin+"&xfec_ini_inc="+xfec_ini_inc
		+"&xfec_fin_inc="+xfec_fin_inc+"&hor_ini="+h_ini+"&h_fin="+h_fin+"&tt_acu_comp="+tt_acu_comp
		+"&tt_acumulado_perm="+tt_acumulado_perm+"&tt_comp_tot="+tt_comp_tot+"&accion="+accion;
	
	alert(pag1)	
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 	
			alert(ajaxc.responseText)			
			var resp1 = ajaxc.responseText;
			var resp1 = resp1.split("|");		
			
			var tt_acu_comp = resp1[1];
			var tt_acu_comp = tt_acu_comp.replace(/\s+/gi,'');	
			
			var tt_tot_comp = resp1[3];
			var tt_tot_comp = tt_tot_comp.replace(/\s+/gi,'');		
				
			document.getElementById("tt_acu_comp").value=tt_acu_comp;
			//document.getElementById("tt_comp_tot").value=tt_tot_comp;
			
			} 
	}			// aumente esto xd
	
	ajaxc.send(null)	
    }


function save_compensaciones_inc(){
		var dni = document.getElementById("dni").value;	
		var c_incidencia = document.getElementById("c_incidencia").value;			
		var iduser = document.getElementById("iduser").value;	
		var idperfil = document.getElementById("idperfil").value;				
		var modo = document.getElementById("modalidad").value;
		var motivo_inc = document.getElementById("motivo").value;
		var tt_acumulado_perm = document.getElementById("tt_acumulado").value; // tiempo acumulado del permiso
		var tt_acu_comp = document.getElementById("tt_acu_comp").value; // tiempo acumulado de la compensacion
		var tt_comp_tot = document.getElementById("tt_comp_tot").value; // tiempo acumulado total de la compensacion
		
		var fec_ini_comp = document.getElementById("inputg3").value;
		var xfec_fin = fec_ini_comp.split("-");
		var fec_ini_comp = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];		
					
		var fec_ini_inc = document.getElementById("fec_ini_inc").value;
		var fec_ini_inc  = fec_ini_inc.split(" ");
		var fec_ini_inc  = fec_ini_inc[0];
		
		var xfec_ini_inc = document.getElementById("fec_ini_inc").value;
		var xfec_fin_inc = document.getElementById("fec_fin_inc").value;
						
		var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
		var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;
		
		//alert("1-"+fec_ini_inc+"|2-"+fec_ini_comp)
		
		
		if (fec_ini_comp < fec_ini_inc){
			alert("Alerta: Las fechas de Compensaciones deben ser mayor que la fecha de permiso")
			return
		}else{
		
		if (document.getElementById("tt_acu_comp").value > document.getElementById("tt_acumulado").value &&
			document.getElementById("tt_comp_tot").value=="00:00:00"){
				alert("Alerta1: El tiempo acumulado supera al tiempo de permiso")
				return
		}else{
			if (document.getElementById("tt_comp_tot").value >= document.getElementById("tt_acumulado").value){
						alert("Alerta2: El tiempo acumulado supera al tiempo de permiso")
						return
				
			}else{			
				
							var fec1 = document.getElementById("inputg3").value;	
							var fec2 = document.getElementById("inputg3").value;	
							
							var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
							var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
							
							var fec1  = fec1.split(" ");
							var fec1x  = fec1[0];
							var xfec_ini = fec1x.split("-");
							var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
							
							var fec2  = fec2.split(" ");
							var fec2x  = fec2[0];
							var xfec_fin = fec2x.split("-");
							var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
							
							
							
							
							if (h_fin<h_ini){
								alert("La hora final debe ser mayor que la hora inicial")
								return
							}else{
								if (h_fin==h_ini){
								alert("Error: Horas Iguales");	
								return
								}
							}
						
		//alert(xfec_ini)
		//alert(xfec_fin)
		
		var pag5 = "funciones_cot.php?dni="+dni+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&xfec_ini_inc="+ xfec_ini_inc
		+"&xfec_fin_inc="+xfec_fin_inc+"&modo="+modo+"&c_incidencia="+c_incidencia+"&h_ini="+h_ini+"&h_fin="+h_fin
		+"&iduser="+iduser+"&idperfil="+idperfil+"&tt_acu_comp="+tt_acu_comp+"&tt_acumulado_perm="+tt_acumulado_perm
		+"&motivo_inc="+motivo_inc+"&accion=save_compensaciones_inc";
		
	//	alert(pag5)
		
		ajaxcc = new createRequest();
		ajaxcc.open("get", pag5, true);
		ajaxcc.onreadystatechange = function () {
			
			if (ajaxcc.readyState == 4) { 	
			//alert(ajaxcc.responseText)			
			var resp1 = ajaxcc.responseText;
			var resp1 = resp1.split("|");		
			
			var error = resp1[0];
			var error = error.replace(/\s+/gi,'');	
			
			var tt_acu_comp = resp1[3];
			var tt_acu_comp = tt_acu_comp.replace(/\s+/gi,'');	
			
			
			//alert(resp1[3])		
			
			document.getElementById("tt_comp_tot").value=resp1[3];
			
				if (error=="0"){					
					alert(resp1[2]);					
					return
				}else{
					listar_compensaciones_inc();
				}
				
					if (document.getElementById("tt_comp_tot").value >= document.getElementById("tt_acumulado").value){						
						document.getElementById("bt_compensacion").style.display="none";						
					}else{
						 document.getElementById("bt_compensacion").style.display="block";
					}
					/*
					document.getElementById("tt_acu_comp").value="00:00:00";
					document.getElementById("h_ini_gru").value="0";
					document.getElementById("mm_ini_gru").value="00";
					document.getElementById("h_fin_gru").value="0";
					document.getElementById("mm_fin_gru").value="00";	
					document.getElementById("inputg3").value="";
					*/
					
			}
		}
		ajaxcc.send(null)
		
		} // fin del if
		}
	}
}

function msn_alerta_nueva(modulo,valor_1,valor_2,c_mot_inc_gru){	
	
	if (modulo=="1"){ // registro de boleta
		var iduser 		= document.getElementById("iduser").value;	
		var idperfil 	= document.getElementById("idperfil").value;	
		var texto_ini	= valor_1;
		var texto_int	= valor_2;
		var texto_fin	= "";
		var estado		= "1";
		var modo 	= document.getElementById("modalidad").value;
		var dni = document.getElementById("arr_hor").value;	
		
		var p_modulo="alertas_nueva.php?texto_ini="+texto_ini+"&texto_int="+texto_int+"&valor_2="+texto_fin+"&iduser="+iduser+"&modo="+modo
		+"&idperfil="+idperfil+"&estado="+estado+"&dni="+dni+"&c_mot_inc_gru="+c_mot_inc_gru;
		//alert(p_modulo);	
		
		var atributos = "width=800px,height=450px,center=1,resize=0,scrolling=0";
		
		alerta 	=	dhtmlmodal.open('EmailBox', 'iframe',p_modulo,'INCIDENCIAS COT',atributos);	
	}
}

function cerrar_esto(){
	parent.alerta.hide();
	parent.parent.ras.hide();
}

function calc_lactancia(){	
	
							var fec1 = document.getElementById("inputg3").value;								
							
							var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
							var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
							
							var fec1  = fec1.split(" ");
							var fec1x  = fec1[0];
							var xfec_ini = fec1x.split("-");
							var fec_ini_lac = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
					
						
		var accion			 = "calcular_lactancia";
		
		if (document.getElementById("combo_mot").value=="41"){
			var pag1 = "funciones_cot.php?fec_ini_lac="+fec_ini_lac+"&accion="+accion;
			alert(pag1)	
			ajaxc = createRequest();
			ajaxc.open("get", pag1, true);
			ajaxc.onreadystatechange = function () {
				
				if (ajaxc.readyState == 4) {
					alert(ajaxc.responseText)  							
					}        
				}
			ajaxc.send(null)	
		}
}

function grabar_movimientos_usuarios_nuevo(id,usuario,fec_ini,dni,cip,aplicativo,n_apli,fec_fin) {
	
	var usu_aplicativo 	= document.getElementById(usuario).value;	
	var n_xfec_ini		= "f_" + n_apli;	
	var fec_ini 	= document.getElementById(n_xfec_ini).value;		
	var iduser 		= document.getElementById("iduser").value;	
	var accion		= grabar_movimientos_usuarios_nuevo;
	
	
	var msn_act="Desea Actualizar la informacion? ";
	if (confirm(msn_act)){	
		if (document.getElementById(usuario).value==""){
			alert("Alerta: El usuario se encuentra vacio")
			return
		}else{
		if (document.getElementById(n_xfec_ini).value=="0000-00-00"){
			alert("Alerta: Fecha se encuentra Vacia")
			return
		}else{
		var page = "funciones_cot.php?id="+id+"&usu_aplicativo="+usu_aplicativo+"&iduser="+iduser+"&fec_ini="+fec_ini+"&fec_fin="+fec_fin
			+"&dni="+dni+"&cip="+cip+"&aplicativo="+aplicativo+"&n_apli="+n_apli+"&accion=grabar_movimientos_usuarios_nuevo";
			
		//Salert(page)
		
		ajax_c = createRequest();
		ajax_c.open("get", page, true);
		ajax_c.onreadystatechange = function () {
			
			if (ajax_c.readyState == 4) {
				alert(ajax_c.responseText)  
				}        
		}
		ajax_c.send(null)
		}
		}
	}
}


function validar_incidencia(){	
		var iduser 		= document.getElementById("iduser").value;	
		var idperfil 		= document.getElementById("idperfil").value;	
		var tipo_incidencia = document.getElementById("c_mot_gru").value;	
		var motivo_incidencia = document.getElementById("combo_mot").value;		
		var modo_incidencia = document.getElementById("modalidad").value;			
		var dni_escogidos = document.getElementById("arr_escogidos").value;	
		var nro_escogidos = document.getElementById("chk_escogidos").value;		
		var s_arr_hor = document.getElementById("arr_hor").value;	
		var arr_hor = s_arr_hor.substring(1,1000);
			
		if (document.getElementById("modalidad").value=="D"){
						var fec1 = document.getElementById("inputg1").value;	
						var fec2 = document.getElementById("inputg2").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
						
						
							if (document.getElementById("combo_mot").value=="800"){
									if (document.getElementById("inputg1").value==""){
										alert("Error: Fechas Vacias")
										return
									}
							}else{
									if (document.getElementById("inputg1").value=="" && document.getElementById("inputg2").value==""){
										alert("Error: Fechas Vacias")
										return
									}else{								
										if (document.getElementById("inputg1").value==""){
											alert("Error: Fechas Inicio Vacia")
											return
										}
										if (document.getElementById("inputg2").value==""){
											alert("Error: Fechas Fin Vacia")
											return
										}
							}
						}
					
					}else{
						
						var fec1 = document.getElementById("inputg3").value;	
						var fec2 = document.getElementById("inputg3").value;	
						
						var h_ini = document.getElementById("h_ini_gru").value +":"+ document.getElementById("mm_ini_gru").value;	
						var h_fin = document.getElementById("h_fin_gru").value +":"+ document.getElementById("mm_fin_gru").value;	
						
						var fec1  = fec1.split(" ");
						var fec1x  = fec1[0];
						var xfec_ini = fec1x.split("-");
						var xfec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0] +" "+ h_ini;
						
						var fec2  = fec2.split(" ");
						var fec2x  = fec2[0];
						var xfec_fin = fec2x.split("-");
						var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0] +" " + h_fin;	
						
						
						if (document.getElementById("inputg3").value==""){
							alert("Error: Fecha Vacia")
								return
						}else{
							if (h_ini=="0:00" && h_fin=="0:00"){
							alert("Error: Datos de Horas Vacios")
							return
							}else{
								if (xfec_ini==xfec_fin){
									alert("Error: Horas Iguales")	
									return
								}
						}
						
					}
				}
				
		
	
		var pag1 = "funciones_cot.php?dni_escogidos="+dni_escogidos+"&iduser="+iduser+"&idperfil="+idperfil
		+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&tipo_incidencia="+tipo_incidencia+"&motivo_incidencia="+motivo_incidencia
		+"&modo_incidencia="+modo_incidencia+"&accion=validar_incidencia";		
		alert(pag1)
		
		ajaxp= new createRequest();	
		ajaxp.open("GET", pag1,true);
		ajaxp.onreadystatechange=function() {
	
			if (ajaxp.readyState==4){
				var resp = ajaxp.responseText;			
				alert(resp)
									
			}		
		}
		 ajaxp.send(null)
				 
}

function eliminar_incidencia_todo(){
	var iduser = document.getElementById("iduser").value;
	var c_incidencia = document.getElementById("c_inc").value;
	
	
	 
	if (document.getElementById("c_inc").value==""){
		alert("Alerta: Debe de ingresar el codigo de incidencia")
		return
	}else{
		var msn2="Desea Eliminar la incidencia "+c_incidencia+".... ?";
		if (confirm(msn2)){	
		
		var urlx = "funciones_cot.php?c_incidencia="+c_incidencia+"&iduser="+iduser+"&accion=eliminar_incidencia_todo";	
	 	//alert(urlx)
			//alert(urlx)
			ajaxc=createRequest();
			ajaxc.open("GET", urlx,true);
			ajaxc.onreadystatechange=function() {
				
				if (ajaxc.readyState==4) 			
				{			
					//alert(ajaxc.responseText);
					alert("Registro eliminado....")
					ver_div_incidencias();
				}
			}
			 ajaxc.send(null)	
		}
	}
}


/************************************************************************************************************************************/


function mostrar_modulos_mant(opc){
	var iduser = document.getElementById("iduser").value;
	//alert(opc)
	
	if (opc=="1"){						
		document.getElementById("mod_mant_motivoincidencias").style.display="block";						
		document.getElementById("mod_mant_olas").style.display="none";
		document.getElementById("mod_mant_aplicativos").style.display="none";	
	}
	
	if (opc=="2"){						
		document.getElementById("mod_mant_motivoincidencias").style.display="none";								
		document.getElementById("mod_mant_olas").style.display="block";
		document.getElementById("mod_mant_aplicativos").style.display="none";	
	}
	
	if (opc=="3"){	
		 	document.getElementById("mod_mant_motivoincidencias").style.display="none";	
			document.getElementById("mod_mant_olas").style.display="none";
			document.getElementById("mod_mant_aplicativos").style.display="block";			
	}
}

function grabar_aplicativo(){
	var aplicativo = document.getElementById("aplicativo").value;	
	var iduser = document.getElementById("iduser").value;	
	
	if (aplicativo == "") {
        return false;
    }
			
	var pag1 = "funciones_cot.php?aplicativo="+aplicativo+"&iduser="+iduser+"&accion=grabar_aplicativo";
	
	//alert(pag1);
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
			document.getElementById("msn_registro").innerHTML=ajaxc.responseText;	
			document.getElementById("msn_registro").style.display="block";
        }
	}
	ajaxc.send(null)	
	
}

/*23/07/20*/

function mostrar_detalle_usuarios(){	
//alert("entro")
		
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var c_supervisor = document.getElementById("c_supervisor").value;
	var c_gestor = document.getElementById("combo_gestor").value;
	
	if (document.getElementById("c_supervisor").value=="0"){
		alert("Debe escojer un supervisor")
		return
	}else{
		if (document.getElementById("combo_gestor").value=="0" && document.getElementById("c_supervisor").value=="T"){
		alert("Debe escojer un gestor")
		return		
	}else{
	var pag1 = "funciones_cot.php?iduser="+iduser+"&c_supervisor="+c_supervisor+"&c_gestor="+c_gestor+"&idperfil="+idperfil
	+"&accion=detalle_usuarioscot";
	
	//alert(pag1)
			
			document.getElementById("load_1").style.display="block";		
			document.getElementById("load_1").innerHTML = "<img src=\"cargando.gif\" width='200px' height='200px' />";
			document.getElementById("d_bandeja_usuarioscot").style.display="none";	
			document.getElementById("bt_mostrar_detalle").style.display="none";
			
					
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
			document.getElementById("load_1").style.display="none";
			document.getElementById("load_1").innerHTML="";
			document.getElementById("d_bandeja_usuarioscot").style.display	="block";
			if (document.getElementById("combo_gestor").value=="0"){
				document.getElementById("d_bandeja_usuarioscot").style.height	="500px";
				document.getElementById("d_bandeja_usuarioscot").style.width	="1500px";
			}else{
				document.getElementById("d_bandeja_usuarioscot").style.height	="150px";
				document.getElementById("d_bandeja_usuarioscot").style.width	="1500px";
			}
			document.getElementById("d_bandeja_usuarioscot").innerHTML		=ajaxc.responseText;	
			document.getElementById("bt_mostrar_detalle").style.display="block";
			
        }
	}
	ajaxc.send(null)	

	//mostrar_gestorcot();
	}
	}
}

function cargar_automaticamente_usuarios(c_supervisor,c_gestor){	
//alert("entro carga")
		
	var iduser = parent.document.getElementById("iduser").value;	
	var idperfil = parent.document.getElementById("idperfil").value;	
	
	
	var pag1 = "funciones_cot.php?iduser="+iduser+"&c_supervisor="+c_supervisor+"&c_gestor="+c_gestor+"&idperfil="+idperfil
	+"&accion=detalle_usuarioscot";
	
	//alert(pag1)
			
			parent.document.getElementById("load_1").style.display="block";		
			parent.document.getElementById("load_1").innerHTML = "<img src=\"cargando.gif\" width='200px' height='200px' />";
			parent.document.getElementById("d_bandeja_usuarioscot").style.display="none";	
			parent.document.getElementById("bt_mostrar_detalle").style.display="none";
			
					
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
			parent.document.getElementById("load_1").style.display="none";
			parent.document.getElementById("load_1").innerHTML="";
			parent.document.getElementById("d_bandeja_usuarioscot").style.display	="block";
			parent.document.getElementById("d_bandeja_usuarioscot").innerHTML		=ajaxc.responseText;	
			parent.document.getElementById("bt_mostrar_detalle").style.display="block";
			
        }
	}
	ajaxc.send(null)	

	//mostrar_gestorcot();
	
}



function edicion_usuarios(dni,dato,aplicativo,est){
	
	
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	
	
	var page="edicion_usuarioscot.php?dni="+dni+"&dato="+dato+"&aplicativo="+aplicativo+"&iduser="+iduser+"&idperfil="+idperfil+"&est="+est;
	//alert(page);
	
	ras=dhtmlmodal.open('EmailBox', 'iframe',page,'INFORMACION DE APLICATIVOS', 
	'top=6,left=500,width=800px,height=300px,center=0,resize=0,scrolling=0');	
	
}

function cerrar_edicion_usuarios(){
	var c_supervisor = parent.document.getElementById("c_supervisor").value;	
	parent.ras.hide();
	mostrar_detalle_usuarios(c_supervisor);
}


function cambios_usuariocot(opc){	
	
	if (document.getElementById("usu_1").value=="-" || document.getElementById("usu_1").value=="" || document.getElementById("usu_1").value==" " ){
		alert("Campo del usuario esta vacio o sin dato");
		return
	}
	
	if(opc=="1"){
	var dni_1 = document.getElementById("dni_1").value;
	var usu_1 = document.getElementById("usu_1").value;
	var aplicativo_1 = document.getElementById("aplicativo_1").value;
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;
	var est = document.getElementById("est").value;
	var msn = "Se cambio de estado correctamente";
	
	var pag1 = "funciones_cot.php?iduser="+iduser+"&dni_1="+dni_1+"&usu_1="+usu_1+"&aplicativo_1="+aplicativo_1+"&est="+est
	+"&accion=estado_usuarioscot";
	}
	
	if(opc=="2"){
	var dni_1 = document.getElementById("dni_1").value;
	var usu_1 = document.getElementById("usu_1").value;
	var usu_ant = document.getElementById("usu_ant").value;
	var aplicativo_1 = document.getElementById("aplicativo_1").value;
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;
	var est = document.getElementById("est").value;
	
	
		if (usu_1=="" || usu_1=="-"){
			alert("El campo de usuario esta en blanco")
			return
		}else{
			var pag1 = "funciones_cot.php?iduser="+iduser+"&dni_1="+dni_1+"&usu_1="+usu_1+"&aplicativo_1="+aplicativo_1+"&est="+est
			+"&usu_ant="+usu_ant+"&accion=actualizar_usuarioscot";
		}
	}
	
	
	//alert(pag1)
	
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			alert(ajaxc.responseText);					
			parent.ras.hide();
			var c_supervisor = parent.document.getElementById("c_supervisor").value;	
			var c_gestor = parent.document.getElementById("combo_gestor").value;
			cargar_automaticamente_usuarios(c_supervisor,c_gestor);			
        }
	}
	ajaxc.send(null)
			
	
			
}

function mostrar_gestorcot(c_supervisor){
	//var c_supervisor = document.getElementById("c_supervisor").value;	
	
	var pag1 = "funciones_cot.php?c_supervisor="+c_supervisor+"&accion=carga_combo_gestor";
			
	//alert(pag1)		
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
			document.getElementById("d_combo_gestor").innerHTML		=ajaxc.responseText;	
			
        }
	}
	ajaxc.send(null)
	
}


function ir(op){
	//alert("Entro")
	if (op=="1"){
	document.getElementById("t_inicio").focus();
	}
	if (op=="2"){
	document.getElementById("t_fin").focus();
	}
	
}

function exportar_aplicativos_usuarioscot(){	
		
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var c_supervisor = document.getElementById("c_supervisor").value;
	var c_gestor = document.getElementById("combo_gestor").value;
	
	var win=null;	
	
	var url="reporte_aplicativos_usuarioscot.php?iduser="+iduser+"&c_supervisor="+c_supervisor+"&c_gestor="+c_gestor+"&idperfil="+idperfil;
	//alert(url)	
	win=window.open(url,true);
	
}

function edit_incidencia(){
	
	var iduser = document.getElementById("iduser").value;	
	var idperfil = document.getElementById("idperfil").value;	
	var c_inc = document.getElementById("c_inc").value;
	
	if (document.getElementById("c_inc").value==""){
		alert("Alerta: Debe de ingresar el codigo de incidencia");
		return
	}else{
		var page="editar_incidencia.php?c_inc="+c_inc+"&iduser="+iduser+"&idperfil="+idperfil;
		//alert(page);
		
		ras=dhtmlmodal.open('EmailBox', 'iframe',page,'INFORMACION DE APLICATIVOS', 
		'top=3,left=200,width=1000px,height=600px,center=0,resize=0,scrolling=0');			
	}
	
	
}

function mostrar_comp(){
	document.getElementById("frm_comp").style.display	="block";
}

function cerrar_edit_incidencia(){		
	parent.ras.hide();
	
}

function escojer_check(){
	
	var i = 0; 
	var con= 0;
	var acceso = '';
	var hor = '';
	
	
	for (i=0; i<100000; i++){
					var cor="check"+i;
					//alert(cor)
					
					if (document.getElementById(cor).checked){
						
						//alert(document.getElementById(cor).value)
						
						acceso = acceso + "|" + document.getElementById(cor).value;
						hor = hor + "," + document.getElementById(cor).value;
						//alert(acceso)	
						
						con = con + 1;
						document.getElementById("nro_escogidos").value = con; 
						//document.getElementById("chk_escogidos").value  = con; 
						document.getElementById("valor_escogido").value  = acceso; 	
						//document.getElementById("arr_hor").value  = acceso;
						//var hor = hor.substring(1, 1000); 						
						
					}					
	}	
}


function eliminiar_comp(){
	var c_incidencia = document.getElementById("c_incidencia").value;	
	var nro_escogidos = document.getElementById("nro_escogidos").value;	
	var valor_escogido = document.getElementById("valor_escogido").value;	
	
	var pag1 = "funciones_cot.php?c_incidencia="+c_incidencia+"&nro_escogidos="+nro_escogidos+"&valor_escogido="+valor_escogido
	+"&accion=eliminar_compensaciones";
			
	//alert(pag1)		
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);	
			listar_compensaciones_inc();
        }
	}
	ajaxc.send(null)
	
}

function grabar_motivos_inc(){
	var tipo_inc = document.getElementById("tipo_inc").value;	
	var motivo_inc = document.getElementById("motivo_inc").value;	
	var iduser = document.getElementById("iduser").value;
	
	
	var pag1 = "funciones_cot.php?tipo_inc="+tipo_inc+"&motivo_inc="+motivo_inc+"&iduser="+iduser+"&accion=grabar_motivos_inc";
			
	//alert(pag1)		
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			alert(ajaxc.responseText);				
        }
	}
	ajaxc.send(null)
	
}

function grabar_olas(){
	var olas = document.getElementById("olas").value;	
	var fec_ini = document.getElementById("fec_ini").value;
	var fec_fin = document.getElementById("fec_fin").value;
	var iduser = document.getElementById("iduser").value;	
	
			
	var pag1 = "funciones_cot.php?olas="+olas+"&iduser="+iduser+"&fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&accion=grabar_olas";
	
	//alert(pag1);
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
			document.getElementById("lista_olas").innerHTML=ajaxc.responseText;	
			document.getElementById("lista_olas").style.display="block";
        }
	}
	ajaxc.send(null)	
	
}

function listar_olas(){
	var iduser = document.getElementById("iduser").value;
		
	var pag1 = "funciones_cot.php?iduser="+iduser+"&accion=listar_olas";
	
	//alert(pag1);
	ajaxc = createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
			//alert(ajaxc.responseText);
			document.getElementById("mod_mant_olas").style.display="block";
			document.getElementById("lista_olas").innerHTML=ajaxc.responseText;	
			document.getElementById("lista_olas").style.display="block";
        }
	}
	ajaxc.send(null)	
	
}

function eliminar_detalle(inc,dni,fecha){
	var c_incidencia = inc;	
	var c_dni = dni;	
	var c_fecha = fecha;	
	
	var msn2="Desea Eliminar el detalle de la incidencia "+c_incidencia+" para el DNI: "+dni+" con fecha inicio: "+fecha+" ?";
		if (confirm(msn2)){	
			var pag1 = "funciones_cot.php?c_incidencia="+c_incidencia+"&dni="+c_dni+"&fecha="+c_fecha
			+"&accion=eliminar_detalle_incidencia";
					
			//alert(pag1)		
			ajaxc = createRequest();
			ajaxc.open("get", pag1, true);
			ajaxc.onreadystatechange = function () {
				
				if (ajaxc.readyState == 4) {  
					//alert(ajaxc.responseText);	
					alert("Cierre la ventana y vuelva a ingresar para visualizar los cambios");
				}
			}
			ajaxc.send(null)
		}
}


function cargar_horarios(){
	
	document.getElementById("mensaje_carga_horarios").innerHTML = '';

	var iduser = document.getElementById("iduser").value;
	var archivo = document.getElementById('imp_archivo_horario').files[0]; 
    
	var formData = new FormData();
	formData.append("file", archivo);
	if(!archivo){
		// alert("DEBE ELEGIR EL ARCHIVO A IMPORTAR");
		document.getElementById("mensaje_carga_horarios").innerHTML = "<p class='warning_color'>Eliga un archivo. <img src='image/warning.png' width='17px' height='17px'/></p>";
		return
	}
	var pag = "funciones_cot.php?iduser="+iduser+"&accion=cargar_horarios_csv";	
	document.getElementById("btn_cargar_file").innerHTML = "<img src='cargando.gif' width='22' height='22'/>Cargando..</button>";
	document.getElementById("btn_cargar_file").disabled = true;
	// document.getElementById("mensaje_carga_horarios").innerHTML = "<p class='loading_color'>CARGANDO ARCHIVO...<img src='cargando.gif' width='17px' height='17px'/></p>";
	ajax = createRequest();	
	ajax.open("POST",pag,true);
	ajax.onreadystatechange=function() {
		console.log(ajax.status);
		if (ajax.readyState==4 && ajax.status == 200){
		var resx=ajax.responseText;							
		document.getElementById("mensaje_carga_horarios").innerHTML = resx;
		document.getElementById("btn_cargar_file").innerHTML = "<img src='image/upload.gif' width='22' height='22'/>Cargar archivo</button>";
		document.getElementById("btn_cargar_file").disabled = false;
		}else if(ajax.status == 403 || ajax.status == 400 || ajax.status == 404 ){
			document.getElementById("mensaje_carga_horarios").innerHTML = "<p class='error_color'> OCURRIO UN ERROR EN LA CARGA !!!<img src='image/Symbol-Error.gif' width='17px' height='17px'/></p>";
		}				 
	}

	ajax.send(formData)	
}



function isJson(str) {
	try {
			JSON.parse(str);
	} catch (e) {
			return false;
	}
	return true;
}