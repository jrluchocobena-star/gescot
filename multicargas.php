<?php

include("funciones_carga.php");
		
set_time_limit(5000);

echo ""; 

echo "0 - Inicio Proceso de Multicargas";

echo "<p>";

$sw="1";

for ($sw=1 ; $sw<6 ; $sw++){
	
	if ($sw=="1"){
	
		echo "<br>".$sw."-Proceso de Carga Asignaciones Iniciado";
		
		copiar_archivo(); 		
		$dia=date('Y-m-d');
		$local_file = "d:/data_cot/Gestel423/glpl494_".$dia.".txt"; //Nombre archivo en nuestro PC				
		$ruta 		= "d:/data_cot/Gestel423/";
		
		if (file_exists($local_file)) { 		 
			blanquear_tablas_423();
			borrar_enprocesos();
			carga_423();	
			exclusiones_423();	
			//carga_beoliquidaciones();
			$sql_3_a="DELETE FROM tb_gestel_423 WHERE pedido='0'";		
				//echo "<br>".$sql_11x;	
			$res_3_a= mysql_query($sql_3_a) or die(mysql_error($sql_3_a));	 
			
			echo "<br>"."Proceso de Carga Asignaciones Gestel Terminado";		

		} else {
				echo "....El fichero $local_file de gestel no se encuentra alojado en la ruta ".$ruta;
				return;
		}	
		
		$sw="3";
	}
	
	echo "<p>";
	
	if ($sw=="2"){
		echo "<br>".$sw."-Proceso de Carga Asignaciones Cms Iniciado";
			$dia=date('Y-m-d');
			$local_file="D:/COMPARTIDO/DATA/CMS/tb_cms_".date("d").date("m").date("y").".csv";		
			$ruta="D:/COMPARTIDO/DATA/CMS/";
			
			if (file_exists($local_file)) {  	
				mysql_query("truncate table tb_cms") ; 	
				carga_cms($local_file);	
				echo "<br>"."Proceso de Carga Asignaciones Cms Terminado";			
			} else {
					echo "....El fichero $local_file de cms no se encuentra alojado en la ruta ".$ruta;
					return;
			}

		$sw="5";
	}
	
	echo "<p>";
	
	if ($sw=="3"){
		echo "<br>".$sw."-Proceso de Carga Canceladas Iniciado";		
		cargar_load_atendidas();		
		$local_file="d:/compartido/data/canceladas/canceladas_sinweb.csv";
		cargar_load_canceladas($local_file);
		cargar_canceladas_pedidos();
		echo "<br>"."Proceso de Carga Canceladas Terminado";
		$sw="4";
	}
	
	echo "<p>";
	
	if ($sw=="4"){
		echo "<br>".$sw."-Proceso de Carga Migraciones Iniciado";	
		
		$dia=date('dmY');
		$name= "migraciones_".$dia.".csv";
		
		$local_file="d:/compartido/DATA/MIGRACIONES/".$name;
		$ruta="d:/compartido/DATA/MIGRACIONES/";
		
		if (file_exists($local_file)) {  	
			//blanquear_tablas_canceladas();
			cargar_load_migraciones($local_file);
			cargar_migraciones_pedidos();
			echo "<br>"."Proceso de Carga Migraciones Terminado";
		} else {
				echo "....El fichero $local_file de migraciones no se encuentra alojado en la ruta ".$ruta;
				return;
		}

		$sw="5";
	}
	
	echo "<p>";
	
	if ($sw=="5"){
		echo "<br>".$sw."-Proceso Total Terminado";
	}

}
?>