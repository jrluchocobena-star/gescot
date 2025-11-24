<?php
ini_set("display_errors", "On");
error_reporting(E_ALL ^ E_NOTICE);


function db_conn()
{
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pwd = '';
	$db_name = 'COT';
	
	$conn = mysql_connect($db_host, $db_user, $db_pwd);
	if (!$conn) {
	   die('No se pudo conectar a la base de datos ' . mysql_error());
	}
	$db_selected = mysql_select_db($db_name, $conn);
	if(!$db_selected)
	  echo 'No se pudo elegir a la Base de Datos';
	return $conn;
  
}

db_conn();



?>
