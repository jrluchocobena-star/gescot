<?php
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pwd = '';
	$db_name = 'cot';
	
	$conn = mysql_connect($db_host, $db_user, $db_pwd);
	if (!$conn) {
	   die('No se pudo conectar a la base de datos ' . mysql_error());
	}
	$db_selected = mysql_select_db($db_name, $conn);
	
	if(!$db_selected)
	  echo 'No se pudo elegir a la Base de Datos';
	return $conn;

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<!--
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tabledit.js"></script>
<script type="text/javascript" src="js/custom_table_edit.js"></script>
-->
</head>

<body>

<table id="data_table" class="table table-striped">
<thead>
<tr>
<th>Id</th>
<th>Name</th>
<th>Gender</th>
<th>Age</th>
<th>Designation</th>
<th>Address</th>
</tr>
</thead>
<tbody>
<?

$sql_query = "SELECT id, a.dni, b.ncompleto, b.cip   
FROM cab_incidencia a, tb_usuarios b WHERE a.dni=b.dni OR a.cip=b.cip GROUP BY 1";

$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
while( $reg_sql = mysqli_fetch_assoc($resultset) ) {
?>
<tr id="<? echo $reg_sql[0]; ?>">
<td><? echo $reg_sql [1]; ?></td>
<td><? echo $reg_sql [2]; ?></td>
</tr>
<? } ?>
</tbody>
</table>

</body>
</html>