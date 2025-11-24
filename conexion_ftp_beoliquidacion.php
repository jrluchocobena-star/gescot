<?php

// Establecer la conexión
		$ftp_server='10.226.44.223';
		$ftp_user_name='atento_cot';
		$ftp_user_pass='4t3nt0c0t';
		$conn_id = ftp_connect($ftp_server);
		
		$ruta_server ="/GCOT/R414/";
		//$archivo=$ruta."F_".date("Y").date("m").date("d")."_".date("H").".csv";
		$archivo_server="VERDE_20180717_15.csv";
		
		//echo $archivo;
		/*
		$local_file = 'D:/DATA_COT/BEOLIQUIDACION/'.$archivo_server; //Nombre archivo en nuestro PC
		$server_file = $ruta_server.$archivo_server; //Nombre archivo en FTP
		
			
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
		*/
		
		
		$directorio=dir($ruta_server);

		//y ahora lo vamos leyendo hasta el final
		while ($archivo = $directorio->read()){
		//
		if (date("d")=="01"){
			if ((date("m")-1)<10){ 
				$valor_ant="0".(date("m")-1).date("Y")	;
			}else{
				$valor_ant=(date("m")-1).date("Y")	;
				}
		}else{
			$valor_ant=date("m").date("Y")	;
		}
		
		$src=substr($archivo,11,6); 
		
		$ext =  explode(".",$archivo);
		//echo "<br>".$ext[0];
			if ($src==$valor_ant){	
				if ($ext[1]=="csv"){			 	
				 $n_arch=$ext[0];
				}
			}
		
		//echo "<p>".$valor_ant;
		//echo "<p>".$archivo;
		//echo "<p>".$src;
		//echo "<p>".$valor_ant;
		
		
		}
		//descargo el objeto
		return $ext[0];
		$directorio->close();	

		
?>