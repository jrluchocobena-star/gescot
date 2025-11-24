<?php
include("conexion_bd.php");
//include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$idperfil=$_GET["idperfil"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<input name="iduser" type="hidden" class="casilla_texto" id="iduser" value="<?php echo $iduser; ?>"/>
 <input name="idperfil" type="hidden" class="casilla_texto" id="idperfil" value="<?php echo $idperfil; ?>"/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>hola</td>
  </tr>
  <tr>
    <td>
	
   </td>
  </tr>
  <tr>
    <td>
	<video controls loop width="500" height="200">     
        <source src="video_001.mp4" type="video/mp4"> 
    </video>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
