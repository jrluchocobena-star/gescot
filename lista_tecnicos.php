<?php
include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$cip=trim($_GET["cip"]);
$dni=trim($_GET["dni"]);
$tecnico=trim($_GET["tecnico"]);

if ($cip=="" and $dni==""){
	$cad=" where carnet='$tecnico'";	
}else{
	if ($cip==""){
		$cad=" where dni='$dni'";	
	}else{
		$cad=" where carnet like '%$cip%'";	
	}
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<? 

	$lista="select * from tb_tecnicos $cad order by ncompleto desc";
	//echo $lista;
	$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'  style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>DNI </td>";	
			echo "<td class='fdotxttabla2'>CIP </td>";														
			echo "<td class='fdotxttabla2'>NOMBRE COMPLETO </td>";	
			echo "<td class='fdotxttabla2'>CELULAR </td>";																
			echo "<td class='fdotxttabla2'>RPM</td>";		
			echo "<td class='fdotxttabla2'>CORREO</td>";			
			echo "<td class='fdotxttabla2'>ESTADO</td>";					
			echo "<td class='fdotxttabla2'>ZONA</td>";
			echo "<td class='fdotxttabla2'>CONTRATA</td>";			
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	     

		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[1]; 				
		echo "</td>";			
		

		echo "<td class='casilla_texto'>";
		echo $reg_lis[2]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[3]; 				
		echo "</td>";


		echo "<td class='casilla_texto'>";
		echo $reg_lis[4]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[5]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[7]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>";
		echo $reg_lis[12]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>";
		echo $reg_lis[14]; 				
		echo "</td>";
		
		
		echo "</tr>";				
		}	
	echo "</table>";
	

?>

</body>
</html>