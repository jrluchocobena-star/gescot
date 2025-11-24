<?php

// Establecer la conexión
		$ftp_server='10.4.40.49';
		$ftp_user_name='usrftpcot';
		$ftp_user_pass='usrC0T29$';
		$conn_robot = ftp_connect($ftp_server);
		/*
		$file = fopen("d:/macros/acceso/gestel.ini", "r") or exit("Unable to open file!");
		//Output a line of the file until the end is reached
		
		$fila = 0;
		while(!feof($file))
		{
			$linea  = fgets($file);	//echo "<br>".$linea;		
				if ($fila==2){
				$ftp_user_pass = trim(substr($linea, 9, 15));						
				}
			$fila=$fila + 1;
		}
		fclose($file);
		*/
?>