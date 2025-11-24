<?php
include("funciones_rutinas_cot.php");

$xmes = date("Y-m");

for ($i = 0; $i < 30; $i++) {
	//echo $i."\n";
	
	if ($i==0){
		echo "1.- Iniciando Proceso Rutinas(procesos_rutinarios.php)"."\n";		
	}	
	
    if ($i==1){
		print "2.- Proceso Rutinas Maestra Terminado.... OK"."\n";	
		rutinas_maestra();			
	}
	
	if ($i==2){
		print "3.- Proceso Rutinas Incidencias Terminado.... OK"."\n";
		rutinas_incidencias();	
	}
	
	/*
	if ($i==3){	
		print "4.- Copiar Reporte Mensual de horarios"."\n";
		copia_mensual_horarios();		
	}
	
	if ($i==4){
		print "<tr><td>4.- Inicio Proceso Rutinas Horarios"."\n";
		//rutinas_horarios();	
	}
	
	*/
	if ($i==3){
		print "4.- Fin Proceso Rutinas COT"."\n";			
	}
	
}



?>