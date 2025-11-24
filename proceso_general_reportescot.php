<?phP
include("conexion_bd.php");

for($i = 0; $i < 10; $i++) {
	
	if ($i == 1){
	echo "1.- Inicio de proceso: proceso_general_reportescot.php..."."\n";
	}
	
	if ($i == 2){  
	echo "2.- Generando Reporte Maestra Unica Cot"."\n";
	include("exportar_maestra_unica.php");
	}
	
	if ($i == 3){     	
	echo "3.- Generando Reporte Maestra de usuarios"."\n";
	include("exportar_maestra_movimientos.php");
	}
	
	if ($i == 4){
	echo "4.- Generando Reporte Incidencias Cot Mensual"."\n";
	include("reporte_incidencias_actual.php");
	}
	
	if ($i == 5){
	echo "5.- Generando Reporte Contactabilidad Cot"."\n";
	include("exportar_reporte_contactabilidad.php");
	}
	
	if ($i == 6){
	echo "6.- Proceso Terminado";	
	}
	
}
?>
