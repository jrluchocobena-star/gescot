<?php
include ("conexion_bd.php"); 

$consultaUsuarios = mysql_query("SELECT * FROM tb_usuarios");
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">

<script src="js/bootstrap.min.js"> </script>
<script src="js/bootstrap.js"> </script>
<script src="js/bootstrap.bundle.js"></script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Documento sin título</title>
</head>

<body>


<div class="table-striped "> 
   <table class="table table-bordered table-striped">
	<thead> 
           <tr>
              <!-- definimos cabeceras de la tabla --> 
              <th>Nombre</th> 
              <th>Teléfono</th> 
              <th>Email</th>
           </tr> 
        </thead>
        <tbody>
	<?php
           //recorremos resultado de la consulta y añadimos el contenido a la tabla
	   while($row= mysql_fetch_array($consultaUsuarios)) 
	   {
              echo "<tr>";
              echo "<td>".$row['ncompleto']."</td>";
              echo "<td>".$row['login']."</td>";
	      echo "<td>".$row['pass']."</td>";
              echo "</tr>";
           }			
        ?>
       </tbody>
   </table>
</div>

</body>
</html>