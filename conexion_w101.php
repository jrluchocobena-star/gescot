<?php 

function db_conn_cot() {

 $db_host 	= 'localhost';
 $db_user	= 'root';
 $db_pwd 	= '';
 $db_name 	= 'cot';
 
 $conn = mysql_connect($db_host, $db_user, $db_pwd);
 
 //echo $conn."<br>";

  if (!$conn) {    
    // die('..........No se pudo conectar a la base de datos ' . mysql_error());
     header("location: http://localhost/cot/relogeo.php");
  }else{
   $db_selected = mysql_select_db($db_name, $conn);
   
   if(!$db_selected){
     echo '...........No se pudo elegir a la Base de Datos';
   //sreturn $conn;
   }
  }
  
  return $conn;
   
}

function db_conn_w101() {
  // establish connection
  //$connection=odbc_connect('mysql_teradata','ic_ccespedes','lzm142chj');
  $db_host_101 		= "10.226.44.223"; 
  $db_user_101  	= "jvillanueva";
  $db_pwd_101	 	= "#tbuEyKIxj3$";
  $db_name_101	 	= 'asignaciones';
  
  $conn_w101 = mysql_connect($db_host_101, $db_user_101, $db_pwd_101);
 
 //echo $conn."<br>";

  if (!$conn_w101) {    
    // die('..........No se pudo conectar a la base de datos ' . mysql_error());
     header("location: http://localhost/cot/relogeo.php");
  }else{
   $db_selected_101 = mysql_select_db($db_name_101, $conn_w101);
   
   if(!$db_selected_101){
     echo '...........No se pudo elegir a la Base de Datos';
   //sreturn $conn;
   }
  }
  
  return $conn_w101;
  
}

//echo "Conexion = ".$connection;


?> 