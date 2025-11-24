<?php
$current_file_name = "\\\\Gppesvlcli2259\\Planificacion\\01_Reportes\\04_Eje_Pen\\eje_pen2001.xlsx";
$file_last_modified = filemtime($current_file_name);
$current_file_date = date("d/m/Y", $file_last_modified);
$current_date =date("d/m/Y");
if($current_date==$current_file_date)
{
	echo "Archivo de hoy generado";
}
else
{
	echo "No pasa";
}
?>