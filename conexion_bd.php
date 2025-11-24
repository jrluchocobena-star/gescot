<?php
ini_set("display_errors", "On");
error_reporting(E_ALL ^ E_NOTICE);


function db_conn()
{
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pwd = '';
	$db_name = 'gescot';
	
	$conn = mysql_connect($db_host, $db_user, $db_pwd);
	
	//echo $conn."<br>";

		if (!$conn) {	   
		  // die('..........No se pudo conectar a la base de datos ' . mysql_error());
		   header("location: http://localhost/cot/relogeo.php");
		}else{
			$db_selected = mysql_select_db($db_name, $conn);
			
			if(!$db_selected){
			  echo '...........No se pudo elegir a la Base de Datos';
			//sreturn $conn;
			}
		}


}

db_conn();



function quitar_tildes($cadena) {
//	echo "entro";
$no_permitidas= array ("·","È","Ì","Û","˙","¡","…","Õ","”","⁄","Ò","¿","√","Ã","“","Ÿ","√ô","√ ","√®","√¨","√≤","√π","Á","«","√¢","Í","√Æ","√¥","√ª","√Ç","√ä","√é","√î","√õ","¸","√∂","√ñ","√Ø","√§","´","“","√è","√Ñ","√ã","—","Ò",'#([^.a-z0-9]+)#i','#-{2,}#','#|^-#¥-',
'"','/','//');
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","N","n",'','','','','','');
$texto = str_replace($no_permitidas, $permitidas ,$cadena);
return $texto;
}



function limpia_cadena($value){
    $new_string = preg_replace("[^'A-Za-z0-9 _]", "", $value);
   	return $new_string;
}

function limpiarCaracteres($cadena){
 	$cadena = trim($cadena);	
	$cadena = preg_replace('#([^.a-z0-9]+)#i', ' ', $cadena);
    $cadena = preg_replace('#-{2,}\"#',' ',$cadena);
    $cadena = preg_replace('#-$^#',' ',$cadena);
	return $cadena;
}

function validar_logeo($iduser){
	
	if ($iduser==""){
		 header("Location:mensaje_logeo.php");
	}
}

function archivo_log($ini,$iduser,$proceso1,$proceso2){	
$sql_="insert into tb_log values('$proceso1','$proceso2','$ini',now(),'$iduser','$proceso')";
echo "<BR>".$sql;
$res_sql_ = mysql_query($sql_) or die(mysql_error());	
}
			

function ObtenerIP()
{
if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
$ip = getenv("HTTP_CLIENT_IP");
else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
$ip = getenv("HTTP_X_FORWARDED_FOR");
else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
$ip = getenv("REMOTE_ADDR");
else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
$ip = $_SERVER['REMOTE_ADDR'];
else
$ip = "IP desconocida";
return($ip);
}


function limpia_espacios($cadena){
	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
}



function leer_ult_archivo($path){
$directorio=dir($path);

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

}

function get_nombre_dia($fecha){
   $fechats = strtotime($fecha); //pasamos a timestamp

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
switch (date('w', $fechats)){
    case 0: return "Domingo"; break;
    case 1: return "Lunes"; break;
    case 2: return "Martes"; break;
    case 3: return "Miercoles"; break;
    case 4: return "Jueves"; break;
    case 5: return "Viernes"; break;
    case 6: return "Sabado"; break;
}
}

function buscar($dir,&$archivo_buscar) {   // Funcion Recursiva 

echo "<br>".$dir,"|",$archivo_buscar;
    // Autor DeeRme 
    // http://deerme.org 
     if ( is_dir($dir) ) 
     { 
          // Recorremos Directorio 
          $d=opendir($dir);  
          while( $archivo = readdir($d) ) 
          { 
            if ( $archivo!="." AND $archivo!=".."  ) 
            { 
                  
                 if ( is_file($dir.'/'.$archivo) ) 
                 { 
                      // Es Archivo 
					  
                      if ( $archivo == $archivo_buscar  ) 
                      { 
						  //echo "archivo encontrado".$archivo;
                           return ($dir.'/'.$archivo); 
						   
						   
                    } 
                     
                } 
                  
                if ( is_dir($dir.'/'.$archivo) ) 
                { 
                     // Es Directorio 
                     // Volvemos a llamar 
                     $r=buscar($dir.'/'.$archivo,$archivo_buscar); 
                     if ( basename($r) == $archivo_buscar ) 
                     { 
                          return $r; 
                    } 
                      
                      
                } 
                   
                   
                 
                  
                  
            } 
                   
        } 
                   
    } 
    return FALSE; 
} 

function eliminar_simbolos($string){
 
    $string = trim($string);
 
    $string = str_replace(
        array('·', '‡', '‰', '‚', '™', '¡', '¿', '¬', 'ƒ'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('È', 'Ë', 'Î', 'Í', '…', '»', ' ', 'À'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('Ì', 'Ï', 'Ô', 'Ó', 'Õ', 'Ã', 'œ', 'Œ'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('Û', 'Ú', 'ˆ', 'Ù', '”', '“', '÷', '‘'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('˙', '˘', '¸', '˚', '⁄', 'Ÿ', '€', '‹'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('Ò', '—', 'Á', '«'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    $string = str_replace(
        array("\\", "®", "∫", "-", "~",
             "#", "@", "|", "!", "\"",
             "∑", "$", "%", "&", "/",
             "(", ")", "?", "'", "°",
             "ø", "[", "^", "<code>", "]",
             "+", "}", "{", "®", "¥",
             ">", "< ", ";", ",", ":",
             ".", " "),
        ' ',
        $string
    );
return $string;
} 

function reg_date($dt) { 
    // Fecha con dÌa y mes en EspaÒol
    $day = array("Domingo,", "Lunes,", "Martes,", "MiÈrcoles,", "Jueves,", "Viernes," ,"S·bado,");
    $month = array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    date_default_timezone_set("America/Buenos_Aires");
    $fecha_reg = $day[date('w', $dt)].date(" d", $dt)." de ".$month[date('n', $dt)]." de ".date("Y", $dt)." a las ".date("G:i", $dt)." hrs.";
    return $fecha_reg;
}

?>
