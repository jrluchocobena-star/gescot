<?PHP
include("funciones_carga.php");

//set_time_limit(5000);

echo "PROCESO DE CARGA CMS INICIADO \n";

/********************************************************************************************************/	
$dia=date('Y-m-d');
$local_file="D:/COMPARTIDO/DATA/CMS/tb_cms_".date("d").date("m").date("y").".csv";		


if (file_exists($local_file)) {  	
	blanquear_tablas_cms();
	carga_cms($local_file);
	echo "<br>NUEVO PROCESO DE CARGA CMS TERMINADO"; 
} else {
		echo "El fichero $local_file no existe";
		return;
}
	

	
?>