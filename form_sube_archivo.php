<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">

function sube_archivo() {
	var archivo=document.getElementById("archivo").value;
	alert("entro")	
	
	/*
	var carpeta_destino=document.getElementById("xruta").value;
	var archivo_destino=document.getElementById("xrut").value;
	var c_unico=document.getElementById("c_unico").value;
	
    var pagina_envio="subir_archivo1.php?carpeta_destino="+carpeta_destino+"&archivo_destino="+archivo_destino+"&c_unico="+c_unico;
	alert(pagina_envio)
    $("#miform").attr("action", pagina_envio);
    $("#miform").submit();
	*/
}

	
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
 <form action="subir_archivo.php" method="post" enctype="multipart/form-data">
 <input type="file" name="archivo" id="archivo"></input>
 <input type="submit" value="Subir archivo"></input>
 </form>

</body>
</html>