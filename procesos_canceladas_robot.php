
<?php
include("funciones_rutinas_cot.php");

$xmes = date("Y-m");

for ($i = 4; $i <= 20; $i++) {
	//echo $i."\n";
	
	if ($i==4){
		print "Inicio Proceso....". "\n";		
	}
	
    if ($i==5){
		print "1.Proceso de Carga Ejepen Iniciado". "\n";	
		carga_ejepen();
		print "1.Proceso de Carga Ejepen Terminado". "\n";		
	}
			
	if ($i==6){
		print "4. Proceso de Inicio de Carga Canceladas Terminadas Iniciado". "\n";	
		carga_canceladas_wa_tecnica();
		print "4. Proceso carga Canceladas Terminadas WA OK". "\n";		
	}
	
	if ($i==7){
		print "5. Proceso de Inicio de Carga Canceladas Robot Terminadas Iniciado". "\n";	
		carga_canceladas_robot_tecnica();
		print "5. Proceso carga Canceladas Robot Terminadas OK". "\n";		
	}
	
	if ($i==8){
		print "6. Proceso de Inicio de Cruce por Pet_req Iniciado". "\n";	
		cruce_pet_req();
		print "6. Proceso de Cruce por Pet_req Robot Terminadas OK". "\n";		
	}
	
	if ($i==9){
		exportar_canceladas_cot();
		print "7.Proceso de exportar archivo Tecnicas.xlsx OK". "\n";		
	}	
	
	if ($i==15){
		print "Fin Proceso....". "\n";		
	}
	
	
}


?>