<?php
include_once("conexion_bd.php");
set_time_limit(10000);

$xmes=date("m")."/".date("Y");
$nmes = date("M-Y");

$xano=$_GET["xano"];
$xmes=$_GET["xmes"];

$ndias = cal_days_in_month(CAL_GREGORIAN,$xmes, $xano);


if($_GET["xmes"]==""){
	$cad=" where substr(fec_reg_web,1,4)='$xano'";
}else{
	$cad=" where substr(fec_reg_web,1,7)='$xano-$xmes'";
}

$paso1="truncate table vista_asignaciones_dia_pre";
$res_col1= mysql_query($paso1);

$paso2="insert into vista_asignaciones_dia_pre
SELECT usu_reg,SUBSTR(fec_reg_web,1,10) AS fecha, SUBSTR(fec_reg_web,1,7) AS mes,SUBSTR(fec_reg_web,9,2) AS dia,COUNT(*) AS cant
FROM cab_asignaciones_cot $cad 
GROUP BY 1,2,3 ORDER BY 1";
//echo $paso2;

$res_col2= mysql_query($paso2);

$paso3="truncate table vista_incidencias_dia ";
$res_col3= mysql_query($paso3);


$paso4="INSERT INTO vista_incidencias_dia
SELECT '',a.iduser,CONCAT(a.dni,'-',a.ncompleto),0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
FROM tb_usuarios a, redimenciones b
WHERE a.iduser=b.iduser
AND a.c_supervisor='183'";
//echo $paso4;
$res_col4= mysql_query($paso4);

		for ($dias = 1; $dias <= $ndias; $dias++) { //mes actual
		$ca1="a.d".$dias."= b.cant";
		$p2="UPDATE vista_incidencias_dia a, vista_asignaciones_dia_pre b
		SET $ca1
		WHERE a.usu_reg=b.usu_reg AND b.dia=$dias and b.mes='$xano-$xmes'";
		//echo "<br>".$ndias."-".$p2;
		$res_p2 = mysql_query($p2) or die (mysql_error());		
		} 


$col1="select * from vista_incidencias_dia";
//echo $col1;
$res_col1= mysql_query($col1);

//echo $xmes."|".$ndias;
echo " <link href='estilos.css' rel='stylesheet' type='text/css' />";

		echo "<table width='100%'>";	
		
		
		echo "<tr>";
		echo "<td class='caja_texto_db'  align='center' colspan='43'>MES : $nmes</td>";		
		echo "</tr>";

		echo "<tr>";
		echo "<td class='caja_texto_db'>ITEM</td>";
		echo "<td class='caja_texto_db' width='30%'>GESTOR</td>";
		for ($cm1 = 1; $cm1 <= $ndias; $cm1++) {
    	echo "<td class='caja_texto_db' align='center'>";
		echo $cm1; 			
		echo "</td>";		
		}
		echo "</tr>";
		
		$item=0;	
		while($reg_col1 = mysql_fetch_row($res_col1)){	
		
		echo "<tr>";
		echo "<td class='caja_texto1'>";
		echo $item=$item+1; 			
		echo "</td>";
		
		echo "<td class='caja_texto1'>";
		echo $reg_col1[2]; 			
		echo "</td>";
		
		for ($dd1 = 3; $dd1 <= $ndias + 2; $dd1++) {
    	echo "<td class='caja_texto1' align='center'>";
		if ($dd1=="NULL"){
			echo "0";	
		}else{
			echo $reg_col1[$dd1]; 	
		}
		echo "</td>";		
		}
		
		
		echo "</tr>";
		}
		
		echo "</table>";

?>