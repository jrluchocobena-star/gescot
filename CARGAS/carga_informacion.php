<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript"> 

function ajaxL() 
{ 
  var objetoAjax=false; 
  try { 
       objetoAjax = new ActiveXObject('Msxml2.XMLHTTP'); 
       } 
  catch (e) 
  { 
    try { 
        objetoAjax = new ActiveXObject('Microsoft.XMLHTTP'); 
        } 
    catch (E)  
    { 
        objetoAjax = false; 
    } 
  } 

    if (!objetoAjax && typeof XMLHttpRequest != 'undefined')  
    { 
           objetoAjax = new XMLHttpRequest(); 
    } 
     return objetoAjax; 
} 



 function load() 
{   
   var ajax = ajaxL();    
   var divContenedor =  document.getElementById("load"); 
   var divContenedorDatos =  document.getElementById("data"); 

    ajax.open("GET","importar_data_contactos.php");                                     
     
   ajax.onreadystatechange = function()     
   {        
     if(ajax.readyState <= 3) 
      { 
         divContenedor.style.display = 'block';   
      } 

     if(ajax.readyState == 4)         
     { 
         divContenedorDatos.innerHTML = ajax.responseText; //resposta del server con los datos              
         divContenedor.style.display = 'none' 

       }     
   } 
ajax.send(null); 
}  

window.onload = function()  
{ 
      load(); 
} 
</script> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<div id="load" 
style="display:none;position:absolute;top:0;bottom:0%;left:0;right:0%;z-index:99;height:300px;width:300px;background-image:url(file:///D|/xampp/htdocs/images/loading1.gif);"></div> 

<div id="data" style="width: 300px; height: 300px; float: left;"></div> 
</body>
</html>