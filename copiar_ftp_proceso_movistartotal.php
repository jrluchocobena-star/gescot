<? 
// Establecer la conexión
		
		$ftp_server_origen		='10.226.157.180';
		$ftp_user_origen		='coc-consulta';
		$ftp_pass_origen		='123456';
		$conn_id_origen 		= ftp_connect($ftp_server);		
		$server_file_origen		= '//10.226.157.180/coc/pdte_prov/xls_/rep_movtotal.xlsx'; //Nombre archivo en FTP
			
		$ftp_server_destino		= '10.226.44.223';
		$ftp_user_destino		= 'atento_usuario';		
		$ftp_pass_destino		= 'cfb29bb832';		
		$conn_id_destino		= ftp_connect($ftp_server);		
		$local_file 			= '//10.226.44.223/PROYECTO_MOVISTAR_TOTAL_RUTAS/Bases/'; //Nombre archivo en nuestro PC	

		// Loguearse con usuario y contraseña
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		// Descarga el $server_file y lo guarda en $local_file
		if (ftp_get($conn_id, $local_file, $server_file_origen, FTP_BINARY)) {
		//echo "Se descargado el archivo $server_file con éxito\n";
		} else {
		echo "Ha ocurrido un error\n";
		}
		
		// Cerrar la conexión
		ftp_close($conn_id);
				
?>
