<?PHP
include("conexion_bd.php");
$dia=date("md");
$hora = date("H");


$archivo_1="BASE_CONSOLIDADA_2019".$dia."_".$hora.".csv";
//echo $ruta1;

$file_1= buscar('z:',$archivo); 

$Result = Shell_Exec ('powershell.exe -executionpolicy bypass -NoProfile -File "D:\data_cot\PROCESOS\nuevo_envio_correo1.ps1"');
echo $Result;

/*

$Result = Shell_Exec ('powershell.exe -executionpolicy bypass -NoProfile -File "D:\data_cot\PROCESOS\nuevo_envio_correo1.ps1"');
echo $Result;
*/

?>
