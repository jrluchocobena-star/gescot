<?php 

function db_conn_switch() {
  // establish connection
  //$connection=odbc_connect('mysql_teradata','ic_ccespedes','lzm142chj');
 
 
  
	$connection="";
	  	
	if (!$connection){  //MYSQL
   
             $db_host 	= 'localhost';
             $db_user	= 'root';
             $db_pwd 	= '';
             $db_name 	= 'cot';
 
			 $conn = mysql_connect($db_host, $db_user, $db_pwd);
			 if (!$conn){
				exit("Connection Failed - ".odbc_error().": error".odbc_errormsg()."\n") ;				
			 }else{				
				return $conn."|"."1";
			 } 			 			         
	}else {
		
		 $server  		= "10.226.4.214";
		  $database 	= "dbi_public";
		  $user  		= "ic_ccespedes";
		  $password 	= "lzm142chj";
		  
		  $connection = odbc_connect("Driver={Teradata DataBase ODBC Driver 16.20};DBCNAME=$server;Database=$database;", $user, $password);
    	return $connection."|"."2";
    
  }
    
	
}


?> 