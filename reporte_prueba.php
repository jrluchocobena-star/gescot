<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include("conexion_bd.php");
//include("funciones_fechas.php");



set_time_limit(2000);



echo "<table width='100%'>";											
echo "<tr>";													
		echo "<td class='caja_texto_peke' width='5%'>C.INDICENCIA </td>";	
		echo "<td class='caja_texto_peke' width='5%'>ESTADO </td>";						
		echo "<td class='caja_texto_peke' width='5%'>DNI</td>";	
		echo "<td class='caja_texto_peke' width='20%'>TRABAJADOR COT</td>";		
		echo "<td class='caja_texto_peke' width='10%'>TP.INCIDENCIA</td>";	
		echo "<td class='caja_texto_peke' width='10%'>MOTIVO</td>";	
		echo "<td class='caja_texto_peke'>FEC.INI INCIDENCIA</td>";						
		echo "<td class='caja_texto_peke'>FEC.FIN INCIDENCIA</td>";				
		echo "<td class='caja_texto_peke'>MODO</td>";
		echo "<td class='caja_texto_peke'>TIEMPO</td>";	
		echo "<td class='caja_texto_peke'>MINUTOS</td>";
        echo "<td class='caja_texto_peke'>USU.REGISTRO</td>";
        echo "<td class='caja_texto_peke'>FECHA REGISTRO</td>";
        echo "<td class='caja_texto_peke'>USU.APROBADO</td>";
        echo "<td class='caja_texto_peke'>FECHA APROB.</td>";
        echo "<td class='caja_texto_peke'>USU.RECHAZADO</td>";
        echo "<td class='caja_texto_peke'>FECHA RECH.</td>";
        echo "<td class='caja_texto_peke'>MOTIVO RECH.</td>";
        echo "<td class='caja_texto_peke'>USU.CANCELADO</td>";
        echo "<td class='caja_texto_peke'>FECHA CANCE.</td>";
		/*
		echo "<td class='caja_texto_peke'>FEC.RECHAZO</td>";
		echo "<td class='caja_texto_peke'>RESP.RECHAZO</td>";
		echo "<td class='caja_texto_peke'>MOTIVO RECHAZO</td>";
		*/

echo "</tr>";
	
echo "</table>";
//echo "total: ".$con;


$hoy=date("Y_m_d");
$n_archivo="rep_incidenciascot_".$hoy.".xlsx";


header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$n_archivo); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);


?>