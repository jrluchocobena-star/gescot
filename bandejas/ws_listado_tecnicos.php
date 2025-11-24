<link href="estilos.css" rel="stylesheet" type="text/css" />
<?php
include_once("conexion_w101.php");

$connection_w101	= db_conn_w101();

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$celular="+51".$_GET["celular"];
$hoy = date("Y-m-d");
$opc=$_GET["opc"];

?>


<?
if ($opc=="1"){
	$lista="select * from ws_movimiento_usuarios where NroCel='$celular' order by FechaModifi desc";
	//echo $lista;

	$res_lista = mysql_query($lista,$connection_w101);
	
	echo "<table width='100%'>";											
	echo "<tr>";		
			echo "<td class='cabeceras_grid'>CELULAR</td>";										
			echo "<td class='cabeceras_grid' width='20%'>TECNICO </td>";	
			echo "<td class='cabeceras_grid'>CARNET</td>";	
			echo "<td class='cabeceras_grid'>DNI</td>";				
			echo "<td class='cabeceras_grid'>TOA</td>";	
			echo "<td class='cabeceras_grid'>FECHA MOVIMIENTO</td>";	
			echo "<td class='cabeceras_grid'>SOLICITADO POR</td>";				
								
	echo "</tr>";
	
	$con = 0		;
	while($reg_lista=mysql_fetch_row($res_lista)){			
		
		$con = $con + 1;			
		
		$fila = "fila_".$con;
		 
		echo "<tr id='$fila' name='$fila' >";					
				
		
		echo "<td class='caja_texto_pe'>"; // CELULAR
		echo $reg_lista[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>"; // TECNICO
		echo $reg_lista[2]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>"; // CARNET
		echo $reg_lista[3]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>"; // DNI
		echo $reg_lista[4]; 				
		echo "</td>";
				
		echo "<td class='caja_texto_pe'>"; //TOA
		echo $reg_lista[38]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>"; //FECHA MOVIMIENTO
		echo $reg_lista[35]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>"; // SOLICITADO POR
		echo $reg_lista[37]; 				
		echo "</td>";					
		
		
		
		echo "</tr>";				
		}	
	echo "</table>";
}
?>	

<?

$mes = date("Y-m");

if ($opc=="2"){
	$hist="select * from ws_movimiento_gestion_usuarios where substr(FechaModifi,1,7)='$mes' order by FechaModifi desc";

echo $hist;

$res_hist = mysql_query($hist);
	
	echo "<table width='100%'>";											
	echo "<tr>";		
			//echo "<td class='cabeceras_grid'>CORRELATIVO</td>";	
			echo "<td class='cabeceras_grid'>CELULAR</td>";																		
			echo "<td class='cabeceras_grid'>TECNICO</td>";		
			echo "<td class='cabeceras_grid'>CARNET</td>";
			echo "<td class='cabeceras_grid'>DNI</td>";							
			echo "<td class='cabeceras_grid'>ACTIVIDAD </td>";	
			echo "<td class='cabeceras_grid'>FEC.MOV</td>";	
			echo "<td class='cabeceras_grid'>SOLICITADO POR</td>";				
			echo "<td class='cabeceras_grid'>OBS.SOLICITUD</td>";									
			echo "<td class='cabeceras_grid'>APROBADO POR</td>";				
			echo "<td class='cabeceras_grid'>OBS.APROBACION</td>";									
			echo "<td class='cabeceras_grid'>EJECUTADO POR</td>";				
			echo "<td class='cabeceras_grid'>OBS.EJECUSION</td>";									
	echo "</tr>";
	
	$con = 0		;
	while($reg_hist=mysql_fetch_row($res_hist)){			
		
		echo "<tr>";					
		
		/*
		echo "<td class='listDet1'>"; // 
		echo $reg_hist[46]; 				
		echo "</td>";
		*/
		echo "<td class='caja_texto_pe'>"; // 
		echo $reg_hist[1]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>"; // 
		echo $reg_hist[2]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>"; // 
		echo $reg_hist[3]; 				
		echo "</td>";
		
		echo "<td class='caja_texto_pe'>"; // 
		echo $reg_hist[4]; 				
		echo "</td>";
		
		
		echo "<td class='caja_texto_pe'>"; // 
		echo $reg_hist[12]; 				
		echo "</td>";
				
		echo "<td class='caja_texto_pe'>"; //
		echo $reg_hist[35]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>"; //
		echo $reg_hist[37]; 				
		echo "</td>";	
		
		echo "<td class='caja_texto_pe'>"; //
		echo $reg_hist[36]; 				
		echo "</td>";	
		
		
		echo "</tr>";				
		}	
	echo "</table>";
}
?>	