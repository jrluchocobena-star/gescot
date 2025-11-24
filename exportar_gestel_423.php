<?php 

include("conexion_bd.php");
//include("funciones_fecha.php");

set_time_limit(5000);


$accion=$_GET["accion"];

if ($accion=="exportar_archivo"){

$archivo='gestel_423.txt'; 
//echo buscar('d:/data_cot/Gestel423/',$archivo); 	

	if (buscar('d:/data_cot/Gestel423/',$archivo)==""){
		$qry_0 = "select * from tb_gestel_423 INTO OUTFILE 'd:/data_cot/Gestel423/gestel_423.txt'"; 	
				//echo "<br>Carga_pedidos_cms ".$qry_0;		
		$res_0 = mysql_query($qry_0) or die(mysql_error($qry_0));
	}else{
		echo "Archivo ya se encuentra generado";	
	}

}
if ($accion=="bajar_archivo"){
header("Content-disposition: attachment; filename=gestel_423.txt");
header("Content-type: application/txt");
readfile("d:/data_cot/Gestel423/gestel_423.txt");

}

function buscar($dir,&$archivo_buscar) 
{   // Funcion Recursiva 
    // Autor DeeRme 
    // http://deerme.org 
     if ( is_dir($dir) ) 
     { 
          // Recorremos Directorio 
          $d=opendir($dir);  
          while( $archivo = readdir($d) ) 
          { 
            if ( $archivo!="." AND $archivo!=".."  ) 
            { 
                  
                 if ( is_file($dir.'/'.$archivo) ) 
                 { 
                      // Es Archivo 
                      if ( $archivo == $archivo_buscar  ) 
                      { 
                           return ($dir.'/'.$archivo); 
                    } 
                     
                } 
                  
                if ( is_dir($dir.'/'.$archivo) ) 
                { 
                     // Es Directorio 
                     // Volvemos a llamar 
                     $r=buscar($dir.'/'.$archivo,$archivo_buscar); 
                     if ( basename($r) == $archivo_buscar ) 
                     { 
                          return $r; 
                    } 
                      
                      
                } 
                   
                   
                 
                  
                  
            } 
                   
        } 
                   
    } 
    return FALSE; 
} 




?>