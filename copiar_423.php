<?php
include ("conexion.php");
include ("conexion_ftp.php");

		$dia=date('Y-m-d');
		//$dia='2018-04-24';
		$local_file = "D:\data_cot\Gestel423\glpl494_".$dia.".txt"; //Nombre archivo en nuestro PC		
		$server_file = '/home/geslis/lcobena0/glpl494.txt'; //Nombre archivo en FTP		
		
		
		 // Procedemos a borrar
		 if (!unlink($local_file)) {
			  // Error al borrar.
			  echo 'Error al borrar';
		 } else {
			  // Archivo eliminado
			  echo 'Archivo eliminado';
		 }
		
	
		// Loguearse con usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		// Descarga el $server_file y lo guarda en $local_file
		if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
		echo "Se descargado el archivo con éxito\n";
		} else {
		echo "Ha ocurrido un error\n";
		}
		
		// Cerrar la conexión
		ftp_close($conn_id);


		
?>