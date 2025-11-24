<?PHP
include("funciones_carga.php");

//set_time_limit(5000);

echo "PROCESO DE CARGA CANCELADAS INICIADO \n";

/********************************************************************************************************/	
$dia=date('dmY');
$name= "migraciones_".$dia.".csv";

$local_file="d:/compartido/DATA/MIGRACIONES/".$name;


if (file_exists($local_file)) {  	
	//blanquear_tablas_canceladas();
	cargar_load_migraciones($local_file);
	cargar_migraciones_pedidos();
	echo "<br>NUEVO PROCESO DE CARGA CANCELADAS TERMINADO"; 
} else {
		echo "El fichero $local_file no existe";
		return;
}

	
?>