<?php


include("conexion_bd.php");
//include("../funciones_fecha.php");

set_time_limit(5000);

		$sql_P1="update tb_gestel_423_total set zon='ARE' WHERE SUBSTR(ciudad,1,2)IN ('50','51','52','53','54','55','56','57','58')";
		$res_P1 = mysql_query($sql_P1) or die(mysql_error());	
		
		$sql_P2="update tb_gestel_423_total set zon='CHY' WHERE SUBSTR(ciudad,1,2)IN ('01','05')";
		$res_P2 = mysql_query($sql_P2) or die(mysql_error());	
		
		$sql_P3="update tb_gestel_423_total set zon='CHB'  WHERE SUBSTR(ciudad,1,2)IN ('13','04','09')";
		$res_P3 = mysql_query($sql_P3) or die(mysql_error());	
		
		$sql_P4="update tb_gestel_423_total set zon='HYO'  WHERE SUBSTR(ciudad,1,2)IN ('10','12','14')";
		$res_P4 = mysql_query($sql_P4) or die(mysql_error());	
		
		$sql_P5="update tb_gestel_423_total set zon='HYO' WHERE CIUDAD IN ('1007','1208','01081','01084','11001','11036','11038','11039')";
		$res_P5 = mysql_query($sql_P5) or die(mysql_error());	
		
		$sql_P6="update tb_gestel_423_total set zon='CUZ' WHERE SUBSTR(ciudad,1,2)IN ('53','54')";
		$res_P6 = mysql_query($sql_P6) or die(mysql_error());	
		
		$sql_P7="update tb_gestel_423_total set zon='HYO' WHERE CIUDAD='57050'";
		$res_P7 = mysql_query($sql_P7) or die(mysql_error());	

		$sql_P8="update tb_gestel_423_total set zon='ICA' WHERE SUBSTR(ciudad,1,2)IN ('03')";
		$res_P8 = mysql_query($sql_P8) or die(mysql_error());	
		
		$sql_P9="update tb_gestel_423_total set zon='HYO' WHERE CIUDAD IN ('12007','12019','12205','12337','12339','12469')";
		$res_P9 = mysql_query($sql_P9) or die(mysql_error());	
		
		$sql_P10="update tb_gestel_423_total set zon='IQU' WHERE ciudad IN ('11037','01001','01078','01095','01096')";
		$res_P10 = mysql_query($sql_P10) or die(mysql_error());	
		
		$sql_P11="update tb_gestel_423_total set zon='PIU' WHERE SUBSTR(ciudad,1,2)IN ('02','07')";
		$res_P11= mysql_query($sql_P11) or die(mysql_error());	

		$sql_P12="update tb_gestel_423_total set zon='TRU' WHERE SUBSTR(ciudad,1,2)IN ('15','51','60','80','81')";
		$res_P12 = mysql_query($sql_P12) or die(mysql_error());
		
		$sql_P13="update tb_gestel_423_total set zon='LIM' WHERE zon='0'";
		$res_P13 = mysql_query($sql_P13) or die(mysql_error());

?>