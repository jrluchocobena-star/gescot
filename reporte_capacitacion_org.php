<?php

$f_actual=date("Y-m-d");
$n_archivo="rep_capacitacionescot_".$f_actual.".xls";


//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=".$n_archivo);

include("conexion_bd.php");
include("funciones_fechas.php");

$iduser=$_GET["iduser"];
$perfil=$_GET["perfil"];



if ($_GET["xmes"]=="0"){
	$cri=$_GET["xano"];	
	$cad="SUBSTR(fec_ini_inc,1,4)='$cri'";
}else{
	$cri=$_GET["xano"]."-".$_GET["xmes"];
 	$cad="SUBSTR(fec_ini_inc,1,7)='$cri'";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REPORTE INCIDENCIAS COT</title>

</head>

<body>
<? 

$lista="select *,SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))),
	SUBSTR(fec_ini_inc,1,7)  
	from cab_capacitacion where SUBSTR(fec_ini_inc,1,7)='2019-09'
	group by dni,tp_incidencia,motivo_incidencia,fec_ini_inc
	order by fec_reg desc";
	
//echo $_GET["xmes"]."|".$lista;

$i=0;
	$res_lis = mysql_query($lista);
	
	echo "<table width='100%'  style='border-collapse:collapse'>";		
			echo "<td class='fdotxttabla2'>ITEM </td>";	
			echo "<td class='fdotxttabla2'>SUPERVISOR</td>";
			echo "<td class='fdotxttabla2'>MONITORA</td>";	
			echo "<td class='fdotxttabla2'>CIP </td>";	
			echo "<td class='fdotxttabla2'>DNI </td>";														
			echo "<td class='fdotxttabla2' width='300'>TRABAJADOR </td>";	
			echo "<td class='fdotxttabla2'>TP.INCIDENCIA </td>";	
			echo "<td class='fdotxttabla2'>TEMATICO </td>";	
			echo "<td class='fdotxttabla2'>F.INI INC </td>";	
			echo "<td class='fdotxttabla2'>F.FIN INC </td>";	
			echo "<td class='fdotxttabla2'>TIEMPO ACUMULADO </td>";												
			echo "</tr>";
	
	while($reg_lis=mysql_fetch_row($res_lis)){		
		
					
		echo "<tr>";	
		
		echo "<td class='casilla_texto'>";
		echo $i=$i+1; 			
		echo "</td>";
		
		$c1="select * from tb_usuarios where dni='$reg_lis[15]'";
		//echo $c1;
		$res_c1 = mysql_query($c1);
		$reg_c1=mysql_fetch_row($res_c1);
		
		$c2="select * from tb_usuarios where iduser='$reg_lis[3]'";
		//echo $c2;
		$res_c2 = mysql_query($c2);
		$reg_c2=mysql_fetch_row($res_c2);
		
		$c3="select * from tb_motivos_incidencia where cod_mot_inc='$reg_lis[5]'";
		//echo $c3;
		$res_c3 = mysql_query($c3);
		$reg_c3=mysql_fetch_row($res_c3);
		
		$sup="select * from tb_supervisores where cod_supervisor='$reg_c1[23]'";
		//echo $c4;
		$res_sup = mysql_query($sup);
		$reg_sup =mysql_fetch_row($res_sup);
		
		$c5="select * from tb_monitores where cod_monitor='$reg_lis[3]'";
		//echo $c4;
		$res_c5 = mysql_query($c5);
		$reg_c5 =mysql_fetch_row($res_c5);
		
			
		echo "<td class='casilla_texto'>"; // SUPERVISOR
		echo $reg_sup[1]; 				
		echo "</td>";
		
		
		echo "<td class='casilla_texto'>"; //  MONITOR
		echo $reg_c5[1]; 				
		echo "</td>";			
		
		echo "<td class='casilla_texto'>"; // CIP
		echo $reg_lis[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // dni
		echo $reg_lis[15]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // TRABAJADOR
		echo $reg_c1[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // INCIDENCIA
		echo $reg_lis[4]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; //  motivo
		echo $reg_c3[1]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // FEC. INICIAL
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // FEC. FINAL
		echo $reg_lis[7]; 				
		echo "</td>";
		
		
		echo "<td class='casilla_texto'>"; // timepo
		echo $reg_lis[19]; 				
		echo "</td>";
		
		/*
		echo "<td class='casilla_texto'>"; //  CORRELATIVO
		echo $reg_lis[10]; 				
		echo "</td>";
		
		echo "<td  class='casilla_texto'>"; // FEC.REGISTRO
		echo $reg_lis[2]; 			
		echo "</td>";
		
	
		echo "<td class='casilla_texto'>"; // MOTIVO CAP.
		echo $reg_lis[17]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; // CURSO.
		echo $reg_c3[1]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; // TEMA.
		echo $reg_lis[18]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // FEC. INICIAL
		echo $reg_lis[6]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // FEC. FINAL
		echo $reg_lis[7]; 				
		echo "</td>";

		echo "<td class='casilla_texto'>"; //TIEMPO
		if (substr($reg_lis[7],11,8)=="00:00:00"){
			$fec1=substr($reg_lis[6],0,10);
			$fec2=substr($reg_lis[7],0,10);
			$dfec=calcular_tiempo_trasnc($fec2,$fec1);
			$fec_r=explode(", ",$dfec); 
			echo $fec_r[0];
			
		}else{
			echo calcular_tiempo_trasnc($reg_lis[7],$reg_lis[6]); 				
		}
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // NRO.PARTICIPANTES
		echo $reg_lis[9]; 				
		echo "</td>";
		
		echo "<td class='casilla_texto'>"; // OBSERVACIONES
		echo $reg_lis[8]; 				
		echo "</td>";
				
		*/
		echo "</tr>";				
		}	
	echo "</table>";
	

?>



</body>
</html>