<?php
include("conexion_bd.php");

$iduser=$_GET["iduser"];
$xmes = date("mY");
	
	/*
	$archivo = "\\\\10.226.5.114\\\FS-Principal\\\Dir_Marketing\\\Ger_Consumo_de_Terminales_y_Banda_Ancha\\\Jefatura_de_Terminales\\\\000Cot\\\zz_InputsExternos\\\WebGescot\\\Input_Maestra\\\maestra_cot_".$xmes.".csv";
	
	
	mysql_query("truncate table maestra_cot_temporal") ;	

	$sql_0 = "LOAD DATA LOCAL INFILE '$archivo' INTO TABLE maestra_cot_temporal
	FIELDS TERMINATED BY ';'
	LINES TERMINATED BY '\r\n' IGNORE 1 LINES";	
	echo $sql_0;			
	$res_0 = mysql_query($sql_0) or die(mysql_error($sql_0));
		
	*/
	$paso1="DELETE FROM maestra_cot_temporal WHERE dni in ('','DNI ','PSI\"')";
	//echo $cc;
	$res_paso1 = mysql_query($paso1);
	
	$pasob="update maestra_cot_temporal set dni=trim(dni),cip=trim(cip)";
	//echo $cc;
	$res_pasob = mysql_query($pasob);
	
	
	$paso1c="DELETE FROM maestra_cot_temporal WHERE dni=''";
		//echo $cc;
	$res_paso1c = mysql_query($paso1c) or die (mysql_error($paso1c)); 
	
		
	$paso1d	= "UPDATE maestra_cot_temporal SET cip = LPAD(TRIM(cip),9,'0') WHERE LENGTH(cip)<10";
	$result_paso1d 	= mysql_query($paso1d) or die(mysql_error());
	
	$paso_1e	= "UPDATE maestra_cot_temporal SET dni = LPAD(TRIM(dni),8,'0') WHERE LENGTH(dni)<9";
	$result_paso1e 	= mysql_query($paso_1e) or die(mysql_error());
	
		
	$paso1f="UPDATE maestra_cot_temporal a, tb_usuarios b
	SET a.enc_cab='SI'
	WHERE a.dni=b.dni";
	//echo $paso2;
	$res_paso1f = mysql_query($paso1f) or die (mysql_error($paso1f)); 
	
	$paso1g="UPDATE maestra_cot_temporal SET enc_cab='NO' where enc_cab=''";
	//echo $paso2;
	$res_paso1g = mysql_query($paso1g) or die (mysql_error($paso1g)); 
	
	$paso1h="UPDATE maestra_cot_temporal a, movimientos_maestra b
	SET a.enc_det='SI'
	WHERE a.dni=b.dni";
	//echo $paso2;
	$res_paso1h = mysql_query($paso1h) or die (mysql_error($paso1h)); 
	
	$paso1i="UPDATE maestra_cot_temporal SET enc_det='NO' WHERE enc_det=''";
	//echo $paso2;
	$res_paso1i = mysql_query($paso1i) or die (mysql_error($paso1i)); 
	
	
	$paso2="INSERT IGNORE INTO tb_usuarios(
	SELECT '',campo2,dni,cip,'',dni,dni,'1','','HABILITADO',0,0,'','COT-TDP','BACK',CONCAT('NUEVO_',CURDATE()),'','',campo46,
	campo55,campo56,campo54,'','','',TRIM(campo47),TRIM(campo48),'',campo52,'',
	NOW(),'','','','',campo63,campo64,campo65,'','','','','','','','','','','','',''
	FROM maestra_cot_temporal WHERE enc_cab='NO')";
	//echo "<br>".$paso2;
	$res_paso2 = mysql_query($paso2) or die (mysql_error($paso2)); 
	
	$paso3="INSERT INTO movimientos_maestra
	SELECT '',dni,'-',b.aplicativo,'ACT.USUARIO',NOW(),CURDATE(),'2050-01-01','$iduser','','NO CREADO',CONCAT('t_',b.aplicativo),'X'
	FROM maestra_cot_temporal a, tb_aplicativos b
	WHERE enc_det='NO'
	GROUP BY 2,4";
	//echo "<br>".$paso3;
	$res_paso3 = mysql_query($paso3) or die (mysql_error($paso3)); 
	
		
	$paso4="UPDATE tb_usuarios
	SET ape_pat=SUBSTRING_INDEX(SUBSTRING_INDEX(ncompleto, ',', 1),' ',1),
	ape_mat=SUBSTRING_INDEX(SUBSTRING_INDEX(ncompleto, ',', 1),' ',-1),
	nombres=TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(ncompleto, ',', -1),' ',2))
	WHERE ape_pat=''";
		//echo $cc;
	$res_paso4 = mysql_query($paso4)  or die (mysql_error($paso4)); 
	
				
				$p_1="TRUNCATE TABLE maestra_cot_det";
				$res_p1 = mysql_query($p_1)  or die (mysql_error($p_1)); 
				
				$p_2="
				INSERT INTO maestra_cot_det				
				(SELECT dni,campo5,'MULTICONSULTA' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo6,'CCM1' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo7,'INTRAWAY 2' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo8,'INTRAWAY 3' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo9,'PSI' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo10,'ATIS' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo12,'CMS' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo14,'GESTEL' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo16,'PDM' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo17,'REPARTIDOR' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo18,'WEB SARA' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo19,'WEB ASEGURAMIENTO' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo20,'ARPU CALCULADORA' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo21,'GENIO' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo22,'WEB SIGTP MAPA GIG' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo24,'GENESYS' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo25,'TOA' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo26,'SRM' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo27,'SPEEDYSIG' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo28,'WEB ASIGNACIONES' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo29,'NUEVO VISOR' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo30,'WEB MOVISTAR T-AYUDA' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo31,'ROL GAUDI' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo32,'WEB STC 6i' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo33,'WEB SIMPLE (WIC)' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo34,'WEB SALESFORCE' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo35,'WEB PACIFYC' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo37,'WEB EQUIFAX' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo38,'WEB FACO' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo39,'WEB ONE MARKETER' FROM maestra_cot_temporal)UNION
				(SELECT dni,campo40,'BUZON GENERICO' FROM maestra_cot_temporal)UNION			
				(SELECT dni,campo45,'RED' FROM maestra_cot_temporal)union
				(SELECT dni,campo68,'TOOLBOX' FROM maestra_cot_temporal)union
				(SELECT dni,campo69,'WAPPE' FROM maestra_cot_temporal)";
				$res_p2 = mysql_query($p_2)  or die (mysql_error($p_2)); 

				$p_3="UPDATE maestra_cot_det SET dato=REPLACE(dato,'  ',''),dato=TRIM(dato), dato=LTRIM(dato),dato=RTRIM(dato)";
				$res_p3 = mysql_query($p_3)  or die (mysql_error($p_3)); 
				
				$p_4 ="UPDATE movimientos_maestra a, maestra_cot_det b
				SET a.dato=b.dato, a.est='CREADO',fec_mov=NOW(),fec_ini=CURDATE()
				WHERE a.dni=b.dni AND a.aplicativo=b.aplicativo AND a.perfil='x'";
				$res_p4 = mysql_query($p_4)  or die (mysql_error($p_4)); 
				
				$p_4 ="UPDATE movimientos_maestra SET dato='-',est='NO CREADO' WHERE dato='' AND perfil='x'";
				$res_p4 = mysql_query($p_4)  or die (mysql_error($p_4));
				
				$p_5="UPDATE movimientos_maestra SET dato='-',est='NO CREADO' WHERE dato=' ' AND perfil='x'";
				$res_p5 = mysql_query($p_5)  or die (mysql_error($p_5));
				
				$p_6="UPDATE movimientos_maestra SET dato='-',est='NO CREADO' WHERE dato='?' AND perfil='x'";
				$res_p6 = mysql_query($p_6)  or die (mysql_error($p_6));


	
	echo "Proceso Terminado";
?>