<?PHP
include("funciones_carga.php");

set_time_limit(5000);

echo "Inicio de Proceso de carga";

/********************************************************************************************************/	

$local_file="d:/compartido/data/canceladas/canceladas_sinweb.csv";

cargar_load_canceladas($local_file);
cargar_canceladas_pedidos();
echo "<br>Proceso de Carga Canceladas Terminado"; 

?>