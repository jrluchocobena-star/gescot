<?php 

function db_conn_mysql() {

 $db_host 	= 'localhost';
 $db_user	= 'root';
 $db_pwd 	= '';
 $db_name 	= 'cot';
 
 $conn = mysql_connect($db_host, $db_user, $db_pwd);
 
 //echo $conn."<br>";

  if (!$conn) {    
		 die('Problemas de conexion al MYSQL' . mysql_error());
		 header("location: http://localhost/cot/relogeo.php");
  }else{
	   $db_selected = mysql_select_db($db_name, $conn);
	  // echo "Conectado a MYSQL OK";
	   
	   if(!$db_selected){
		 echo '...........No se pudo elegir a la Base de Datos';
	   //sreturn $conn;
	   }
  }
  
  return $conn;
   
}

function db_conn_teradata() {
  // establish connection
  //$connection=odbc_connect('mysql_teradata','ic_ccespedes','lzm142chj');
  $server  		= "10.226.4.214";
  $database 	= "dbi_cot";
  $user  		= "ic_lcobena";
  $password 	= "Lc0b3n4#";

$connection = odbc_connect("Driver={Teradata DataBase ODBC Driver 16.20};DBCNAME=$server;Database=$database;", $user, $password);

  //echo $connection;

  if (!$connection){
   exit("Connection Failed - ".odbc_error().": error".odbc_errormsg()."\n");  
   header("location: http://localhost/cot/relogeo.php");
  
  } 
  else {
   // echo "Conectado a TERADATA OK";
  
  }
  
  return $connection;
  
}

?> 