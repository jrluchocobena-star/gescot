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
		$this->server->openConnection();
		// try to download $remote_file and save it to $handle
		if (ftp_get($this->server->getConnID(), $fileTo, $fileFrom, FTP_ASCII, 0)) {
			return true;
			
		} else {
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

date_default_timezone_set('America/Lima');

/**
* Directorio Local donde se copiaran los archivos
*/
$src_dir='D:/cot';

/**
* Directorio Local donde se copiaran los log
*/
$src_log='D:/LOG';
$name_log='ftp_atento.txt';

/**
* Abrimos el archivo log, si no existe se crea
*/
$gestor=fopen($src_log.'/'.$name_log, "a");

/**
* Agregamos cabecera de inicio
*/
fwrite($gestor,"\r\n");
fwrite($gestor,"\r\n");
fwrite($gestor,"******************************************* \r\n");
fwrite($gestor,date("j F, Y, g:i a")."\r\n");
fwrite($gestor,"******************************************* \r\n");
/**
* Obtiene archivos de ftp://10.4.40.49/canceladas/precarga/
*/
$servername = '10.4.40.49';
$user = 'usrftpcot';
$pass = 'usrC0T29$';
$depth_max = 1;
$show_directories = FALSE;
$directories_to_skip = array('/private', '/home');
$file_patterns_to_skip = array('.DS_Store');
$path = '/usrftpcot/canceladas/precarga';

$server = new TmFtpServer($servername, $user, $pass, $path);
$listing = new TmFtpServerWinFileListing($server);
$files = $listing->setDirectoriesToSkip($directories_to_skip)
		->setFilePatternsToSkip($file_patterns_to_skip)
		->getFileList($depth_max, $show_directories);

$file_comercial='Comercial_'.date('Ymd');
$file_tecnicas='Tecnicas_'.date('Ymd');

foreach ($files as $file) {
	$filename = $file->name;
	if(substr($filename,0,18) == $file_comercial){
		if($listing->downloadFile($filename,$src_dir."/".$filename))
		{
			print "Archivo ".$filename." descargado a PC \n";
			fwrite($gestor,"Archivo ".$filename." descargado a PC \r\n");
		}
		else{
			print "No se pudo descargar a PC archivo ".$filename."\n";
			fwrite("No se pudo descargar a PC archivo ".$filename."\r\n");
		}
	}else if (substr($filename,0,17) == $file_tecnicas){
		if($listing->downloadFile($filename,$src_dir."/".$filename))
		{
			print "Archivo ".$filename." descargado a PC \n";
			fwrite($gestor,"Archivo ".$filename." descargado a PC \r\n");
		}
		else{
			print "No se pudo descargar a PC archivo ".$filename."\n";
			fwrite($gestor, "No se pudo descargar a PC archivo ".$filename."\r\n");
		}
	}
}

/**
* Obtiene archivo Online_Comercial_ult_vuelta.txt
*/

$file_origen='\\\\gppesvlcli1003\\FS Explotacion\\ReportesBI\\TorreControl\\Online_Comercial_ult_vuelta.txt';
$file_destino=$src_dir.'/Online_Comercial_ult_vuelta.txt';
if(copy($file_origen,$file_destino))
{
	print "Archivo Online_Comercial_ult_vuelta.txt descargado a PC \n";
	fwrite($gestor, "Archivo Online_Comercial_ult_vuelta.txt descargado a PC \r\n");
}
else{
	print "No se pudo descargar a PC archivo Online_Comercial_ult_vuelta.txt \n";
	fwrite($gestor, "No se pudo descargar a PC archivo Online_Comercial_ult_vuelta.txt \r\n");
}


/**
* Obtiene archivo eje_pen.xlsx


$file_origen='\\\\10.226.157.180\\coc\\pdte_prov\\eje_pen.xlsx';
$file_destino=$src_dir.'/'.date('Ymd').'_eje_pen.xlsx';
if(copy($file_origen,$file_destino))
{
	print "Archivo eje_pen.xlsx descargado a PC \n";
}
else{
	print "No se pudo descargar a PC archivo eje_pen.xlsx \n";
}
*/

$file_origen_ejepen='eje_pen'.date('ym').".xlsx";
$file_origen='\\\\Gppesvlcli2259\\Planificacion\\01_Reportes\\04_Eje_Pen\\'.$file_origen_ejepen;
$file_destino=$src_dir.'/'.date('Ymd').'_eje_pen.xlsx';
$file_last_modified = filemtime($file_origen);
$current_file_date = date("d/m/Y", $file_last_modified);
$current_date =date("d/m/Y");
if($current_date==$current_file_date)
{
	if(copy($file_origen,$file_destino))
	{
		print "Archivo ". $file_origen_ejepen ." descargado a PC \n";
		fwrite($gestor, "Archivo ". $file_origen_ejepen ." descargado a PC \r\n");
	}
	else{
		print "No se pudo descargar a PC archivo ". $file_origen_ejepen ." \n";
		fwrite($gestor, "No se pudo descargar a PC archivo ". $file_origen_ejepen ." \r\n");
	}
}
else{
	fwrite($gestor, "Archivo ".$file_origen_ejepen." NO ACTUALIZADO \r\n");
}

/**
* Obtiene archivo BASE_CONSOLIDADA_YYYYMMDD (del día anterior)
*/

$dir = "\\\\10.226.5.114\\FS-Principal\\Dir_Marketing\\Ger_Consumo_de_Terminales_y_Banda_Ancha\\Jefatura_de_Terminales\\000Cot\\zz_InputsExternos\\BaseConsolidada\\";
$anio=date('Y');
$mes=date('m');
$dia=date('d')-1;
$hoy=date('d');
$cardinal_dia=array("1"=>"01","2"=>"02","3"=>"03","4"=>"04","5"=>"05","6"=>"06","7"=>"07","8"=>"08","9"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25","26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31");
$dia=$cardinal_dia[$dia];
$file_consolidado="BASE_CONSOLIDADA_".$anio.$mes.$dia;
$file_consolidado_hoy="BASE_CONSOLIDADA_".$anio.$mes.$hoy;
$files = scandir($dir, 1);
#print_r($files);
foreach($files as $file) {
	if($file != '.' && $file != '..'){
		if (substr($file,0,25) == $file_consolidado){
			if(copy($dir.$file,$src_dir.'/'.$file))
			{
				print "Archivo base_consolidada de ayer descargado a PC \n";
				fwrite($gestor, "Archivo base_consolidada de ayer: ".$file_consolidado." descargado a PC \r\n");
			}
			else{
				print "No se pudo descargar a PC archivo base_consolidada de ayer \n";
				fwrite($gestor, "No se pudo descargar a PC archivo base_consolidada de ayer \r\n");
			}
		}
		
		if (substr($file,0,25) == $file_consolidado_hoy){
			if(copy($dir.$file,$src_dir.'/'.$file))
			{
				print "Archivo base_consolidada hoy descargado a PC \n";
				fwrite($gestor, "Archivo base_consolidada de hoy: ".$file_consolidado_hoy." descargado a PC \r\n");
			}
			else{
				print "No se pudo descargar a PC archivo base_consolidada de hoy \n";
				fwrite($gestor, "No se pudo descargar a PC archivo base_consolidada de hoy \r\n");
			}
		}		
		/*
 		else{
			print "No se encontro archivo base_consolidada del dia anterior: ".$dia."/".$mes."/".$anio."\n";
		} */
    }
}



/**
* Configuración del FTP Atento
*/

$servername_at = '10.226.44.223';
$user_at = 'atento_usuario';
$pass_at = 'cfb29bb832';
$depth_max_at = 1;
$path_at = '/PROYECTO_MOVISTAR_TOTAL_RUTAS/Bases';

$server_at=new TmFtpServer($servername_at, $user_at, $pass_at, $path_at);
$server_at->openConnection();

/**
* Eliminamos archivos en FTP.
*/

$files = ftp_nlist($server_at->getConnID(), ".");
foreach ($files as $file)
{
	ftp_delete($server_at->getConnID(), $file);
    print "Archivo Eliminado en FTP: ".$file."\n";
	fwrite($gestor, "Archivo Eliminado en FTP: ".$file."\r\n");
}


/**
* Cargamos archivos en FTP.
*/

$dst_dir=$path_at;
$d = dir($src_dir);
while($file = $d->read()) { // do this for each file in the directory
	if ($file != "." && $file != "..") { // to prevent an infinite loop
		if (!is_dir($src_dir."/".$file)) { // do the following if it is not a directory
			$upload = ftp_put($server_at->getConnID(), $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY); // put the files
			print "Archivo cargado al FTP: ".$file. "\n";
			fwrite($gestor, "Archivo cargado al FTP: ".$file. "\r\n");
		}
	}
}

$d->close();
$server_at->closeConnection();

/**
* Eliminamos archivos locales.
*/

$local_files = glob($src_dir.'/*'); //obtenemos todos los nombres de los ficheros
 foreach($local_files as $file){
    if(is_file($file)){
		unlink($file); //elimino el fichero
		print "Archivo eliminado en PC: ".$file."\n";
		fwrite($gestor, "Archivo eliminado en PC: ".$file."\r\n");
	}
}
fclose($gestor);
?>