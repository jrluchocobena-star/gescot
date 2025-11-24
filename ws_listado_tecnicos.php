<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="funciones_js.js"></script>
<?php
include_once("conexion_w101.php");

$connection_w101	= db_conn_w101();

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];
$hoy = date("Y-m-d");
$opc=$_GET["opc"];


	$celular	= "+51".trim($_GET["celular"]);
	$dni		= $_GET["xdni"];
	$carnet		= $_GET["xcarnet"];
	
	if ($_GET["celular"]<>"" and $_GET["xdni"]=="" and $_GET["xcarnet"]=="" ){ // celular
		$dato="1";
	}
	
	if ($_GET["celular"]=="" and $_GET["xdni"]<>"" and $_GET["xcarnet"]==""){ // dni
		$dato="2";
	}


	if ($_GET["celular"]=="" and $_GET["xdni"]=="" and $_GET["xcarnet"]<>""){ // carnet
		$dato="3";
	}

	
	
//	echo $_GET["celular"]."|".$_GET["xdni"]."|".$_GET["xcarnet"]."|".$_GET["xnombres"]."|".$opc;

	if ($dato=="1"){
		$lista 		= "select * from ws_movimiento_usuarios where NroCel='$celular' order by FechaModifi desc";	
		$msn="EL NUMERO DE CELULAR ".$celular." SE ENCUENTRA REGISTRADO";
	}
	
	if ($dato=="2"){
		$lista 		= "select * from ws_movimiento_usuarios where dni='$dni' order by FechaModifi desc";	
		$msn="EL NUMERO DE DNI ".$dni." SE ENCUENTRA REGISTRADO";
	}
	
	if ($dato=="3"){
		$lista 		= "select * from ws_movimiento_usuarios where Carnet='$carnet' order by FechaModifi desc";	
		$msn="EL NUMERO DE CARNET ".$carnet." SE ENCUENTRA REGISTRADO";
	}
	


?>


<?php
if ($opc=="1"){
	
	echo $lista;

	$res_lista = mysql_query($lista,$connection_w101);
	
	echo "<table width='100%'>";	
	
	echo "<tr>";		
			echo "<td class='caja_texto_pe' colspan='7' align='right'><a href='javascript:cerrar_win(0)'>Cerrar</a></td>";													
	echo "</tr>";
											
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

<?php

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