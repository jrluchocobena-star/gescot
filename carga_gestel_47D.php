<?php


include("funciones_carga.php");
		
set_time_limit(5000);
$row=0;	
mysql_query("truncate table gestel_47d") ;	

		for ($i = 1; $i < 11 ; $i++) {
			
			if ($i==1)  { $zon="LIM"; }
			if ($i==2)  { $zon="ARE"; }
			if ($i==3)  { $zon="CHB"; }
			if ($i==4)  { $zon="CHY"; }
			if ($i==5)  { $zon="ICA"; }
			if ($i==6)  { $zon="CUZ"; }
			if ($i==7)  { $zon="HYO"; }
			if ($i==8)  { $zon="PIU"; }
			if ($i==9)  { $zon="TRU"; }
			if ($i==10) { $zon="IQU"; }
			
			$dia=date('Y-m-d');		
			$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
			$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;			
			
			if (file_exists($fileName)) {
				carga_tabla_GESTEL_47D($fileName,$zon);
				echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";				
			}else{
				echo "<P>"."ARCHIVO ".$fileName." NO SE ENCONTRO";
			}			
			
		}
		
/********************************************************************************************************/	
		

		/*
		$zon="LIM";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;	
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;	
		carga_tabla_GESTEL_47D($fileName,$zon);
		//echo "<P>"."Se cargo el archivo GESTEL_47D_LIM.txt Satisfactoriamente";
		echo "<br>"."Se cargo el archivo GESTEL_47D_LIM.txt Satisfactoriamente";			
		
		$sw=2;

		$zon="ARE";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;	
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;	
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}

		$zon="CHB";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;	
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;			
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}
		//echo "<P>"."proceso 3 terminado";

		$zon="CHY";		
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;	
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}
		$sw=5;
		//echo "<P>"."proceso 3 terminado";

		$zon="ICA";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;			
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}
		$sw=6;
		//echo "<P>"."proceso 3 terminado";
	
		$zon="CUZ";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}
		$sw=7;
		//echo "<P>"."proceso 3 terminado";

		$zon="HYO";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;			
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}
		$sw=8;
		//echo "<P>"."proceso 3 terminado";

		$zon="PIU";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";	
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;				
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}
		$sw=9;
		//echo "<P>"."proceso 3 terminado";
	
		$zon="TRU";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;			
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}
		$sw=10;
		//echo "<P>"."proceso 3 terminado";

		$zon="IQU";
		$dia=date('Y-m-d');		
		$archivo="GESTEL_47D_".$zon."_".$dia.".txt";
		$fileName = "d:/COMPARTIDO/DATA/GESTEL_47D/".$archivo;			
		//$fileName = "d:/data_cot/Reasignaciones_47D/".$archivo;		
		if (file_exists($fileName)) {
			carga_tabla_GESTEL_47D($fileName,$zon);
			echo "<P>"."Se cargo el archivo $fileName Satisfactoriamente";
			$sw=3;
		}else{
			echo "<P>"."ARCHIVO ".$fileName." NO SE GENERO";
		}		
		$sw=11;
		//echo "<P>"."proceso 3 terminado";

		$ini=date("Y-m-d H:m");
		echo "<P>"."PROCESO DE CARGA FINALIZADO......";
		archivo_log($ini,'USER_WIN','CARGA GESTEL 47D','1. ARCHIVOS IMPORTADOS OK ');

		*/		
		
?>	