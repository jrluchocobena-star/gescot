// JavaScript Document
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


function buscar_gestor(){
	var dni = document.getElementById("dni").value;
	var cip = document.getElementById("cip").value;
	var nombre = document.getElementById("nombre").value;
	
	if (document.getElementById("dni").value=="" && document.getElementById("nombre").value=="" && document.getElementById("cip").value==""){		
			var opc="0";
		}else{
			if (document.getElementById("dni").value=="" && document.getElementById("cip").value==""){
				var opc="1";
			}else{
				if (document.getElementById("cip").value==""){
					var opc="2";
				}else{
					var opc="3";
				}
			}
		}
	
	var pag1 = "funciones_php.php?dni="+dni+"&cip="+cip+"&nombre="+nombre+"&opc="+opc+"&accion=buscar_gestor";
	
	//alert(pag1);
	
	ajaxc = new createRequest();
    ajaxc.open("get", pag1, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 				
		//alert(ajaxc.responseText);
		 document.getElementById("d_botonera").style.display="none";  
		document.getElementById("d_lista_usu").style.display="block";  
		document.getElementById("d_lista_usu").innerHTML=ajaxc.responseText;
		//document.getElementById("dni").value="";
		//document.getElementById("cip").value="";
		//document.getElementById("nombre").value="";
        }
	}
	ajaxc.send(null)

}


function calcular_tiempos(){
	var modo = document.getElementById("modo").value;
	var factor = document.getElementById("factor").value;
		
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
			document.getElementById("btn_grabar").style.display="block"; 
		}else{			
			alert("ALERTA: LA FECHA FINAL DEBE SER MAYOR A LA FECHA INICIAL")
			document.getElementById("btn_grabar").style.display="none"; 
		}
		*/

}else{
		if (document.getElementById("modo").value=="D"){			
		var fec1 = document.getElementById("input1").value;
		var fec = document.getElementById("input1").value;
		//var fec2 = document.getElementById("input2").value;		
		document.getElementById("exc").value="dias";
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini = fec1x.split("-");
		var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];	
		
		var fec_fin="0000-00-00";
		
		}else{	// si modo=H

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
			document.getElementById("bt_aceptar").style.display="block";	
		}		
	}else{
		if (document.getElementById("input3").value=="" || 
		document.getElementById("h_ini").value=="0" || document.getElementById("h_fin").value=="0"
		){
			document.getElementById("bt_aceptar").style.display="none";	
			alert("ERROR: NO HA INGRESADO HORAS COMPLETAS")
			return
		}else{
			document.getElementById("bt_aceptar").style.display="block";	
		}		
	}
	
	var pag4 = "funciones_php.php?fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&fec="+fec+"&modo="+modo+"&factor="+factor+"&hor_ini="+hor_ini
	+"&hor_fin="+hor_fin+"&accion=calcular_tiempo";
	
	//alert(pag4);
	
	document.getElementById("btn_grabar").style.display="block"; 
	
	ajaxc = new createRequest();
    ajaxc.open("get", pag4, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) {  
		//alert(ajaxc.responseText)
			var msn_  = ajaxc.responseText; 			
			var msn = msn_.split("|");         
			document.getElementById("tt_c").value = msn[2];			
			document.getElementById("tiempo").value = msn[0];
			document.getElementById("ndia").value = msn[1];		
			
        }
	}
	ajaxc.send(null)
	
	
	}
	
function grabar_incidencia_comp(){
var iduser = document.getElementById("iduser").value;	
var idperfil = document.getElementById("idperfil").value;	
var tp_incidencia = document.getElementById("tp_incidencia").value;	
var obs = document.getElementById("obs").value;	
var dni = document.getElementById("dni").value;
var factor = document.getElementById("factor").value;
var tiempo = document.getElementById("tiempo").value;	
var modo = document.getElementById("modo").value;	
var tt_c = document.getElementById("tt_c").value;	


	if (document.getElementById("modo").value=="D"){
		var fec1 = document.getElementById("input1").value;	
		//var fec2 = document.getElementById("input2").value;	
		
		var fec1  = fec1.split(" ");
		var fec1x  = fec1[0];
		var xfec_ini_ = fec1x.split("-");
		
		/*
		var fec2  = fec2.split(" ");
		var fec2x  = fec2[0];
		var xfec_fin = fec2x.split("-");
		var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
		*/
		xfec_ini_ = xfec_ini_[2]+"-"+xfec_ini_[1]+"-"+xfec_ini_[0];
		var xfec_ini = xfec_ini_+" 08:00:00";
		
		var xfec_fin = xfec_ini_+" 16:30:00";
	
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



if (document.getElementById("tp_incidencia").value=="0"){
	alert("DEBE ESCOGER UN TIPO INCIDENCIA");
	return	
}

if (document.getElementById("factor").value=="0"){
	alert("DEBE ESCOGER FACTOR");
	return	
}


if (document.getElementById("obs").value==""){
	alert("DEBE INGRESAR UNA OBSERVACION");
	return	
}


var pag1 = "funciones_php.php?iduser="+iduser+"&dni="+dni+"&tp_incidencia="+tp_incidencia+"&factor="+factor+"&fec_ini="+xfec_ini+"&modo="+modo+"&tiempo="+tiempo+"&fec_fin="+xfec_fin+"&tt_c="+tt_c+"&obs="+obs+"&accion=grabar_incidencia_comp";


//alert(pag1)

	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag1, true);
    ajaxc1.onreadystatechange = function () {
		
		//alert(ajaxc1.responseText)  	
		
		
        if (ajaxc1.readyState == 4) {																	
			var msn="Se registro la programacion exitosamente"			
			alert(msn)							
			parent.window.close();				
			document.getElementById("d_lista_usu").innerHTML="";
			document.getElementById("d_lista_usu").style.display="none"; 		
			}        
	}
	ajaxc1.send(null)
		
			
}


function  popup_reclamo(opc,id){	
	
	if (opc==1){ // registro de boleta	
	var page="../modulo_compensacion.php?id="+id;
	//alert(page);	
	ras=dhtmlmodal.open('MODULO', 'iframe',page,'MODULO DE COMPENSACION', 'width=700px,height=450px,center=1,resize=0,scrolling=0');	
	}
	
	
}

function cerrar_modal(){
		parent.ras.hide();
}	



/***************/

function calcular_tiempos_comp(){
	var modo = document.getElementById("modo").value;
	var dni = document.getElementById("dni").value;	
	var tt_acumulado = document.getElementById("tt_acumulado").value;	
	var tt_restante = document.getElementById("tt_restante").value;
	var tt_compensando = document.getElementById("tt_compensando").value;
	var t_comp_a = document.getElementById("t_comp_a").value;
	var t_saldo_a = document.getElementById("t_saldo_a").value;
	
		if (document.getElementById("modo").value=="D"){
					if (document.getElementById("input1").value==""){
					alert("Ingrese fecha de Compensacion")	
						return
					}
					//var fec2 = document.getElementById("input2").value;
					var fec1 = document.getElementById("input1").value;				
					document.getElementById("exc").value="dias";
					
					var fec1  = fec1.split(" ");
					var fec1x  = fec1[0];
					var xfec_ini = fec1x.split("-");
					
					var fec_ini = xfec_ini[2]+"-"+xfec_ini[1]+"-"+xfec_ini[0];				
					var fec_fin ="0000-00-00";
					var hor_ini = "00:00:00";
					var hor_fin = "00:00:00";
		}else{			
					if (document.getElementById("input3").value==""){
					alert("Ingrese fecha de Compensacion")	
					return
					}					
					var fec_ini = document.getElementById("input3").value;
					var hor_ini = document.getElementById("h_ini").value + ":" + document.getElementById("mm_ini").value;
					var hor_fin = document.getElementById("h_fin").value + ":" + document.getElementById("mm_fin").value;
					document.getElementById("exc").value="HH:MM";	
					var fec_fin ="0000-00-00";										
				
					
		}		

	var pag_c = "funciones_php.php?dni="+dni+"&fec_ini="+fec_ini+"&fec_fin="+fec_fin+"&tt_acumulado="+tt_acumulado+"&tt_restante="+tt_restante+"&tt_compensando="+tt_compensando+"&t_comp_a="+t_comp_a+"&t_saldo_a="+t_saldo_a+"&modo="+modo+"&hor_ini="+hor_ini+"&hor_fin="+hor_fin+"&accion=calcular_compensacion";
	
	//alert(pag_c)		
		 
	ajaxc = new createRequest();
    ajaxc.open("get", pag_c, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 
		//alert(ajaxc.responseText);	
		var mos = ajaxc.responseText; 			
		var mos = mos.split("|");			
		
		document.getElementById("t_comp_a").value = mos[0];		
		document.getElementById("t_saldo_a").value = mos[1];	
		document.getElementById("bt_grabar").style.display="block"; 		
		
		var hh1 = document.getElementById("t_comp_a").value;
		var hh1 = hh1.split(":")
		
		var hh2 = document.getElementById("tt_restante").value;
		var hh2 = hh2.split(":")
		
		//alert(hh1[0])
		//alert(hh2[0])
		
		if (hh1[0] > hh2[0]){
			var msn = "Tiempo Compensado supera al tiempo Programado";
			alert(msn)
			document.getElementById("bt_grabar").style.display="none"; 		
			return
		}
		
		if (document.getElementById("t_comp_a").value>"08:30"){
			var msn = "Excede el limite de horas compensadas";
			alert(msn)
			document.getElementById("bt_grabar").style.display="none"; 		
			return
		}
		
			
			
		}
	}
	ajaxc.send(null)
	
}
	
	

function grabar_compensaciones(){
		var dni = document.getElementById("dni").value;	
		var tiempo_a = document.getElementById("t_comp_a").value;	
		var iduser = document.getElementById("iduser").value;			
		var modo = document.getElementById("modo").value;
		var obs = document.getElementById("obs").value;
	
	
		if (document.getElementById("modo").value=="D"){
			
			var fec1 = document.getElementById("input1").value;	
			//var fec2 = document.getElementById("input2").value;	
			
			var fec1  = fec1.split(" ");
			var fec1x  = fec1[0];
			var xfec_ini_ = fec1x.split("-");
				
			
			/*
			var fec2  = fec2.split(" ");
			var fec2x  = fec2[0];
			var xfec_fin = fec2x.split("-");
			var xfec_fin = xfec_fin[2]+"-"+xfec_fin[1]+"-"+xfec_fin[0];	
			*/
			xfec_ini_ = xfec_ini_[2]+"-"+xfec_ini_[1]+"-"+xfec_ini_[0];
			var xfec_ini = xfec_ini_+" 08:00:00";
			
			var xfec_fin = xfec_ini_+" 16:30:00";
		
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
	
	//alert(xfec_ini)
	//alert(xfec_fin)
	
	var pag5 = "funciones_php.php?dni="+dni+"&fec_ini="+xfec_ini+"&fec_fin="+xfec_fin+"&obs="+obs+"&tiempo_a="+tiempo_a+"&modo="+modo
	+"&hor_ini="+h_ini+"&h_fin="+h_fin+"&iduser="+iduser+"&accion=grabar_compensaciones";
	
	//alert(pag5)
	ajaxc = new createRequest();
    ajaxc.open("get", pag5, true);
    ajaxc.onreadystatechange = function () {
		
        if (ajaxc.readyState == 4) { 				
		//alert(ajaxc.responseText);
		parent.window.close();
		window.reload();
		}
	}
	ajaxc.send(null)
	
}

	 
function mostrar_modo(valor_c){
	document.getElementById("t_comp_a").value = "00:00";		
	document.getElementById("t_saldo_a").value = "00:00";	
	
	if (valor_c=="D"){
		document.getElementById("f_dias").style.display="block";	
		document.getElementById("f_horas").style.display="none";
		document.getElementById("input1").value = "";					
		
	}
	if (valor_c=="H"){
		document.getElementById("f_horas").style.display="block";	
		document.getElementById("f_dias").style.display="none";	
		document.getElementById("input3").value = "";
		document.getElementById("h_ini").value = "0";
		document.getElementById("h_fin").value = "0";
		document.getElementById("mm_ini").value = "00";
		document.getElementById("mm_fin").value = "00";
		
	}
	
	
	
}


function cerrar_ventana(){
	parent.window.close();
}



function grabar_incidencia(){
var iduser = document.getElementById("iduser").value;	
var idperfil = document.getElementById("idperfil").value;	
var tp_incidencia = document.getElementById("tp_incidencia").value;	

var obs = document.getElementById("obs").value;	
var trabajador = document.getElementById("gestor").value;
var tiempo = document.getElementById("tiempo").value;	
var modo = document.getElementById("modo").value;	
var c_doid = document.getElementById("c_doid").value;	

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


if (document.getElementById("gestor").value=="0"){
	alert("DEBE INGRESAR DATOS DEL TRABAJADOR")	
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

var pag1 = "funciones_cot.php?iduser="+iduser+"&trabajador="+trabajador+"&tp_incidencia="+tp_incidencia+"&c_mot_inc="+c_mot_inc+"&c_doid="+c_doid+"&fec_ini="+xfec_ini+"&modo="+modo+"&tiempo="+tiempo+"&fec_fin="+xfec_fin+"&obs="+obs+"&accion=grabar_incidencia";


//alert(pag1)

	
	ajaxc1 = createRequest();
    ajaxc1.open("get", pag1, true);
    ajaxc1.onreadystatechange = function () {
		
		//alert(ajaxc1.responseText)  	
		
        if (ajaxc1.readyState == 4) {																	
			alert("Se registro exitosamente")	
			//parent.ras.hide();
				parent.window.close();
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
function exportar_prog_extra(opc){
	
	var iduser = document.getElementById("iduser").value;
	var dni = document.getElementById("dni").value;
	var cip = document.getElementById("cip").value;
	
	if (document.getElementById("dni").value==""){
			alert("Ingrese DNI")
			return	
	}
	
	
	if (opc==1){			
	var page="reportes_prog_extras_individual.php?dni="+dni+"&cip="+cip+"&iduser="+iduser;
	window.open(page);	
	}	
			
		
}

