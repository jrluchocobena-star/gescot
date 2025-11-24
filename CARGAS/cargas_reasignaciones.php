<? 
	
	$sw=1;		

	for ($sw=1 ; $sw<11 ; $sw++){
		
		if ($sw==1)	{
			$archivo="LIMA_".date("Y-m-d");
			$sw=2;			
		}
		
		if ($sw==2)	{
			$archivo="ARE_".date("Y-m-d");
			$sw=3;			
		}
		
		if ($sw==3)	{
			$archivo="CHB_".date("Y-m-d");
			$sw=4;			
		}
		
		if ($sw==4)	{
			$archivo="CHY_".date("Y-m-d");
			$sw=5;			
		}
	}
	
	
	$local_file = 'd:/data_cot/Reasignaciones_47D/'.$archivo; //Nombre archivo en nuestro PC
	$server_file = '/home/geslis/lcobena0/gppl480_r_fecusu.txt'; //Nombre archivo en FTP
		
		// Establecer la conexión
		$ftp_server='10.4.3.220';
		$ftp_user_name='lcobena0';
		$ftp_user_pass='abc00abc';
		$conn_id = ftp_connect($ftp_server);
		
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