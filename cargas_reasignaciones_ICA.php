<?php
include("conexion_ftp.php");


	$archivo="GESTEL_47D_ICA_".date("Y-m-d").".txt";
	
	$local_file = 'u:/data_cot/Reasignaciones_47D/'.$archivo; //Nombre archivo en nuestro PC
	$server_file = '/home/geslis/mcancha2/gppl480_r_fecusu.txt'; //Nombre archivo en FTP
		
		
		// Loguearse con usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		// Descarga el $server_file y lo guarda en $local_file
		if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
		echo "Se descargado el archivo con éxito\n";
		
			if (ftp_delete($conn_id, $server_file)) {
			 echo "$file se ha eliminado satisfactoriamente\n";
			} else {
			 echo "No se pudo eliminar $file\n";
			}
			
		
		} else {
		echo "Ha ocurrido un error\n";
		}
		
		
		

		// Cerrar la conexión
		ftp_close($conn_id);
		
	
?>		