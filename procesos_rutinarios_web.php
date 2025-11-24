<?php
include("funciones_rutinas_cot.php");

$xmes = date("Y-m");

echo "<table border='1'>";
for ($i = 0; $i <= 5; $i++) {
	//echo $i."\n";
	
	if ($i==0){
		echo "<tr><td>0.- Inicio Proceso Rutinas COT</td></tr>";		
	}
	
	if ($i==1){
		buscar_archivo();
	}
	
	/*
    if ($i==1){
		rutinas_maestra();
		print "<tr><td>1.- Proceso Rutinas Maestra Terminado OK</td></tr>";		
	}
	
	if ($i==2){
		rutinas_incidencias();
		print "<tr><td>2.- Proceso Rutinas Incidencias Terminado OK</td></tr>";
		
	}
	if ($i==3){	
		copia_mensual_horarios();		
	}
	
	if ($i==4){
		print "<tr><td>4.- Inicio Proceso Rutinas Horarios</td></tr>";
		rutinas_horarios();	
	}
	
	
	if ($i==5){
		print "<tr><td>5.- Fin Proceso Rutinas COT</td></tr>";		
	}
	*/
	
}
echo "</tr>";
echo "</table>";


?>