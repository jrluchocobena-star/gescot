<? 
//$zon="LIM";
//$archivo="glpl494_".$zon."_".date('Y-m-d').".txt";
/*
$nombre_archivo="d:/data_cot/Gestel423/glpl494_".date('Y-m-d').".txt";
//echo $nombre_archivo;

if (file_exists($nombre_archivo)) {
    echo date("Y m d H:i:s.", filectime($nombre_archivo));
}

*/


echo gethostbyaddr($_SERVER['REMOTE_ADDR']);
?>