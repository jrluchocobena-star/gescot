<?php
 
/**
 * Connects and disconnects to an FTP server.
 */
class TmFtpServer {
 
	public $servername;
	public $user;
	public $pass;
	public $path;
	private $conn_id;
	protected $connected = FALSE;
	private $messageArray = array();

	private function logMessage($message) 
	{
		$this->messageArray[] = $message;
	}

	public function getMessages()
	{
		return $this->messageArray;
	}

 
  /**
   * Initializes variables.
   * 
   * @param string $name Server name.
   * @param string $user Username.
   * @param string $pass Password.
   * @param string $path Remote start path.
   */
   
	public function __construct($servername, $user, $pass, $path) {
		$this->servername = $servername;
		$this->user = $user;
		$this->pass = $pass;
		$this->path = $path;
	}
 
	/**
	* Logs in to FTP server and changes to a directory.
	*/
	public function openConnection() {
		if (!$this->connected) {
			$this->conn_id = ftp_connect($this->servername);
			if ($this->conn_id !== FALSE // Connection successful?
				&& ftp_login($this->conn_id, $this->user, $this->pass) // Logs in.
				&& ftp_chdir($this->conn_id, $this->path)) { // Changes directory.
				$this->connected = TRUE; // Records success.
			}
		}
		return $this;
	}

	/**
	* Gets the connection id.
	* 
	* @return resource An FTP Stream.
	*/
	public function getConnID() {
		return $this->conn_id;
	}

	/**
	* Closes the connection.
	*/
	public function closeConnection() {
		ftp_close($this->conn_id);
		$this->connected = FALSE;
		return $this;
	}

	/**
	* Gets the connection status.
	* 
	* @return boolean TRUE if an FTP connetion is established. 
	*/
	public function getConnectionStatus() {
		return $this->connected;
	}
}
 
/**
 * Retrieves a listing of files and directories on a Windows FTP server.
 */
class TmFtpServerWinFileListing {
 
  protected $server;
  protected $filelist = array();
  protected $directories_to_skip = array();
  protected $file_patterns_to_skip = array();
  protected $depth_reached = 0;
  protected $count = 0;
 

  public function __construct(TmFtpServer $server) {
    $this->server = $server;
  }
 
  /**
   * Ensures FTP connection is closed.
   */
  public function __destruct() {
    if ($this->server->getConnectionStatus()) {
      $this->server->closeConnection();
    }
  }
 
 
  /**
   * Gets file list.
   *
   * @param int $depth_max Maximum depth to traverse. Set to 0 for unlimited.
   * @param boolean $show_directories Show directories in listing.
   * @param string $path The base directory.
   * @return array indexed array where each value is a path to a filename or directory.
   */
  public function getFileList($depth_max = 3, $show_directories = TRUE, $path = '') {
    $rawlist = $this->getRawList($path);
    // Gets current depth of path.
    $depth = substr_count($path, '/');
    if ($depth > $this->depth_reached) {
      $this->depth_reached = $depth;
    }
    // Opens the connection to the server if not already opened.
    foreach ($rawlist as $line) { // Loops through the directory listing.
      $item = preg_split('/[\s]+/', $line); // Puts the raw string into an array.
      $name = $this->getNameFromLineItem($item, $line); // Gets the filename.
      if ($item[2] == '<DIR>') { // Is a directory.
        if ($show_directories) { // Includes directories in listing.
          $file = new stdClass();
          $file->size = 0;
          $file->path = $path;
          $file->name = $name;
          $this->filelist[] = $file;
        }
        if (!$this->isSkipDir("$path/$name")) { // Directory is not marked to be skipped.
          if (!$depth_max || $depth < $depth_max) { // Only recurses if max_depth hasn't been reached.
            $this->getFileList($depth_max, $show_directories, "$path/$name"); // Recurses.
          }
        }
      } else if (!$this->isSkipFilePattern("$path/$name")) { // Is a file and it isn't marked to be skipped.
        // Adds to the filelist.
        $file = new stdClass();
        $file->size = (int) $item[2];
        $file->path = $path;
        $file->name = $name;
        $this->filelist[] = $file;
      }
      $this->count++;
      if ($this->count % 50 === 0) {
        error_log("$this->count lines processed");
      }
    }
    return $this->filelist;
  }
 
  /**
   * Gets depth; only useful after running getFileList().
   * 
   * @return int 
   */
  public function getDepthReached() {
    return $this->depth_reached;
  }
 
  /**
   * Gets and FTP Rawlist
   * 
   * @return array
   */
  public function getRawList($path) {
    // Sets the path on the first pass.
    if (!$path) {
      $path = $this->server->path;
    }
    $this->server->openConnection();
    $rawlist = ftp_rawlist($this->server->getConnID(), $path);
    $this->server->closeConnection();
    return $rawlist;
  }
 
  /**
   * Extracts name from ftp rawlist line item.
   */
  protected function getNameFromLineItem($item, $line) {
    $line = str_replace(array($item[0], $item[1], $item[2]), '', $line);
    return ltrim($line);
  }
 
  /**
   * Gets directories to skip.
   */
  public function getDirectoriesToSkip() {
    if (!$this->directories_to_skip) {
      $this->setDirectoriesToSkip();
    }
    return $this->directories_to_skip;
  }
 
  /**
   * Sets directories to skip. 
   */
  public function setDirectoriesToSkip($directories = array()) {
    $this->directories_to_skip = $directories;
    return $this;
  }
 
  /**
   * Checks to see if a directory is marked to be skipped.
   */
  protected function isSkipDir($path) {
    $directories_to_skip = $this->getDirectoriesToSkip();
    foreach ($directories_to_skip as $dir) {
      if (strpos($path, "/drupaldev$dir") === 0) {
        return TRUE;
      }
    }
    return FALSE;
  }
 
  /**
   * Gets file patterns to skip.
   */
  public function getFilePatternsToSkip() {
    if (!$this->file_patterns_to_skip) {
      $this->setFilePatternsToSkip();
    }
    return $this->file_patterns_to_skip;
  }
 
  /**
   * Sets file patterns to skip. 
   */
  public function setFilePatternsToSkip($file_patterns_to_skip = array()) {
    $this->file_patterns_to_skip = $file_patterns_to_skip;
    return $this;
  }
 
  /**
   * Checks to see if a file pattern is marked to be skipped.
   */
  protected function isSkipFilePattern($path) {
    $file_patterns_to_skip = $this->getFilePatternsToSkip();
    foreach ($file_patterns_to_skip as $pattern) {
      if (strstr($path, $pattern)) {
        return TRUE;
      }
    }
    return FALSE;
  }

	public function downloadFile ($fileFrom, $fileTo)
	{
		// *** Set the transfer mode
/* 		$asciiArray = array('txt', 'csv');
		$seprarar = explode('.', $fileFrom);
		$extension = end($separar);
		if (in_array($extension, $asciiArray)) {
			$mode = FTP_ASCII;      
		} else {
			$mode = FTP_BINARY;
		} */
		$this->server->openConnection();
		// try to download $remote_file and save it to $handle
		if (ftp_get($this->server->getConnID(), $fileTo, $fileFrom, FTP_ASCII, 0)) {
			#$this->logMessage(' file "' . $fileTo . '" successfully downloaded');
			return true;
			
		} else {
			#$this->logMessage('There was an error downloading file "' . $fileFrom . '" to "' . $fileTo . '"');
			return false;	
		}
		$this->server->closeConnection();
	}

	public function deleteFile ()
	{
		$this->server->openConnection();
		// try to download $remote_file and save it to $handle
		$files = ftp_nlist($conn_id, ".");
		foreach ($files as $file)
		{
			#ftp_delete($conn_id, $file);
		}  
		$this->server->closeConnection();
	}

}

/**
* Directorio Local donde se copiaran los archivos
*/
$src_dir='D:/Cargas/Agendamiento';

/**
* Obtiene archivo reporte_agendas.csv
*/
$servername = '10.226.44.223';
$user = 'atento_cot';
$pass = '4t3nt0c0t';
$depth_max = 1;
$show_directories = FALSE;
$directories_to_skip = array('/private', '/home');
$file_patterns_to_skip = array('.DS_Store');
$path = '/';

$server = new TmFtpServer($servername, $user, $pass, $path);
$listing = new TmFtpServerWinFileListing($server);
$files = $listing->setDirectoriesToSkip($directories_to_skip)
		->setFilePatternsToSkip($file_patterns_to_skip)
		->getFileList($depth_max, $show_directories);

$filename_in='reporte_agendas.csv';
$filename_out='BO_AGENDAMIENTO_AVERIAS_'.date('Ymd').'_'.date('H').'.csv';
$csv_sep=',';
$csv_end = '  
';
$csv='';

if($listing->downloadFile($filename_in,$src_dir."/".$filename_in))
{
	print "Archivo ".$filename_in." se descargó correctamente <br />\n";
}
else{
	print "No se pudo descargar a PC archivo ".$filename_in." <br />\n";
}

/**
* Leemos el archivo reporte_agendas.csv
*/
if (($agendas = fopen($src_dir.$path.$filename_in, "r")) !== FALSE) {
	$numeroDeFila = 1;
	$csv.='QUIEBRE'.$csv_sep.'ATENCION'.$csv_sep.'FUENTE'.$csv_sep.'CODACTU'.$csv_sep.'CODCLI'.$csv_sep.'TIPOAVERIA'.$csv_sep.'CLIENTENOMBRE'.$csv_sep.'CLIENTECELULAR'.$csv_sep.'CLIENTETELEFONO'.$csv_sep.'CLIENTECORREO'.$csv_sep.'CLIENTEDNI'.$csv_sep.'CONTACTONOMBRE'.$csv_sep.'CONTACTOCELULAR'.$csv_sep.'CONTACTOTELEFONO'.$csv_sep.'CONTACTOCORREO'.$csv_sep.'CONTACTODNI'.$csv_sep.'EMBAJADORNOMBRE'.$csv_sep.'EMBAJADORCORREO'.$csv_sep.'EMBAJADORCELULAR'.$csv_sep.'EMBAJADORDNI'.$csv_sep.'COMENTARIO'.$csv_sep.'FH_REG104'.$csv_sep.'FH_REG1L'.$csv_sep.'FH_REG2L'.$csv_sep.'CODMULTIGESTION'.$csv_sep.'LLAMADOR'.$csv_sep.'TITULAR'.$csv_sep.'Direccion'.$csv_sep.'Distrito'.$csv_sep.'Urbanizacion'.$csv_sep.'TELF_GESTION'.$csv_sep.'TELF_ENTRANTE'.$csv_sep.'OPERADOR'.$csv_sep.'MOTIVO_CALL'.$csv_end;
	$quiebre='BO AGENDAMIENTO AVERIA';
	$atencion='Normal - Masivo';
	$tipo_averia='Television';
	$fuente='Otros2';
    while (($datos = fgetcsv($agendas, 1000)) !== FALSE) {
		
        // Procesar los datos.
        // En $datos[0] está el valor del primer campo,
        // en $datos[1] está el valor del segundo campo, etc...
		if ($numeroDeFila == 1){
			$numeroDeFila++;
		}elseif($datos[17]=='AGENDA AVERIAS COT'){
			$csv.=$quiebre.$csv_sep.$atencion.$csv_sep.$fuente.$csv_sep.$datos[7].$csv_sep.$datos[1].$csv_sep.$tipo_averia.$csv_sep.$datos[6].$csv_sep.$datos[5].$csv_sep.$datos[4].$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.''.$csv_sep.'Comentario: '.str_replace(',', '.', $datos[8]).'.Fecha Agenda: '.$datos[9].'.Turno: '.$datos[16].$csv_sep.$datos[14].$csv_sep.''.$csv_sep.''.$csv_sep.$datos[7].$csv_end;
			$numeroDeFila++;
			}
    }
	//Generamos el csv de todos los datos  
	if (!$handle = fopen($src_dir.$path.$filename_out, "w")) {  
		echo "Cannot open file";  
		exit;  
	}
	if (fwrite($handle, utf8_decode($csv)) === FALSE) {  
		echo "Cannot write to file";  
		exit;  
	}  
	fclose($handle);
}


/**
* Configuración del FTP Atento


$servername_at = '10.226.44.223';
$user_at = 'atento_usuario';
$pass_at = 'cfb29bb832';
$depth_max_at = 1;
$path_at = '/PROYECTO_MOVISTAR_TOTAL_RUTAS/Bases';

$server_at=new TmFtpServer($servername_at, $user_at, $pass_at, $path_at);
#$listing_at=new TmFtpServerWinFileListing($server_at);
$server_at->openConnection();
**/
$server->openConnection();

/**
* Eliminamos archivos en FTP.


$files = ftp_nlist($server_at->getConnID(), ".");
foreach ($files as $file)
{
	ftp_delete($server_at->getConnID(), $file);
    print "Archivo Eliminado en FTP: ".$file."<br />\n";	
}
**/

/**
* Cargamos archivos en FTP.
**/

$dst_dir='/PREFIJOS/AGENDAMIENTO';

/**
$d = dir($src_dir);
while($file = $d->read()) { // do this for each file in the directory
	if ($file != "." && $file != "..") { // to prevent an infinite loop
		if (!is_dir($src_dir."/".$file)) { // do the following if it is not a directory
			$upload = ftp_put($server_at->getConnID(), $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY); // put the files
			print "Archivo cargado al FTP: ".$file. "<br />\n";
		}
	}
}
**/

if (!is_dir($src_dir."/".$filename_out)) { // do the following if it is not a directory
	$upload = ftp_put($server->getConnID(), $dst_dir."/".$filename_out, $src_dir."/".$filename_out, FTP_BINARY); // put the files
	print "Archivo cargado al FTP: ".$filename_out. "<br />\n";
}

//$d->close();
$server->closeConnection();

/**
* Eliminamos archivos locales.


$local_files = glob($src_dir.'/*'); //obtenemos todos los nombres de los ficheros
foreach($local_files as $file){
    if(is_file($file)){
		unlink($file); //elimino el fichero
		print "Archivo eliminado en PC: ".$file."<br />\n";
	}
}*/
?>