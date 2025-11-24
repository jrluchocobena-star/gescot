<?
		$fileTmpPath = $_FILES['nombre_archivo']['tmp_name'];
		$fileName = $_FILES['nombre_archivo']['name'];
		$fileSize = $_FILES['nombre_archivo']['size'];
		$fileType = $_FILES['nombre_archivo']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));		
		$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
		
		
		$allowedfileExtensions = array('jpg', 'csv', 'png', 'zip', 'txt', 'xls', 'doc');
		$uploadFileDir = 'd://';
		$dest_path = $uploadFileDir . "masivo_ussd.csv";
		 
		if(move_uploaded_file($fileTmpPath, $dest_path))
		{
		  $message ='File is successfully uploaded.';
		}
		else
		{
		  $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
		}
				
?>