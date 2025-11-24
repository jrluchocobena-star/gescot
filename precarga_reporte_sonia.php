<?
// precarga

include("cabecera.php");

mysql_query("truncate table tb_cms") ; 

$p1="SELECT gescot_super,gescot_ncompleto,dni,modalidad,xmes,COUNT(*) AS conteo1 FROM REPORTERIA_COT.reporte_sonia 
WHERE gescot_ncompleto<>'' AND xmes='04/2018' GROUP BY 1,3,4";
$res_p1 = mysql_query($p1);

$ndias = cal_days_in_month(CAL_GREGORIAN, date("m"), date("y"));

for ($dias = 1; $dias <= $ndias + 1; $dias++) {
		$p2="UPDATE reporte_cot_v1 a, reporte_cot_v1_vert b
		SET a.$dias=b.cantidad
		WHERE a.dni=b.dni AND ndia='$dias'";
		echo $p2;
		$res_p2 = mysql_query($p2);
		
} 

?>